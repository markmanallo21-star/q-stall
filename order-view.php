<section class="py-5">
    <div class="container text-center">
        <h2 class="text-success mb-4">Order Tracking</h2>
        <p class="text-muted">Enter your order code to track your order status.</p>
        <form action="<?= url('order-tracking') ?>" method="GET" class="row justify-content-center">
            <div class="col-md-6">
                <div class="input-group input-group-lg">
                    <input type="text" class="form-control" name="code" placeholder="Enter order code (e.g., LU-20260915-0001)" required>
                    <button class="btn btn-success" type="submit">Track Order</button>
                </div>
            </div>
        </form>
    </div>
</section>