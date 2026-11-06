<section class="stall-menu-hero">
    <div class="container">
        <div class="stall-menu-hero-card">
            <div class="stall-menu-hero-content">
                <a href="<?= url('stalls') ?>" class="menu-back-link">
                    <i class="bi bi-arrow-left me-2"></i>Back to stalls
                </a>
                <div class="stall-menu-hero-main">
                    <div class="stall-menu-logo">
                        <?php if ($stall['logo_image']): ?>
                            <img src="<?= url('assets/uploads/stalls/' . $stall['logo_image']) ?>" alt="<?= htmlspecialchars($stall['name']) ?>">
                        <?php else: ?>
                            <span><?= strtoupper(substr($stall['name'], 0, 1)) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="stall-menu-hero-copy">
                        <span class="menu-eyebrow">Student-run stall</span>
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <h1><?= htmlspecialchars($stall['name']) ?></h1>
                            <?php if ($stall['is_active']): ?>
                                <span class="menu-status"><i class="bi bi-circle-fill me-1"></i>Open now</span>
                            <?php else: ?>
                                <span class="menu-status menu-status-closed"><i class="bi bi-circle-fill me-1"></i>Temporarily closed</span>
                            <?php endif; ?>
                        </div>
                        <p class="stall-menu-tagline"><?= htmlspecialchars($stall['tagline']) ?></p>
                        <p class="stall-menu-description"><?= nl2br(htmlspecialchars($stall['description'])) ?></p>
                        <div class="stall-menu-meta">
                            <span><i class="bi bi-person me-1"></i><?= htmlspecialchars($stall['owner_name'] ?: 'Student Entrepreneur') ?></span>
                            <span><i class="bi bi-geo-alt me-1"></i>Laguna University</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (!empty($products)): ?>
                <div class="stall-menu-stats">
                    <div>
                        <span class="menu-stat-number"><?= count($products) ?></span>
                        <span class="menu-stat-label">Menu items</span>
                    </div>
                    <div>
                        <span class="menu-stat-number">100%</span>
                        <span class="menu-stat-label">Student made</span>
                    </div>
                    <div>
                        <span class="menu-stat-number"><i class="bi bi-clock"></i></span>
                        <span class="menu-stat-label">Pickup available</span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if (!empty($products)): ?>
<section class="menu-section">
    <div class="container">
        <div class="menu-section-heading">
            <div>
                <span class="menu-eyebrow">Order online</span>
                <h2>Choose your favorites</h2>
                <p class="text-muted">Select an item and add it to your cart in one tap.</p>
            </div>
            <div class="menu-filters" role="group" aria-label="Filter menu">
                <button type="button" class="menu-filter-pill active" data-menu-filter="all" aria-pressed="true">
                    <i class="bi bi-grid me-1"></i>All
                </button>
                <button type="button" class="menu-filter-pill" data-menu-filter="food" aria-pressed="false">
                    <i class="bi bi-egg-fried me-1"></i>Food
                </button>
                <button type="button" class="menu-filter-pill" data-menu-filter="drinks" aria-pressed="false">
                    <i class="bi bi-cup-straw me-1"></i>Drinks
                </button>
                <button type="button" class="menu-filter-pill" data-menu-filter="carbonation" aria-pressed="false">
                    <i class="bi bi-lightning-charge me-1"></i>Carbonation
                </button>
            </div>
        </div>

        <div class="menu-grid">
            <?php foreach ($products as $product): ?>
                <article class="menu-card menu-item" data-menu-category="<?= htmlspecialchars($product['category'] ?? 'food') ?>">
                    <div class="menu-image-wrap">
                        <?php if ($product['image']): ?>
                            <img src="<?= url('assets/uploads/products/' . $product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" loading="lazy">
                        <?php else: ?>
                            <div class="menu-image-placeholder">
                                <i class="bi <?= ($product['category'] ?? '') === 'drinks' ? 'bi-cup-straw' : 'bi-egg-fried' ?>"></i>
                            </div>
                        <?php endif; ?>
                        <span class="menu-category-badge"><?= htmlspecialchars(ucfirst($product['category'] ?? 'food')) ?>">
                            <?= htmlspecialchars(ucfirst($product['category'] ?? 'Food')) ?>
                        </span>
                    </div>
                    <div class="menu-card-body">
                        <div class="menu-card-heading">
                            <h3><?= htmlspecialchars($product['name']) ?></h3>
                            <span class="menu-price">₱<?= number_format($product['price'], 2) ?></span>
                        </div>
                        <p class="menu-card-description"><?= htmlspecialchars($product['description']) ?></p>
                        <div class="menu-card-footer">
                            <span class="menu-card-note"><i class="bi bi-check-circle me-1"></i>Available today</span>
                            <a href="<?= url('cart/add/' . (int) $product['id']) ?>" class="menu-add-button">
                                <i class="bi bi-cart-plus me-1"></i>Add
                            </a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="menu-footer-actions">
            <a href="<?= url('stalls') ?>" class="btn btn-outline-success menu-secondary-button">
                <i class="bi bi-arrow-left me-2"></i>Browse other stalls
            </a>
            <a href="<?= url('cart') ?>" class="btn btn-success menu-primary-button">
                <i class="bi bi-cart3 me-2"></i>View cart <span class="menu-cart-count"><?= cart_count() ?></span>
            </a>
        </div>
    </div>
</section>
<?php else: ?>
<section class="menu-empty-section">
    <div class="container">
        <div class="menu-empty-card">
            <div class="menu-empty-icon"><i class="bi bi-receipt"></i></div>
            <h2>No menu items yet</h2>
            <p class="text-muted">This stall has not added any available items yet.</p>
            <a href="<?= url('stalls') ?>" class="btn btn-success">
                <i class="bi bi-arrow-left me-2"></i>Back to stalls
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
    document.querySelectorAll('[data-menu-filter]').forEach(function (button) {
        button.addEventListener('click', function () {
            var filter = button.getAttribute('data-menu-filter');

            document.querySelectorAll('[data-menu-filter]').forEach(function (item) {
                var isActive = item === button;
                item.classList.toggle('active', isActive);
                item.setAttribute('aria-pressed', isActive ? 'true' : 'false');
            });

            document.querySelectorAll('.menu-item').forEach(function (item) {
                var category = item.getAttribute('data-menu-category');
                item.classList.toggle('d-none', filter !== 'all' && category !== filter);
            });
        });
    });
</script>