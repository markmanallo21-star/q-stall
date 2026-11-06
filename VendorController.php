<?php
require_once SRC_PATH . '/Order.php';
require_once SRC_PATH . '/Stall.php';

class VendorController {
    public function dashboard() {
        if (!auth_check()) {
            flash('error', 'Please log in to access the vendor portal.');
            redirect('login');
            return;
        }

        $user = auth_user();

        // Check permission: Only stall_admin and admin allowed
        if ($user['role'] === 'customer') {
            flash('error', 'Access denied. The vendor dashboard is reserved for stall administrators only.');
            redirect('');
            return;
        }

        $isSuperAdmin = ($user['role'] === 'admin');
        $stalls = Stall::allActive();

        // If stall_admin, strictly restrict to their own stall_id
        if ($user['role'] === 'stall_admin') {
            $selectedStallId = (int)($user['stall_id'] ?? 1);
        } else {
            // Super Admin can switch stalls
            $selectedStallId = isset($_GET['stall_id']) ? (int)$_GET['stall_id'] : ($stalls[0]['id'] ?? 1);
        }

        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $weekStart = $today;

        $stall = Stall::find($selectedStallId);
        if (!$stall) {
            $stall = [
                'id' => $selectedStallId,
                'name' => $selectedStallId == 2 ? 'Chick-Chi-Laok' : ($selectedStallId == 3 ? 'Chaohaus' : 'Carbonation'),
                'tagline' => 'Laguna University Entrepreneurship Stall'
            ];
        }

        // Status filter for orders list: all, pending, confirmed, ready, completed
        $filterStatus = strtolower($_GET['status'] ?? 'all');

        // Detailed incoming orders for this stall
        $allOrders = Order::getStallOrdersDetailed($selectedStallId);
        
        // Filter orders if status is specified
        if ($filterStatus !== 'all') {
            $filteredOrders = array_values(array_filter($allOrders, function($o) use ($filterStatus) {
                return strtolower($o['status']) === $filterStatus;
            }));
        } else {
            $filteredOrders = $allOrders;
        }

        $todaySummary   = Order::getStallSalesSummary($selectedStallId, $today);
        $overallSummary = Order::getStallOverallSummary($selectedStallId);
        $upcomingSales  = Order::getStallUpcomingSales($selectedStallId, $weekStart, 7);
        $tomorrowSales  = Order::getStallSalesByDate($selectedStallId, $tomorrow);

        // Overall stalls summary only visible to Super Admin
        $allStallsToday = $isSuperAdmin ? Order::getAllStallsSalesToday() : [];

        $dashboardData = [
            'title'             => 'Stall Owner Dashboard - ' . $stall['name'],
            'user'              => $user,
            'isSuperAdmin'      => $isSuperAdmin,
            'stalls'            => $stalls,
            'selected_stall_id' => $selectedStallId,
            'selected_stall'    => $stall,
            'today'             => $today,
            'filter_status'     => $filterStatus,
            'detailed_orders'   => $filteredOrders,
            'all_orders_count'  => count($allOrders),
            'today_summary'     => $todaySummary,
            'overall_summary'   => $overallSummary,
            'upcoming_sales'    => $upcomingSales,
            'tomorrow_sales'    => $tomorrowSales,
            'all_stalls_today'  => $allStallsToday,
        ];

        layout('main', view('vendor-dashboard', $dashboardData), $dashboardData);
    }

    public function orders() {
        if (!auth_check()) {
            flash('error', 'Please log in to view orders.');
            redirect('login');
            return;
        }

        $user = auth_user();
        if ($user['role'] === 'customer') {
            flash('error', 'Access denied.');
            redirect('');
            return;
        }

        if ($user['role'] === 'stall_admin') {
            $stallId = (int)$user['stall_id'];
        } else {
            $stallId = isset($_GET['stall_id']) ? (int)$_GET['stall_id'] : 1;
        }

        $date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');
        $detailedOrders = Order::getStallOrdersDetailed($stallId, $date);
        $stall = Stall::find($stallId);

        $data = [
            'title'           => 'Orders - ' . ($stall['name'] ?? 'Stall') . ' - Laguna University',
            'user'            => $user,
            'stall'           => $stall,
            'detailed_orders' => $detailedOrders,
            'date'            => $date,
            'stall_id'        => $stallId,
        ];

        layout('main', view('vendor-orders', $data), $data);
    }

    public function updateStatus() {
        if (!auth_check()) {
            redirect('login');
            return;
        }

        $user = auth_user();
        if ($user['role'] === 'customer') {
            flash('error', 'Access denied.');
            redirect('');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $orderCode = trim($_POST['order_code'] ?? '');
            $newStatus = trim($_POST['status'] ?? '');

            if ($orderCode && $newStatus) {
                $res = Order::updateStatus($orderCode, $newStatus);
                if ($res) {
                    flash('success', "Order #{$orderCode} status successfully updated to " . ucfirst($newStatus) . "!");
                } else {
                    flash('error', "Failed to update order status.");
                }
            }
        }

        $referer = $_SERVER['HTTP_REFERER'] ?? url('vendor');
        header('Location: ' . $referer);
        exit;
    }
}
