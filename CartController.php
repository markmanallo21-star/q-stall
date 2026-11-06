<?php
require_once SRC_PATH . '/Product.php';

class CartController {
    public function index() {
        if ($this->isAjax()) {
            $this->sendJsonCart();
            return;
        }

        $data = [
            'title'        => 'My Order - Grill Restaurant',
            'cart_by_stall' => cart_by_stall(),
            'cart_total'   => cart_total(),
        ];

        layout('main', view('cart', $data), $data);
    }

    public function add($productId) {
        $quantity = max(1, (int) ($_POST['quantity'] ?? 1));
        $product = Product::findWithStall($productId);

        if ($product) {
            cart_add([
                'product_id' => $product['id'],
                'stall_id'   => $product['stall_id'],
                'stall_name' => $product['stall_name'] ?? 'Grill Restaurant',
                'name'       => $product['name'],
                'price'      => (float) $product['price'],
                'image'      => $product['image'] ?? null,
                'category'   => $product['category'] ?? 'Fast Food',
                'description'=> $product['description'] ?? '',
            ], $quantity);
            $msg = $product['name'] . ' added to order!';
            flash('success', $msg);
            if ($this->isAjax()) {
                $this->sendJsonCart(true, $msg);
                return;
            }
        } else {
            flash('error', 'Product not found or unavailable.');
            if ($this->isAjax()) {
                $this->sendJsonCart(false, 'Product not found.');
                return;
            }
        }

        redirect('home');
    }

    public function remove($productId) {
        cart_remove((int) $productId);
        flash('success', 'Item removed from order.');
        if ($this->isAjax()) {
            $this->sendJsonCart(true, 'Item removed.');
            return;
        }
        redirect('home');
    }

    public function clear() {
        cart_clear();
        flash('success', 'Order cleared.');
        if ($this->isAjax()) {
            $this->sendJsonCart(true, 'Order cleared.');
            return;
        }
        redirect('home');
    }

    public function update() {
        if (isset($_POST['quantity']) && is_array($_POST['quantity'])) {
            foreach ($_POST['quantity'] as $productId => $qty) {
                cart_update((int) $productId, (int) $qty);
            }
        } elseif (isset($_POST['product_id']) && isset($_POST['qty'])) {
            cart_update((int) $_POST['product_id'], (int) $_POST['qty']);
        }
        if ($this->isAjax()) {
            $this->sendJsonCart(true, 'Order updated.');
            return;
        }
        redirect('home');
    }

    private function isAjax() {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
            || (isset($_POST['ajax']) && $_POST['ajax'] == '1')
            || (isset($_GET['ajax']) && $_GET['ajax'] == '1')
            || (isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == '1')
            || (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);
    }

    private function sendJsonCart($success = true, $message = '') {
        header('Content-Type: application/json');
        $rawCart = cart();
        $items = [];
        foreach ($rawCart as $item) {
            $item['image_url'] = product_image_url($item['image'] ?? null);
            $item['subtotal'] = $item['price'] * $item['quantity'];
            $item['subtotal_formatted'] = '₱' . number_format($item['subtotal'], 2);
            $item['price_formatted'] = '₱' . number_format($item['price'], 2);
            $items[] = $item;
        }
        $total = cart_total();
        $discount = 3.00;
        $finalTotal = max(0, $total - ($total > 0 ? $discount : 0));

        echo json_encode([
            'success' => $success,
            'message' => $message,
            'items' => $items,
            'count' => cart_count(),
            'total' => $total,
            'total_formatted' => '₱' . number_format($total, 2),
            'discount' => ($total > 0 ? $discount : 0),
            'discount_formatted' => ($total > 0 ? '-₱' . number_format($discount, 2) : '₱0.00'),
            'final_total' => $finalTotal,
            'final_total_formatted' => '₱' . number_format($finalTotal, 2),
        ]);
        exit;
    }
}
