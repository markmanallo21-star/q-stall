-- Laguna University BS Entrepreneurship Stall Database Schema
-- Focus: 3 Stalls selling Foods and Drinks only

SET FOREIGN_KEY_CHECKS = 0;

-- Drop tables if they exist
DROP TABLE IF EXISTS `order_items`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `stalls`;
DROP TABLE IF EXISTS `users`;

SET FOREIGN_KEY_CHECKS = 1;

-- ========================================
-- USERS TABLE
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

INSERT INTO `users` (`email`, `password`, `full_name`, `role`) VALUES
('admin@qstall.com', '$2y$10$e3J.r1ib18Iwkhlrq9xIO.b/s9pw.8uP4tBtopOwVcN3QaLGmxVE.', 'Q-Stall Admin', 'admin'),
('customer@qstall.com', '$2y$10$9CW/k53ZYWnWG89h.sDxku4TJu17JVB5ouEqwAYMUjjQLaHSB3aOe', 'Q-Stall Customer', 'customer');

CREATE INDEX `idx_users_email` ON `users`(`email`);

-- ========================================
-- STALLS TABLE
-- ========================================
CREATE TABLE `stalls` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `tagline` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `owner_name` VARCHAR(100),
    `logo_image` VARCHAR(255),
    `is_active` TINYINT(1) DEFAULT 1,
    `is_featured` TINYINT(1) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- PRODUCTS TABLE
-- ========================================
CREATE TABLE `products` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `stall_id` INT NOT NULL,
    `name` VARCHAR(150) NOT NULL,
    `description` TEXT,
    `price` DECIMAL(10,2) NOT NULL,
    `category` ENUM('food', 'drinks', 'carbonation') NOT NULL,
    `image` VARCHAR(255),
    `is_available` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`stall_id`) REFERENCES `stalls`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- ORDERS TABLE
-- ========================================
CREATE TABLE `orders` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_code` VARCHAR(50) NOT NULL UNIQUE,
    `customer_name` VARCHAR(100) NOT NULL,
    `customer_email` VARCHAR(150) NOT NULL,
    `customer_contact` VARCHAR(20) NOT NULL,
    `pickup_date` DATE NOT NULL,
    `pickup_time` TIME NOT NULL,
    `payment_method` ENUM('cash', 'gcash') NOT NULL,
    `payment_proof` VARCHAR(255),
    `total_amount` DECIMAL(10,2) NOT NULL,
    `status` ENUM('pending', 'confirmed', 'ready', 'completed', 'cancelled') DEFAULT 'pending',
    `notes` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- ORDER ITEMS TABLE
-- ========================================
CREATE TABLE `order_items` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT NOT NULL,
    `stall_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    `product_name` VARCHAR(150) NOT NULL,
    `price` DECIMAL(10,2) NOT NULL,
    `quantity` INT NOT NULL,
    `subtotal` DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`stall_id`) REFERENCES `stalls`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`product_id`) REFERENCES `products`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- INDEXES FOR PERFORMANCE
-- ========================================
CREATE INDEX `idx_stalls_active` ON `stalls`(`is_active`);
CREATE INDEX `idx_stalls_featured` ON `stalls`(`is_featured`);
CREATE INDEX `idx_products_stall` ON `products`(`stall_id`);
CREATE INDEX `idx_products_category` ON `products`(`category`);
CREATE INDEX `idx_products_available` ON `products`(`is_available`);
CREATE INDEX `idx_orders_code` ON `orders`(`order_code`);
CREATE INDEX `idx_order_items_order` ON `order_items`(`order_id`);

-- ========================================
-- SEED DATA: 3 STALLS (Foods & Drinks Focus)
-- ========================================

-- Stall 1: Carbonation
INSERT INTO `stalls` (`name`, `tagline`, `description`, `owner_name`, `logo_image`, `is_active`, `is_featured`) VALUES
('Carbonation', 'Fresh Fruit & Carbonated Drinks', 'Serving a wide variety of fruit drinks, milk-based beverages, and carbonated refreshments made from locally sourced ingredients. All drinks are prepared fresh to order with no artificial sweeteners.', 'Maria Santos', 'buko-juice-haven.jpg', 1, 1);

-- Stall 2: Chick-Chi-Laok
INSERT INTO `stalls` (`name`, `tagline`, `description`, `owner_name`, `logo_image`, `is_active`, `is_featured`) VALUES
('Chick-Chi-Laok', 'Grilled Chicken & Silog Meals', 'Student-run grill serving classic Filipino breakfast silog meals, grilled chicken inasal, and budget-friendly rice meals. Made with love by BS Entrepreneurship students.', 'Juan Dela Cruz', 'chick-chi-laok.jpg', 1, 1);

-- Stall 3: Chaohaus
INSERT INTO `stalls` (`name`, `tagline`, `description`, `owner_name`, `logo_image`, `is_active`, `is_featured`) VALUES
('Chaohaus', 'Chaofan, Siomai & Lumpia Combos', 'Serving delicious chaofan rice bowls with crispy siomai and lumpia combos. Simple, satisfying meals perfect for any time of day. All made fresh to order by student entrepreneurs.', 'Ana Reyes', 'sweet-treats.jpg', 1, 1);

-- ========================================
-- SEED DATA: PRODUCTS (Emphasizing Foods & Drinks)
-- ========================================

-- ========================================
-- STALL 1: Buko & Juice Haven (Drinks Focus)
-- ========================================
INSERT INTO `products` (`stall_id`, `name`, `description`, `price`, `category`, `image`, `is_available`) VALUES
(1, 'Fruitie Green Apple', 'Refreshing green apple drink, available in plain or soda', 39.00, 'carbonation', 'fruitie-green-apple.jpg', 1),
(1, 'Fruitie Strawberry', 'Sweet strawberry drink, available in plain or soda', 39.00, 'carbonation', 'fruitie-strawberry.jpg', 1),
(1, 'Fruitie Blueberry', 'Wild blueberry drink, available in plain or soda', 39.00, 'carbonation', 'fruitie-blueberry.jpg', 1),
(1, 'Fruitie Lychee', 'Exotic lychee drink, available in plain or soda', 39.00, 'carbonation', 'fruitie-lychee.jpg', 1),
(1, 'Zen Green Milk', 'Creamy milk-based drink with green tea flavor', 55.00, 'drinks', 'zen-green-milk.jpg', 1),
(1, 'Chocy Moomoo', 'Rich chocolate milk-based drink', 55.00, 'drinks', 'chocy-moomoo.jpg', 1),
(1, 'Ichigo Latte', 'Strawberry milk-based latte', 55.00, 'drinks', 'ichigo-latte.jpg', 1),
(1, 'Cookies & Cream', 'Creamy milk drink with cookies and cream flavor', 55.00, 'drinks', 'cookies-cream.jpg', 1),
(1, 'Nata', 'Sweet fermented tea gel candy', 10.00, 'food', 'nata.jpg', 1),
(1, 'Yakult', 'Probiotic drink for digestive health', 15.00, 'drinks', 'yakult.jpg', 1),
(1, 'Chuckie', 'Chewy candy snack', 20.00, 'food', 'chuckie.jpg', 1),
(1, 'Popping Boba', 'Chewy tapioca pearls with bursting flavor', 20.00, 'food', 'popping-boba.jpg', 1);

-- ========================================
-- STALL 2: Chick-Chi-Laok (Food Focus)
-- ========================================
INSERT INTO `products` (`stall_id`, `name`, `description`, `price`, `category`, `image`, `is_available`) VALUES
(2, 'Chicken Inasal with Rice', 'Bacolod-style grilled chicken marinated in annatto, lemongrass, and spices, served with steamed rice', 95.00, 'food', 'chicken-inasal-rice.jpg', 1),
(2, 'Chicken Wings with Rice', 'Crispy fried chicken wings with savory glaze, served with steamed rice', 85.00, 'food', '121.jpg', 1),
(2, 'Chicken Neck (Add-on)', 'Grilled chicken neck, perfect as add-on to any meal', 25.00, 'food', 'chicken-neck.jpg', 1),
(2, 'Rice (Add-on)', 'Extra serving of steamed white rice', 15.00, 'food', 'rice.jpg', 1);

-- ========================================
-- STALL 3: Chaohaus (Food & Drinks)
-- ========================================
INSERT INTO `products` (`stall_id`, `name`, `description`, `price`, `category`, `image`, `is_available`) VALUES
(3, 'Plain Chaofan', 'Simple. Classic. Satisfying wok-fried rice with egg and scallions', 30.00, 'food', 'plain-chaofan.jpg', 1),
(3, 'Combo 1: Chaofan + 3 pcs Siomai', 'The perfect light combo. Savory chaofan with 3 steamed pork siomai & chili garlic', 40.00, 'food', 'combo-1.jpg', 1),
(3, 'Combo 2: Chaofan + 4 pcs Lumpia', 'Extra crispy. Extra filling. Chaofan paired with 4 crispy shanghai spring rolls', 55.00, 'food', 'combo-2.jpg', 1),
(3, 'Combo 3: Overload (Chaofan + 3 pcs Siomai + 4 pcs Lumpia)', 'The ultimate combo for ultimate cravings!', 65.00, 'food', 'combo-3.jpg', 1);

-- ========================================
-- VERIFICATION QUERIES
-- ========================================
-- Check stalls count
-- SELECT COUNT(*) as total_stalls FROM stalls WHERE is_active = 1;
-- Expected: 3

-- Check products count per stall
-- SELECT s.name as stall, COUNT(p.id) as product_count, p.category
-- FROM stalls s LEFT JOIN products p ON s.id = p.stall_id AND p.is_available = 1
-- WHERE s.is_active = 1
-- GROUP BY s.id, p.category;

-- Check all products by category
-- SELECT category, COUNT(*) as count FROM products WHERE is_available = 1 GROUP BY category;
-- Expected: food and drinks only