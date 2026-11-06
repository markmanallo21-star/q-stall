<?php
require_once SRC_PATH . '/Stall.php';
require_once SRC_PATH . '/Product.php';

class HomeController {
    /**
     * The Brand New Landing Page (matching uploaded reference)
     */
    public function landing() {
        $data = [
            'title'             => 'Q-Stalls - Laguna University BS Entrepreneurship',
            'featured_stalls'   => Stall::allActive(),
            'popular_products'  => [
                Product::find(1), // Chicken Inasal with Rice
                Product::find(8), // Combo 3: Overload Chaofan
                Product::find(2), // Chicken Wings with Rice
                Product::find(12),// Fruitie Green Apple
            ],
            'cart_count'        => cart_count(),
            'cart_total'        => cart_total(),
        ];

        layout('site-layout', view('landing', $data), $data);
    }

    /**
     * Menu Route:
     * - If customer is logged in -> goes straight into the interactive POS Dashboard!
     * - If guest -> shows public products catalog with "Sign in to Order in POS" buttons!
     */
    public function menu() {
        if (auth_check()) {
            $this->pos();
            return;
        }

        $query = trim($_GET['q'] ?? '');
        $category = $_GET['category'] ?? null;

        if ($query !== '') {
            $products = Product::search($query, $category);
        } elseif ($category !== null && $category !== '' && strtolower($category) !== 'all') {
            $products = Product::allByCategory($category);
        } else {
            $products = Product::all();
        }

        // Group products strictly by stall
        $stallsList = [
            2 => [
                'id' => 2,
                'name' => 'Chick-Chi-Laok',
                'tagline' => 'Grilled Chicken & Silog Meals',
                'icon' => 'bi-fire',
                'color' => '#ea580c',
                'badge' => 'Grill & Silog',
                'products' => []
            ],
            3 => [
                'id' => 3,
                'name' => 'Chaohaus',
                'tagline' => 'Chaofan, Siomai & Lumpia Combos',
                'icon' => 'bi-box-seam-fill',
                'color' => '#dc2626',
                'badge' => 'Chaofan Combos',
                'products' => []
            ],
            1 => [
                'id' => 1,
                'name' => 'Carbonation',
                'tagline' => 'Fresh Fruit & Carbonated Drinks',
                'icon' => 'bi-cup-straw',
                'color' => '#0284c7',
                'badge' => 'Drinks & Shakes',
                'products' => []
            ],
        ];

        foreach ($products as $p) {
            $sId = (int) ($p['stall_id'] ?? 2);
            if (isset($stallsList[$sId])) {
                $stallsList[$sId]['products'][] = $p;
            }
        }

        $data = [
            'title'             => 'Campus Menu - Laguna University Stall',
            'products'          => $products,
            'stallsList'        => $stallsList,
            'active_category'   => $category ?? 'All',
            'search_query'      => $query,
            'cart_count'        => cart_count(),
        ];

        layout('site-layout', view('public-menu', $data), $data);
    }

    /**
     * The Full Interactive Food POS Ordering Dashboard
     * Restricted to authenticated users
     */
    public function pos() {
        if (!auth_check()) {
            flash('error', 'Please log in to open the POS Ordering Dashboard.');
            redirect('login');
            return;
        }

        $query = trim($_GET['q'] ?? '');
        $category = $_GET['category'] ?? null;

        if ($query !== '') {
            $products = Product::search($query, $category);
        } elseif ($category !== null && $category !== '' && strtolower($category) !== 'all') {
            $products = Product::allByCategory($category);
        } else {
            $products = Product::all();
        }

        // The user's 3 stalls as the primary category filter pills
        $categories = [
            'All',
            'Chick-Chi-Laok',
            'Chaohaus',
            'Carbonation',
            'Food',
            'Drinks'
        ];

        $data = [
            'title'             => 'POS Ordering Dashboard - Laguna University Stall',
            'date_string'       => date('F j, Y'),
            'restaurant_name'   => 'Laguna University Stall',
            'featured_stalls'   => Stall::featured(3),
            'all_stalls'        => Stall::allActive(),
            'categories'        => $categories,
            'products'          => $products,
            'trending_products' => Product::trending(8),
            'active_category'   => $category ?? 'All',
            'search_query'      => $query,
            'cart_items'        => cart(),
            'cart_total'        => cart_total(),
            'cart_count'        => cart_count(),
        ];

        layout('main', view('home', $data), $data);
    }

    public function index() {
        $this->landing();
    }

    public function products() {
        $this->menu();
    }

    public function about() {
        $data = [
            'title'      => 'About Us - Laguna University BS Entrepreneurship',
            'stalls'     => Stall::allActive(),
            'cart_count' => cart_count(),
        ];
        layout('site-layout', view('about', $data), $data);
    }

    public function contact() {
        $data = [
            'title'      => 'Contact Us - Laguna University Stall',
            'cart_count' => cart_count(),
        ];
        layout('site-layout', view('contact', $data), $data);
    }
}
