<?php include __DIR__ . '/../layouts/header.php'; ?>
<h2 style="margin-left:100px">Edit Product</h2>
<nav style="display: flex; justify-content: right; align-items: center; gap: 10px;">
    <a href="index.php?controller=User&action=logout" class="login-btn">Log Out</a>
    <a href="index.php?controller=User&action=aindex" class="btn btn-secondary">Back</a>
</nav>

<form method="POST" action="index.php?controller=User&action=saveProduct" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
    <div class="form-group">
        <label>Product Name</label>
        <input type="text" name="name" class="form-control" value="<?php echo $product['name']; ?>"
            required>
    </div>

    <div class="form-group">
        <label>Description</label>
        <input type="text" name="description" class="form-control"
            value="<?php echo $product['description']; ?>" required>
    </div>


    <div class="form-group">
        <label>Overview</label>
        <textarea rows="4" cols="50" name="mdescription"
            class="form-control"><?php echo $product['mdescription']; ?></textarea>
    </div>


    <div class="form-group">
        <label>Price</label>
        <input type="number" name="price" class="form-control"
            value="<?php echo $product['price']; ?>" required>
    </div>

    <div class="form-group">
        <label>Current Image:</label><br>
        <?php if (!empty($product['img'])): ?>
            <img src="public/uploads/<?php echo $product['img']; ?>" alt="Product Image" width="120"
                style="margin-bottom:10px;">
        <?php else: ?>
            <p>No image uploaded.</p>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <label>Change Image (optional):</label>
        <input type="file" name="profile_picture" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Update Product</button>
</form>

<?php include __DIR__ . '/../layouts/footer.php'; ?>