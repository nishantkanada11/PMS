<?php include __DIR__ . '/../layouts/header.php'; ?>

<div
    style="max-width: 800px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); padding: 20px;">
    <div style="text-align: center;">
        <img src="public/uploads/<?php echo htmlspecialchars($product['img']); ?>"
            alt="<?php echo htmlspecialchars($product['name']); ?>"
            style="width:100%; height:250px; object-fit:contain; background-color:#f4f7fb; border-radius: 8px;">
    </div>

    <div class="card-body" style="padding: 20px;">
        <h2 style="font-size: 1.6em; margin-bottom: 12px; text-transform: capitalize; color: #333;">
            <?php echo htmlspecialchars($product['name']); ?>
        </h2>


        <img src="public/uploads/<?php echo htmlspecialchars($product['brand_logo']); ?>"
            alt="<?php echo htmlspecialchars($product['brand_name']); ?> Logo"
            style="width: 60px; height: 60px; object-fit: contain; border-radius: 8px; background: #f9f9f9; padding: 5px;">
        <p style="margin: 0; font-size: 1.1em;">
            <strong>Brand:</strong> <?php echo htmlspecialchars($product['brand_name']); ?>
        </p>
    </div>

    <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></p>
    <p><strong>Price:</strong> ₹<?php echo htmlspecialchars($product['price']); ?></p>

    <hr>

    <div class="overview-text">
        <strong>Overview:</strong>
        <?php
        $mdescription = htmlspecialchars($product['mdescription']);
        $shortText = substr($mdescription, 0, 100);
        ?>

        <p id="shortText"><?php echo nl2br($shortText); ?>...</p>
        <p id="fullText" class="card-text" style="display: none;"><?php echo nl2br($mdescription); ?></p>

        <button id="readMoreBtn" class="btn btn-primary" style="margin-top: 10px;">Read more</button>
        <a href="index.php?controller=User&action=showActiveProducts" class="btn btn-secondary"
            style="margin-top: 10px;">
            Back to Products
        </a>
    </div>
</div>
</div>

<script>
    document.getElementById("readMoreBtn").addEventListener("click", function () {
        const shortText = document.getElementById("shortText");
        const fullText = document.getElementById("fullText");
        const btn = document.getElementById("readMoreBtn");

        if (fullText.style.display === "none" || fullText.style.display === "") {
            shortText.style.display = "none";
            fullText.style.display = "block";
            btn.textContent = "Read less";
        } else {
            shortText.style.display = "block";
            fullText.style.display = "none";
            btn.textContent = "Read more";
        }
    });
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>