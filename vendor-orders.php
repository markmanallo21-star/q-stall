<section class="vendor-orders-page">
    <div class="container">
        <div class="vendor-orders-header">
            <div>
                <span class="vendor-eyebrow">Order Details</span>
                <h1><?= htmlspecialchars($stall['name']) ?></h1>
                <p class="text-muted">Orders for <?= date('F j, Y', strtotime($date)) ?></p>
            </div>
            <div class="vendor-orders-actions">
                <a href="<?= url('vendor') ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
                </a>
            </div>
        </div>

        <?php if (!empty($sales)): ?>
            <div class="vendor-orders-table-wrapper">
                <table class="vendor-orders-table">
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Order Code</th>
                            <th>Product</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Subtotal</th>
                            <th>Status</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sales as $sale): ?>
                            <tr>
                                <td><i class="bi bi-clock me-1 text-muted"></i><?= date('g:i A', strtotime($sale['pickup_time'])) ?></td>
                                <td><code class="vendor-order-code"><?= htmlspecialchars($sale['order_code']) ?></code></td>
                                <td>
                                    <div class="vendor-order-product-cell">
                                        <span class="vendor-order-product-name"><?= htmlspecialchars($sale['product_name']) ?></span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="vendor-order-qty-badge"><?= $sale['quantity'] ?></span>
                                </td>
                                <td class="text-end fw-semibold">₱<?= number_format($sale['subtotal'], 2) ?></td>
                                <td>
                                    <span class="vendor-status-badge status-<?= $sale['status'] ?>">
                                        <?= Order::statusLabel($sale['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="vendor-payment-badge">
                                        <i class="bi bi-<?= $sale['payment_method'] === 'gcash' ? 'phone' : 'cash' ?> me-1"></i>
                                        <?= ucfirst($sale['payment_method']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="vendor-empty-state vendor-orders-empty">
                <i class="bi bi-calendar-x"></i>
                <h3>No orders for this date</h3>
                <p class="text-muted">There are no orders scheduled for <?= date('F j, Y', strtotime($date)) ?>.</p>
                <a href="<?= url('vendor') ?>" class="btn btn-success mt-3">
                    <i class="bi bi-house me-2"></i>Back to Dashboard
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>