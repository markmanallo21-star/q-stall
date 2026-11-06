<?php
$stallName = $selected_stall['name'] ?? 'Stall Dashboard';
$stallId = (int)($selected_stall['id'] ?? 1);

// Stall theme accent colors
$themeColor = '#f25c54'; // Coral
$themeIcon = 'bi-shop';

if ($stallId == 2) { // Chick-Chi-Laok
    $themeColor = '#ea580c';
    $themeIcon = 'bi-fire';
} elseif ($stallId == 3) { // Chaohaus
    $themeColor = '#dc2626';
    $themeIcon = 'bi-box2-heart';
} elseif ($stallId == 1) { // Carbonation
    $themeColor = '#0284c7';
    $themeIcon = 'bi-cup-straw';
}

$pendingCount   = $overall_summary['pending_orders'] ?? 0;
$confirmedCount = $overall_summary['confirmed_orders'] ?? 0;
$readyCount     = $overall_summary['ready_orders'] ?? 0;
$completedCount = $overall_summary['completed_orders'] ?? 0;
$totalOrders    = $overall_summary['total_orders'] ?? 0;
?>

<div class="coral-vendor-theme">

    <!-- Top Bar: Search Orders & User Profile Header matching POS Coral layout -->
    <header class="coral-top-bar mb-4">
        <div class="coral-search-wrap">
            <i class="bi bi-search coral-search-icon"></i>
            <input type="text" 
                   id="coralOrderSearchInput" 
                   class="coral-search-input" 
                   placeholder="Search received orders, customer name, or code..." 
                   autocomplete="off">
        </div>

        <div class="coral-user-profile">
            <div class="coral-avatar">
                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&h=120&q=80" 
                     alt="Owner Avatar" 
                     onerror="this.src='<?= url('assets/uploads/products/121.jpg') ?>'">
            </div>
            <div class="coral-user-info">
                <span class="coral-user-name"><?= htmlspecialchars($user['full_name'] ?? $stallName) ?></span>
                <span class="coral-user-role"><?= htmlspecialchars($stallName) ?> &bull; <?= htmlspecialchars(ucfirst($user['role'] ?? 'Owner')) ?></span>
            </div>
            <a href="<?= url('logout') ?>" class="coral-dot-menu-btn text-danger text-decoration-none" title="Log Out">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </header>

    <!-- Stall Branding & Status Alert Bar -->
    <div class="coral-vendor-header-bar">
        <div class="coral-vendor-badge-wrap">
            <div class="coral-vendor-avatar-icon" style="background: <?= $themeColor ?>18; color: <?= $themeColor ?>;">
                <i class="bi <?= $themeIcon ?>"></i>
            </div>
            <div class="coral-vendor-title-wrap">
                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                    <span class="badge" style="background: <?= $themeColor ?>; color:#fff; font-weight:700; border-radius:8px; padding: 5px 10px;">
                        <?= htmlspecialchars($stallName) ?> &bull; Stall #<?= $stallId ?>
                    </span>
                    <?php if ($user['role'] === 'stall_admin'): ?>
                        <span class="badge bg-light text-dark border">
                            <i class="bi bi-shield-lock-fill text-success me-1"></i> Dedicated Stall Owner Dashboard
                        </span>
                    <?php elseif ($isSuperAdmin): ?>
                        <span class="badge bg-warning text-dark">
                            <i class="bi bi-shield-check me-1"></i> Super Admin
                        </span>
                    <?php endif; ?>

                    <?php if ($pendingCount > 0): ?>
                        <span class="badge bg-danger animate-pulse">
                            <i class="bi bi-bell-fill me-1"></i> <?= $pendingCount ?> New Order<?= $pendingCount > 1 ? 's' : '' ?> Pending
                        </span>
                    <?php endif; ?>
                </div>
                <h1><?= htmlspecialchars($stallName) ?> Order Tracking &amp; Sales Dashboard</h1>
                <p>Monitor real-time student orders, track items sold, and update preparation statuses.</p>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <?php if ($isSuperAdmin): ?>
                <!-- Stall Switcher for Super Admin -->
                <form method="GET" class="d-flex align-items-center gap-2 bg-light p-2 rounded-3 border">
                    <label class="small text-muted text-nowrap fw-bold">Switch Stall:</label>
                    <select name="stall_id" class="form-select form-select-sm coral-input" onchange="this.form.submit()" style="width: auto;">
                        <?php foreach ($stalls as $s): ?>
                            <option value="<?= $s['id'] ?>" <?= $selected_stall_id == $s['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($s['name']) ?> (Stall #<?= $s['id'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            <?php endif; ?>

            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="window.location.reload()" title="Refresh data">
                <i class="bi bi-arrow-clockwise me-1"></i> Refresh
            </button>
        </div>
    </div>

    <!-- Coral Metrics Cards -->
    <div class="coral-vendor-metrics-grid">
        <!-- Today's Sales -->
        <div class="coral-vendor-stat-tile">
            <div class="coral-vendor-stat-icon" style="background:#ecfdf5; color:#059669;">
                <i class="bi bi-currency-peso"></i>
            </div>
            <div class="coral-vendor-stat-details">
                <span class="coral-vendor-stat-label">Today's Stall Sales</span>
                <div class="coral-vendor-stat-val" style="color: <?= $themeColor ?>;">
                    ₱<?= number_format($today_summary['total_sales'] ?? 0, 2) ?>
                </div>
                <span class="coral-vendor-stat-sub"><i class="bi bi-calendar-event me-1"></i><?= date('F j, Y') ?></span>
            </div>
        </div>

        <!-- All-Time Cumulative Sales -->
        <div class="coral-vendor-stat-tile">
            <div class="coral-vendor-stat-icon" style="background:#fef3c7; color:#d97706;">
                <i class="bi bi-cash-stack"></i>
            </div>
            <div class="coral-vendor-stat-details">
                <span class="coral-vendor-stat-label">All-Time Revenue</span>
                <div class="coral-vendor-stat-val">
                    ₱<?= number_format($overall_summary['total_sales'] ?? 0, 2) ?>
                </div>
                <span class="coral-vendor-stat-sub">Total stall earnings</span>
            </div>
        </div>

        <!-- Orders Received -->
        <div class="coral-vendor-stat-tile">
            <div class="coral-vendor-stat-icon" style="background:#eff6ff; color:#2563eb;">
                <i class="bi bi-inbox-fill"></i>
            </div>
            <div class="coral-vendor-stat-details">
                <span class="coral-vendor-stat-label">Orders Received</span>
                <div class="coral-vendor-stat-val"><?= (int)$totalOrders ?></div>
                <span class="coral-vendor-stat-sub"><?= (int)$pendingCount ?> need kitchen action</span>
            </div>
        </div>

        <!-- Total Items Sold -->
        <div class="coral-vendor-stat-tile">
            <div class="coral-vendor-stat-icon" style="background:#fdf2f8; color:#db2777;">
                <i class="bi bi-box-seam-fill"></i>
            </div>
            <div class="coral-vendor-stat-details">
                <span class="coral-vendor-stat-label">Units Sold</span>
                <div class="coral-vendor-stat-val"><?= (int)($overall_summary['total_items'] ?? 0) ?></div>
                <span class="coral-vendor-stat-sub">Dishes &amp; drinks prepared</span>
            </div>
        </div>
    </div>

    <!-- Filter Tabs (matching screenshot tile pill look) -->
    <div class="coral-vendor-filters-row">
        <div class="coral-filter-tile-list">
            <a href="<?= url('vendor' . ($isSuperAdmin ? '?stall_id=' . $selectedStallId . '&status=all' : '?status=all')) ?>" 
               class="coral-filter-pill-btn <?= $filter_status === 'all' ? 'active' : '' ?>">
                All Orders (<?= (int)$all_orders_count ?>)
            </a>
            <a href="<?= url('vendor' . ($isSuperAdmin ? '?stall_id=' . $selectedStallId . '&status=pending' : '?status=pending')) ?>" 
               class="coral-filter-pill-btn <?= $filter_status === 'pending' ? 'active' : '' ?>">
                <i class="bi bi-clock-history"></i> Pending (<?= (int)$pendingCount ?>)
            </a>
            <a href="<?= url('vendor' . ($isSuperAdmin ? '?stall_id=' . $selectedStallId . '&status=confirmed' : '?status=confirmed')) ?>" 
               class="coral-filter-pill-btn <?= $filter_status === 'confirmed' ? 'active' : '' ?>">
                <i class="bi bi-fire"></i> Confirmed (<?= (int)$confirmedCount ?>)
            </a>
            <a href="<?= url('vendor' . ($isSuperAdmin ? '?stall_id=' . $selectedStallId . '&status=ready' : '?status=ready')) ?>" 
               class="coral-filter-pill-btn <?= $filter_status === 'ready' ? 'active' : '' ?>">
                <i class="bi bi-bag-check"></i> Ready (<?= (int)$readyCount ?>)
            </a>
            <a href="<?= url('vendor' . ($isSuperAdmin ? '?stall_id=' . $selectedStallId . '&status=completed' : '?status=completed')) ?>" 
               class="coral-filter-pill-btn <?= $filter_status === 'completed' ? 'active' : '' ?>">
                <i class="bi bi-check2-all"></i> Completed (<?= (int)$completedCount ?>)
            </a>
        </div>

        <div class="form-check form-switch mb-0 small text-muted">
            <input class="form-check-input" type="checkbox" id="coralAutoRefreshToggle" checked>
            <label class="form-check-label" for="coralAutoRefreshToggle">Live Auto-Refresh (20s)</label>
        </div>
    </div>

    <!-- Orders Main Card -->
    <div class="coral-table-card mb-4">
        <div class="coral-table-card-header">
            <h2 class="coral-table-card-title">
                <i class="bi bi-receipt me-2" style="color:<?= $themeColor ?>;"></i>
                Received Orders for <?= htmlspecialchars($stallName) ?> (<?= count($detailed_orders ?? []) ?>)
            </h2>
            <span class="small text-muted">Showing <?= $filter_status === 'all' ? 'all' : ucfirst($filter_status) ?> orders</span>
        </div>

        <div class="p-0">
            <?php if (!empty($detailed_orders)): ?>
                <div class="table-responsive">
                    <table class="table coral-orders-table align-middle mb-0" id="coralVendorOrdersTable">
                        <thead>
                            <tr>
                                <th class="ps-4">Time &amp; Order Code</th>
                                <th>Customer Details</th>
                                <th>Ordered Items (<?= htmlspecialchars($stallName) ?>)</th>
                                <th class="text-end">Stall Subtotal</th>
                                <th class="text-center">Status</th>
                                <th class="text-end pe-4">Kitchen Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($detailed_orders as $ord): 
                                $statusCode = strtolower($ord['status']);
                                $statusBadgeClass = match($statusCode) {
                                    'pending'   => 'bg-warning text-dark',
                                    'confirmed' => 'bg-primary text-white',
                                    'ready'     => 'bg-info text-white',
                                    'completed' => 'bg-success text-white',
                                    'cancelled' => 'bg-danger text-white',
                                    default     => 'bg-secondary text-white'
                                };
                            ?>
                                <tr class="order-row <?= $statusCode === 'pending' ? 'table-warning-subtle' : '' ?>"
                                    data-customer="<?= htmlspecialchars(strtolower($ord['customer_name'])) ?>"
                                    data-code="<?= htmlspecialchars(strtolower($ord['order_code'])) ?>">
                                    
                                    <!-- Time & Code -->
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">
                                            <i class="bi bi-clock me-1 text-muted"></i><?= date('g:i A', strtotime($ord['pickup_time'])) ?>
                                        </div>
                                        <div class="small text-muted">
                                            <i class="bi bi-calendar3 me-1"></i><?= date('M j, Y', strtotime($ord['pickup_date'])) ?>
                                        </div>
                                        <a href="<?= url('order-tracking?code=' . urlencode($ord['order_code'])) ?>" 
                                           target="_blank" 
                                           class="small text-decoration-none fw-semibold" 
                                           style="color: <?= $themeColor ?>;">
                                            <?= htmlspecialchars($ord['order_code']) ?> <i class="bi bi-box-arrow-up-right small"></i>
                                        </a>
                                        <div class="mt-1">
                                            <span class="badge bg-light text-dark border small">
                                                <?= htmlspecialchars(strtoupper($ord['payment_method'])) ?>
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Customer Details -->
                                    <td>
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($ord['customer_name']) ?></div>
                                        <div class="small">
                                            <a href="tel:<?= htmlspecialchars($ord['customer_contact']) ?>" class="text-decoration-none text-muted">
                                                <i class="bi bi-telephone me-1 text-success"></i><?= htmlspecialchars($ord['customer_contact']) ?>
                                            </a>
                                        </div>
                                        <?php if (!empty($ord['notes'])): ?>
                                            <div class="small text-danger fst-italic mt-1" style="max-width: 220px;">
                                                <i class="bi bi-chat-quote-fill me-1"></i>"<?= htmlspecialchars($ord['notes']) ?>"
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Stall Items Only -->
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            <?php foreach ($ord['items'] as $item): ?>
                                                <div class="d-flex align-items-center justify-content-between gap-2 small py-1 border-bottom" style="border-style: dashed !important; border-color: #f1f5f9 !important;">
                                                    <span class="text-dark">
                                                        <span class="badge bg-dark text-white rounded-pill px-2 me-1"><?= $item['quantity'] ?>x</span>
                                                        <strong><?= htmlspecialchars($item['product_name']) ?></strong>
                                                    </span>
                                                    <span class="text-muted fw-bold">₱<?= number_format($item['subtotal'], 2) ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </td>

                                    <!-- Stall Subtotal -->
                                    <td class="text-end">
                                        <div class="fw-bold fs-5 text-dark">₱<?= number_format($ord['stall_total'], 2) ?></div>
                                        <small class="text-muted">Stall portion</small>
                                    </td>

                                    <!-- Status Pill -->
                                    <td class="text-center">
                                        <span class="badge <?= $statusBadgeClass ?> px-3 py-2 rounded-pill text-uppercase" style="letter-spacing: 0.5px; font-size: 0.72rem;">
                                            <?= Order::statusLabel($ord['status']) ?>
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="text-end pe-4">
                                        <div class="d-flex flex-column align-items-end gap-1">
                                            <?php if ($statusCode === 'pending'): ?>
                                                <form method="POST" action="<?= url('vendor/update-status') ?>" class="d-inline">
                                                    <input type="hidden" name="order_code" value="<?= htmlspecialchars($ord['order_code']) ?>">
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="btn btn-sm coral-action-btn-primary">
                                                        <i class="bi bi-check-lg me-1"></i> Confirm Order
                                                    </button>
                                                </form>
                                            <?php elseif ($statusCode === 'confirmed'): ?>
                                                <form method="POST" action="<?= url('vendor/update-status') ?>" class="d-inline">
                                                    <input type="hidden" name="order_code" value="<?= htmlspecialchars($ord['order_code']) ?>">
                                                    <input type="hidden" name="status" value="ready">
                                                    <button type="submit" class="btn btn-sm btn-info text-white rounded-pill px-3 py-1 fw-bold">
                                                        <i class="bi bi-bell-fill me-1"></i> Mark Ready
                                                    </button>
                                                </form>
                                            <?php elseif ($statusCode === 'ready'): ?>
                                                <form method="POST" action="<?= url('vendor/update-status') ?>" class="d-inline">
                                                    <input type="hidden" name="order_code" value="<?= htmlspecialchars($ord['order_code']) ?>">
                                                    <input type="hidden" name="status" value="completed">
                                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 py-1 fw-bold">
                                                        <i class="bi bi-check2-all me-1"></i> Mark Completed
                                                    </button>
                                                </form>
                                            <?php endif; ?>

                                            <!-- Full Status Dropdown Selector -->
                                            <form method="POST" action="<?= url('vendor/update-status') ?>" class="d-inline-flex align-items-center gap-1 mt-1">
                                                <input type="hidden" name="order_code" value="<?= htmlspecialchars($ord['order_code']) ?>">
                                                <select name="status" class="form-select form-select-sm coral-input py-1" style="width: 125px; font-size: 0.74rem;" onchange="this.form.submit()">
                                                    <option value="pending" <?= $statusCode === 'pending' ? 'selected' : '' ?>>Set Pending</option>
                                                    <option value="confirmed" <?= $statusCode === 'confirmed' ? 'selected' : '' ?>>Set Confirmed</option>
                                                    <option value="ready" <?= $statusCode === 'ready' ? 'selected' : '' ?>>Set Ready</option>
                                                    <option value="completed" <?= $statusCode === 'completed' ? 'selected' : '' ?>>Set Completed</option>
                                                    <option value="cancelled" <?= $statusCode === 'cancelled' ? 'selected' : '' ?>>Cancel Order</option>
                                                </select>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1 mb-2 d-block opacity-50"></i>
                    <h3 class="h6 fw-bold text-dark">No orders found matching this filter</h3>
                    <p class="small text-muted mb-0">Orders containing food or drinks from <?= htmlspecialchars($stallName) ?> will show up here live!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Campus Stalls Comparison (Super Admin Only) -->
    <?php if ($isSuperAdmin && !empty($all_stalls_today)): ?>
        <div class="coral-table-card mb-4">
            <div class="coral-table-card-header">
                <h2 class="coral-table-card-title">
                    <i class="bi bi-bar-chart-fill text-warning me-2"></i>Campus Stalls Performance Comparison (Super Admin)
                </h2>
            </div>
            <div class="p-3">
                <div class="row g-3">
                    <?php foreach ($all_stalls_today as $idx => $sRank): ?>
                        <div class="col-md-4">
                            <div class="p-3 rounded-4 border bg-light d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="badge bg-white text-dark border rounded-circle p-2 fs-6" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center;">
                                        #<?= $idx + 1 ?>
                                    </span>
                                    <div>
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($sRank['stall_name']) ?></div>
                                        <small class="text-muted"><?= $sRank['total_orders'] ?> orders &bull; <?= $sRank['total_items'] ?> items</small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold fs-6" style="color: #f25c54;">₱<?= number_format($sRank['total_sales'], 2) ?></span>
                                    <div>
                                        <a href="<?= url('vendor?stall_id=' . $sRank['stall_id']) ?>" class="small text-decoration-none fw-semibold">View &raquo;</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>

<script>
// Live Auto-Refresh
(function() {
    var timer = null;
    var toggle = document.getElementById('coralAutoRefreshToggle');
    function startTimer() {
        timer = setInterval(function() {
            if (toggle && toggle.checked) {
                window.location.reload();
            }
        }, 20000);
    }
    startTimer();
    if (toggle) {
        toggle.addEventListener('change', function() {
            if (!this.checked && timer) clearInterval(timer);
            else if (this.checked) startTimer();
        });
    }

    // Live search filter on orders table
    var searchInput = document.getElementById('coralOrderSearchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            var q = this.value.trim().toLowerCase();
            var rows = document.querySelectorAll('#coralVendorOrdersTable tbody tr.order-row');
            rows.forEach(function(row) {
                var cust = row.getAttribute('data-customer') || '';
                var code = row.getAttribute('data-code') || '';
                if (q === '' || cust.includes(q) || code.includes(q)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
})();
</script>
