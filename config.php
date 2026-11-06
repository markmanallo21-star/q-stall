<?php
if (session_status() === PHP_SESSION_NONE) {
    @session_start();
}

define('BASE_PATH', __DIR__);
define('PUBLIC_PATH', BASE_PATH);
define('SRC_PATH', BASE_PATH);
define('ASSETS_URL', '/assets');
define('BASE_URL', '');
define('UPLOAD_PATH', PUBLIC_PATH . '/assets/uploads');

$config = [
    'app' => [
        'name' => 'Laguna University - BS Entrepreneurship Stall',
        'url' => 'http://localhost/laguna-stall',
        'debug' => true,
    ],
    'db' => [
        'host' => 'localhost',
        'name' => 'laguna_university_stall',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4',
    ],
];

if ($config['app']['debug']) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

function db() {
    global $config;
    static $pdo = null;

    if ($pdo === null) {
        $dsn = "mysql:host={$config['db']['host']};dbname={$config['db']['name']};charset={$config['db']['charset']}";
        $pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    return $pdo;
}

function view($name, $data = []) {
    extract($data);
    ob_start();
    require SRC_PATH . "/{$name}.php";
    return ob_get_clean();
}

function layout($name, $content, $data = []) {
    extract($data);
    ob_start();
    require SRC_PATH . "/{$name}.php";
    ob_end_flush();
}

function asset($path) {
    return ASSETS_URL . '/' . ltrim($path, '/');
}

function url($path = '') {
    return BASE_URL . '/' . ltrim($path, '/');
}

function redirect($path) {
    header('Location: ' . url($path));
    exit;
}

function product_image_url($image) {
    if (!$image) {
        return url('assets/uploads/products/121.jpg');
    }
    if (file_exists(BASE_PATH . '/assets/uploads/products/' . $image)) {
        return url('assets/uploads/products/' . $image);
    }
    if (file_exists(BASE_PATH . '/' . $image)) {
        return url($image);
    }
    return url('assets/uploads/products/' . $image);
}

// ---------------------------------------------------------
// CART HELPERS (session-based, supports multiple stalls)
// Cart shape: $_SESSION['cart'][product_id] = [
//     'product_id' => int, 'stall_id' => int, 'stall_name' => string,
//     'name' => string, 'price' => float, 'quantity' => int
// ]
// ---------------------------------------------------------
function cart() {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    return $_SESSION['cart'];
}

function cart_add($product, $quantity = 1) {
    $cart = cart();
    $id = $product['product_id'] ?? $product['id'];

    if (isset($cart[$id])) {
        $cart[$id]['quantity'] += $quantity;
    } else {
        $cart[$id] = [
            'product_id' => $id,
            'stall_id'   => $product['stall_id'],
            'stall_name' => $product['stall_name'] ?? '',
            'name'       => $product['name'],
            'price'      => (float) $product['price'],
            'description'=> $product['description'] ?? '',
            'image'      => $product['image'] ?? null,
            'category'   => $product['category'] ?? 'food',
            'quantity'   => $quantity,
        ];
    }

    $_SESSION['cart'] = $cart;
}

function cart_update($productId, $quantity) {
    $cart = cart();
    if (!isset($cart[$productId])) return;

    if ($quantity <= 0) {
        unset($cart[$productId]);
    } else {
        $cart[$productId]['quantity'] = $quantity;
    }

    $_SESSION['cart'] = $cart;
}

function cart_remove($productId) {
    $cart = cart();
    unset($cart[$productId]);
    $_SESSION['cart'] = $cart;
}

function cart_clear() {
    $_SESSION['cart'] = [];
}

function cart_count() {
    $count = 0;
    foreach (cart() as $item) {
        $count += $item['quantity'];
    }
    return $count;
}

function cart_total() {
    $total = 0;
    foreach (cart() as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

// Group cart items by stall - useful for checkout summary
function cart_by_stall() {
    $grouped = [];
    foreach (cart() as $item) {
        $grouped[$item['stall_id']]['stall_name'] = $item['stall_name'];
        $grouped[$item['stall_id']]['items'][] = $item;
    }
    return $grouped;
}

function flash(string $key, string $message = null) {
    if ($message === null) {
        $msg = $_SESSION['flash'][$key] ?? null;
        unset($_SESSION['flash'][$key]);
        return $msg;
    }
    $_SESSION['flash'][$key] = $message;
}

function uploadFile(array $file, string $subdir = 'misc') {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $allowed = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowed)) {
        return null;
    }

    $targetDir = UPLOAD_PATH . '/' . $subdir;
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $ext;
    $destination = $targetDir . '/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return $filename;
    }

    return null;
}

// Auth helpers
function auth_user() {
    return $_SESSION['user'] ?? null;
}

function auth_check() {
    return isset($_SESSION['user']);
}

function auth_login(array $user) {
    $_SESSION['user'] = [
        'id'        => $user['id'],
        'email'     => $user['email'],
        'full_name' => $user['full_name'],
        'role'      => $user['role'],
        'stall_id'  => $user['stall_id'] ?? null,
    ];
}

function auth_is_stall_admin(): bool {
    $u = auth_user();
    return $u && $u['role'] === 'stall_admin';
}

function auth_is_admin(): bool {
    $u = auth_user();
    return $u && ($u['role'] === 'admin' || $u['role'] === 'stall_admin');
}

function auth_is_customer(): bool {
    $u = auth_user();
    return $u && $u['role'] === 'customer';
}

function auth_stall_id(): ?int {
    $u = auth_user();
    return $u ? (isset($u['stall_id']) ? (int)$u['stall_id'] : null) : null;
}

function require_login(string $redirectTo = 'login'): void {
    if (!auth_check()) {
        flash('error', 'Please log in to continue.');
        redirect($redirectTo);
        exit;
    }
}

function require_stall_admin(): void {
    require_login();
    if (!auth_is_stall_admin() && !(auth_user()['role'] === 'admin')) {
        flash('error', 'Access denied. Stall admin only.');
        redirect('');
        exit;
    }
}

function auth_logout() {
    unset($_SESSION['user']);
}

function auth_hash(string $password): string {
    return password_hash($password, PASSWORD_DEFAULT);
}

function auth_verify(string $password, string $hash): bool {
    return password_verify($password, $hash);
}