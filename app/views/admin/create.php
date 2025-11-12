<?php include __DIR__ . '/../layouts/header.php'; ?>

<h2 style="margin-left:100px">Add Product</h2>

<nav style="display: flex; justify-content: right; align-items: center; gap: 10px;">
    <a href="/PMS/user/logout" class="login-btn">Log Out</a>
    <a href="/PMS/user/aindex" class="btn btn-secondary">Back</a>
</nav>

<form method="POST" action="/PMS/user/saveProduct" enctype="multipart/form-data" id="create"
    style="max-width: 600px; margin: 40px auto;">

    <div class="form-group">
        <label>Product Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Description</label>
        <input type="text" name="description" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Overview</label>
        <textarea rows="4" cols="50" name="mdescription" class="form-control" required></textarea>
    </div>

    <div class="form-group">
        <label>Price</label>
        <input type="number" name="price" class="form-control" required min="0" step="0.01">
    </div>

    <div class="form-group">
        <label>Brand Name</label>
        <input type="text" name="brand_name" class="form-control" placeholder="e.g., Adidas, Nike, Puma" required>
    </div>

    <div class="form-group">
        <label>Brand Logo</label>
        <input type="file" name="brand_logo" class="form-control" accept="image/*">
    </div>

    <div class="form-group">
        <label>Product Image</label>
        <input type="file" name="profile_picture" class="form-control" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary">Add Product</button>

</form>

<?php include __DIR__ . '/../layouts/footer.php'; ?>