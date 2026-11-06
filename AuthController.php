<?php
require_once SRC_PATH . '/User.php';

class AuthController {
    public function show() {
        if (auth_check()) {
            $user = auth_user();
            if ($user['role'] === 'stall_admin' || $user['role'] === 'admin') {
                redirect('vendor');
            } else {
                redirect('');
            }
            return;
        }

        $data = [
            'title' => 'Sign In & Register - Laguna University Stall',
        ];

        layout('site-layout', view('login', $data), $data);
    }

    public function login() {
        if (auth_check()) {
            $user = auth_user();
            if ($user['role'] === 'stall_admin' || $user['role'] === 'admin') {
                redirect('vendor');
            } else {
                redirect('');
            }
            return;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $errors = [];

        if ($email === '') {
            $errors[] = 'Email address is required.';
        }
        if ($password === '') {
            $errors[] = 'Password is required.';
        }

        $user = null;
        if ($errors === []) {
            $user = User::findByEmail($email);
            if (!$user || !(int)$user['is_active']) {
                $errors[] = 'Invalid email or password.';
            } elseif (!auth_verify($password, $user['password'])) {
                $errors[] = 'Invalid email or password.';
            }
        }

        if ($errors !== []) {
            $data = [
                'title'  => 'Sign In - Laguna University Stall',
                'errors' => $errors,
                'tab'    => 'login'
            ];

            layout('site-layout', view('login', $data), $data);
            return;
        }

        session_regenerate_id(true);
        auth_login($user);

        if ($user['role'] === 'stall_admin') {
            $stallName = '';
            if ($user['stall_id'] == 1) $stallName = 'Carbonation';
            elseif ($user['stall_id'] == 2) $stallName = 'Chick-Chi-Laok';
            elseif ($user['stall_id'] == 3) $stallName = 'Chaohaus';
            
            flash('success', "Welcome back, {$user['full_name']}! You are managing {$stallName}.");
            redirect('vendor');
        } elseif ($user['role'] === 'admin') {
            flash('success', "Welcome back, Administrator ({$user['full_name']})!");
            redirect('vendor');
        } else {
            flash('success', "Welcome back, {$user['full_name']}! You are now in the POS Ordering Dashboard.");
            redirect('pos');
        }
    }

    public function register() {
        if (auth_check()) {
            redirect('');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('login');
            return;
        }

        $fullName = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';
        $errors = [];

        if ($fullName === '') {
            $errors[] = 'Full name is required.';
        }
        if ($email === '') {
            $errors[] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        }
        if ($password === '') {
            $errors[] = 'Password is required.';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters long.';
        }
        if ($password !== $passwordConfirm) {
            $errors[] = 'Passwords do not match.';
        }

        if ($errors === []) {
            $res = User::register([
                'full_name' => $fullName,
                'email'     => $email,
                'phone'     => $phone,
                'password'  => $password,
            ]);

            if ($res['success']) {
                session_regenerate_id(true);
                auth_login($res['user']);
                flash('success', "Account created successfully! Welcome to Laguna University Stall, {$fullName}! You can now order from the POS Dashboard.");
                redirect('pos');
                return;
            } else {
                $errors[] = $res['error'] ?? 'Registration failed. Please try again.';
            }
        }

        $data = [
            'title'  => 'Sign Up - Laguna University Stall',
            'errors' => $errors,
            'tab'    => 'register',
            'old'    => [
                'full_name' => $fullName,
                'email'     => $email,
                'phone'     => $phone,
            ]
        ];
        layout('site-layout', view('login', $data), $data);
    }

    public function logout() {
        auth_logout();
        flash('success', 'You have been logged out successfully.');
        redirect('login');
    }

    public function profile() {
        if (!auth_check()) {
            redirect('login');
            return;
        }

        $user = User::findById(auth_user()['id']);
        $profile = [
            'full_name' => $user['full_name'] ?? '',
            'phone' => $user['phone'] ?? '',
            'email' => $user['email'] ?? '',
            'role' => $user['role'] ?? 'customer',
            'stall_id' => $user['stall_id'] ?? null,
            'created_at' => $user['created_at'] ?? null,
        ];
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $profile = [
                'full_name' => trim($_POST['full_name'] ?? ''),
                'phone' => trim($_POST['phone'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'role' => $user['role'] ?? 'customer',
                'stall_id' => $user['stall_id'] ?? null,
                'created_at' => $user['created_at'] ?? null,
            ];
            $password = trim($_POST['password'] ?? '');
            $passwordConfirm = trim($_POST['password_confirm'] ?? '');

            if ($profile['full_name'] === '') {
                $errors[] = 'Full name is required.';
            }
            if ($profile['email'] === '') {
                $errors[] = 'Email is required.';
            } elseif (!filter_var($profile['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Please enter a valid email address.';
            }
            if ($profile['phone'] !== '' && strlen($profile['phone']) > 20) {
                $errors[] = 'Phone number must be 20 characters or fewer.';
            }
            if ($password !== '') {
                if ($password !== $passwordConfirm) {
                    $errors[] = 'Passwords do not match.';
                } elseif (strlen($password) < 6) {
                    $errors[] = 'Password must be at least 6 characters.';
                }
            }

            if (empty($errors)) {
                $updateData = $profile;
                if ($password !== '') {
                    $updateData['password'] = $password;
                }

                $result = User::updateProfile(auth_user()['id'], $updateData);
                if ($result['success']) {
                    $updatedUser = User::findById(auth_user()['id']);
                    auth_login($updatedUser);
                    flash('success', 'Profile updated successfully!');
                    redirect('profile');
                    return;
                }

                $errors[] = $result['error'] ?? 'Failed to update profile.';
            }

            $data = [
                'title'  => 'Edit Profile - Q-Stall',
                'user'   => $profile,
                'errors' => $errors,
            ];
            layout('main', view('profile', $data), $data);
            return;
        }

        $data = [
            'title' => 'Edit Profile - Q-Stall',
            'user'  => $profile,
        ];
        layout('main', view('profile', $data), $data);
    }
}
