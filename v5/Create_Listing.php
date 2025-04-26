<?php
require_once 'classes/User.php'; // Load the User class
include 'util/Connection.php';

session_start();


?>
<!DOCTYPE html>
<html lang="en">
    
    <title>Game & Stop - Create Listing</title>
    <?php include'Header.php';?>
    <style>
        form {
            margin: 20px auto;
            width: 300px;
            padding: 20px;
            background-color: #f2f2f2;
        }

        body {
                font-family: Arial, sans-serif;

            }

        h2 {
            text-align: center;
        }

        label, input, textarea, select {
            display: inline-block;
            margin-bottom: 10px;
            width: 100%;
        }

        input[type="submit"] {
                background-color: #4CAF50;
                color: white;
                padding: 14px 20px;
                margin: 8px 0;
                border: none;
                cursor: pointer;
                width: 100%;
            }

        .hidden { display: none; }
    </style>

<body>
<h2>List Item For Sale</h2>
<form method="POST" id="listingForm">
    <label>Category:</label>
    <select name="category" id="categorySelect" required>
        <option value="">Select category</option>
        <?php
        $catRequest = $connection->query("SELECT category_id, category_name FROM Categories");
        $cats = $catRequest->fetchAll(PDO::FETCH_ASSOC);
        foreach ($cats as $cat) {
            echo "<option value='{$cat['category_id']}'>" . htmlspecialchars($cat['category_name']) . "</option>";
        }
        ?>
    </select>

    <div id="productSection" class="hidden">
        <label>Product:</label>
        <select name="product" id="productSelect" required>
            <option value="">Select product</option>
        </select>
    </div>

    <div id="newProductFields" class="hidden">
        <label>New Product Title:</label>
        <input type="text" name="new_title">

        <label>Description:</label>
        <textarea name="new_description"></textarea>
    </div>

    <input type="submit" value="Upload Product">
</form>

<script>
document.getElementById("categorySelect").addEventListener("change", function () {
    const categoryId = this.value;
    const productSelect = document.getElementById("productSelect");
    const productSection = document.getElementById("productSection");
    const newProductFields = document.getElementById("newProductFields");

    productSelect.innerHTML = "<option value=''>Loading...</option>";
    productSection.classList.add("hidden");
    newProductFields.classList.add("hidden");
    if(categoryId != 0){
        productSection.classList.remove("hidden");
        fetch(`util/fetch_products.php?category_id=${categoryId}&arg=name`)
            .then(response => response.json())
            .then(data => {
                let options = "<option value=''>Select product</option>";

                for (let i = 0; i < data.length; i++) {
                    options += `<option value="${data[i].product_id}">${data[i].product_name}</option>`;
                }

                options += `<option value="new">+ Add New Product</option>`;

                productSelect.innerHTML = options;
            });
    }
});

document.getElementById("productSelect").addEventListener("change", function () {
    const newProductFields = document.getElementById("newProductFields");
    newProductFields.classList.toggle("hidden", this.value !== "new");
});
</script>
    
</body>

<?php include'Footer.php';?>
</html>