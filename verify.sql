SELECT COUNT(*) as stalls FROM stalls WHERE is_active=1;
SELECT COUNT(*) as products FROM products WHERE is_available=1;
SELECT category, COUNT(*) as count FROM products WHERE is_available=1 GROUP BY category;