<section class="profile-page">
    <div class="container">
        <div class="profile-header">
            <div>
                <span class="profile-eyebrow">Account settings</span>
                <h1>Edit Profile</h1>
                <p class="text-muted">Update your personal information and account security.</p>
            </div>
            <div class="profile-header-badge">
                <i class="bi bi-shield-check"></i>
                <span>Secure account</span>
            </div>
        </div>

        <div class="profile-layout">
            <aside class="profile-sidebar">
                <div class="profile-avatar">
                    <span><?= strtoupper(substr($user['full_name'] ?? 'A', 0, 1)) ?></span>
                </div>
                <h2><?= htmlspecialchars($user['full_name'] ?? 'Account') ?></h2>
                <p><?= htmlspecialchars($user['email'] ?? '') ?></p>
                <div class="profile-account-status">
                    <span class="status-dot"></span>
                    Active account
                </div>
                <div class="profile-sidebar-info">
                    <div>
                        <span class="profile-info-label">Role</span>
                        <strong><?= ucfirst($user['role'] ?? 'customer') ?></strong>
                    </div>
                    <div>
                        <span class="profile-info-label">Member since</span>
                        <strong><?= htmlspecialchars(date('M d, Y', strtotime($user['created_at'] ?? 'now'))) ?></strong>
                    </div>
                </div>
            </aside>

            <div class="profile-content">
                <div class="profile-card">
                    <?php if (isset($errors) && !empty($errors)): ?>
                        <div class="alert alert-danger profile-alert">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            <span>Please correct the following:</span>
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= url('profile') ?>" class="profile-form">
                        <div class="profile-form-heading">
                            <div>
                                <h2>Profile Information</h2>
                                <p>These details are visible on your account.</p>
                            </div>
                            <i class="bi bi-person-badge"></i>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="profileFullName">Full Name <span class="text-danger">*</span></label>
                                <input id="profileFullName" type="text" class="form-control profile-input" name="full_name" required maxlength="100" value="<?= htmlspecialchars($user['full_name'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="profileEmail">Email Address <span class="text-danger">*</span></label>
                                <input id="profileEmail" type="email" class="form-control profile-input" name="email" required maxlength="150" value="<?= htmlspecialchars($user['email'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="profilePhone">Phone Number</label>
                                <input id="profilePhone" type="text" class="form-control profile-input" name="phone" maxlength="20" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" placeholder="+63 9XX XXX XXXX">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="profileRole">Account Role</label>
                                <div class="profile-role-field">
                                    <i class="bi bi-person-check"></i>
                                    <input id="profileRole" type="text" class="form-control profile-input" value="<?= ucfirst($user['role'] ?? 'customer') ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="profile-divider">
                            <span>Security</span>
                        </div>

                        <div class="profile-form-heading profile-security-heading">
                            <div>
                                <h2>Change Password</h2>
                                <p>Leave both fields blank to keep your current password.</p>
                            </div>
                            <i class="bi bi-key"></i>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="profilePassword">New Password</label>
                                <input id="profilePassword" type="password" class="form-control profile-input" name="password" minlength="6" autocomplete="new-password" placeholder="At least 6 characters">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="profilePasswordConfirm">Confirm New Password</label>
                                <input id="profilePasswordConfirm" type="password" class="form-control profile-input" name="password_confirm" minlength="6" autocomplete="new-password" placeholder="Repeat new password">
                            </div>
                        </div>

                        <div class="profile-actions">
                            <button type="submit" class="btn btn-success profile-save">
                                <i class="bi bi-check-circle me-2"></i>Save Changes
                            </button>
                            <a href="<?= url() ?>" class="btn btn-outline-secondary profile-cancel">
                                <i class="bi bi-arrow-left me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>