<?php include __DIR__ . '/../layouts/header.php'; ?>
<h1 style="margin-left:100px">Product Management System</h1>

<div class="top-bar"
    style="display: flex; justify-content: flex-end; align-items: center; gap: 10px; margin-right: 100px;">
    <a href="index.php?controller=User&action=login" class="login-btn">Login</a>
</div>

<div style="display: flex; justify-content: center; align-items: center; gap: 10px; margin-top: 20px;">
    <input type="text" id="search" placeholder="Search Product..."
        style="padding: 8px; width: 250px; border-radius: 4px; border: 1px solid #ccc;">

    <select id="brandFilter" style="padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
        <option value="">All Brands</option>
        <?php if (!empty($brands)): ?>
            <?php foreach ($brands as $brand): ?>
                <option value="<?php echo htmlspecialchars($brand); ?>">
                    <?php echo htmlspecialchars($brand); ?>
                </option>
            <?php endforeach; ?>
        <?php else: ?>
            <option disabled>No brands found</option>
        <?php endif; ?>
    </select>

</div>

<div class="container" style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px; justify-content: center;"
    id="usersTable">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="card" style="width: 18rem;">
                <img src="public/uploads/<?php echo htmlspecialchars($product['img']); ?>"
                    alt="<?php echo htmlspecialchars($product['name']); ?>"
                    style="width:100%; height:250px; object-fit:contain; background-color:#f4f7fb;">
                <div class="card-body">

                    <div style="display:flex; align-items:center; justify-content:space-between;">
                        <h5 class="card-title" style="margin:0;"><?php echo htmlspecialchars($product['name']); ?></h5>
                        <?php if (!empty($product['brand_logo'])): ?>
                            <img src="public/uploads/<?php echo htmlspecialchars($product['brand_logo']); ?>" alt="Brand Logo"
                                style="width:35px; height:35px; object-fit:contain; margin-left:8px;">
                        <?php endif; ?>
                    </div>

                    <p><strong>Brand:</strong> <?php echo htmlspecialchars($product['brand_name']); ?></p>
                    <p class="card-text"><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?>
                    </p>
                    <p><strong>₹<?php echo htmlspecialchars($product['price']); ?></strong></p>

                    <a href="index.php?controller=User&action=show&id=<?php echo $product['id']; ?>"
                        class="btn btn-primary">View</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products found</p>
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
            <a href="index.php?controller=User&action=showActiveProducts&page=<?php echo $page - 1; ?>"
                class="btn btn-secondary">Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPage; $i++): ?>
            <a href="index.php?controller=User&action=showActiveProducts&page=<?php echo $i; ?>"
                class="btn <?php echo $i == $page ? 'btn-primary' : 'btn-light'; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $totalPage): ?>
            <a href="index.php?controller=User&action=showActiveProducts&page=<?php echo $page + 1; ?>"
                class="btn btn-secondary">Next</a>
        <?php endif; ?>
    <?php endif; ?>
</div>





<?php include __DIR__ . '/../layouts/footer.php'; ?>

<script>
    const searchInput = document.getElementById("search");
    const brandFilter = document.getElementById("brandFilter");
    const container = document.getElementById("usersTable");

    function fetchProducts() {
        const query = searchInput.value.trim();
        const brand = brandFilter.value.trim();

        fetch(`index.php?controller=User&action=search&query=${encodeURIComponent(query)}&brand=${encodeURIComponent(brand)}`)
            .then(res => res.json())
            .then(products => {
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
                                style="width:100%; height:250px; object-fit:contain; background-color:#f4f7fb;">
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
                                <p><strong>₹${product.price}</strong></p>
                                <a href="index.php?controller=User&action=show&id=${product.id}" class="btn btn-primary">View</a>
                            </div>
                        </div>`;
                });
            })
            .catch(err => console.error("Fetch error:", err));
    }

    searchInput.addEventListener("keyup", fetchProducts);
    brandFilter.addEventListener("change", fetchProducts);
</script>