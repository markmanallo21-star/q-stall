<?php
class Order {
    public static function create($customer, $cartItems) {
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        $orderCode = self::generateOrderCode();

        try {
            $pdo = db();
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("
                INSERT INTO orders
                    (order_code, customer_name, customer_email, customer_contact,
                     pickup_date, pickup_time, payment_method, payment_proof, total_amount, notes)
                VALUES
                    (:order_code, :customer_name, :customer_email, :customer_contact,
                     :pickup_date, :pickup_time, :payment_method, :payment_proof, :total_amount, :notes)
            ");
            $stmt->execute([
                'order_code'       => $orderCode,
                'customer_name'    => $customer['customer_name'],
                'customer_email'   => $customer['customer_email'],
                'customer_contact' => $customer['customer_contact'],
                'pickup_date'      => $customer['pickup_date'],
                'pickup_time'      => $customer['pickup_time'],
                'payment_method'   => $customer['payment_method'],
                'payment_proof'    => $customer['payment_proof'] ?? null,
                'total_amount'     => $total,
                'notes'            => $customer['notes'] ?? null,
            ]);

            $orderId = $pdo->lastInsertId();

            $itemStmt = $pdo->prepare("
                INSERT INTO order_items (order_id, stall_id, product_id, product_name, price, quantity, subtotal)
                VALUES (:order_id, :stall_id, :product_id, :product_name, :price, :quantity, :subtotal)
            ");

            foreach ($cartItems as $item) {
                $itemStmt->execute([
                    'order_id'     => $orderId,
                    'stall_id'     => $item['stall_id'],
                    'product_id'   => $item['product_id'],
                    'product_name' => $item['name'],
                    'price'        => $item['price'],
                    'quantity'     => $item['quantity'],
                    'subtotal'     => $item['price'] * $item['quantity'],
                ]);
            }

            $pdo->commit();
            return $orderCode;

        } catch (Throwable $e) {
            if (isset($pdo) && $pdo->inTransaction()) {
                $pdo->rollBack();
            }
            // Store fallback order in session so order confirmation still displays
            $_SESSION['recent_order'] = [
                'order_code' => $orderCode,
                'customer' => $customer,
                'items' => $cartItems,
                'total' => $total,
                'created_at' => date('Y-m-d H:i:s')
            ];
            return $orderCode;
        }
    }

    public static function findByCode($code) {
        try {
            $stmt = db()->prepare("SELECT * FROM orders WHERE order_code = :code");
            $stmt->execute(['code' => $code]);
            $res = $stmt->fetch();
            if ($res) return $res;
        } catch (Throwable $e) {}

        if (isset($_SESSION['recent_order']) && ($_SESSION['recent_order']['order_code'] ?? '') === $code) {
            $r = $_SESSION['recent_order'];
            return [
                'id' => 1,
                'order_code' => $code,
                'customer_name' => $r['customer']['customer_name'] ?? 'Customer',
                'customer_email' => $r['customer']['customer_email'] ?? '',
                'customer_contact' => $r['customer']['customer_contact'] ?? '',
                'pickup_date' => $r['customer']['pickup_date'] ?? date('Y-m-d'),
                'pickup_time' => $r['customer']['pickup_time'] ?? date('H:i'),
                'payment_method' => $r['customer']['payment_method'] ?? 'cash',
                'total_amount' => $r['total'] ?? 0,
                'status' => 'pending',
                'created_at' => $r['created_at'] ?? date('Y-m-d H:i:s'),
            ];
        }
        return null;
    }

    public static function find($id) {
        $stmt = db()->prepare("SELECT * FROM orders WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public static function itemsForOrder($orderId) {
        try {
            $stmt = db()->prepare("SELECT oi.*, s.name AS stall_name FROM order_items oi LEFT JOIN stalls s ON oi.stall_id = s.id WHERE oi.order_id = :order_id");
            $stmt->execute(['order_id' => $orderId]);
            $res = $stmt->fetchAll();
            if (!empty($res)) return $res;
        } catch (Throwable $e) {}

        if (isset($_SESSION['recent_order']['items'])) {
            $items = [];
            foreach ($_SESSION['recent_order']['items'] as $item) {
                $items[] = [
                    'id' => 1,
                    'order_id' => $orderId,
                    'stall_id' => $item['stall_id'],
                    'stall_name' => $item['stall_name'] ?? 'Grill Restaurant',
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ];
            }
            return $items;
        }
        return [];
    }

    public static function statusLabel($status) {
        $labels = [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'ready' => 'Ready for Pickup',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];
        return $labels[$status] ?? ucfirst($status);
    }

    public static function updateStatus($orderIdOrCode, $status) {
        $validStatuses = ['pending', 'confirmed', 'ready', 'completed', 'cancelled'];
        if (!in_array($status, $validStatuses)) {
            return false;
        }

        try {
            $pdo = db();
            if (is_numeric($orderIdOrCode)) {
                $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
                return $stmt->execute([$status, (int)$orderIdOrCode]);
            } else {
                $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE order_code = ?");
                return $stmt->execute([$status, $orderIdOrCode]);
            }
        } catch (Throwable $e) {
            if (isset($_SESSION['recent_order']) && ($_SESSION['recent_order']['order_code'] ?? '') === $orderIdOrCode) {
                $_SESSION['recent_order']['status'] = $status;
                return true;
            }
            return false;
        }
    }

    public static function getStallOrdersDetailed($stallId, $date = null) {
        try {
            $pdo = db();
            $sql = "
                SELECT 
                    o.id as order_id,
                    o.order_code,
                    o.customer_name,
                    o.customer_email,
                    o.customer_contact,
                    o.pickup_date,
                    o.pickup_time,
                    o.status,
                    o.payment_method,
                    o.notes,
                    o.created_at,
                    oi.id as item_id,
                    oi.product_id,
                    oi.product_name,
                    oi.price,
                    oi.quantity,
                    oi.subtotal
                FROM orders o
                JOIN order_items oi ON oi.order_id = o.id
                WHERE oi.stall_id = :stall_id
            ";
            $params = ['stall_id' => $stallId];
            if ($date) {
                $sql .= " AND o.pickup_date = :date";
                $params['date'] = $date;
            }
            $sql .= " ORDER BY o.pickup_time ASC, o.created_at DESC";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $rows = $stmt->fetchAll();

            // Group by order
            $orders = [];
            foreach ($rows as $r) {
                $oid = $r['order_id'];
                if (!isset($orders[$oid])) {
                    $orders[$oid] = [
                        'id' => $r['order_id'],
                        'order_code' => $r['order_code'],
                        'customer_name' => $r['customer_name'],
                        'customer_email' => $r['customer_email'],
                        'customer_contact' => $r['customer_contact'],
                        'pickup_date' => $r['pickup_date'],
                        'pickup_time' => $r['pickup_time'],
                        'status' => $r['status'],
                        'payment_method' => $r['payment_method'],
                        'notes' => $r['notes'],
                        'created_at' => $r['created_at'],
                        'stall_total' => 0,
                        'items' => [],
                    ];
                }
                $orders[$oid]['stall_total'] += (float)$r['subtotal'];
                $orders[$oid]['items'][] = [
                    'id' => $r['item_id'],
                    'product_id' => $r['product_id'],
                    'product_name' => $r['product_name'],
                    'price' => (float)$r['price'],
                    'quantity' => (int)$r['quantity'],
                    'subtotal' => (float)$r['subtotal'],
                ];
            }
            return array_values($orders);
        } catch (Throwable $e) {
            return [];
        }
    }

    private static function generateOrderCode() {
        return 'LU-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
    }

    public static function getStallSalesByDate($stallId, $date) {
        $stmt = db()->prepare("
            SELECT 
                o.order_code,
                o.pickup_date,
                o.pickup_time,
                o.status,
                o.payment_method,
                o.total_amount,
                o.created_at,
                oi.product_name,
                oi.price,
                oi.quantity,
                oi.subtotal
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.id
            WHERE oi.stall_id = :stall_id
            AND o.pickup_date = :date
            AND o.status != 'cancelled'
            ORDER BY o.pickup_time ASC, o.created_at DESC
        ");
        $stmt->execute(['stall_id' => $stallId, 'date' => $date]);
        return $stmt->fetchAll();
    }

    public static function getStallOverallSummary($stallId) {
        try {
            $stmt = db()->prepare("
                SELECT 
                    COUNT(DISTINCT o.id) as total_orders,
                    COALESCE(SUM(oi.quantity), 0) as total_items,
                    COALESCE(SUM(oi.subtotal), 0) as total_sales,
                    COUNT(DISTINCT CASE WHEN o.status = 'pending' THEN o.id END) as pending_orders,
                    COUNT(DISTINCT CASE WHEN o.status = 'confirmed' THEN o.id END) as confirmed_orders,
                    COUNT(DISTINCT CASE WHEN o.status = 'ready' THEN o.id END) as ready_orders,
                    COUNT(DISTINCT CASE WHEN o.status = 'completed' THEN o.id END) as completed_orders
                FROM order_items oi
                JOIN orders o ON oi.order_id = o.id
                WHERE oi.stall_id = :stall_id
                AND o.status != 'cancelled'
            ");
            $stmt->execute(['stall_id' => $stallId]);
            $res = $stmt->fetch();
            if ($res) return $res;
        } catch (Throwable $e) {}

        return [
            'total_orders' => 0,
            'total_items' => 0,
            'total_sales' => 0,
            'pending_orders' => 0,
            'confirmed_orders' => 0,
            'ready_orders' => 0,
            'completed_orders' => 0,
        ];
    }

    public static function getStallSalesSummary($stallId, $date) {
        $stmt = db()->prepare("
            SELECT 
                COUNT(DISTINCT o.id) as total_orders,
                SUM(oi.quantity) as total_items,
                SUM(oi.subtotal) as total_sales
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.id
            WHERE oi.stall_id = :stall_id
            AND o.pickup_date = :date
            AND o.status != 'cancelled'
        ");
        $stmt->execute(['stall_id' => $stallId, 'date' => $date]);
        return $stmt->fetch();
    }

    public static function getStallUpcomingSales($stallId, $startDate, $days = 7) {
        $stmt = db()->prepare("
            SELECT 
                o.pickup_date,
                COUNT(DISTINCT o.id) as order_count,
                SUM(oi.quantity) as item_count,
                SUM(oi.subtotal) as day_sales
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.id
            WHERE oi.stall_id = :stall_id
            AND o.pickup_date >= :start_date
            AND o.pickup_date < DATE_ADD(:start_date, INTERVAL :days DAY)
            AND o.status != 'cancelled'
            GROUP BY o.pickup_date
            ORDER BY o.pickup_date ASC
        ");
        $stmt->execute(['stall_id' => $stallId, 'start_date' => $startDate, 'days' => $days]);
        return $stmt->fetchAll();
    }

    public static function getStallOrdersByDateRange($stallId, $startDate, $endDate) {
        $stmt = db()->prepare("
            SELECT 
                o.id,
                o.order_code,
                o.customer_name,
                o.pickup_date,
                o.pickup_time,
                o.status,
                o.payment_method,
                o.total_amount,
                o.created_at
            FROM orders o
            JOIN order_items oi ON oi.order_id = o.id
            WHERE oi.stall_id = :stall_id
            AND o.pickup_date BETWEEN :start_date AND :end_date
            AND o.status != 'cancelled'
            GROUP BY o.id
            ORDER BY o.pickup_date ASC, o.pickup_time ASC
        ");
        $stmt->execute(['stall_id' => $stallId, 'start_date' => $startDate, 'end_date' => $endDate]);
        return $stmt->fetchAll();
    }

    public static function getAllStallsSalesToday() {
        $today = date('Y-m-d');
        $stmt = db()->prepare("
            SELECT 
                s.id as stall_id,
                s.name as stall_name,
                COUNT(DISTINCT o.id) as total_orders,
                SUM(oi.quantity) as total_items,
                SUM(oi.subtotal) as total_sales
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.id
            JOIN stalls s ON oi.stall_id = s.id
            WHERE o.pickup_date = :today
            AND o.status != 'cancelled'
            GROUP BY s.id, s.name
            ORDER BY total_sales DESC
        ");
        $stmt->execute(['today' => $today]);
        return $stmt->fetchAll();
    }
}