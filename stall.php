<?php
class Stall {
    private static function getFallbackStalls() {
        return [
            [
                'id' => 2,
                'name' => 'Grill Restaurant',
                'tagline' => 'Chick-Chi-Laok & Sizzling Meals',
                'description' => 'Serving delicious grilled chicken inasal, barbecue, sizzling specialties and hot fresh meals.',
                'owner_name' => 'Juan Dela Cruz',
                'logo_image' => 'chick-chi-laok.jpg',
                'is_active' => 1,
                'is_featured' => 1
            ],
            [
                'id' => 3,
                'name' => 'Chaohaus',
                'tagline' => 'Chaofan, Siomai & Lumpia Combos',
                'description' => 'Serving delicious chaofan rice bowls with crispy siomai and lumpia combos.',
                'owner_name' => 'Ana Reyes',
                'logo_image' => 'sweet-treats.jpg',
                'is_active' => 1,
                'is_featured' => 1
            ],
            [
                'id' => 1,
                'name' => 'Carbonation',
                'tagline' => 'Fresh Fruit & Carbonated Drinks',
                'description' => 'Wide variety of refreshing fruit drinks, shakes, and milk beverages.',
                'owner_name' => 'Maria Santos',
                'logo_image' => 'buko-juice-haven.jpg',
                'is_active' => 1,
                'is_featured' => 1
            ],
        ];
    }

    public static function allActive() {
        try {
            $stmt = db()->query("SELECT * FROM stalls WHERE is_active = 1 ORDER BY name ASC");
            $res = $stmt->fetchAll();
            if (!empty($res)) return $res;
        } catch (Throwable $e) {}

        return self::getFallbackStalls();
    }

    public static function featured($limit = 3) {
        try {
            $stmt = db()->prepare("SELECT * FROM stalls WHERE is_active = 1 AND is_featured = 1 ORDER BY name ASC LIMIT :limit");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetchAll();
            if (!empty($res)) return $res;
        } catch (Throwable $e) {}

        return array_slice(self::getFallbackStalls(), 0, $limit);
    }

    public static function find($id) {
        try {
            $stmt = db()->prepare("SELECT * FROM stalls WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $res = $stmt->fetch();
            if ($res) return $res;
        } catch (Throwable $e) {}

        foreach (self::getFallbackStalls() as $s) {
            if ($s['id'] == $id) return $s;
        }
        return null;
    }
}
