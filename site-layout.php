<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Q-Stalls - Laguna University BS Entrepreneurship') ?></title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?= url('style.css') ?>">
    <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
</head>
<body class="site-public-body">

    <!-- Top Sticky Header Navigation -->
    <header class="site-header" id="siteHeader">
        <div class="site-nav-container">
            <!-- Brand Logo -->
            <a href="<?= url() ?>" class="site-brand">
                <div class="site-logo-icon">
                    <!-- Chef Hat / Pot SVG Icon -->
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 13.87A4 4 0 0 1 7.41 6a5.11 5.11 0 0 1 1.05-1.54 5 5 0 0 1 7.08 0A5.11 5.11 0 0 1 16.59 6 4 4 0 0 1 18 13.87V21H6Z"/>
                        <line x1="6" y1="17" x2="18" y2="17"/>
                    </svg>
                </div>
                <div class="site-brand-text">
                    <span class="site-brand-name">Q-Stalls</span>
                    <span class="site-brand-tagline">CAMPUS FOOD &bull; HAPPY MOOD</span>
                </div>
            </a>

            <!-- Desktop Nav Links -->
            <nav class="site-nav-links" id="siteNavLinks">
                <a href="<?= url() ?>" class="site-nav-link <?= empty($segments[0]) || $segments[0] === 'landing' ? 'active' : '' ?>">Home</a>
                <a href="<?= url('menu') ?>" class="site-nav-link <?= ($segments[0] ?? '') === 'menu' ? 'active' : '' ?>">Menu & POS</a>
                <a href="<?= url('about') ?>" class="site-nav-link <?= ($segments[0] ?? '') === 'about' ? 'active' : '' ?>">About</a>
                <a href="<?= url('stalls') ?>" class="site-nav-link <?= ($segments[0] ?? '') === 'stalls' ? 'active' : '' ?>">Stalls</a>
                <a href="<?= url('order-tracking') ?>" class="site-nav-link <?= ($segments[0] ?? '') === 'order-tracking' ? 'active' : '' ?>">Track Order</a>
                <a href="<?= url('contact') ?>" class="site-nav-link <?= ($segments[0] ?? '') === 'contact' ? 'active' : '' ?>">Contact</a>
            </nav>

            <!-- Right Action Buttons -->
            <div class="site-nav-actions">
                <!-- Search icon (links to menu search) -->
                <a href="<?= url('menu') ?>" class="site-icon-btn" title="Search Food & Drinks">
                    <i class="bi bi-search"></i>
                </a>

                <!-- Cart icon with counter badge -->
                <a href="<?= url('menu') ?>" class="site-cart-btn" title="View Cart">
                    <i class="bi bi-cart3"></i>
                    <span class="site-cart-badge" id="siteNavCartCount"><?= cart_count() ?></span>
                </a>

                <!-- Order Now primary amber pill button -->
                <a href="<?= url('menu') ?>" class="btn site-btn-order">
                    <span>Order Now</span>
                    <i class="bi bi-arrow-right ms-1"></i>
                </a>

                <!-- Auth / Login state -->
                <?php if (auth_check()): ?>
                    <div class="dropdown d-inline-block">
                        <button class="btn site-btn-user dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i>
                            <span class="d-none d-md-inline"><?= htmlspecialchars(auth_user()['full_name']) ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3">
                            <?php if (auth_user()['role'] === 'stall_admin' || auth_user()['role'] === 'admin'): ?>
                                <li>
                                    <a class="dropdown-item text-warning fw-semibold" href="<?= url('vendor') ?>">
                                        <i class="bi bi-graph-up-arrow me-2"></i>Stall Sales Dashboard
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="<?= url('profile') ?>"><i class="bi bi-gear me-2"></i>My Profile</a></li>
                            <li><a class="dropdown-item" href="<?= url('order-tracking') ?>"><i class="bi bi-clock-history me-2"></i>Track Orders</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Log Out</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="<?= url('login') ?>" class="btn site-btn-login">
                        <i class="bi bi-box-arrow-in-right me-1"></i>
                        <span>Sign In</span>
                    </a>
                <?php endif; ?>

                <!-- Mobile Hamburger Toggle -->
                <button type="button" class="site-mobile-toggle d-lg-none" id="siteMobileNavToggle" aria-label="Toggle navigation">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Drawer Menu -->
        <div class="site-mobile-drawer" id="siteMobileDrawer">
            <a href="<?= url() ?>" class="site-drawer-link">Home</a>
            <a href="<?= url('menu') ?>" class="site-drawer-link">Menu & POS Dashboard</a>
            <a href="<?= url('about') ?>" class="site-drawer-link">About BS Entrepreneurship</a>
            <a href="<?= url('stalls') ?>" class="site-drawer-link">Our 3 Stalls</a>
            <a href="<?= url('order-tracking') ?>" class="site-drawer-link">Track Order</a>
            <a href="<?= url('contact') ?>" class="site-drawer-link">Contact</a>
            <hr class="my-2 border-secondary">
            <?php if (auth_check()): ?>
                <?php if (auth_user()['role'] === 'stall_admin' || auth_user()['role'] === 'admin'): ?>
                    <a href="<?= url('vendor') ?>" class="site-drawer-link text-warning fw-bold">
                        <i class="bi bi-graph-up-arrow me-1"></i> Stall Sales Dashboard
                    </a>
                <?php endif; ?>
                <a href="<?= url('profile') ?>" class="site-drawer-link">Profile (<?= htmlspecialchars(auth_user()['full_name']) ?>)</a>
                <a href="<?= url('logout') ?>" class="site-drawer-link text-danger">Log Out</a>
            <?php else: ?>
                <a href="<?= url('login') ?>" class="site-drawer-link fw-bold text-warning">Sign In / Register</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Flash Message Notification -->
    <?php 
    $flashSuccess = flash('success');
    $flashError = flash('error');
    ?>
    <?php if ($flashSuccess || $flashError): ?>
        <div class="pos-toast-container" id="posToastAlert" style="z-index: 9999;">
            <?php if ($flashSuccess): ?>
                <div class="pos-toast success">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <span><?= htmlspecialchars($flashSuccess) ?></span>
                    <button type="button" class="pos-toast-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            <?php endif; ?>
            <?php if ($flashError): ?>
                <div class="pos-toast error">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <span><?= htmlspecialchars($flashError) ?></span>
                    <button type="button" class="pos-toast-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Main Content Body -->
    <main class="site-main-content">
        <?= $content ?>
    </main>

    <!-- Shared Footer matching the uploaded reference -->
    <footer class="site-footer">
        <!-- 4 Value Proposition Features Bar -->
        <div class="site-features-bar">
            <div class="container">
                <div class="row g-3 text-center text-md-start">
                    <div class="col-6 col-lg-3">
                        <div class="site-feature-item">
                            <div class="site-feat-icon"><i class="bi bi-leaf"></i></div>
                            <div class="site-feat-text">
                                <strong>100% Fresh Ingredients</strong>
                                <small>Locally prepared daily</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="site-feature-item">
                            <div class="site-feat-icon"><i class="bi bi-star"></i></div>
                            <div class="site-feat-text">
                                <strong>Top Rated by Students</strong>
                                <small>Campus favorite picks</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="site-feature-item">
                            <div class="site-feat-icon"><i class="bi bi-truck"></i></div>
                            <div class="site-feat-text">
                                <strong>Fast & Reliable Pickup</strong>
                                <small>Skip the long queues</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="site-feature-item">
                            <div class="site-feat-icon"><i class="bi bi-shield-check"></i></div>
                            <div class="site-feat-text">
                                <strong>Secure Online Payment</strong>
                                <small>Cash & GCash accepted</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copyright & Social Links -->
        <div class="site-copyright-bar">
            <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2 py-3">
                <div class="small text-muted">
                    &copy; <?= date('Y') ?> <strong>Q-Stalls</strong> &bull; Laguna University BS Entrepreneurship. All rights reserved.
                </div>
                <div class="site-social-links">
                    <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                    <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.APP_URL = "<?= url() ?>";
        window.BASE_URL = "<?= BASE_URL ?>";

        // Mobile drawer toggle
        var mobileBtn = document.getElementById('siteMobileNavToggle');
        var mobileDrawer = document.getElementById('siteMobileDrawer');
        if (mobileBtn && mobileDrawer) {
            mobileBtn.addEventListener('click', function() {
                mobileDrawer.classList.toggle('open');
            });
        }
    </script>
</body>
</html>
