<div class="public-menu-page" style="background:#faf7f2; min-height: 90vh;">
    
    <!-- Hero Header -->
    <section class="py-5" style="background: radial-gradient(circle at 80% 30%, #2a2219 0%, #171411 60%, #0d0c0a 100%); color: #fff;">
        <div class="container text-center py-3">
            <span class="hero-tag-badge mb-2">
                <span>CAMPUS STALL MENU</span> &bull; <span style="color:#f59e0b;">STUDENT ENTERPRISES</span>
            </span>
            <h1 class="display-5 fw-bold mb-2">
                Explore Our Campus <span class="hero-cursive">Menu</span>
            </h1>
            <p class="text-muted mx-auto mb-4" style="max-width: 620px; font-size: 1.02rem;">
                Browse freshly prepared meals, chaofan combos, and thirst-quenching fruit sodas from our 3 student-run stalls.
            </p>

            <!-- Call to Action Banner for Guests -->
            <div class="card border-0 mx-auto rounded-4 p-3 shadow-lg" style="max-width: 680px; background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(8px); border: 1px solid rgba(245, 158, 11, 0.3) !important;">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 text-start">
                    <div class="d-flex align-items-center gap-3">
                        <div class="site-feat-icon" style="background:#f59e0b; color:#171411;">
                            <i class="bi bi-person-lock fs-4"></i>
                        </div>
                        <div>
                            <strong class="d-block text-white" style="font-size: 0.95rem;">Ready to Order?</strong>
                            <small class="text-light opacity-75">Sign in to unlock the live POS Dashboard, choose Dine/Pickup, and checkout!</small>
                        </div>
                    </div>
                    <a href="<?= url('login') ?>" class="btn hero-order-btn py-2 px-3 fs-6 text-nowrap">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Sign In to Order in POS
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Products Directory -->
    <div class="container py-5">
        
        <!-- Search & Filter Controls -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
            <!-- Category Filter Pills -->
            <div class="d-flex flex-wrap gap-2" id="publicCategoryPills">
                <a href="<?= url('menu') ?>" class="btn rounded-pill px-3 py-2 fw-semibold <?= empty($active_category) || strtolower($active_category) === 'all' ? 'btn-dark' : 'btn-outline-dark' ?>">
                    All Products
                </a>
                <a href="<?= url('menu?category=Chick-Chi-Laok') ?>" class="btn rounded-pill px-3 py-2 fw-semibold <?= strtolower($active_category ?? '') === 'chick-chi-laok' ? 'btn-warning text-dark fw-bold' : 'btn-outline-dark' ?>">
                    🍗 Chick-Chi-Laok
                </a>
                <a href="<?= url('menu?category=Chaohaus') ?>" class="btn rounded-pill px-3 py-2 fw-semibold <?= strtolower($active_category ?? '') === 'chaohaus' ? 'btn-danger text-white' : 'btn-outline-dark' ?>">
                    🥡 Chaohaus
                </a>
                <a href="<?= url('menu?category=Carbonation') ?>" class="btn rounded-pill px-3 py-2 fw-semibold <?= strtolower($active_category ?? '') === 'carbonation' ? 'btn-info text-white' : 'btn-outline-dark' ?>">
                    🥤 Carbonation
                </a>
            </div>

            <!-- Search Bar -->
            <form action="<?= url('menu') ?>" method="GET" class="d-flex gap-2" style="max-width: 320px; width: 100%;">
                <input type="text" 
                       name="q" 
                       class="form-control rounded-pill px-3 py-2" 
                       placeholder="Search products..." 
                       value="<?= htmlspecialchars($search_query ?? '') ?>">
                <button type="submit" class="btn btn-dark rounded-pill px-3">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

        <!-- Products Separated by Stall -->
        <?php foreach ($stallsList as $stallId => $stallGroup): ?>
            <?php if (!empty($stallGroup['products'])): ?>
                <div class="stall-menu-section mb-5">
                    
                    <!-- Stall Banner -->
                    <div class="d-flex align-items-center justify-content-between p-3 rounded-4 bg-white shadow-sm mb-4" style="border-left: 6px solid <?= $stallGroup['color'] ?>;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="site-feat-icon" style="background: <?= $stallGroup['color'] ?>18; color: <?= $stallGroup['color'] ?>;">
                                <i class="bi <?= $stallGroup['icon'] ?> fs-3"></i>
                            </div>
                            <div>
                                <h3 class="h4 fw-bold mb-0 text-dark"><?= htmlspecialchars($stallGroup['name']) ?></h3>
                                <p class="text-muted small mb-0"><?= htmlspecialchars($stallGroup['tagline']) ?></p>
                            </div>
                        </div>
                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill small">
                            <?= count($stallGroup['products']) ?> items
                        </span>
                    </div>

                    <!-- Products Grid -->
                    <div class="row g-4">
                        <?php foreach ($stallGroup['products'] as $product): ?>
                            <?php 
                            $imgUrl = product_image_url($product['image'] ?? null);
                            ?>
                            <div class="col-sm-6 col-lg-3">
                                <div class="landing-food-card h-100">
                                    <div class="card-img-wrap">
                                        <img src="<?= htmlspecialchars($imgUrl) ?>" 
                                             alt="<?= htmlspecialchars($product['name']) ?>" 
                                             class="card-img-top"
                                             onerror="this.src='<?= url('assets/uploads/products/121.jpg') ?>'">
                                    </div>
                                    <div class="card-body-content">
                                        <span class="card-stall-label" style="color: <?= $stallGroup['color'] ?>;">
                                            <?= htmlspecialchars($stallGroup['name']) ?>
                                        </span>
                                        <h4 class="card-item-title"><?= htmlspecialchars($product['name']) ?></h4>
                                        <p class="card-item-desc"><?= htmlspecialchars($product['description'] ?? '') ?></p>
                                        <div class="d-flex align-items-center justify-content-between mt-auto pt-2">
                                            <div class="card-item-price mb-0">₱<?= number_format((float)$product['price'], 2) ?></div>
                                            <a href="<?= url('login') ?>" class="btn card-add-btn text-decoration-none" style="width: auto; padding: 8px 16px;">
                                                <i class="bi bi-lock-fill me-1 small"></i> Order in POS
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <!-- Bottom Call to action -->
        <div class="p-4 rounded-4 text-center mt-5" style="background:#171411; color:#fff;">
            <h3 class="fw-bold mb-2">Ready to taste our campus bestsellers?</h3>
            <p class="text-muted small mb-3">Sign in or create your student account to open the interactive POS ordering dashboard.</p>
            <a href="<?= url('login') ?>" class="btn hero-order-btn px-4 py-2 fs-6">
                <span>Sign In / Register Now</span>
                <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>

    </div>
</div>
