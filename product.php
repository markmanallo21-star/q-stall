<?php
class Product {
    private static function getFallbackProducts() {
        return [
            // ==========================================
            // STALL 2: CHICK-CHI-LAOK (Grilled & Meals)
            // ==========================================
            [
                'id' => 1,
                'stall_id' => 2,
                'stall_name' => 'Chick-Chi-Laok',
                'name' => 'Chicken Inasal with Rice',
                'description' => 'Bacolod-style grilled chicken marinated in annatto, lemongrass, and spices, served with steamed rice',
                'price' => 95.00,
                'category' => 'Food',
                'image' => 'chicken-inasal-rice.jpg',
                'rating' => '5.0',
                'is_available' => 1
            ],
            [
                'id' => 2,
                'stall_id' => 2,
                'stall_name' => 'Chick-Chi-Laok',
                'name' => 'Chicken Wings with Rice',
                'description' => 'Crispy fried chicken wings with savory glaze, served with steamed white rice',
                'price' => 85.00,
                'category' => 'Food',
                'image' => '121.jpg',
                'rating' => '4.9',
                'is_available' => 1
            ],
            [
                'id' => 3,
                'stall_id' => 2,
                'stall_name' => 'Chick-Chi-Laok',
                'name' => 'Chicken Neck (Add-on)',
                'description' => 'Grilled savory chicken neck, glazed with sweet barbecue sauce',
                'price' => 25.00,
                'category' => 'Food',
                'image' => 'chicken-neck.jpg',
                'rating' => '4.8',
                'is_available' => 1
            ],
            [
                'id' => 4,
                'stall_id' => 2,
                'stall_name' => 'Chick-Chi-Laok',
                'name' => 'Extra Steamed Rice',
                'description' => 'Fresh hot serving of steamed fragrant white rice',
                'price' => 15.00,
                'category' => 'Food',
                'image' => 'rice.jpg',
                'rating' => '5.0',
                'is_available' => 1
            ],

            // ==========================================
            // STALL 3: CHAOHAUS (Chaofan & Combos)
            // ==========================================
            [
                'id' => 5,
                'stall_id' => 3,
                'stall_name' => 'Chaohaus',
                'name' => 'Plain Chaofan',
                'description' => 'Simple. Classic. Satisfying wok-fried rice with egg and spring onions',
                'price' => 30.00,
                'category' => 'Food',
                'image' => 'plain-chaofan.jpg',
                'rating' => '5.0',
                'is_available' => 1
            ],
            [
                'id' => 6,
                'stall_id' => 3,
                'stall_name' => 'Chaohaus',
                'name' => 'Combo 1: Chaofan + 3 pcs Siomai',
                'description' => 'The perfect light combo. Savory chaofan with 3 steamed pork siomai & chili garlic',
                'price' => 40.00,
                'category' => 'Food',
                'image' => 'combo-1.jpg',
                'rating' => '5.0',
                'is_available' => 1
            ],
            [
                'id' => 7,
                'stall_id' => 3,
                'stall_name' => 'Chaohaus',
                'name' => 'Combo 2: Chaofan + 4 pcs Lumpia',
                'description' => 'Extra crispy, extra filling! Chaofan paired with 4 crispy shanghai spring rolls',
                'price' => 55.00,
                'category' => 'Food',
                'image' => 'combo-2.jpg',
                'rating' => '5.0',
                'is_available' => 1
            ],
            [
                'id' => 8,
                'stall_id' => 3,
                'stall_name' => 'Chaohaus',
                'name' => 'Combo 3: Overload Combo',
                'description' => 'The ultimate combo! Chaofan + 3 pcs Siomai + 4 pcs Lumpia for ultimate cravings',
                'price' => 65.00,
                'category' => 'Food',
                'image' => 'combo-3.jpg',
                'rating' => '5.0',
                'is_available' => 1
            ],

            // ==========================================
            // STALL 1: CARBONATION (Beverages & Shakes)
            // ==========================================
            [
                'id' => 12,
                'stall_id' => 1,
                'stall_name' => 'Carbonation',
                'name' => 'Fruitie Green Apple',
                'description' => 'Crisp refreshing green apple fruit drink, available plain or sparkling fizz',
                'price' => 39.00,
                'category' => 'Drinks',
                'image' => 'fruitie-green-apple.jpg',
                'rating' => '5.0',
                'is_available' => 1
            ],
            [
                'id' => 13,
                'stall_id' => 1,
                'stall_name' => 'Carbonation',
                'name' => 'Fruitie Strawberry',
                'description' => 'Sweet strawberry refreshment prepared with popping pearls and real fruit puree',
                'price' => 39.00,
                'category' => 'Drinks',
                'image' => 'fruitie-strawberry.jpg',
                'rating' => '4.9',
                'is_available' => 1
            ],
            [
                'id' => 14,
                'stall_id' => 1,
                'stall_name' => 'Carbonation',
                'name' => 'Fruitie Blueberry',
                'description' => 'Wild blueberry beverage with a revitalizing sweet-tart sparkle',
                'price' => 39.00,
                'category' => 'Drinks',
                'image' => 'fruitie-blueberry.jpg',
                'rating' => '5.0',
                'is_available' => 1
            ],
            [
                'id' => 15,
                'stall_id' => 1,
                'stall_name' => 'Carbonation',
                'name' => 'Fruitie Lychee',
                'description' => 'Exotic sweet lychee drink infused with fresh flavors and nata sinkers',
                'price' => 39.00,
                'category' => 'Drinks',
                'image' => 'fruitie-lychee.jpg',
                'rating' => '4.9',
                'is_available' => 1
            ],
            [
                'id' => 16,
                'stall_id' => 1,
                'stall_name' => 'Carbonation',
                'name' => 'Zen Green Milk',
                'description' => 'Smooth and creamy milk-based beverage with authentic green tea matcha notes',
                'price' => 55.00,
                'category' => 'Drinks',
                'image' => 'zen-green-milk.jpg',
                'rating' => '5.0',
                'is_available' => 1
            ],
            [
                'id' => 17,
                'stall_id' => 1,
                'stall_name' => 'Carbonation',
                'name' => 'Chocy Moomoo',
                'description' => 'Rich chocolate milk drink topped with chocolate drizzle',
                'price' => 55.00,
                'category' => 'Drinks',
                'image' => 'chocy-moomoo.jpg',
                'rating' => '5.0',
                'is_available' => 1
            ],
            [
                'id' => 18,
                'stall_id' => 1,
                'stall_name' => 'Carbonation',
                'name' => 'Ichigo Latte',
                'description' => 'Japanese-style strawberry milk latte crafted with fresh creamy milk',
                'price' => 55.00,
                'category' => 'Drinks',
                'image' => 'ichigo-latte.jpg',
                'rating' => '5.0',
                'is_available' => 1
            ],
            [
                'id' => 19,
                'stall_id' => 1,
                'stall_name' => 'Carbonation',
                'name' => 'Cookies & Cream',
                'description' => 'Velvety milk drink blended with crushed Oreo cookie bits',
                'price' => 55.00,
                'category' => 'Drinks',
                'image' => 'cookies-cream.jpg',
                'rating' => '5.0',
                'is_available' => 1
            ],
            [
                'id' => 20,
                'stall_id' => 1,
                'stall_name' => 'Carbonation',
                'name' => 'Popping Boba',
                'description' => 'Bursting fruit juice pearls add-on for that extra pop in every sip',
                'price' => 20.00,
                'category' => 'Food',
                'image' => 'popbob.jpg',
                'rating' => '4.8',
                'is_available' => 1
            ],
            [
                'id' => 21,
                'stall_id' => 1,
                'stall_name' => 'Carbonation',
                'name' => 'Nata de Coco',
                'description' => 'Sweet coconut gel chewies, great addition to any drink',
                'price' => 10.00,
                'category' => 'Food',
                'image' => 'nata.jpg',
                'rating' => '4.8',
                'is_available' => 1
            ],
            [
                'id' => 22,
                'stall_id' => 1,
                'stall_name' => 'Carbonation',
                'name' => 'Chuckie Snack',
                'description' => 'Classic chocolate fudge snack and refreshment',
                'price' => 20.00,
                'category' => 'Drinks',
                'image' => 'chuckie.jpg',
                'rating' => '4.9',
                'is_available' => 1
            ],
        ];
    }

    public static function find($id) {
        try {
            $pdo = db();
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? AND is_available = 1");
            $stmt->execute([$id]);
            $res = $stmt->fetch();
            if ($res) return $res;
        } catch (Throwable $e) {}

        foreach (self::getFallbackProducts() as $p) {
            if ($p['id'] == $id) return $p;
        }
        return null;
    }

    public static function findWithStall($id) {
        try {
            $pdo = db();
            $stmt = $pdo->prepare("SELECT p.*, s.name AS stall_name FROM products p JOIN stalls s ON p.stall_id = s.id WHERE p.id = ? AND p.is_available = 1 AND s.is_active = 1");
            $stmt->execute([$id]);
            $res = $stmt->fetch();
            if ($res) return $res;
        } catch (Throwable $e) {}

        foreach (self::getFallbackProducts() as $p) {
            if ($p['id'] == $id) return $p;
        }
        return null;
    }

    public static function byStall($stallId) {
        try {
            $pdo = db();
            $stmt = $pdo->prepare("SELECT * FROM products WHERE stall_id = ? AND is_available = 1 ORDER BY name ASC");
            $stmt->execute([$stallId]);
            $res = $stmt->fetchAll();
            if (!empty($res)) return $res;
        } catch (Throwable $e) {}

        return array_values(array_filter(self::getFallbackProducts(), fn($p) => $p['stall_id'] == $stallId));
    }

    public static function all() {
        try {
            $pdo = db();
            $stmt = $pdo->query("SELECT p.*, s.name AS stall_name FROM products p JOIN stalls s ON p.stall_id = s.id WHERE p.is_available = 1 AND s.is_active = 1 ORDER BY s.name ASC, p.id ASC");
            $res = $stmt->fetchAll();
            if (!empty($res)) return $res;
        } catch (Throwable $e) {}

        return self::getFallbackProducts();
    }

    public static function allByCategory($category) {
        try {
            $pdo = db();
            $stmt = $pdo->prepare("SELECT p.*, s.name AS stall_name FROM products p JOIN stalls s ON p.stall_id = s.id WHERE p.is_available = 1 AND s.is_active = 1 AND (p.category = ? OR s.name = ?) ORDER BY p.id ASC");
            $stmt->execute([$category, $category]);
            $res = $stmt->fetchAll();
            if (!empty($res)) return $res;
        } catch (Throwable $e) {}

        $cat = strtolower($category);
        return array_values(array_filter(self::getFallbackProducts(), function($p) use ($cat) {
            return strtolower($p['category']) === $cat 
                || strtolower($p['stall_name']) === $cat
                || (str_contains(strtolower($p['stall_name']), $cat));
        }));
    }

    public static function search($query, $category = null) {
        try {
            $pdo = db();
            $sql = "SELECT p.*, s.name AS stall_name
                    FROM products p
                    JOIN stalls s ON s.id = p.stall_id
                    WHERE p.is_available = 1
                      AND s.is_active = 1
                      AND (p.name LIKE :query OR p.description LIKE :query OR s.name LIKE :query)";

            if ($category !== null && $category !== '' && strtolower($category) !== 'all') {
                $sql .= " AND (p.category = :category OR s.name = :category)";
            }

            $sql .= " ORDER BY s.name ASC, p.name ASC";
            $stmt = $pdo->prepare($sql);
            $search = '%' . trim($query) . '%';
            $params = ['query' => $search];

            if ($category !== null && $category !== '' && strtolower($category) !== 'all') {
                $params['category'] = $category;
            }

            $stmt->execute($params);
            $res = $stmt->fetchAll();
            if (!empty($res)) return $res;
        } catch (Throwable $e) {}

        $q = strtolower(trim($query));
        $cat = $category && strtolower($category) !== 'all' ? strtolower(trim($category)) : null;

        return array_values(array_filter(self::getFallbackProducts(), function($p) use ($q, $cat) {
            $matchQuery = ($q === '') || (str_contains(strtolower($p['name']), $q) || str_contains(strtolower($p['description']), $q) || str_contains(strtolower($p['stall_name']), $q));
            $matchCat = (!$cat) || (strtolower($p['category']) === $cat) || str_contains(strtolower($p['stall_name']), $cat);
            return $matchQuery && $matchCat;
        }));
    }

    public static function trending($limit = 8) {
        try {
            $pdo = db();
            $stmt = $pdo->prepare("SELECT p.*, s.name AS stall_name FROM products p JOIN stalls s ON p.stall_id = s.id WHERE p.is_available = 1 AND s.is_active = 1 ORDER BY RAND() LIMIT ?");
            $stmt->bindValue(1, $limit, PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetchAll();
            if (!empty($res)) return $res;
        } catch (Throwable $e) {}

        $items = self::getFallbackProducts();
        shuffle($items);
        return array_slice($items, 0, $limit);
    }
}
