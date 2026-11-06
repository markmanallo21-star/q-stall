<?php
if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . $path;
    if ($path !== '/' && is_file($file)) {
        return false;
    }
}

require_once __DIR__ . '/config.php';

require_once SRC_PATH . '/AuthController.php';
require_once SRC_PATH . '/HomeController.php';
require_once SRC_PATH . '/StallController.php';
require_once SRC_PATH . '/CartController.php';
require_once SRC_PATH . '/OrderController.php';
require_once SRC_PATH . '/VendorController.php';

$requestUri = $_SERVER['REQUEST_URI'];
$requestPath = strtok($requestUri, '?');

$basePath = BASE_URL;
$route = trim(str_replace($basePath, '', $requestPath), '/');
$route = $route === '' ? 'home' : $route;

$segments = explode('/', $route);
$segments[0] = $segments[0] === '' ? 'home' : $segments[0];

$method = $_SERVER['REQUEST_METHOD'];

$controllerMap = [
    'home' => 'HomeController',
    'landing' => 'HomeController',
    'menu' => 'HomeController',
    'pos' => 'HomeController',
    'dashboard' => 'HomeController',
    'login' => 'AuthController',
    'logout' => 'AuthController',
    'register' => 'AuthController',
    'profile' => 'AuthController',
    'vendor' => 'VendorController',
    'stalls' => 'StallController',
    'stall' => 'StallController',
    'products' => 'HomeController',
    'about' => 'HomeController',
    'contact' => 'HomeController',
    'cart' => 'CartController',
    'checkout' => 'OrderController',
    'order' => 'OrderController',
    'order-tracking' => 'OrderController',
    'order-confirmation' => 'OrderController',
];

$controllerClass = $controllerMap[$segments[0]] ?? null;

if (!$controllerClass || !class_exists($controllerClass)) {
    http_response_code(404);
    echo 'Page not found';
    exit;
}

$controller = new $controllerClass();

switch ($segments[0]) {
    case 'home':
    case 'landing':
        $controller->landing();
        break;

    case 'menu':
    case 'pos':
    case 'products':
        $controller->menu();
        break;

    case 'login':
        if ($method === 'POST') {
            $controller->login();
        } else {
            $controller->show();
        }
        break;

    case 'register':
        if ($method === 'POST') {
            $controller->register();
        } else {
            $controller->show();
        }
        break;

    case 'logout':
        $controller->logout();
        break;

    case 'profile':
        $controller->profile();
        break;

    case 'vendor':
        if (isset($segments[1]) && $segments[1] === 'orders') {
            $controller->orders();
        } elseif (isset($segments[1]) && ($segments[1] === 'update-status' || $segments[1] === 'status')) {
            $controller->updateStatus();
        } else {
            $controller->dashboard();
        }
        break;

    case 'stalls':
        $controller->index();
        break;

    case 'stall':
        if (!isset($segments[1]) || !is_numeric($segments[1])) {
            http_response_code(404);
            echo 'Stall not found';
            exit;
        }
        $controller->show((int) $segments[1]);
        break;

    case 'products':
        $controller->products();
        break;

    case 'about':
        $controller->about();
        break;

    case 'contact':
        $controller->contact();
        break;

    case 'cart':
        if ($method === 'POST' && isset($_POST['action'])) {
            if ($_POST['action'] === 'add') {
                $controller->add((int) ($_POST['product_id'] ?? 0));
            } elseif ($_POST['action'] === 'remove') {
                $controller->remove((int) ($_POST['product_id'] ?? 0));
            } elseif ($_POST['action'] === 'clear') {
                $controller->clear();
            } elseif ($_POST['action'] === 'update') {
                $controller->update();
            }
        } elseif (isset($segments[1])) {
            if ($segments[1] === 'add' && isset($segments[2])) {
                $controller->add((int) $segments[2]);
            } elseif ($segments[1] === 'update' && $method === 'POST') {
                $controller->update();
            } elseif ($segments[1] === 'remove' && isset($segments[2])) {
                $controller->remove((int) $segments[2]);
            } elseif ($segments[1] === 'clear') {
                $controller->clear();
            } else {
                $controller->index();
            }
        } else {
            $controller->index();
        }
        break;

    case 'checkout':
        $controller->checkout();
        break;

    case 'order':
        if (isset($segments[1]) && $segments[1] === 'store') {
            if ($method === 'POST') {
                $controller->store();
            } else {
                $controller->checkout();
            }
        } elseif (isset($segments[1]) && $segments[1] === 'track') {
            $code = $segments[2] ?? null;
            $controller->track($code);
        } elseif (isset($segments[1]) && $segments[1] === 'confirmation') {
            $controller->confirmation();
        } elseif (isset($segments[1]) && is_numeric($segments[1])) {
            $controller->track(null);
        } else {
            $controller->track(null);
        }
        break;

    case 'order-tracking':
        $code = $_GET['code'] ?? null;
        $controller->track($code);
        break;

    case 'order-confirmation':
        $controller->confirmation();
        break;

    default:
        http_response_code(404);
        echo 'Page not found';
        break;
}