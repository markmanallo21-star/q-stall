<?php
$currentCategory = $active_category ?? 'All';
$searchQuery = $search_query ?? '';
$cartItems = $cart_items ?? [];
$cartTotal = $cart_total ?? 0;
$discount = $cartTotal > 0 ? 3.00 : 0;
$finalTotal = max(0, $cartTotal - $discount);
$user = auth_user();

// -------------------------------------------------------------
// Category Tiles Data (matching the screenshot)
// -------------------------------------------------------------
$categoryTiles = [
    ['key' => 'All',            'label' => 'Popular',       'icon' => '⭐', 'desc' => 'Bestsellers'],
    ['key' => 'Chick-Chi-Laok', 'label' => 'Chick-Chi-Laok','icon' => '🍗', 'desc' => 'Stall #2'],
    ['key' => 'Chaohaus',       'label' => 'Chaohaus',      'icon' => '🥡', 'desc' => 'Stall #3'],
    ['key' => 'Carbonation',    'label' => 'Carbonation',   'icon' => '🥤', 'desc' => 'Stall #1'],
    ['key' => 'Food',           'label' => 'Rice Bowl',     'icon' => '🍚', 'desc' => 'Rice Meals'],
    ['key' => 'Drinks',         'label' => 'Drinks',        'icon' => '☕', 'desc' => 'Beverages'],
];

// Group products strictly by stall
$stallsList = [
    2 => [
        'id' => 2,
        'name' => 'Chick-Chi-Laok',
        'tagline' => 'Grilled Chicken & Silog Meals',
        'icon' => 'bi-fire',
        'color' => '#ea580c',
        'badge' => 'Grill & Silog',
        'products' => []
    ],
    3 => [
        'id' => 3,
        'name' => 'Chaohaus',
        'tagline' => 'Chaofan, Siomai & Lumpia Combos',
        'icon' => 'bi-box-seam-fill',
        'color' => '#dc2626',
        'badge' => 'Chaofan Combos',
        'products' => []
    ],
    1 => [
        'id' => 1,
        'name' => 'Carbonation',
        'tagline' => 'Fresh Fruit & Carbonated Drinks',
        'icon' => 'bi-cup-straw',
        'color' => '#0284c7',
        'badge' => 'Drinks & Shakes',
        'products' => []
    ],
];

foreach ($products as $p) {
    $sId = (int) ($p['stall_id'] ?? 2);
    if (isset($stallsList[$sId])) {
        $stallsList[$sId]['products'][] = $p;
    } else {
        $stallsList[$sId] = [
            'id' => $sId,
            'name' => $p['stall_name'] ?? ('Stall ' . $sId),
            'tagline' => 'Specialty Food & Drinks',
            'icon' => 'bi-shop',
            'color' => '#f25c54',
            'badge' => 'Stall',
            'products' => [$p]
        ];
    }
}
?>

<div class="pos-app-layout coral-pos-theme">
    
    <!-- ============================================== -->
    <!-- CENTER CONTENT: MAIN MENU CATALOG              -->
    <!-- ============================================== -->
    <div class="pos-main-content">
        
        <!-- Top Bar: Search Input & User Profile Header -->
        <header class="coral-top-bar">
            <!-- Search Menu Input -->
            <div class="coral-search-wrap">
                <i class="bi bi-search coral-search-icon"></i>
                <input type="text" 
                       id="posFoodSearchInput" 
                       class="coral-search-input" 
                       placeholder="Search menu..." 
                       value="<?= htmlspecialchars($searchQuery) ?>"
                       autocomplete="off">
            </div>

            <!-- User Profile Avatar & Role -->
            <div class="coral-user-profile">
                <div class="coral-avatar">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&h=120&q=80" 
                         alt="User" 
                         onerror="this.src='<?= url('assets/uploads/products/121.jpg') ?>'">
                </div>
                <div class="coral-user-info">
                    <span class="coral-user-name"><?= htmlspecialchars($user['full_name'] ?? 'Guest Customer') ?></span>
                    <span class="coral-user-role"><?= htmlspecialchars(ucfirst($user['role'] ?? 'Cashier')) ?></span>
                </div>
                <button type="button" class="coral-dot-menu-btn" title="Options">
                    <i class="bi bi-three-dots"></i>
                </button>
            </div>
        </header>

        <!-- "Choose Category" Section -->
        <div class="coral-section-header">
            <h2 class="coral-section-title">Choose Category</h2>
            <button type="button" class="coral-dot-btn" title="More categories">
                <i class="bi bi-three-dots"></i>
            </button>
        </div>

        <!-- Horizontal Category Tiles Carousel (matching screenshot) -->
        <div class="coral-category-tiles" id="posCategoryPills" role="tablist">
            <?php foreach ($categoryTiles as $tile): 
                $isActive = (strtolower($tile['key']) === strtolower($currentCategory));
            ?>
                <button type="button" 
                        class="coral-cat-tile pos-category-pill <?= $isActive ? 'active' : '' ?>" 
                        data-category="<?= htmlspecialchars($tile['key']) ?>"
                        data-label="<?= htmlspecialchars($tile['label']) ?>">
                    <span class="coral-tile-icon"><?= $tile['icon'] ?></span>
                    <span class="coral-tile-label"><?= htmlspecialchars($tile['label']) ?></span>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- Menu Section Header -->
        <div class="coral-menu-header">
            <h2 class="coral-menu-title" id="coralMenuHeading">
                <?= htmlspecialchars($currentCategory === 'All' ? 'Popular Menu' : ($currentCategory . ' Menu')) ?>
            </h2>
            <div class="coral-sort-dropdown">
                <span>Sort by A-Z</span>
                <i class="bi bi-chevron-down ms-1 small"></i>
            </div>
        </div>

        <!-- Food Cards Grid -->
        <div class="pos-stall-sections-wrap" id="posStallSectionsWrap">
            <?php $firstCard = true; ?>
            <?php foreach ($stallsList as $stallId => $stallGroup): ?>
                <?php if (!empty($stallGroup['products'])): ?>
                    <section class="pos-stall-section mb-4" 
                             data-stall-id="<?= $stallId ?>" 
                             data-stall-name="<?= htmlspecialchars(strtolower($stallGroup['name'])) ?>">
                        
                        <!-- Stall Mini Tag Header -->
                        <div class="coral-stall-badge-bar mb-3">
                            <span class="badge" style="background: <?= $stallGroup['color'] ?>18; color: <?= $stallGroup['color'] ?>; font-weight:700; border: 1px solid <?= $stallGroup['color'] ?>30;">
                                <i class="bi <?= $stallGroup['icon'] ?> me-1"></i> <?= htmlspecialchars($stallGroup['name']) ?>
                            </span>
                            <span class="small text-muted"><?= htmlspecialchars($stallGroup['tagline']) ?></span>
                        </div>

                        <!-- 3-Column Food Grid -->
                        <div class="coral-food-grid">
                            <?php foreach ($stallGroup['products'] as $product): 
                                $price = (float) $product['price'];
                                $imgUrl = product_image_url($product['image'] ?? null);
                                $productCat = $product['category'] ?? 'Food';
                                $isExpanded = $firstCard; // Expand first card with options matching screenshot
                                $firstCard = false;
                            ?>
                                <div class="coral-food-card pos-food-card <?= $isExpanded ? 'expanded' : '' ?>" 
                                     data-id="<?= $product['id'] ?>" 
                                     data-product-id="<?= $product['id'] ?>"
                                     data-category="<?= htmlspecialchars($productCat) ?>"
                                     data-name="<?= htmlspecialchars(strtolower($product['name'])) ?>"
                                     data-desc="<?= htmlspecialchars(strtolower($product['description'] ?? '')) ?>"
                                     data-price="<?= $price ?>"
                                     data-stall="<?= htmlspecialchars(strtolower($stallGroup['name'])) ?>">
                                    
                                    <!-- Food Image -->
                                    <div class="coral-card-img-wrap">
                                        <img src="<?= htmlspecialchars($imgUrl) ?>" 
                                             alt="<?= htmlspecialchars($product['name']) ?>" 
                                             class="coral-card-img"
                                             onerror="this.src='<?= url('assets/uploads/products/121.jpg') ?>'">
                                    </div>

                                    <!-- Food Details -->
                                    <div class="coral-card-body">
                                        <h3 class="coral-card-title"><?= htmlspecialchars($product['name']) ?></h3>
                                        <div class="coral-card-price">
                                            ₱<?= number_format($price, 2) ?> <span class="coral-portion">/portion</span>
                                        </div>

                                        <!-- Option Toggles for active card (matching screenshot Eggs & Spicy Level) -->
                                        <?php if ($isExpanded): ?>
                                            <div class="coral-card-options">
                                                <div class="coral-option-group">
                                                    <span class="coral-opt-title">Add-on Option</span>
                                                    <div class="coral-opt-pills">
                                                        <label class="coral-opt-pill active">
                                                            <input type="radio" name="opt_egg_<?= $product['id'] ?>" checked hidden>
                                                            <span>Sunny Side Up</span>
                                                        </label>
                                                        <label class="coral-opt-pill">
                                                            <input type="radio" name="opt_egg_<?= $product['id'] ?>" hidden>
                                                            <span>Over Medium</span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="coral-option-group">
                                                    <span class="coral-opt-title">Spicy Level</span>
                                                    <div class="coral-opt-pills">
                                                        <label class="coral-opt-pill">
                                                            <input type="radio" name="opt_spice_<?= $product['id'] ?>" hidden>
                                                            <span>Mild</span>
                                                        </label>
                                                        <label class="coral-opt-pill active">
                                                            <input type="radio" name="opt_spice_<?= $product['id'] ?>" checked hidden>
                                                            <span>Medium</span>
                                                        </label>
                                                        <label class="coral-opt-pill">
                                                            <input type="radio" name="opt_spice_<?= $product['id'] ?>" hidden>
                                                            <span>Extra Hot</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Add to Billing Button for expanded card -->
                                            <button type="button" 
                                                    class="btn coral-add-billing-btn pos-add-to-cart-btn" 
                                                    data-id="<?= $product['id'] ?>"
                                                    data-product-id="<?= $product['id'] ?>"
                                                    data-name="<?= htmlspecialchars($product['name']) ?>"
                                                    data-price="<?= $price ?>"
                                                    data-image="<?= htmlspecialchars($imgUrl) ?>"
                                                    data-stall="<?= htmlspecialchars($stallGroup['name']) ?>">
                                                Add to Billing
                                            </button>
                                        <?php else: ?>
                                            <!-- Simple Add to Cart Button for other cards -->
                                            <div class="mt-auto pt-2">
                                                <button type="button" 
                                                        class="btn coral-card-add-simple pos-add-to-cart-btn" 
                                                        data-id="<?= $product['id'] ?>"
                                                        data-product-id="<?= $product['id'] ?>"
                                                        data-name="<?= htmlspecialchars($product['name']) ?>"
                                                        data-price="<?= $price ?>"
                                                        data-image="<?= htmlspecialchars($imgUrl) ?>"
                                                        data-stall="<?= htmlspecialchars($stallGroup['name']) ?>">
                                                    <i class="bi bi-plus-lg me-1"></i> Add
                                                </button>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>
            <?php endforeach; ?>

            <div class="pos-empty-grid" style="display: none;">
                <i class="bi bi-search pos-empty-icon"></i>
                <p class="pos-empty-text">No items found matching your search.</p>
            </div>
        </div>
    </div>

    <!-- ============================================== -->
    <!-- RIGHT SIDEBAR: "BILLS" LIVE ORDER PANEL        -->
    <!-- ============================================== -->
    <aside class="coral-bills-sidebar" id="posOrderSidebar">
        
        <!-- Bills Header -->
        <div class="coral-bills-header">
            <h2 class="coral-bills-title">Bills</h2>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="coral-dot-btn" id="posClearOrderBtn" title="Clear bills">
                    <i class="bi bi-three-dots"></i>
                </button>
            </div>
        </div>

        <!-- Order Mode Selector (Dine / Pick Up / Delivery) -->
        <div class="coral-mode-wrap mb-3">
            <div class="coral-mode-tabs" id="posOrderModeTabs">
                <button type="button" class="coral-mode-tab active pos-mode-pill" data-mode="dine">Dine</button>
                <button type="button" class="coral-mode-tab pos-mode-pill" data-mode="pickup">Pick Up</button>
                <button type="button" class="coral-mode-tab pos-mode-pill" data-mode="delivery">Delivery</button>
            </div>
        </div>

        <!-- Ordered Items List -->
        <div class="coral-bills-items-list" id="posOrderItemsList">
            <?php if (!empty($cartItems)): ?>
                <?php foreach ($cartItems as $item): 
                    $itemImg = product_image_url($item['image'] ?? null);
                    $subtotal = $item['price'] * $item['quantity'];
                    $qtyFormatted = StringVal($item['quantity']);
                ?>
                    <div class="coral-bill-item pos-order-item" data-id="<?= $item['product_id'] ?>">
                        <div class="coral-bill-thumb-wrap">
                            <img src="<?= htmlspecialchars($itemImg) ?>" 
                                 alt="<?= htmlspecialchars($item['name']) ?>" 
                                 class="coral-bill-thumb"
                                 onerror="this.src='<?= url('assets/uploads/products/121.jpg') ?>'">
                        </div>
                        <div class="coral-bill-details">
                            <h4 class="coral-bill-name"><?= htmlspecialchars($item['name']) ?></h4>
                            <span class="coral-bill-meta"><?= htmlspecialchars($item['stall_name'] ?? 'Over Hard, Mild') ?></span>
                        </div>
                        <div class="coral-bill-right">
                            <span class="coral-bill-price">₱<?= number_format($item['price'], 2) ?></span>
                            <!-- Coral Stepper -->
                            <div class="coral-stepper pos-qty-stepper">
                                <button type="button" class="coral-step-btn minus pos-qty-btn" data-product-id="<?= $item['product_id'] ?>" data-action="minus">
                                    <i class="bi bi-dash"></i>
                                </button>
                                <span class="coral-step-num pos-qty-num"><?= $qtyFormatted ?></span>
                                <button type="button" class="coral-step-btn plus pos-qty-btn" data-product-id="<?= $item['product_id'] ?>" data-action="plus">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="coral-empty-bills text-center py-4 text-muted">
                    <i class="bi bi-receipt fs-2 mb-2 d-block opacity-50"></i>
                    <p class="small mb-0">No items in your bill yet.<br>Click items to add!</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Subtotal / Discount / Tax / Total Breakdown -->
        <div class="coral-bills-summary">
            <div class="coral-summary-row">
                <span>Subtotal</span>
                <span id="posSummaryItems">₱<?= number_format($cartTotal, 2) ?></span>
            </div>
            <div class="coral-summary-row">
                <span>Discount</span>
                <span id="posSummaryDiscount" class="text-danger">-₱<?= number_format($discount, 2) ?></span>
            </div>
            <div class="coral-summary-row">
                <span>Tax / Service</span>
                <span id="posSummaryTax">₱0.00</span>
            </div>
            <div class="coral-summary-dashed"></div>
            <div class="coral-summary-row total">
                <span class="coral-total-label">Total</span>
                <span class="coral-total-value" id="posSummaryTotal">₱<?= number_format($finalTotal, 2) ?></span>
            </div>
        </div>

        <!-- Payment Method Selection (Cash / Debit / GCash) -->
        <div class="coral-payment-method-section">
            <h3 class="coral-pm-title">Payment Method</h3>
            <div class="coral-pm-grid" id="posPaymentMethods">
                
                <!-- Cash Tile -->
                <button type="button" class="coral-pm-tile active pos-pay-btn" data-method="cash">
                    <i class="bi bi-cash-stack coral-pm-icon"></i>
                    <span class="coral-pm-name">Cash</span>
                </button>

                <!-- Debit Card Tile -->
                <button type="button" class="coral-pm-tile pos-pay-btn" data-method="debit">
                    <i class="bi bi-credit-card-2-front coral-pm-icon"></i>
                    <span class="coral-pm-name">Debit Card</span>
                </button>

                <!-- QRIS / GCash Tile -->
                <button type="button" class="coral-pm-tile pos-pay-btn" data-method="ewallet">
                    <i class="bi bi-qr-code-scan coral-pm-icon"></i>
                    <span class="coral-pm-name">GCash</span>
                </button>
            </div>
        </div>

        <!-- Action Button (Add to Billing / Checkout) -->
        <div class="coral-checkout-action-wrap mt-3">
            <?php if (auth_check()): ?>
                <button type="button" class="btn coral-btn-add-billing" id="posCheckoutBtn">
                    Add to Billing &bull; Place Order
                </button>
            <?php else: ?>
                <a href="<?= url('login') ?>" class="btn coral-btn-add-billing text-center text-decoration-none">
                    <i class="bi bi-lock-fill me-1"></i> Sign In to Order
                </a>
            <?php endif; ?>
        </div>

    </aside>
</div>

<!-- ============================================== -->
<!-- CHECKOUT MODAL: INSTANT ORDER COMPLETION       -->
<!-- ============================================== -->
<div class="modal fade pos-checkout-modal" id="posCheckoutModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content coral-modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <div>
                    <h5 class="modal-title fw-bold text-dark">Confirm Order &amp; Billing</h5>
                    <p class="text-muted small mb-0" id="posModalSubtitle">Review your details to place the order.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="<?= url('order/store') ?>" method="POST" enctype="multipart/form-data" id="posCheckoutForm">
                <input type="hidden" name="order_mode" id="posFormOrderMode" value="dine">
                <input type="hidden" name="payment_method" id="posFormPaymentMethod" value="cash">

                <div class="modal-body pt-3 px-4">
                    <!-- Order preview pill -->
                    <div class="p-3 rounded-3 mb-3" style="background:#fff5f5; border:1px solid #fed7d7;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-danger text-uppercase fw-semibold px-2 py-1" id="posModalModeBadge">Dine</span>
                                <span class="badge bg-dark text-uppercase fw-semibold px-2 py-1 ms-1" id="posModalPayBadge">Cash</span>
                            </div>
                            <div class="text-end">
                                <span class="small text-muted d-block">Total to Pay:</span>
                                <span class="fw-bold fs-4 text-danger" id="posModalTotal">₱<?= number_format($finalTotal, 2) ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Customer Full Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control coral-input" 
                               name="customer_name" 
                               placeholder="e.g. Juan Dela Cruz" 
                               required 
                               value="<?= htmlspecialchars(auth_user()['full_name'] ?? '') ?>">
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Contact # <span class="text-danger">*</span></label>
                            <input type="tel" 
                                   class="form-control coral-input" 
                                   name="customer_contact" 
                                   placeholder="0912 345 6789" 
                                   required
                                   value="<?= htmlspecialchars(auth_user()['phone'] ?? '') ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control coral-input" 
                                   name="customer_email" 
                                   placeholder="juan@email.com" 
                                   required
                                   value="<?= htmlspecialchars(auth_user()['email'] ?? '') ?>">
                        </div>
                    </div>

                    <!-- Pickup / Dine-in Date & Time -->
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold" id="posDateLabel">Order Date <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control coral-input" 
                                   name="pickup_date" 
                                   id="posPickupDateInput" 
                                   required 
                                   min="<?= date('Y-m-d') ?>" 
                                   value="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold" id="posTimeLabel">Time / Table # <span class="text-danger">*</span></label>
                            <input type="time" 
                                   class="form-control coral-input" 
                                   name="pickup_time" 
                                   id="posPickupTimeInput" 
                                   required 
                                   value="<?= date('H:i') ?>">
                        </div>
                    </div>

                    <!-- GCash / E-Wallet upload field with official account details -->
                    <div class="mb-3 p-3 rounded-3" id="posModalProofSection" style="display: none; background: #fff5f5; border: 1px solid #feb2b2;">
                        <div class="d-flex align-items-center gap-2 mb-2 text-danger fw-bold">
                            <i class="bi bi-qr-code-scan fs-5"></i>
                            <span>GCash Payment Details</span>
                        </div>
                        <div class="small text-dark mb-2">
                            Send payment to GCash: <strong class="text-danger fs-6">0912 345 6789</strong><br>
                            Account Name: <strong>Laguna University Stall</strong>
                        </div>
                        <label class="form-label small fw-semibold text-dark">Upload GCash Screenshot Proof <span class="text-danger">*</span></label>
                        <input type="file" class="form-control bg-white" name="payment_proof" accept="image/*" id="posModalProofInput">
                        <small class="text-muted d-block mt-1">Screenshot reference required for online verification.</small>
                    </div>

                    <!-- Cash / Debit helper message -->
                    <div class="mb-3 p-2 rounded-3 text-muted small bg-light border" id="posModalCounterMsg">
                        <i class="bi bi-info-circle me-1 text-primary"></i> <span id="posPaymentNoteText">You can pay with Cash at the stall counter upon dining or pickup.</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Special Instructions / Notes</label>
                        <textarea class="form-control coral-input" name="notes" rows="2" placeholder="e.g. Less ice, extra sauce, table number 5..."></textarea>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn coral-btn-add-billing px-4 py-2" id="posSubmitOrderBtn">
                        Confirm &amp; Place Order <i class="bi bi-check2-circle ms-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
