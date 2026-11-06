<section class="py-5" style="background:#faf7f2; min-height: 80vh;">
    <div class="container py-3">
        
        <div class="text-center mb-5">
            <span class="section-eyebrow">CAMPUS FOOD & DRINKS DIRECTORY</span>
            <h1 class="section-title">Our Student-Run Stalls</h1>
            <p class="section-subtitle mx-auto" style="max-width: 620px;">
                Explore the three entrepreneurial food and beverage stalls managed by Laguna University BS Entrepreneurship students.
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            
            <!-- Stall 2: Chick-Chi-Laok -->
            <div class="col-md-6 col-lg-4">
                <div class="stall-feature-card chick-card h-100">
                    <div class="card-img-wrap mb-3" style="height: 200px;">
                        <img src="<?= url('assets/uploads/products/chicken-inasal-rice.jpg') ?>" 
                             alt="Chick-Chi-Laok"
                             class="card-img-top"
                             onerror="this.src='<?= url('assets/uploads/products/121.jpg') ?>'">
                    </div>
                    <div class="stall-card-header">
                        <div class="stall-card-icon" style="background:#ea580c; color:#fff;">
                            <i class="bi bi-fire fs-3"></i>
                        </div>
                        <span class="badge" style="background:#ea580c; color:#fff;">Stall #2</span>
                    </div>
                    <h3 class="stall-card-title">Chick-Chi-Laok</h3>
                    <p class="stall-card-tagline">Grilled Chicken & Silog Meals</p>
                    <p class="stall-card-desc">Bacolod-style grilled chicken inasal, crispy wings with savory glaze, barbecue chicken neck, and hot garlic rice.</p>
                    <div class="mt-auto d-flex gap-2">
                        <a href="<?= url('menu?category=Chick-Chi-Laok') ?>" class="btn hero-order-btn py-2 px-3 fs-6 w-100 justify-content-center">
                            <span>Order in POS</span> <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stall 3: Chaohaus -->
            <div class="col-md-6 col-lg-4">
                <div class="stall-feature-card chao-card h-100">
                    <div class="card-img-wrap mb-3" style="height: 200px;">
                        <img src="<?= url('assets/uploads/products/combo-3.jpg') ?>" 
                             alt="Chaohaus"
                             class="card-img-top"
                             onerror="this.src='<?= url('assets/uploads/products/plain-chaofan.jpg') ?>'">
                    </div>
                    <div class="stall-card-header">
                        <div class="stall-card-icon" style="background:#dc2626; color:#fff;">
                            <i class="bi bi-box2-heart fs-3"></i>
                        </div>
                        <span class="badge" style="background:#dc2626; color:#fff;">Stall #3</span>
                    </div>
                    <h3 class="stall-card-title">Chaohaus</h3>
                    <p class="stall-card-tagline">Chaofan, Siomai & Lumpia Combos</p>
                    <p class="stall-card-desc">Wok-fried chaofan rice bowls served fresh with steamed pork siomai, crispy shanghai lumpia rolls, and spicy chili garlic.</p>
                    <div class="mt-auto d-flex gap-2">
                        <a href="<?= url('menu?category=Chaohaus') ?>" class="btn hero-order-btn py-2 px-3 fs-6 w-100 justify-content-center">
                            <span>Order in POS</span> <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stall 1: Carbonation -->
            <div class="col-md-6 col-lg-4">
                <div class="stall-feature-card carb-card h-100">
                    <div class="card-img-wrap mb-3" style="height: 200px;">
                        <img src="<?= url('assets/uploads/products/fruitie-green-apple.jpg') ?>" 
                             alt="Carbonation"
                             class="card-img-top"
                             onerror="this.src='<?= url('assets/uploads/products/drinks1.jpg') ?>'">
                    </div>
                    <div class="stall-card-header">
                        <div class="stall-card-icon" style="background:#0284c7; color:#fff;">
                            <i class="bi bi-cup-straw fs-3"></i>
                        </div>
                        <span class="badge" style="background:#0284c7; color:#fff;">Stall #1</span>
                    </div>
                    <h3 class="stall-card-title">Carbonation</h3>
                    <p class="stall-card-tagline">Fruit Refreshers & Milk Shakes</p>
                    <p class="stall-card-desc">Refreshing fruit sodas, popping fruit boba pearls, sweet lychee, strawberry fizz, cookies & cream, and creamy zen green milk.</p>
                    <div class="mt-auto d-flex gap-2">
                        <a href="<?= url('menu?category=Carbonation') ?>" class="btn hero-order-btn py-2 px-3 fs-6 w-100 justify-content-center">
                            <span>Order in POS</span> <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Back to Home banner -->
        <div class="text-center mt-5">
            <a href="<?= url() ?>" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-semibold">
                <i class="bi bi-house me-1"></i> Back to Home Landing Page
            </a>
            <a href="<?= url('menu') ?>" class="btn hero-order-btn rounded-pill px-4 py-2 ms-2 fw-bold">
                <i class="bi bi-grid-fill me-1"></i> Open Full POS Menu
            </a>
        </div>
    </div>
</section>
