<?php include __DIR__ . '/../layouts/header.php'; ?>

<h1 style="margin-left:100px">Admin Dashboard</h1>

<nav style="display: flex; justify-content: right; align-items: center; gap: 10px;">
    <a href="index.php?controller=User&action=logout" class="login-btn">Log Out</a>
    <a href="index.php?controller=User&action=aedit" class="login-btn">Edit Profile</a>
    <a href="index.php?controller=User&action=pcreate" class="login-btn">Create New Product</a>
</nav>

<div style="display: flex; align-items: center; gap: 15px; margin: 20px 100px;">
    <input type="text" id="search" placeholder="Search products..."
        style="padding: 8px; width: 300px; border: 1px solid #ccc; border-radius: 4px;">

    <select id="brandFilter" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        <option value="">All Brands</option>
        <?php
        $brands = [];
        foreach ($products as $p) {
            if (!empty($p['brand_name']) && !in_array($p['brand_name'], $brands)) {
                $brands[] = $p['brand_name'];
            }
        }

        foreach ($brands as $brand): ?>
            <option value="<?php echo htmlspecialchars($brand); ?>">
                <?php echo htmlspecialchars($brand); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="container" style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px;" id="usersTable">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="card" style="width: 18rem;">
                <img src="public/uploads/<?php echo htmlspecialchars($product['img']); ?>"
                    alt="<?php echo htmlspecialchars($product['name']); ?>"
                    style="width:100%; height:250px; object-fit:cover; background-color:#f4f7fb;">
                <div class="card-body">

                    <div style="display:flex; align-items:center; justify-content:space-between;">
                        <h5 class="card-title" style="margin:0;">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </h5>
                        <?php if (!empty($product['brand_logo'])): ?>
                            <img src="public/uploads/<?php echo htmlspecialchars($product['brand_logo']); ?>" alt="Brand Logo"
                                style="width:35px; height:35px; object-fit:contain; margin-left:8px;">
                        <?php endif; ?>
                    </div>

                    <p><strong>Brand:</strong> <?php echo htmlspecialchars($product['brand_name']); ?></p>
                    <p class="card-text"><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?>
                    </p>
                    <p class="card-text"><strong>Overview:</strong> <?php echo htmlspecialchars($product['mdescription']); ?>
                    </p>
                    <p><strong>₹<?php echo htmlspecialchars($product['price']); ?></strong></p>

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
<?php
$page = isset($page) ? (int) $page : 1;
$totalPage = isset($totalPage) ? (int) $totalPage : 1;
$limit = isset($limit) ? (int) $limit : 6;
?>
<div style="text-align:center; margin:20px;">
    <?php if ($totalPage > 1): ?>
        <?php if ($page > 1): ?>
            <a href="index.php?controller=User&action=aindex&page=<?php echo $page - 1; ?>"
                class="btn btn-secondary">Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPage; $i++): ?>
            <a href="index.php?controller=User&action=aindex&page=<?php echo $i; ?>"
                class="btn <?php echo $i == $page ? 'btn-primary' : 'btn-light'; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $totalPage): ?>
            <a href="index.php?controller=User&action=aindex&page=<?php echo $page + 1; ?>" class="btn btn-secondary">Next</a>
        <?php endif; ?>
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
            .catch(err => console.error("Status update error:", err));
    }
</script>

<script>
    const searchInput = document.getElementById("search");
    const brandFilter = document.getElementById("brandFilter");

    function fetchProducts() {
        const query = searchInput.value.trim();
        const brand = brandFilter.value;

        fetch(`index.php?controller=User&action=search&query=${encodeURIComponent(query)}&brand=${encodeURIComponent(brand)}`)
            .then(res => res.json())
            .then(products => {
                const container = document.getElementById("usersTable");
                container.innerHTML = "";

                if (products.length === 0) {
                    container.innerHTML = "<p>No products found</p>";
                    return;
                }

                products.forEach(product => {
                    container.innerHTML += `
                        <div class="card" style="width: 18rem;">
                            <img src="public/uploads/${product.img}"
                                alt="${product.name}"
                                style="width:100%; height:250px; object-fit:cover; background-color:#f4f7fb;">
                            <div class="card-body">

                                <div style="display:flex; align-items:center; justify-content:space-between;">
                                    <h5 class="card-title" style="margin:0;">${product.name}</h5>
                                    ${product.brand_logo ?
                            `<img src="public/uploads/${product.brand_logo}" 
                                              alt="Brand Logo" 
                                              style="width:35px; height:35px; object-fit:contain; margin-left:8px;">`
                            : ''
                        }
                                </div>

                                <p><strong>Brand:</strong> ${product.brand_name}</p>
                                <p class="card-text"><strong>Description:</strong> ${product.description}</p>
                                <p class="card-text"><strong>Overview:</strong> ${product.mdescription}</p>
                                <p><strong>₹${product.price}</strong></p>

                                <select name="status" id="status_${product.id}"
                                    onchange="updateStatus(${product.id}, this.value)">
                                    <option value="active" ${product.status === 'active' ? 'selected' : ''}>Active</option>
                                    <option value="inactive" ${product.status === 'inactive' ? 'selected' : ''}>Inactive</option>
                                </select>

                                <div style="margin-top:8px;">
                                    <a href="index.php?controller=User&action=pedit&id=${product.id}" 
                                       class="btn btn-primary">Edit</a>
                                    <a href="index.php?controller=User&action=delete&id=${product.id}" 
                                       onclick="return confirm('Are you sure?')" 
                                       class="btn btn-primary">Delete</a>
                                </div>
                            </div>
                        </div>`;
                });
            })
            .catch(err => console.error("Search error:", err));
    }

    searchInput.addEventListener("keyup", fetchProducts);
    brandFilter.addEventListener("change", fetchProducts);
</script>


<?php include __DIR__ . '/../layouts/footer.php'; ?>