<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Q-Stalls POS') ?></title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Stylesheets with Cache Busting -->
    <link rel="stylesheet" href="<?= url('style.css') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= url('assets/css/style.css') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= url('pos-coral.css') ?>?v=<?= time() ?>">

    <!-- Embedded Critical Coral POS Styles (guarantees instant layout even with browser cache) -->
    <style>
        <?= file_get_contents(__DIR__ . '/assets/css/pos-coral.css') ?>
    </style>
</head>
<body class="pos-app-body coral-body-bg">

    <div class="coral-app-outer">
        <!-- App Wrapper Card Container -->
        <div class="pos-app-wrapper coral-card-container">

            <!-- ============================================== -->
            <!-- LEFT NARROW SIDEBAR (NAVIGATION RAIL)          -->
            <!-- ============================================== -->
            <nav class="pos-sidebar-rail" aria-label="Main Navigation">
                <!-- Top Concentric Circle Logo matching screenshot -->
                <a href="<?= url() ?>" class="pos-rail-logo" title="POS Dashboard & Home">
                    <div class="coral-concentric-logo">
                        <div class="concentric-ring-outer">
                            <div class="concentric-ring-inner">
                                <div class="concentric-dot"></div>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Middle Navigation Icons -->
                <div class="pos-rail-menu">
                    <?php 
                    $dashboardUrl = (auth_check() && in_array(auth_user()['role'] ?? '', ['stall_admin', 'admin'])) 
                        ? url('vendor') 
                        : url('pos');
                    ?>
                    <a href="<?= $dashboardUrl ?>" class="pos-rail-link active" title="Dashboard">
                        <i class="bi bi-grid-fill"></i>
                    </a>
                </div>

                <!-- Bottom Settings / Profile / Auth Icons -->
                <div class="pos-rail-bottom">
                    <?php if (auth_check()): ?>
                        <a href="<?= url('profile') ?>" class="pos-rail-link" title="Profile: <?= htmlspecialchars(auth_user()['full_name']) ?>">
                            <i class="bi bi-person-circle"></i>
                        </a>
                        <a href="<?= url('logout') ?>" class="pos-rail-link" title="Log Out" style="color:#ef4444;">
                            <i class="bi bi-box-arrow-right"></i>
                        </a>
                    <?php else: ?>
                        <a href="<?= url('login') ?>" class="pos-rail-link" title="Sign In / Register">
                            <i class="bi bi-box-arrow-in-right"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </nav>

            <!-- ============================================== -->
            <!-- MAIN APP VIEWPORT (CONTENT)                    -->
            <!-- ============================================== -->
            <main class="pos-app-main-viewport">
                <!-- Flash Message Toast Notification -->
                <?php 
                $flashSuccess = flash('success');
                $flashError = flash('error');
                ?>
                <?php if ($flashSuccess || $flashError): ?>
                    <div class="pos-toast-container" id="posToastAlert">
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

                <!-- Render Controller View Content -->
                <?= $content ?>
            </main>
        </div> <!-- end .pos-app-wrapper -->
    </div> <!-- end .coral-app-outer -->

    <!-- Mobile Floating "My Order" Trigger Pill -->
    <button type="button" class="pos-mobile-cart-btn" id="posMobileCartToggle" title="View Order">
        <i class="bi bi-bag-fill me-2"></i>
        <span>My Order</span>
        <span class="badge bg-white text-success rounded-pill ms-2" id="posMobileCartBadge"><?= cart_count() ?></span>
    </button>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.APP_URL = "<?= url() ?>";
        window.BASE_URL = "<?= BASE_URL ?>";
        window.IS_LOGGED_IN = <?= auth_check() ? 'true' : 'false' ?>;
    </script>
    <script src="<?= url('main.js') ?>?v=<?= time() ?>"></script>
    <script src="<?= url('assets/js/main.js') ?>?v=<?= time() ?>"></script>
</body>
</html>
