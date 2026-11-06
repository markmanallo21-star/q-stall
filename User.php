<?php
class User {
    public static function findByEmail($email) {
        try {
            $stmt = db()->prepare("SELECT * FROM users WHERE email = ? AND is_active = 1 LIMIT 1");
            $stmt->execute([$email]);
            return $stmt->fetch();
        } catch (Throwable $e) {
            // fallback demo accounts when DB unavailable
            return self::fallbackByEmail($email);
        }
    }

    public static function findById($id) {
        try {
            $stmt = db()->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (Throwable $e) {
            return null;
        }
    }

    public static function register(array $data): array {
        try {
            $pdo = db();
            // check duplicate
            $chk = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $chk->execute([$data['email']]);
            if ($chk->fetch()) {
                return ['success' => false, 'error' => 'Email already registered.'];
            }
            $stmt = $pdo->prepare(
                "INSERT INTO users (email, password, full_name, phone, role, stall_id) VALUES (?,?,?,?,'customer',NULL)"
            );
            $stmt->execute([
                $data['email'],
                password_hash($data['password'], PASSWORD_DEFAULT),
                $data['full_name'],
                $data['phone'] ?? null,
            ]);
            $id = (int)$pdo->lastInsertId();
            $user = self::findById($id);
            return ['success' => true, 'user' => $user];
        } catch (Throwable $e) {
            return ['success' => false, 'error' => 'Registration failed: ' . $e->getMessage()];
        }
    }

    public static function updateProfile($id, $data): array {
        $fields = [];
        $params = [];

        if (array_key_exists('full_name', $data)) {
            $fullName = trim($data['full_name']);
            if ($fullName === '') return ['success' => false, 'error' => 'Full name is required.'];
            $fields[] = 'full_name = ?';
            $params[] = $fullName;
        }
        if (array_key_exists('phone', $data)) {
            $fields[] = 'phone = ?';
            $params[] = trim($data['phone']);
        }
        if (array_key_exists('email', $data)) {
            $email = trim($data['email']);
            if ($email === '') return ['success' => false, 'error' => 'Email is required.'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return ['success' => false, 'error' => 'Invalid email.'];
            try {
                $stmt = db()->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
                $stmt->execute([$email, $id]);
                if ($stmt->fetch()) return ['success' => false, 'error' => 'Email already in use.'];
            } catch (Throwable $e) {}
            $fields[] = 'email = ?';
            $params[] = $email;
        }
        if (!empty($data['password'])) {
            $fields[] = 'password = ?';
            $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        if (empty($fields)) return ['success' => true, 'changed' => false];

        try {
            $params[] = $id;
            $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
            $stmt = db()->prepare($sql);
            $result = $stmt->execute($params);
            return $result ? ['success' => true, 'changed' => true] : ['success' => false, 'error' => 'Update failed.'];
        } catch (Throwable $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    // -------------------------------------------------------
    // FALLBACK demo accounts when MySQL is unreachable
    // -------------------------------------------------------
    private static function fallbackByEmail($email) {
        $accounts = [
            'admin@qstall.com'       => ['id'=>1,'email'=>'admin@qstall.com','password'=>password_hash('admin123',PASSWORD_DEFAULT),'full_name'=>'Q-Stall Admin','role'=>'admin','stall_id'=>null,'is_active'=>1,'phone'=>null],
            'customer@qstall.com'    => ['id'=>2,'email'=>'customer@qstall.com','password'=>password_hash('customer123',PASSWORD_DEFAULT),'full_name'=>'Q-Stall Customer','role'=>'customer','stall_id'=>null,'is_active'=>1,'phone'=>null],
            'carbonation@qstall.com' => ['id'=>3,'email'=>'carbonation@qstall.com','password'=>password_hash('carbonation123',PASSWORD_DEFAULT),'full_name'=>'Carbonation Admin','role'=>'stall_admin','stall_id'=>1,'is_active'=>1,'phone'=>null],
            'chickchilaok@qstall.com'=> ['id'=>4,'email'=>'chickchilaok@qstall.com','password'=>password_hash('chickchilaok123',PASSWORD_DEFAULT),'full_name'=>'Chick-Chi-Laok Admin','role'=>'stall_admin','stall_id'=>2,'is_active'=>1,'phone'=>null],
            'chaohaus@qstall.com'    => ['id'=>5,'email'=>'chaohaus@qstall.com','password'=>password_hash('chaohaus123',PASSWORD_DEFAULT),'full_name'=>'Chaohaus Admin','role'=>'stall_admin','stall_id'=>3,'is_active'=>1,'phone'=>null],
            'student@laguna.edu.ph'  => ['id'=>6,'email'=>'student@laguna.edu.ph','password'=>password_hash('student123',PASSWORD_DEFAULT),'full_name'=>'Sample Student','role'=>'customer','stall_id'=>null,'is_active'=>1,'phone'=>null],
        ];
        return $accounts[$email] ?? null;
    }
}
