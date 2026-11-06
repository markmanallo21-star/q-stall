<?php
require_once SRC_PATH . '/Order.php';
require_once SRC_PATH . '/Product.php';

class OrderController {
    public function checkout() {
        if (!auth_check()) {
            flash('error', 'Please log in or create an account to proceed to checkout.');
            redirect('login');
            return;
        }

        if (empty(cart())) {
            flash('error', 'Your cart is empty.');
            redirect('menu');
            return;
        }

        $data = [
            'title'        => 'Checkout - BS Entrepreneurship Stall',
            'cart_by_stall' => cart_by_stall(),
            'cart_total'   => cart_total(),
            'errors'       => $_SESSION['checkout_errors'] ?? [],
        ];
        unset($_SESSION['checkout_errors']);

        layout('site-layout', view('checkout', $data), $data);
    }

    public function store() {
        if (!auth_check()) {
            flash('error', 'Please sign in or register to place your order.');
            redirect('login');
            return;
        }

        $cartItems = cart();

        if (empty($cartItems)) {
            flash('error', 'Your cart is empty.');
            redirect('menu');
            return;
        }

        $errors = [];

        $name    = trim($_POST['customer_name'] ?? '');
        $email   = trim($_POST['customer_email'] ?? '');
        $contact = trim($_POST['customer_contact'] ?? '');
        $date    = trim($_POST['pickup_date'] ?? '');
        $time    = trim($_POST['pickup_time'] ?? '');
        $method  = strtolower($_POST['payment_method'] ?? 'cash');
        if ($method === 'ewallet') $method = 'gcash';
        if ($method === 'debit') $method = 'cash';
        $notes   = trim($_POST['notes'] ?? '');

        if ($name === '')    $errors[] = 'Full name is required.';
        if ($email === '')   $errors[] = 'Email is required.';
        if ($contact === '') $errors[] = 'Contact number is required.';
        if ($date === '')    $errors[] = 'Pickup date is required.';
        if ($time === '')    $errors[] = 'Pickup time is required.';
        if (!in_array($method, ['cash', 'gcash', 'debit'])) $errors[] = 'Invalid payment method.';

        if ($date !== '' && strtotime($date) < strtotime(date('Y-m-d'))) {
            $errors[] = 'Pickup date cannot be in the past.';
        }

        $proofFilename = null;
        if ($method === 'gcash') {
            if (empty($_FILES['payment_proof']['name'])) {
                $errors[] = 'Please upload your GCash payment screenshot.';
            } else {
                $proofFilename = $this->handleUpload($_FILES['payment_proof'], $errors);
            }
        }

        if (!empty($errors)) {
            $_SESSION['checkout_errors'] = $errors;
            redirect('checkout');
            return;
        }

        $orderCode = Order::create([
            'customer_name'    => $name,
            'customer_email'   => $email,
            'customer_contact' => $contact,
            'pickup_date'      => $date,
            'pickup_time'      => $time,
            'payment_method'   => $method,
            'payment_proof'    => $proofFilename,
            'notes'            => $notes,
        ], $cartItems);

        cart_clear();

        if ($orderCode) {
            $_SESSION['order_code'] = $orderCode;
            redirect('order-confirmation');
        } else {
            flash('error', 'Failed to place order. Please try again.');
            redirect('checkout');
            return;
        }
    }

    public function confirmation() {
        $orderCode = $_SESSION['order_code'] ?? ($_SESSION['recent_order']['order_code'] ?? null);

        if (!$orderCode) {
            redirect('home');
            return;
        }

        $order = Order::findByCode($orderCode);

        if (!$order) {
            redirect('home');
            return;
        }

        $data = [
            'title' => 'Order Confirmed - Grill Restaurant',
            'order' => $order,
            'items' => Order::itemsForOrder($order['id']),
        ];

        layout('site-layout', view('order-confirmation', $data), $data);
    }

    public function track($code = null) {
        if (!$code) {
            $code = trim($_GET['code'] ?? '');
        }

        if (!$code && isset($_SESSION['order_code'])) {
            $code = $_SESSION['order_code'];
        } elseif (!$code && isset($_SESSION['recent_order']['order_code'])) {
            $code = $_SESSION['recent_order']['order_code'];
        }

        $recentCode = $_SESSION['recent_order']['order_code'] ?? ($_SESSION['order_code'] ?? null);

        $data = [
            'title'       => 'Order Tracking - Laguna University Stall',
            'search_code' => $code,
            'recent_code' => $recentCode,
            'order'       => null,
            'items'       => [],
            'error'       => null,
        ];

        if ($code) {
            $order = Order::findByCode($code);
            if ($order) {
                $data['order'] = $order;
                $data['items'] = Order::itemsForOrder($order['id']);
            } else {
                $data['error'] = 'No order found with code "' . htmlspecialchars($code) . '". Please check your receipt or order code.';
            }
        }

        layout('site-layout', view('order-tracking', $data), $data);
    }

    private function handleUpload($file, &$errors) {
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($file['type'], $allowed)) {
            $errors[] = 'Payment proof must be a JPG, PNG, or WEBP image.';
            return null;
        }
        if ($file['size'] > 3 * 1024 * 1024) {
            $errors[] = 'Payment proof must be smaller than 3MB.';
            return null;
        }

        $uploadDir = PUBLIC_PATH . '/assets/uploads/payments';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'proof_' . uniqid() . '.' . $ext;

        if (!move_uploaded_file($file['tmp_name'], $uploadDir . '/' . $filename)) {
            $errors[] = 'Failed to upload payment proof. Please try again.';
            return null;
        }

        return $filename;
    }
}