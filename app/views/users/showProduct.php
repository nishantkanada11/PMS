<?php include __DIR__ . '/../layouts/header.php'; ?>


<img src="public/uploads/<?php echo htmlspecialchars($product['img']); ?>"
    alt="<?php echo htmlspecialchars($product['name']); ?>"
    style="width:100%; height:250px; object-fit:contain; background-color:#f4f7fb; margin-top: 20px;">


<div class="card-body" style="padding: 20px;">
    <h2 style="font-size: 1.6em; margin-bottom: 12px; text-transform: capitalize;">
        <?php echo htmlspecialchars($product['name']); ?>
    </h2>

    <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></p>
    <p><strong>Price:</strong> ₹<?php echo htmlspecialchars($product['price']); ?></p>
    <hr>

    <div class="overview-text">
        <strong>Overview:</strong>
        <?php
        $mdescription = htmlspecialchars($product['mdescription']);
        $shortText = substr($mdescription, 0, 10);
        ?>

        <p id="shortText"><?php echo nl2br($shortText); ?>...</p>
        <p id="fullText" class="card-text"><?php echo nl2br($mdescription); ?></p>

        <button id="readMoreBtn" class="btn btn-primary" style="margin-top: 10px;">Read more</button>
        <a href="index.php?controller=User&action=showActiveProducts" class="btn btn-secondary">
            Back to Products
        </a>
    </div>
</div>

<style>
 
</style>

</div>
</div>

<script>
    document.getElementById("readMoreBtn").addEventListener("click", function () {
        const shortText = document.getElementById("shortText");
        const fullText = document.getElementById("fullText");
        const btn = document.getElementById("readMoreBtn");

        if (fullText.style.display === "none") {
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