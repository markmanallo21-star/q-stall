<div class="landing-page-wrapper">

    <!-- ============================================== -->
    <!-- HERO SECTION: Food Made with Love              -->
    <!-- ============================================== -->
    <section class="landing-hero-section">
        <div class="container position-relative">
            <div class="row align-items-center min-vh-75 py-5 g-4">
                
                <!-- Left Text Column -->
                <div class="col-lg-6 z-2">
                    <div class="hero-tag-badge">
                        <span>FRESH</span>
                        <span class="bullet">&bull;</span>
                        <span>TASTY</span>
                        <span class="bullet">&bull;</span>
                        <span>DELICIOUS</span>
                    </div>

                    <h1 class="hero-headline">
                        Food<br>
                        Made with <span class="hero-cursive">Love</span>
                    </h1>

                    <p class="hero-description">
                        From smoky Bacolod chicken inasal to sizzling chaofan combos and ice-cold fruit refreshers, we serve the best campus favorites crafted by Laguna University student entrepreneurs with fresh ingredients and a whole lot of love.
                    </p>

                    <div class="hero-actions mb-4">
                        <a href="<?= url('menu') ?>" class="btn hero-order-btn">
                            <span>Order Now</span>
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>

                    <!-- 3 Feature Badges below CTA -->
                    <div class="hero-trust-badges">
                        <div class="trust-badge-item">
                            <i class="bi bi-leaf"></i>
                            <span>Fresh<br>Ingredients</span>
                        </div>
                        <div class="trust-badge-divider"></div>
                        <div class="trust-badge-item">
                            <i class="bi bi-truck"></i>
                            <span>Fast<br>Pickup</span>
                        </div>
                        <div class="trust-badge-divider"></div>
                        <div class="trust-badge-item">
                            <i class="bi bi-shield-check"></i>
                            <span>Hygienic<br>& Safe</span>
                        </div>
                    </div>
                </div>

                <!-- Right Hero Image Column -->
                <div class="col-lg-6 position-relative text-center">
                    <div class="hero-image-wrap">
                        <!-- Best in Town playful annotation -->
                        <div class="hero-floating-tag">
                            <div class="floating-sparkles">///</div>
                            <span class="floating-text">Best Bites<br>in Town</span>
                            <div class="floating-arrow">&crarr;</div>
                        </div>

                        <!-- Hero Main Food Platter Image -->
                        <img src="<?= url('assets/uploads/products/chicken-inasal-rice.jpg') ?>" 
                             alt="Food Made with Love" 
                             class="hero-main-img img-fluid shadow-lg rounded-4"
                             onerror="this.src='<?= url('assets/uploads/products/121.jpg') ?>'">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================================== -->
    <!-- SECTION 2: POPULAR MENU SPECIALS               -->
    <!-- ============================================== -->
    <section class="landing-specials-section">
        <div class="container py-5">
            
            <div class="d-flex flex-wrap align-items-end justify-content-between mb-4 gap-3">
                <div>
                    <span class="section-eyebrow">OUR SPECIALS</span>
                    <h2 class="section-title">Popular Menu</h2>
                    <p class="section-subtitle mb-0">Explore our most loved dishes, crafted for your taste and campus happiness.</p>
                </div>
                <div>
                    <a href="<?= url('menu') ?>" class="btn btn-view-full">
                        <span>View Full Menu</span>
                        <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>

            <!-- Popular Food Cards Grid (from the 3 stalls) -->
            <div class="row g-4">
                
                <!-- Card 1: Chicken Inasal with Rice (Chick-Chi-Laok) -->
                <div class="col-sm-6 col-lg-3">
                    <div class="landing-food-card">
                        <div class="card-img-wrap">
                            <span class="card-popular-pill">Popular</span>
                            <img src="<?= url('assets/uploads/products/chicken-inasal-rice.jpg') ?>" 
                                 alt="Chicken Inasal with Rice"
                                 class="card-img-top"
                                 onerror="this.src='<?= url('assets/uploads/products/121.jpg') ?>'">
                        </div>
                        <div class="card-body-content">
                            <span class="card-stall-label chick">Chick-Chi-Laok</span>
                            <h3 class="card-item-title">Chicken Inasal with Rice</h3>
                            <p class="card-item-desc">Bacolod-style grilled chicken marinated in lemongrass, annatto, and spices.</p>
                            <div class="card-item-price">₱95.00</div>
                            <button type="button" class="btn card-add-btn" onclick="quickAddToCart(1, 'Chicken Inasal with Rice')">
                                <i class="bi bi-cart-plus me-1"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Combo 3: Overload Chaofan (Chaohaus) -->
                <div class="col-sm-6 col-lg-3">
                    <div class="landing-food-card">
                        <div class="card-img-wrap">
                            <img src="<?= url('assets/uploads/products/combo-3.jpg') ?>" 
                                 alt="Combo 3: Overload Chaofan"
                                 class="card-img-top"
                                 onerror="this.src='<?= url('assets/uploads/products/121.jpg') ?>'">
                        </div>
                        <div class="card-body-content">
                            <span class="card-stall-label chao">Chaohaus</span>
                            <h3 class="card-item-title">Combo 3: Overload</h3>
                            <p class="card-item-desc">Savory wok-fried chaofan loaded with 3 steamed siomai and 4 crispy lumpia.</p>
                            <div class="card-item-price">₱65.00</div>
                            <button type="button" class="btn card-add-btn" onclick="quickAddToCart(8, 'Combo 3: Overload')">
                                <i class="bi bi-cart-plus me-1"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Chicken Wings with Rice (Chick-Chi-Laok) -->
                <div class="col-sm-6 col-lg-3">
                    <div class="landing-food-card">
                        <div class="card-img-wrap">
                            <img src="<?= url('assets/uploads/products/121.jpg') ?>" 
                                 alt="Chicken Wings with Rice"
                                 class="card-img-top">
                        </div>
                        <div class="card-body-content">
                            <span class="card-stall-label chick">Chick-Chi-Laok</span>
                            <h3 class="card-item-title">Chicken Wings with Rice</h3>
                            <p class="card-item-desc">Crispy fried chicken wings with savory sweet glaze, served with steamed rice.</p>
                            <div class="card-item-price">₱85.00</div>
                            <button type="button" class="btn card-add-btn" onclick="quickAddToCart(2, 'Chicken Wings with Rice')">
                                <i class="bi bi-cart-plus me-1"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Fruitie Green Apple Fizz (Carbonation) -->
                <div class="col-sm-6 col-lg-3">
                    <div class="landing-food-card">
                        <div class="card-img-wrap">
                            <img src="<?= url('assets/uploads/products/fruitie-green-apple.jpg') ?>" 
                                 alt="Fruitie Green Apple"
                                 class="card-img-top"
                                 onerror="this.src='<?= url('assets/uploads/products/drinks1.jpg') ?>'">
                        </div>
                        <div class="card-body-content">
                            <span class="card-stall-label carb">Carbonation</span>
                            <h3 class="card-item-title">Fruitie Green Apple</h3>
                            <p class="card-item-desc">Crisp refreshing green apple fruit drink, available in plain or sparkling soda fizz.</p>
                            <div class="card-item-price">₱39.00</div>
                            <button type="button" class="btn card-add-btn" onclick="quickAddToCart(12, 'Fruitie Green Apple')">
                                <i class="bi bi-cart-plus me-1"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================================== -->
    <!-- SECTION 3: MEET OUR 3 CAMPUS STALLS            -->
    <!-- ============================================== -->
    <section class="landing-stalls-section py-5">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-eyebrow">LAGUNA UNIVERSITY BS ENTREPRENEURSHIP</span>
                <h2 class="section-title">Our 3 Student-Run Stalls</h2>
                <p class="section-subtitle mx-auto" style="max-width: 600px;">
                    Each stall operates as an independent student incubator business offering specialized foods and drinks with dedicated student teams.
                </p>
            </div>

            <div class="row g-4">
                <!-- Stall 1: Chick-Chi-Laok -->
                <div class="col-md-4">
                    <div class="stall-feature-card chick-card">
                        <div class="stall-card-header">
                            <div class="stall-card-icon" style="background:#ea580c; color:#fff;">
                                <i class="bi bi-fire fs-3"></i>
                            </div>
                            <span class="badge bg-warning text-dark">Stall #2</span>
                        </div>
                        <h3 class="stall-card-title">Chick-Chi-Laok</h3>
                        <p class="stall-card-tagline">Grilled Chicken & Silog Meals</p>
                        <p class="stall-card-desc">Serving signature Bacolod-style chicken inasal, savory barbecue wings, tender grilled chicken neck, and hot extra rice.</p>
                        <div class="stall-card-footer">
                            <a href="<?= url('menu?category=Chick-Chi-Laok') ?>" class="btn stall-link-btn">
                                Explore Stall Menu <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Stall 2: Chaohaus -->
                <div class="col-md-4">
                    <div class="stall-feature-card chao-card">
                        <div class="stall-card-header">
                            <div class="stall-card-icon" style="background:#dc2626; color:#fff;">
                                <i class="bi bi-box2-heart fs-3"></i>
                            </div>
                            <span class="badge bg-danger text-white">Stall #3</span>
                        </div>
                        <h3 class="stall-card-title">Chaohaus</h3>
                        <p class="stall-card-tagline">Chaofan, Siomai & Lumpia Combos</p>
                        <p class="stall-card-desc">Delicious wok-fried chaofan rice bowls paired with steamed pork siomai, crispy shanghai lumpia, and chili garlic sauce.</p>
                        <div class="stall-card-footer">
                            <a href="<?= url('menu?category=Chaohaus') ?>" class="btn stall-link-btn">
                                Explore Stall Menu <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Stall 3: Carbonation -->
                <div class="col-md-4">
                    <div class="stall-feature-card carb-card">
                        <div class="stall-card-header">
                            <div class="stall-card-icon" style="background:#0284c7; color:#fff;">
                                <i class="bi bi-cup-straw fs-3"></i>
                            </div>
                            <span class="badge bg-info text-white">Stall #1</span>
                        </div>
                        <h3 class="stall-card-title">Carbonation</h3>
                        <p class="stall-card-tagline">Fruit Refreshers & Milk Shakes</p>
                        <p class="stall-card-desc">Freshly crafted sparkling fruit drinks, popping boba pearls, creamy matcha zen milk, cookies & cream, and iced beverages.</p>
                        <div class="stall-card-footer">
                            <a href="<?= url('menu?category=Carbonation') ?>" class="btn stall-link-btn">
                                Explore Stall Menu <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================== -->
    <!-- SECTION 4: CRAVE IT? WE'LL DELIVER IT! / PICKUP-->
    <!-- ============================================== -->
    <section class="landing-cta-section my-5">
        <div class="container">
            <div class="landing-cta-banner">
                <div class="row align-items-center g-4">
                    
                    <div class="col-lg-6 cta-text-col">
                        <span class="cta-eyebrow">GOOD FOOD ALWAYS</span>
                        <h2 class="cta-headline">
                            <span class="cta-cursive">Crave It?</span><br>
                            We'll Deliver It!
                        </h2>
                        <p class="cta-copy">
                            Order your favorite campus meal or drink now and enjoy the perfect blend of taste and freshness. Order online for swift pickup or dining at Laguna University.
                        </p>
                        <a href="<?= url('menu') ?>" class="btn cta-btn">
                            <span>Order Now</span>
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>

                    <div class="col-lg-6 cta-image-col text-center">
                        <div class="cta-image-wrapper">
                            <!-- Playful doodle note -->
                            <div class="cta-doodle-tag">
                                <span>Good Food &hearts;</span><br>
                                <span>Good Vibes !</span>
                            </div>
                            <img src="<?= url('assets/uploads/products/plain-chaofan.jpg') ?>" 
                                 alt="Good Food Good Vibes" 
                                 class="cta-img img-fluid rounded-4 shadow"
                                 onerror="this.src='<?= url('assets/uploads/products/121.jpg') ?>'">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

</div>

<!-- Quick Add to Cart Client Script -->
<script>
function quickAddToCart(productId, productName) {
    var formData = new FormData();
    formData.append('ajax', '1');
    formData.append('product_id', productId);
    formData.append('quantity', '1');
    formData.append('action', 'add');

    fetch("<?= url('cart/add') ?>", {
        method: 'POST',
        body: formData
    })
    .then(function(res) { return res.json(); })
    .then(function(data) {
        if (data && data.success) {
            // Update cart counter in navbar
            var badge = document.getElementById('siteNavCartCount');
            if (badge) badge.innerText = data.cart_count;
            
            // Show toast notification
            showLandingToast("Added " + productName + " to your order!");
        } else {
            window.location.href = "<?= url('menu') ?>";
        }
    })
    .catch(function(err) {
        window.location.href = "<?= url('menu') ?>";
    });
}

function showLandingToast(msg) {
    var toast = document.createElement('div');
    toast.className = 'pos-toast success';
    toast.style.position = 'fixed';
    toast.style.bottom = '24px';
    toast.style.right = '24px';
    toast.style.zIndex = '99999';
    toast.style.background = '#10b981';
    toast.style.color = '#fff';
    toast.style.padding = '14px 20px';
    toast.style.borderRadius = '12px';
    toast.style.boxShadow = '0 10px 25px rgba(0,0,0,0.2)';
    toast.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i>' + msg + ' <a href="<?= url('menu') ?>" class="badge bg-white text-dark ms-2 text-decoration-none">View Cart &raquo;</a>';
    document.body.appendChild(toast);

    setTimeout(function() {
        toast.style.transition = 'opacity 0.4s ease';
        toast.style.opacity = '0';
        setTimeout(function() { toast.remove(); }, 400);
    }, 2800);
}
</script>
