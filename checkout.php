<section class="checkout-page">
    <div class="container">
        <div class="checkout-header">
            <div>
                <span class="checkout-eyebrow">Checkout</span>
                <h1>Complete Your Order</h1>
                <p class="text-muted">Review your details and confirm the order.</p>
            </div>
            <a href="<?= url('cart') ?>" class="btn btn-outline-success checkout-back">
                <i class="bi bi-arrow-left me-2"></i>Back to Cart
            </a>
        </div>

        <form action="<?= url('order/store') ?>" method="POST" enctype="multipart/form-data" id="checkoutForm" class="checkout-form">
            <div class="checkout-layout">
                <div class="checkout-main">
                    <div class="checkout-section">
                        <div class="checkout-section-header">
                            <i class="bi bi-person-circle"></i>
                            <h2>Customer Information</h2>
                        </div>
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="customer_name" required value="<?= htmlspecialchars($_POST['customer_name'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="customer_email" required value="<?= htmlspecialchars($_POST['customer_email'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="customer_contact" required value="<?= htmlspecialchars($_POST['customer_contact'] ?? '') ?>">
                            </div>
                        </div>
                    </div>

                    <div class="checkout-section">
                        <div class="checkout-section-header">
                            <i class="bi bi-calendar-event"></i>
                            <h2>Pickup Details</h2>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Pickup Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="pickup_date" required min="<?= date('Y-m-d') ?>" value="<?= htmlspecialchars($_POST['pickup_date'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pickup Time <span class="text-danger">*</span></label>
                                <select class="form-select" name="pickup_time" required>
                                    <option value="">Select a time</option>
                                    <option value="09:00:00" <?= ($_POST['pickup_time'] ?? '') === '09:00:00' ? 'selected' : '' ?>>9:00 AM</option>
                                    <option value="10:00:00" <?= ($_POST['pickup_time'] ?? '') === '10:00:00' ? 'selected' : '' ?>>10:00 AM</option>
                                    <option value="11:00:00" <?= ($_POST['pickup_time'] ?? '') === '11:00:00' ? 'selected' : '' ?>>11:00 AM</option>
                                    <option value="12:00:00" <?= ($_POST['pickup_time'] ?? '') === '12:00:00' ? 'selected' : '' ?>>12:00 PM</option>
                                    <option value="13:00:00" <?= ($_POST['pickup_time'] ?? '') === '13:00:00' ? 'selected' : '' ?>>1:00 PM</option>
                                    <option value="14:00:00" <?= ($_POST['pickup_time'] ?? '') === '14:00:00' ? 'selected' : '' ?>>2:00 PM</option>
                                    <option value="15:00:00" <?= ($_POST['pickup_time'] ?? '') === '15:00:00' ? 'selected' : '' ?>>3:00 PM</option>
                                    <option value="16:00:00" <?= ($_POST['pickup_time'] ?? '') === '16:00:00' ? 'selected' : '' ?>>4:00 PM</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-section">
                        <div class="checkout-section-header">
                            <i class="bi bi-credit-card"></i>
                            <h2>Payment Method</h2>
                        </div>
                        <div class="payment-options">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="cash" <?= (!isset($_POST['payment_method']) || $_POST['payment_method'] === 'cash') ? 'checked' : '' ?> onchange="togglePaymentProof()">
                                <div class="payment-option-content">
                                    <i class="bi bi-cash-stack"></i>
                                    <div>
                                        <strong>Cash on Pickup</strong>
                                        <small class="text-muted d-block">Pay when you pick up your order</small>
                                    </div>
                                </div>
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="gcash" <?= (isset($_POST['payment_method']) && $_POST['payment_method'] === 'gcash') ? 'checked' : '' ?> onchange="togglePaymentProof()">
                                <div class="payment-option-content">
                                    <i class="bi bi-phone"></i>
                                    <div>
                                        <strong>GCash</strong>
                                        <small class="text-muted d-block">Scan QR code or send to our GCash number</small>
                                    </div>
                                </div>
                            </label>
                        </div>
                        <div class="mb-3" id="paymentProofField" style="display:none;">
                            <label class="form-label">GCash Payment Proof (screenshot) <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="payment_proof" accept="image/*">
                            <small class="text-muted">Take a screenshot of your GCash payment and upload it</small>
                        </div>
                    </div>

                    <div class="checkout-section">
                        <div class="checkout-section-header">
                            <i class="bi bi-chat-left-text"></i>
                            <h2>Additional Notes</h2>
                        </div>
                        <textarea class="form-control" name="notes" rows="3" placeholder="Special instructions, e.g. specific stall location preference, dietary requirements..."><?= htmlspecialchars($_POST['notes'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="checkout-summary">
                    <div class="checkout-summary-card" style="position: sticky; top: 90px; align-self: start;">
                        <h3>Order Summary</h3>
                        
                        <?php if (!empty($cart_by_stall)): ?>
                            <?php foreach ($cart_by_stall as $stall): ?>
                            <div class="checkout-stall-group">
                                <div class="checkout-stall-header">
                                    <span class="checkout-stall-name">
                                        <i class="bi bi-shop me-1"></i><?= htmlspecialchars($stall['stall_name']) ?>
                                    </span>
                                    <span class="checkout-stall-count"><?= count($stall['items']) ?> item<?= count($stall['items']) === 1 ? '' : 's' ?></span>
                                </div>
                                <div class="checkout-items">
                                    <?php foreach ($stall['items'] as $item): ?>
                                    <div class="checkout-item">
                                        <div class="checkout-item-info">
                                            <span class="checkout-item-name"><?= htmlspecialchars($item['name']) ?></span>
                                            <span class="checkout-item-qty">× <?= $item['quantity'] ?></span>
                                        </div>
                                        <span class="checkout-item-price">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <div class="checkout-totals">
                            <div class="checkout-total-row">
                                <span>Subtotal</span>
                                <span>₱<?= number_format($cart_total, 2) ?></span>
                            </div>
                            <div class="checkout-total-row">
                                <span>Shipping</span>
                                <span class="text-success">Free</span>
                            </div>
                            <hr>
                            <div class="checkout-total-row checkout-grand-total">
                                <span>Total</span>
                                <span>₱<?= number_format($cart_total, 2) ?></span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success checkout-submit w-100">
                            <i class="bi bi-check-circle me-2"></i>Place Order
                        </button>
                        <a href="<?= url('cart') ?>" class="btn btn-outline-success checkout-back w-100 mt-2">
                            <i class="bi bi-arrow-left me-2"></i>Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    function togglePaymentProof() {
        var method = document.querySelector('input[name="payment_method"]:checked').value;
        var field = document.getElementById('paymentProofField');
        field.style.display = method === 'gcash' ? 'block' : 'none';
        
        // Update required attribute
        var proofInput = field.querySelector('input[name="payment_proof"]');
        if (proofInput) {
            proofInput.required = method === 'gcash';
        }
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        togglePaymentProof();
    });
</script>