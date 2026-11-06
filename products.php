<?php
$searchQuery = trim($search_query ?? '');
$activeCategory = $active_category ?? '';
$productsBase = url('products');
?>
<section class="<?= $searchQuery !== '' ? 'search-results-header bg-light py-1' : 'hero-section bg-light py-3' ?>">
    <div class="container">
        <?php if ($searchQuery !== ''): ?>
            <div class="text-center mb-1">
                <h1 class="h4 fw-bold text-success mb-0">“<?= htmlspecialchars($searchQuery) ?>”</h1>
                <p class="text-muted small mb-0"><i class="bi bi-search me-1"></i><?= count($products) ?> result<?= count($products) === 1 ? '' : 's' ?></p>
            </div>
        <?php else: ?>
            <div class="text-center">
                <h1 class="h3 fw-bold text-success">All Products</h1>
                <p class="text-muted small mt-2">Browse all products from our student entrepreneurs</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php if (!empty($categories)): ?>
<section class="<?= $searchQuery !== '' ? 'py-1 bg-light' : 'py-3 bg-light' ?>">
    <div class="container">
        <div class="menu-filters" role="group" aria-label="Filter products">
            <?php
            $allUrl = $productsBase;
            if ($searchQuery !== '') {
                $allUrl .= '?q=' . urlencode($searchQuery);
            }
            ?>
            <a href="<?= $allUrl ?>" class="menu-filter-pill <?= $activeCategory === '' ? 'active' : '' ?>" aria-pressed="<?= $activeCategory === '' ? 'true' : 'false' ?>">
                <i class="bi bi-grid me-1"></i>All
            </a>
            <?php foreach ($categories as $cat): ?>
                <?php
                $filterUrl = $productsBase . '?category=' . urlencode($cat);
                if ($searchQuery !== '') {
                    $filterUrl .= '&q=' . urlencode($searchQuery);
                }
                $catLabel = $cat === 'drinks' ? 'Drinks' : 'Food';
                $catIcon = $cat === 'drinks' ? 'bi-cup-straw' : 'bi-egg-fried';
                ?>
                <a href="<?= $filterUrl ?>" class="menu-filter-pill <?= $activeCategory === $cat ? 'active' : '' ?>" aria-pressed="<?= $activeCategory === $cat ? 'true' : 'false' ?>">
                    <i class="bi <?= $catIcon ?> me-1"></i><?= $catLabel ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="<?= $searchQuery !== '' ? 'pt-2 pb-4' : 'py-5' ?>">
    <div class="container">

        <?php if (!empty($products)): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($products as $product): ?>
            <div class="col">
                <div class="card h-100 product-card shadow-sm">
                    <?php if ($product['image']): ?>
                        <img src="<?= url('assets/uploads/products/' . $product['image']) ?>" class="card-img-top product-img" alt="<?= htmlspecialchars($product['name']) ?>">
                    <?php else: ?>
                        <div class="card-img-top product-img d-flex align-items-center justify-content-center bg-light">
                            <span class="display-4">📦</span>
                        </div>
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <span class="badge bg-outline-success text-success small align-self-start mb-2"><?= htmlspecialchars($product['category'] ?? 'General') ?></span>
                        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                        <p class="text-muted small mb-1"><?= htmlspecialchars($product['stall_name']) ?></p>
                        <p class="card-text small mb-3"><?= htmlspecialchars($product['description']) ?></p>
                        <div class="mt-auto d-flex align-items-center justify-content-between">
                            <span class="price text-success fw-bold">₱<?= number_format($product['price'], 2) ?></span>
                            <a href="<?= url('cart/add/' . $product['id']) ?>" class="btn btn-success btn-sm">
                                <i class="bi bi-cart-plus"></i> Add
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <?php if ($searchQuery !== ''): ?>
                <div class="empty-search-icon"><i class="bi bi-search-heart"></i></div>
                <h4 class="text-muted">No menu items found</h4>
                <p class="text-muted">Try searching for another food, drink, or stall name.</p>
                <a href="<?= $productsBase ?>" class="btn btn-success">View all menus</a>
            <?php else: ?>
                <h4 class="text-muted">No products found</h4>
                <a href="<?= url() ?>" class="btn btn-success">Back to Home</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>