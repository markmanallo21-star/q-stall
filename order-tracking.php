<?php
$searchCode = $search_code ?? '';
$recentCode = $recent_code ?? null;
$error = $error ?? null;
$order = $order ?? null;
$items = $items ?? [];

// Status index mapping
$status = strtolower($order['status'] ?? 'pending');
$statusStep = 1;
if ($status === 'confirmed') $statusStep = 2;
elseif ($status === 'ready') $statusStep = 3;
elseif ($status === 'completed') $statusStep = 4;
elseif ($status === 'cancelled') $statusStep = -1;
?>

<div class="pos-tracking-page">
    <div class="pos-tracking-container">

        <!-- Top Header & Back Link -->
        <div class="pos-tracking-header">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <a href="<?= url() ?>" class="pos-tracking-back-link">
                    <i class="bi bi-arrow-left me-1"></i> Back to Home
                </a>
                <a href="<?= url('menu') ?>" class="badge bg-warning text-dark text-decoration-none px-3 py-2 rounded-pill fw-semibold">
                    <i class="bi bi-grid-fill me-1"></i> Open POS Menu
                </a>
            </div>

            <div class="pos-tracking-title-wrap">
                <h1 class="pos-tracking-title">Live Order Tracking</h1>
                <p class="pos-tracking-subtitle">Monitor the live preparation, pickup schedule, and receipt of your order.</p>
            </div>

            <!-- Search Bar to look up order code -->
            <form action="<?= url('order-tracking') ?>" method="GET" class="pos-tracking-search-form">
                <div class="pos-tracking-search-bar">
                    <i class="bi bi-search pos-tracking-search-icon"></i>
                    <input type="text" 
                           name="code" 
                           class="pos-tracking-search-input" 
                           placeholder="Enter order code (e.g. <?= $recentCode ?: 'LU-20261105-8BB89' ?>)" 
                           value="<?= htmlspecialchars($searchCode) ?>" 
                           required 
                           autocomplete="off">
                    <button type="submit" class="pos-tracking-search-btn">
                        Track Order
                    </button>
                </div>
            </form>

            <?php if ($recentCode && $searchCode !== $recentCode): ?>
                <div class="pos-tracking-recent-pill-wrap">
                    <span class="text-muted small">Your recent order:</span>
                    <a href="<?= url('order-tracking?code=' . urlencode($recentCode)) ?>" class="pos-tracking-recent-chip">
                        <i class="bi bi-clock-history me-1"></i><?= htmlspecialchars($recentCode) ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($error): ?>
            <!-- Error Alert -->
            <div class="pos-tracking-error-card">
                <div class="pos-tracking-error-icon">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
                <div>
                    <h3 class="pos-tracking-error-title">Order Not Found</h3>
                    <p class="pos-tracking-error-desc"><?= htmlspecialchars($error) ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($order): ?>
            <!-- ============================================== -->
            <!-- LIVE STATUS TIMELINE STEPPER                   -->
            <!-- ============================================== -->
            <div class="pos-tracking-stepper-card">
                <div class="pos-stepper-header">
                    <div>
                        <span class="pos-order-code-eyebrow">Tracking Order</span>
                        <div class="d-flex align-items-center gap-2">
                            <h2 class="pos-order-code-title">#<?= htmlspecialchars($order['order_code']) ?></h2>
                            <button type="button" class="pos-copy-code-btn" onclick="copyOrderCode('<?= htmlspecialchars($order['order_code']) ?>')" title="Copy Order Code">
                                <i class="bi bi-copy"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <?php if ($status === 'cancelled'): ?>
                            <span class="badge bg-danger px-3 py-2 rounded-pill fs-6">
                                <i class="bi bi-x-circle me-1"></i> Cancelled
                            </span>
                        <?php else: ?>
                            <span class="pos-status-badge status-<?= $status ?>">
                                <span class="pos-status-pulse"></span>
                                <?= Order::statusLabel($order['status']) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($status !== 'cancelled'): ?>
                    <!-- 4-Step Progress Stepper -->
                    <div class="pos-timeline-stepper">
                        <!-- Connecting Line -->
                        <div class="pos-timeline-line">
                            <div class="pos-timeline-progress" style="width: <?= ($statusStep - 1) * 33.33 ?>%;"></div>
                        </div>

                        <!-- Step 1: Placed -->
                        <div class="pos-step-item <?= $statusStep >= 1 ? 'completed' : '' ?> <?= $statusStep === 1 ? 'active' : '' ?>">
                            <div class="pos-step-circle">
                                <i class="bi bi-receipt-cutoff"></i>
                            </div>
                            <span class="pos-step-label">Order Placed</span>
                            <span class="pos-step-desc">Order received</span>
                        </div>

                        <!-- Step 2: Preparing -->
                        <div class="pos-step-item <?= $statusStep >= 2 ? 'completed' : '' ?> <?= $statusStep === 2 ? 'active' : '' ?>">
                            <div class="pos-step-circle">
                                <i class="bi bi-fire"></i>
                            </div>
                            <span class="pos-step-label">Kitchen Preparing</span>
                            <span class="pos-step-desc">Cooking fresh</span>
                        </div>

                        <!-- Step 3: Ready -->
                        <div class="pos-step-item <?= $statusStep >= 3 ? 'completed' : '' ?> <?= $statusStep === 3 ? 'active' : '' ?>">
                            <div class="pos-step-circle">
                                <i class="bi bi-bag-check"></i>
                            </div>
                            <span class="pos-step-label">Ready for Pickup</span>
                            <span class="pos-step-desc">Ready at counter</span>
                        </div>

                        <!-- Step 4: Completed -->
                        <div class="pos-step-item <?= $statusStep >= 4 ? 'completed' : '' ?> <?= $statusStep === 4 ? 'active' : '' ?>">
                            <div class="pos-step-circle">
                                <i class="bi bi-patch-check-fill"></i>
                            </div>
                            <span class="pos-step-label">Completed</span>
                            <span class="pos-step-desc">Order fulfilled</span>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-danger rounded-4 mt-3 mb-0">
                        <i class="bi bi-info-circle me-2"></i> This order was cancelled. If you believe this is an error, please contact the stall vendor directly.
                    </div>
                <?php endif; ?>
            </div>

            <!-- ============================================== -->
            <!-- ORDER DETAILS 2-COLUMN GRID                    -->
            <!-- ============================================== -->
            <div class="pos-tracking-grid">
                
                <!-- Left Column: Customer & Schedule Info -->
                <div class="pos-tracking-col">
                    <!-- Pickup / Schedule Card -->
                    <div class="pos-info-card">
                        <div class="pos-info-card-header">
                            <i class="bi bi-calendar-check pos-info-icon"></i>
                            <h3 class="pos-info-card-title">Pickup Schedule</h3>
                        </div>
                        <div class="pos-info-list">
                            <div class="pos-info-row">
                                <span class="pos-info-label">Date</span>
                                <span class="pos-info-val fw-semibold">
                                    <i class="bi bi-calendar3 me-1 text-success"></i>
                                    <?= date('l, F j, Y', strtotime($order['pickup_date'])) ?>
                                </span>
                            </div>
                            <div class="pos-info-row">
                                <span class="pos-info-label">Pickup Time</span>
                                <span class="pos-info-val fw-semibold">
                                    <i class="bi bi-clock me-1 text-success"></i>
                                    <?= date('g:i A', strtotime($order['pickup_time'])) ?>
                                </span>
                            </div>
                            <div class="pos-info-row">
                                <span class="pos-info-label">Pickup Location</span>
                                <span class="pos-info-val text-dark">Laguna University BS Entrepreneurship Food Court</span>
                            </div>
                            <?php if (!empty($order['notes'])): ?>
                                <div class="pos-info-row flex-column align-items-start gap-1">
                                    <span class="pos-info-label">Special Instructions</span>
                                    <div class="pos-notes-box">
                                        <?= nl2br(htmlspecialchars($order['notes'])) ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Customer & Payment Details -->
                    <div class="pos-info-card">
                        <div class="pos-info-card-header">
                            <i class="bi bi-person-badge pos-info-icon"></i>
                            <h3 class="pos-info-card-title">Customer &amp; Payment</h3>
                        </div>
                        <div class="pos-info-list">
                            <div class="pos-info-row">
                                <span class="pos-info-label">Customer Name</span>
                                <span class="pos-info-val fw-semibold"><?= htmlspecialchars($order['customer_name']) ?></span>
                            </div>
                            <div class="pos-info-row">
                                <span class="pos-info-label">Contact Number</span>
                                <span class="pos-info-val"><?= htmlspecialchars($order['customer_contact']) ?></span>
                            </div>
                            <div class="pos-info-row">
                                <span class="pos-info-label">Email Address</span>
                                <span class="pos-info-val"><?= htmlspecialchars($order['customer_email']) ?></span>
                            </div>
                            <div class="pos-info-row">
                                <span class="pos-info-label">Payment Method</span>
                                <span class="badge bg-dark-subtle text-dark text-uppercase px-2 py-1 rounded-pill fw-semibold">
                                    <?= $order['payment_method'] === 'gcash' ? 'GCash / E-Wallet' : ($order['payment_method'] === 'debit' ? 'Debit Card' : 'Cash on Pickup') ?>
                                </span>
                            </div>
                            <div class="pos-info-row">
                                <span class="pos-info-label">Payment Status</span>
                                <span class="pos-info-val text-success fw-semibold">
                                    <?= $order['payment_method'] === 'cash' ? 'Pay upon collection' : 'Verified Online' ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Order Items & Pricing Breakdown -->
                <div class="pos-tracking-col">
                    <div class="pos-info-card">
                        <div class="pos-info-card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-basket pos-info-icon"></i>
                                <h3 class="pos-info-card-title">Order Items</h3>
                            </div>
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1">
                                <?= count($items) ?> item<?= count($items) === 1 ? '' : 's' ?>
                            </span>
                        </div>

                        <!-- Item Rows -->
                        <div class="pos-tracking-items-list">
                            <?php foreach ($items as $item): 
                                $itemSubtotal = (float) $item['subtotal'];
                            ?>
                                <div class="pos-tracking-item-row">
                                    <div class="pos-tracking-item-bullet">
                                        <i class="bi bi-check2"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h4 class="pos-tracking-item-name"><?= htmlspecialchars($item['product_name']) ?></h4>
                                        <span class="pos-tracking-item-stall">
                                            <i class="bi bi-shop me-1"></i><?= htmlspecialchars($item['stall_name'] ?? 'Grill Restaurant') ?>
                                        </span>
                                    </div>
                                    <div class="pos-tracking-item-qty">
                                        × <?= str_pad($item['quantity'], 2, '0', STR_PAD_LEFT) ?>
                                    </div>
                                    <div class="pos-tracking-item-subtotal">
                                        ₱<?= number_format($itemSubtotal, 2) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="pos-tracking-pricing-box">
                            <div class="d-flex justify-content-between text-muted small mb-2">
                                <span>Subtotal</span>
                                <span>₱<?= number_format($order['total_amount'], 2) ?></span>
                            </div>
                            <div class="d-flex justify-content-between text-success small mb-2">
                                <span>Discount</span>
                                <span>-₱3.00</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <span class="fw-bold text-dark fs-6">Total Amount</span>
                                <span class="fw-bold fs-4 text-success">₱<?= number_format(max(0, $order['total_amount'] - 3.00), 2) ?></span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 mt-4">
                            <button type="button" class="btn btn-outline-secondary rounded-pill flex-grow-1 py-2 fw-semibold" onclick="window.print()">
                                <i class="bi bi-printer me-1"></i> Print Receipt
                            </button>
                            <a href="<?= url('home') ?>" class="btn btn-success rounded-pill flex-grow-1 py-2 fw-semibold">
                                <i class="bi bi-plus-lg me-1"></i> Order More
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        <?php elseif (!$error): ?>
            <!-- Default Empty State: How to track guide -->
            <div class="pos-tracking-empty-guide">
                <div class="pos-guide-illustration">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h2 class="pos-guide-title">Track Any Order in Real Time</h2>
                <p class="pos-guide-desc">Enter your Order Code in the box above to see real-time updates as the kitchen prepares your dishes.</p>

                <div class="pos-guide-tips">
                    <div class="pos-guide-tip-item">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>Order codes are formatted like: <code>LU-20261105-XXXXX</code></span>
                    </div>
                    <div class="pos-guide-tip-item">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        <span>View your live status: Placed, Preparing, Ready, or Completed</span>
                    </div>
                </div>

                <a href="<?= url('home') ?>" class="btn btn-success rounded-pill px-4 py-2 mt-4 fw-semibold shadow-sm">
                    <i class="bi bi-grid me-1"></i> Browse Delicious Menu
                </a>
            </div>
        <?php endif; ?>

    </div>
</div>

<script>
function copyOrderCode(code) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(code).then(() => {
            alert('Order Code ' + code + ' copied to clipboard!');
        });
    } else {
        alert('Order Code: ' + code);
    }
}
</script>
