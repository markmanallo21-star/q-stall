<section class="cart-page py-4 px-3 px-md-5">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <a href="<?= url('home') ?>" class="text-decoration-none text-success small fw-semibold d-inline-flex align-items-center mb-1">
                    <i class="bi bi-arrow-left me-1"></i> Back to Menu
                </a>
                <h1 class="h3 fw-bold text-dark mb-1">My Order Details</h1>
                <p class="text-muted small mb-0">Review items or update quantities before checkout.</p>
            </div>
            <?php if (!empty($cart_by_stall)): ?>
                <a href="<?= url('cart/clear') ?>" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                    <i class="bi bi-trash me-1"></i> Clear order
                </a>
            <?php endif; ?>
        </div>

        <?php if (!empty($cart_by_stall)): ?>
        <form class="cart-form" method="post" action="<?= url('cart/update') ?>">
        <div class="row g-4">
            <div class="col-lg-8">
                <?php foreach ($cart_by_stall as $stall): ?>
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                        <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                            <span class="badge bg-success-subtle text-success fs-6 py-2 px-3 rounded-pill fw-semibold">
                                <i class="bi bi-shop me-1"></i><?= htmlspecialchars($stall['stall_name']) ?>
                            </span>
                            <span class="text-muted small"><?= count($stall['items']) ?> item<?= count($stall['items']) === 1 ? '' : 's' ?></span>
                        </div>

                        <div class="card-body p-0">
                            <?php foreach ($stall['items'] as $item): 
                                $itemImg = product_image_url($item['image'] ?? null);
                            ?>
                            <div class="p-3 px-md-4 border-bottom d-flex align-items-center gap-3">
                                <div style="width: 56px; height: 56px; border-radius: 50%; overflow: hidden; flex-shrink: 0; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                                    <img src="<?= htmlspecialchars($itemImg) ?>" alt="<?= htmlspecialchars($item['name']) ?>" style="width:100%; height:100%; object-fit:cover;">
                                </div>
                                <div class="flex-grow-1 min-w-0">
                                    <h4 class="h6 fw-bold mb-1 text-dark"><?= htmlspecialchars($item['name']) ?></h4>
                                    <span class="text-success fw-bold small">₱<?= number_format($item['price'], 2) ?></span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="number" name="quantity[<?= $item['product_id'] ?>]" value="<?= $item['quantity'] ?>" min="1" step="1" class="form-control form-control-sm text-center fw-semibold rounded-pill" style="width: 70px;">
                                    <span class="fw-bold text-dark px-2" style="min-width: 80px; text-align: right;">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                                    <a href="<?= url('cart/remove/' . $item['product_id']) ?>" class="btn btn-outline-danger btn-sm rounded-circle p-1" style="width: 32px; height: 32px;" title="Remove">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 24px;">
                    <h3 class="h5 fw-bold mb-3 text-dark">Order Summary</h3>
                    <div class="d-flex justify-content-between text-muted mb-2 small">
                        <span>Items Subtotal</span>
                        <span class="fw-semibold text-dark">₱<?= number_format($cart_total, 2) ?></span>
                    </div>
                    <div class="d-flex justify-content-between text-success mb-2 small">
                        <span>Discount</span>
                        <span class="fw-semibold">-₱3.00</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between text-dark fw-bold mb-4 fs-5">
                        <span>Total</span>
                        <span class="text-success">₱<?= number_format(max(0, $cart_total - 3.00), 2) ?></span>
                    </div>

                    <button type="submit" class="btn btn-outline-success rounded-pill w-100 mb-2 fw-semibold">
                        <i class="bi bi-arrow-repeat me-1"></i> Update Quantities
                    </button>
                    <a href="<?= url('home') ?>" class="btn btn-success rounded-pill w-100 fw-bold py-2 shadow-sm">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
        </form>
        <?php else: ?>
        <div class="text-center py-5">
            <div class="mb-3 text-muted display-4"><i class="bi bi-bag"></i></div>
            <h3 class="h4 fw-bold text-dark">Your order is empty</h3>
            <p class="text-muted small mb-4">You haven't added any delicious food or drinks yet.</p>
            <a href="<?= url('home') ?>" class="btn btn-success rounded-pill px-4 fw-semibold">
                <i class="bi bi-grid me-1"></i> Browse Menu
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>
