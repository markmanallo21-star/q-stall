<?php
$items = $items ?? [];
$orderCode = $order['order_code'] ?? '';
$total = (float) ($order['total_amount'] ?? 0);
$discount = 3.00;
$finalTotal = max(0, $total - ($total > 0 ? $discount : 0));
?>

<div class="pos-tracking-page">
    <div class="pos-tracking-container">

        <!-- Success Hero Banner -->
        <div class="text-center py-4 mb-4">
            <div class="pos-confirm-icon-wrap mb-3">
                <i class="bi bi-check-lg"></i>
            </div>
            <span class="badge bg-success-subtle text-success text-uppercase fw-semibold px-3 py-1 rounded-pill mb-2">Order Confirmed</span>
            <h1 class="h2 fw-bold text-dark mb-2">Thank you for your order!</h1>
            <p class="text-muted small mb-0">We have received your order and the student stall has been notified.</p>
        </div>

        <!-- Order Code Box -->
        <div class="pos-stepper-card mb-4 text-center">
            <span class="text-muted small text-uppercase fw-semibold">Your Order Code</span>
            <div class="d-flex align-items-center justify-content-center gap-2 mt-1 mb-2">
                <span class="display-6 fw-bold text-success">#<?= htmlspecialchars($orderCode) ?></span>
                <button type="button" class="btn btn-sm btn-light rounded-circle shadow-sm" onclick="copyOrderCode('<?= htmlspecialchars($orderCode) ?>')" title="Copy Code">
                    <i class="bi bi-copy"></i>
                </button>
            </div>
            <p class="text-muted small mb-0">Please save this code to check your order status or show it at the counter upon pickup.</p>
        </div>

        <!-- 2-Column Summary -->
        <div class="pos-tracking-grid">
            <!-- Left: Schedule & Customer Info -->
            <div class="pos-tracking-col">
                <div class="pos-info-card">
                    <div class="pos-info-card-header">
                        <i class="bi bi-calendar-event pos-info-icon"></i>
                        <h3 class="pos-info-card-title">Pickup Details</h3>
                    </div>
                    <div class="pos-info-list">
                        <div class="pos-info-row">
                            <span class="pos-info-label">Customer</span>
                            <span class="pos-info-val fw-semibold"><?= htmlspecialchars($order['customer_name']) ?></span>
                        </div>
                        <div class="pos-info-row">
                            <span class="pos-info-label">Contact</span>
                            <span class="pos-info-val"><?= htmlspecialchars($order['customer_contact']) ?></span>
                        </div>
                        <div class="pos-info-row">
                            <span class="pos-info-label">Pickup Date</span>
                            <span class="pos-info-val fw-semibold text-success">
                                <i class="bi bi-calendar3 me-1"></i><?= date('F j, Y', strtotime($order['pickup_date'])) ?>
                            </span>
                        </div>
                        <div class="pos-info-row">
                            <span class="pos-info-label">Pickup Time</span>
                            <span class="pos-info-val fw-semibold text-success">
                                <i class="bi bi-clock me-1"></i><?= date('g:i A', strtotime($order['pickup_time'])) ?>
                            </span>
                        </div>
                        <div class="pos-info-row">
                            <span class="pos-info-label">Payment</span>
                            <span class="badge bg-dark-subtle text-dark text-uppercase px-2 py-1 rounded-pill">
                                <?= $order['payment_method'] === 'gcash' ? 'GCash' : ($order['payment_method'] === 'debit' ? 'Debit' : 'Cash on Pickup') ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Order Items & Total -->
            <div class="pos-tracking-col">
                <div class="pos-info-card">
                    <div class="pos-info-card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-receipt pos-info-icon"></i>
                            <h3 class="pos-info-card-title">Order Items</h3>
                        </div>
                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1">
                            <?= count($items) ?> item<?= count($items) === 1 ? '' : 's' ?>
                        </span>
                    </div>

                    <div class="pos-tracking-items-list">
                        <?php foreach ($items as $item): ?>
                            <div class="pos-tracking-item-row">
                                <div class="pos-tracking-item-bullet">
                                    <i class="bi bi-check2"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h4 class="pos-tracking-item-name"><?= htmlspecialchars($item['product_name']) ?></h4>
                                    <span class="pos-tracking-item-stall"><?= htmlspecialchars($item['stall_name'] ?? 'Grill Restaurant') ?></span>
                                </div>
                                <div class="pos-tracking-item-qty">× <?= $item['quantity'] ?></div>
                                <div class="pos-tracking-item-subtotal">₱<?= number_format($item['subtotal'], 2) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="pos-tracking-pricing-box">
                        <div class="d-flex justify-content-between text-muted small mb-1">
                            <span>Subtotal</span>
                            <span>₱<?= number_format($total, 2) ?></span>
                        </div>
                        <div class="d-flex justify-content-between text-success small mb-2">
                            <span>Discount</span>
                            <span>-₱3.00</span>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between align-items-baseline">
                            <span class="fw-bold text-dark fs-6">Total Paid / Due</span>
                            <span class="fw-bold fs-4 text-success">₱<?= number_format($finalTotal, 2) ?></span>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <a href="<?= url('order-tracking?code=' . urlencode($orderCode)) ?>" class="btn btn-outline-success rounded-pill flex-grow-1 py-2 fw-semibold">
                            <i class="bi bi-clock-history me-1"></i> Track Live Status
                        </a>
                        <a href="<?= url('home') ?>" class="btn btn-success rounded-pill flex-grow-1 py-2 fw-semibold">
                            <i class="bi bi-grid me-1"></i> Back to Menu
                        </a>
                    </div>
                </div>
            </div>
        </div>

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
