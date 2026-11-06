<?php
$activeTab = $tab ?? 'login';
?>
<section class="auth-page pos-auth-page">
    <div class="container py-4">
        <div class="auth-shell">
            <!-- Left Branding Side -->
            <div class="auth-brand-panel">
                <div class="auth-brand-shape auth-brand-shape-one"></div>
                <div class="auth-brand-shape auth-brand-shape-two"></div>
                <div class="auth-brand-content">
                    <div class="pos-auth-logo">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 13.87A4 4 0 0 1 7.41 6a5.11 5.11 0 0 1 1.05-1.54 5 5 0 0 1 7.08 0A5.11 5.11 0 0 1 16.59 6 4 4 0 0 1 18 13.87V21H6Z"/>
                            <line x1="6" y1="17" x2="18" y2="17"/>
                        </svg>
                    </div>
                    <div>
                        <span class="auth-eyebrow">Laguna University BS Entrepreneurship</span>
                        <h1>Q-Stalls &bull; Campus Portal</h1>
                        <p class="auth-brand-copy">Good food &bull; Happy mood. Sign in to place quick campus orders or access your dedicated stall sales dashboard.</p>
                    </div>
                </div>

                <div class="pos-auth-stalls-preview">
                    <div class="pos-stall-chip chick">
                        <i class="bi bi-fire"></i>
                        <div>
                            <strong>Chick-Chi-Laok</strong>
                            <small>Grilled Chicken & Silog Meals</small>
                        </div>
                    </div>
                    <div class="pos-stall-chip chao">
                        <i class="bi bi-box2-heart"></i>
                        <div>
                            <strong>Chaohaus</strong>
                            <small>Chaofan, Siomai & Lumpia Combos</small>
                        </div>
                    </div>
                    <div class="pos-stall-chip carb">
                        <i class="bi bi-cup-straw"></i>
                        <div>
                            <strong>Carbonation</strong>
                            <small>Fruit Refreshers & Milk Shakes</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Form Side -->
            <div class="auth-form-panel">
                <div class="auth-form-wrap">
                    <a href="<?= url() ?>" class="auth-back-link">
                        <i class="bi bi-arrow-left me-2"></i>Back to Menu Catalog
                    </a>

                    <!-- Tabs Header -->
                    <div class="pos-auth-tabs">
                        <button type="button" class="pos-auth-tab-btn <?= $activeTab === 'login' ? 'active' : '' ?>" id="tabLoginBtn" onclick="switchAuthTab('login')">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                        </button>
                        <button type="button" class="pos-auth-tab-btn <?= $activeTab === 'register' ? 'active' : '' ?>" id="tabRegisterBtn" onclick="switchAuthTab('register')">
                            <i class="bi bi-person-plus me-1"></i> Student Register
                        </button>
                    </div>

                    <!-- Errors alert -->
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger auth-alert" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                            <div>
                                <?php foreach ($errors as $error): ?>
                                    <div><?= htmlspecialchars($error) ?></div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- ============================================== -->
                    <!-- TAB 1: SIGN IN                                 -->
                    <!-- ============================================== -->
                    <div id="authLoginSection" style="<?= $activeTab === 'login' ? 'display:block;' : 'display:none;' ?>">
                        <div class="auth-form-header">
                            <h2>Sign In to Your Account</h2>
                            <p class="text-muted">Access customer ordering or manage your stall's sales dashboard.</p>
                        </div>

                        <!-- One-Click Quick Logins -->
                        <div class="pos-quick-roles mb-3">
                            <span class="pos-quick-roles-title"><i class="bi bi-lightning-charge-fill me-1 text-warning"></i> Quick Demo Logins (1-Click Fill):</span>
                            <div class="pos-quick-role-grid">
                                <button type="button" class="pos-quick-btn chick" onclick="quickFill('chickchilaok@qstall.com', 'chickchilaok123', 'Chick-Chi-Laok Admin')">
                                    <span class="pos-qb-badge" style="background:#ea580c;">🍗 Stall #2</span>
                                    <span class="pos-qb-name">Chick-Chi-Laok</span>
                                    <span class="pos-qb-sub">Admin Sales</span>
                                </button>
                                <button type="button" class="pos-quick-btn chao" onclick="quickFill('chaohaus@qstall.com', 'chaohaus123', 'Chaohaus Admin')">
                                    <span class="pos-qb-badge" style="background:#dc2626;">🥡 Stall #3</span>
                                    <span class="pos-qb-name">Chaohaus</span>
                                    <span class="pos-qb-sub">Admin Sales</span>
                                </button>
                                <button type="button" class="pos-quick-btn carb" onclick="quickFill('carbonation@qstall.com', 'carbonation123', 'Carbonation Admin')">
                                    <span class="pos-qb-badge" style="background:#0284c7;">🥤 Stall #1</span>
                                    <span class="pos-qb-name">Carbonation</span>
                                    <span class="pos-qb-sub">Admin Sales</span>
                                </button>
                                <button type="button" class="pos-quick-btn cust" onclick="quickFill('customer@qstall.com', 'customer123', 'Customer')">
                                    <span class="pos-qb-badge" style="background:#10b981;">🛒 Customer</span>
                                    <span class="pos-qb-name">Sample Student</span>
                                    <span class="pos-qb-sub">Order & Track</span>
                                </button>
                            </div>
                        </div>

                        <form method="POST" action="<?= url('login') ?>" class="auth-form" id="loginForm">
                            <div class="auth-field">
                                <label for="loginEmail">Email Address</label>
                                <div class="auth-input-group">
                                    <i class="bi bi-envelope"></i>
                                    <input type="email" class="form-control" id="loginEmail" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" placeholder="Enter email (e.g. chaohaus@qstall.com)" required autocomplete="email">
                                </div>
                            </div>

                            <div class="auth-field">
                                <label for="loginPassword">Password</label>
                                <div class="auth-input-group">
                                    <i class="bi bi-lock"></i>
                                    <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Enter your password" required autocomplete="current-password">
                                    <button type="button" class="auth-password-toggle" aria-label="Show password" onclick="togglePass('loginPassword', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="btn auth-submit w-100" id="loginSubmitBtn">
                                <span>Sign In to Account</span> <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </form>
                    </div>

                    <!-- ============================================== -->
                    <!-- TAB 2: REGISTER (NEW CUSTOMER)                 -->
                    <!-- ============================================== -->
                    <div id="authRegisterSection" style="<?= $activeTab === 'register' ? 'display:block;' : 'display:none;' ?>">
                        <div class="auth-form-header">
                            <h2>Create Customer Account</h2>
                            <p class="text-muted">Register as a student or campus customer to easily order and track food & drinks.</p>
                        </div>

                        <form method="POST" action="<?= url('register') ?>" class="auth-form">
                            <div class="auth-field">
                                <label for="regFullName">Full Name</label>
                                <div class="auth-input-group">
                                    <i class="bi bi-person"></i>
                                    <input type="text" class="form-control" id="regFullName" name="full_name" value="<?= htmlspecialchars($old['full_name'] ?? '') ?>" placeholder="Juan Dela Cruz" required>
                                </div>
                            </div>

                            <div class="auth-field">
                                <label for="regEmail">Email Address</label>
                                <div class="auth-input-group">
                                    <i class="bi bi-envelope"></i>
                                    <input type="email" class="form-control" id="regEmail" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" placeholder="student@laguna.edu.ph" required>
                                </div>
                            </div>

                            <div class="auth-field">
                                <label for="regPhone">Contact / Phone Number</label>
                                <div class="auth-input-group">
                                    <i class="bi bi-telephone"></i>
                                    <input type="tel" class="form-control" id="regPhone" name="phone" value="<?= htmlspecialchars($old['phone'] ?? '') ?>" placeholder="09123456789">
                                </div>
                            </div>

                            <div class="row g-2">
                                <div class="col-sm-6">
                                    <div class="auth-field">
                                        <label for="regPassword">Password</label>
                                        <div class="auth-input-group">
                                            <i class="bi bi-lock"></i>
                                            <input type="password" class="form-control" id="regPassword" name="password" placeholder="At least 6 chars" required minlength="6">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="auth-field">
                                        <label for="regConfirm">Confirm Password</label>
                                        <div class="auth-input-group">
                                            <i class="bi bi-shield-check"></i>
                                            <input type="password" class="form-control" id="regConfirm" name="password_confirm" placeholder="Repeat password" required minlength="6">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn auth-submit w-100 mt-2">
                                <span>Create Account & Sign In</span> <i class="bi bi-check2-circle ms-2"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Footer note -->
                    <div class="auth-form-footer mt-4 text-center">
                        <small class="text-muted">Laguna University BS Entrepreneurship &bull; Food & Drinks System</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function switchAuthTab(tab) {
    var loginSec = document.getElementById('authLoginSection');
    var regSec = document.getElementById('authRegisterSection');
    var tabLoginBtn = document.getElementById('tabLoginBtn');
    var tabRegBtn = document.getElementById('tabRegisterBtn');

    if (tab === 'register') {
        loginSec.style.display = 'none';
        regSec.style.display = 'block';
        tabLoginBtn.classList.remove('active');
        tabRegBtn.classList.add('active');
    } else {
        loginSec.style.display = 'block';
        regSec.style.display = 'none';
        tabLoginBtn.classList.add('active');
        tabRegBtn.classList.remove('active');
    }
}

function quickFill(email, password, label) {
    switchAuthTab('login');
    var emailInput = document.getElementById('loginEmail');
    var passInput = document.getElementById('loginPassword');
    emailInput.value = email;
    passInput.value = password;
    
    // Highlight inputs briefly
    emailInput.style.backgroundColor = '#ecfdf5';
    passInput.style.backgroundColor = '#ecfdf5';
    setTimeout(function() {
        emailInput.style.backgroundColor = '';
        passInput.style.backgroundColor = '';
    }, 600);

    // Auto submit form directly
    document.getElementById('loginForm').submit();
}

function togglePass(id, btn) {
    var input = document.getElementById(id);
    var icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>
