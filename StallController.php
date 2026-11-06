<?php
require_once SRC_PATH . '/Stall.php';
require_once SRC_PATH . '/Product.php';

class StallController {
    public function index() {
        $data = [
            'title'  => 'All Stalls - BS Entrepreneurship Stall',
            'stalls' => Stall::allActive(),
        ];

        layout('site-layout', view('stalls', $data), $data);
    }

    public function show($id) {
        $stall = Stall::find($id);

        if (!$stall) {
            flash('error', 'Stall not found.');
            redirect('stalls');
            return;
        }

        $data = [
            'title'    => $stall['name'] . ' - Q-Stall',
            'stall'    => $stall,
            'products' => Product::byStall($stall['id']),
        ];

        layout('site-layout', view('stall-detail', $data), $data);
    }
}