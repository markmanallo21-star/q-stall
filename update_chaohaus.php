<?php
require_once __DIR__ . '/config.php';

$pdo = db();

try {
    $pdo->beginTransaction();
    
    // Update stall 3 to Chaohaus
    $stmt = $pdo->prepare("UPDATE stalls SET name = 'Chaohaus', tagline = 'Chaofan, Siomai & Lumpia Combos', description = 'Serving delicious chaofan rice bowls with crispy siomai and lumpia combos. Simple, satisfying meals perfect for any time of day. All made fresh to order by student entrepreneurs.' WHERE id = 3");
    $stmt->execute();
    echo "Updated stall 3 to Chaohaus\n";
    
    // Delete existing products for stall 3
    $stmt = $pdo->prepare("DELETE FROM products WHERE stall_id = 3");
    $stmt->execute();
    
    // Insert new products (authentic Chaohaus meals only)
    $products = [
        ['Plain Chaofan', 'Simple. Classic. Satisfying wok-fried rice with egg and scallions', 30.00, 'food', 'plain-chaofan.jpg'],
        ['Combo 1: Chaofan + 3 pcs Siomai', 'The perfect light combo. Savory chaofan with 3 steamed pork siomai & chili garlic', 40.00, 'food', 'combo-1.jpg'],
        ['Combo 2: Chaofan + 4 pcs Lumpia', 'Extra crispy. Extra filling. Chaofan paired with 4 crispy shanghai spring rolls', 55.00, 'food', 'combo-2.jpg'],
        ['Combo 3: Overload (Chaofan + 3 pcs Siomai + 4 pcs Lumpia)', 'The ultimate combo for ultimate cravings!', 65.00, 'food', 'combo-3.jpg'],
    ];
    
    $insertStmt = $pdo->prepare("INSERT INTO products (stall_id, name, description, price, category, image, is_available) VALUES (3, ?, ?, ?, ?, ?, 1)");
    foreach ($products as $p) {
        $insertStmt->execute($p);
    }
    
    $pdo->commit();
    echo "Updated: " . count($products) . " products inserted for stall 3\n";
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Error: " . $e->getMessage() . "\n";
}