-- ========================================
-- USERS TABLE (for authentication)
-- ========================================
CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `full_name` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20),
    `role` ENUM('customer', 'admin') DEFAULT 'customer',
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Default demo accounts
INSERT INTO `users` (`email`, `password`, `full_name`, `role`) VALUES
('admin@qstall.com', '$2y$10$e3J.r1ib18Iwkhlrq9xIO.b/s9pw.8uP4tBtopOwVcN3QaLGmxVE.', 'Q-Stall Admin', 'admin'),
('customer@qstall.com', '$2y$10$9CW/k53ZYWnWG89h.sDxku4TJu17JVB5ouEqwAYMUjjQLaHSB3aOe', 'Q-Stall Customer', 'customer');

-- Index
CREATE INDEX `idx_users_email` ON `users`(`email`);