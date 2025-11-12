<?php include __DIR__ . '/../layouts/header.php'; ?>
<h2 style="margin-left:100px">Edit Profile</h2>
<nav style="display: flex; justify-content: right; align-items: center; gap: 10px;">
    <a href="/PMS/user/aindex" class="btn btn-secondary">Back</a>
</nav>

<form method="POST" action="/PMS/user/updateProfile" id="editProfile">
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name'] ?? '') ?>"
            required>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email'] ?? '') ?>"
            reonly>
    </div>

    <div class="form-group">
        <label>Mobile</label>
        <input type="text" name="mobile" class="form-control" value="<?= htmlspecialchars($user['mobile'] ?? '') ?>"
            required>
    </div>

    <div class="form-group">
        <label>New Password </label>
        <input type="text" name="password" class="form-control" placeholder="Leave BLank to keep current">
    </div>

    <button type="submit" class="btn btn-primary">Save Changes</button>
</form>

<?php include __DIR__ . '/../layouts/footer.php'; ?>