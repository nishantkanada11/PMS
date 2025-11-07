<?php include __DIR__ . '/../layouts/header.php'; ?>


<h1 style="margin-left:100px">Admin Dashboard</h1>
<nav style="display: flex; justify-content: right; align-items: center; gap: 10px;">
    <a href="index.php?controller=User&action=logout" class="login-btn">Log Out</a>
    <a href="index.php?controller=User&action=aedit" class="login-btn">Edit Profile</a>
    <a href="index.php?controller=User&action=pcreate" class="login-btn">Create New Product</a>
</nav>

<input type="text" id="search" placeholder="Search products...">
<div class="container" style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px;" id="usersTable">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="card" style="width: 18rem;">
                <img src="public/uploads/<?php echo htmlspecialchars($product['img']); ?>"
                    alt="<?php echo htmlspecialchars($product['name']); ?>"
                    style="width:100%; height:250px; object-fit:cover; background-color:#f4f7fb;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $product['name']; ?></h5>
                    <p class="card-text"><strong>Description:</strong> <?php echo $product['description']; ?></p>
                    <p class="card-text"><strong>Overview:</strong> <?php echo $product['mdescription']; ?></p>
                    <p><strong>₹<?php echo $product['price']; ?></strong></p>
                    <select name="status" id="status_<?php echo $product['id']; ?>"
                        onchange="updateStatus(<?php echo $product['id']; ?>, this.value)">
                        <option value="active" <?php echo $product['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo $product['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive
                        </option>
                    </select>

                    <a href="index.php?controller=User&action=pedit&id=<?php echo $product['id']; ?>"
                        class="btn btn-primary">Edit</a>

                    <a href="index.php?controller=User&action=delete&id=<?= $product['id']; ?>"
                        onclick="return confirm('Are you sure?')" class="btn btn-primary">Delete</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
</div>
<script>
    function updateStatus(id, status) {
        fetch(`index.php?controller=User&action=updateStatus`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}&status=${status}`
        })
            .then(response => response.text())
            .then(data => alert(data))
    }
</script>
<?php include __DIR__ . '/../layouts/footer.php'; ?>

<script>
    document.getElementById("search").addEventListener("keyup", function () {
        const query = this.value.trim();

        fetch(`index.php?controller=User&action=search&query=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(products => {
                const container = document.getElementById("usersTable");
                container.innerHTML = ""; // Clear existing cards

                if (products.length === 0) {
                    container.innerHTML = "<p>No products found</p>";
                    return;
                }

                products.forEach(product => {
                    container.innerHTML += `
                    <div class="card" style="width: 18rem;">
                        <img src="public/uploads/${product.img}"
                            alt="${product.name}"
                            style="width:100%; height:250px; object-fit:contain; background-color:#f4f7fb;">
                        <div class="card-body">
                            <h5 class="card-title">${product.name}</h5>
                            <p class="card-text"><strong>Description:</strong> ${product.description}</p>
                            <p><strong>₹${product.price}</strong></p>
                            <a href="index.php?controller=User&action=show&id=${product.id}" 
                               class="btn btn-primary">View</a>
                        </div>
                    </div>`;
                });
            })
            .catch(err => console.error("Search error:", err));
    });
</script>