<?php
require_once 'classes/User.php'; // Load the User class
include 'util/Connection.php';
include 'util/common.php';

session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == NULL) {
    $msg = "<p style='color:red;'>You must be logged in to create a listing.</p>";
    echo $msg;
    exit;
}

$userId = $_SESSION['user_id']; // Assuming user is logged in
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryId = escape($_POST['category']);
    $productId = escape($_POST['product']);
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    $price = $_POST['price'];
    $image = $_FILES['image'];  // keep this array untouched
    $imageData = null;
    $imageType = null;

    if (isset($image) && $image['error'] === UPLOAD_ERR_OK) {
        $imageData = file_get_contents($image['tmp_name']); // 🡒 store data separately
        $imageType = $image['type'];
    } else {
        die('Upload failed with error code ' . $image['error']);
    }

    if ($productId === 'new') {
        $checkProduct = $connection->prepare("SELECT * FROM Products WHERE product_name = :product_name AND category_id = :category_id");
        $checkProduct->execute([
            ':product_name' => $_POST['new_title'],
            ':category_id' => $categoryId
        ]);
        $existingProduct = $checkProduct->fetch(PDO::FETCH_ASSOC);
        //check that product of the same name and category doesnt already exist
        if ($existingProduct) {
            // If the product already exists in the same category
            $msg = "<p class='message' style='color:red;'>A product with the same name already exists in this category. please select the product from the list and try again.</p>";
            echo $msg;
            exit;
        }
        else{
            // User wants to add a completely new product
            $newTitle = escape($_POST['new_title']);
            $newDescription = escape($_POST['new_description']);

            if (empty($newTitle) || empty($newDescription)) {
                $msg = "<p class='message'>Error: New product title and description are required.</p>";
                exit;
            }
            $connection->beginTransaction();
            try {
                $condition = 'used'; // Always mark user-submitted products as 'used'

                $insertProduct = $connection->prepare("
                    INSERT INTO Products (product_name, description, price, quantity, category_id, seller_id, conditions)
                    VALUES (:product_name, :description, :price, :quantity, :category_id, :seller_id, :conditions)
                ");
                $insertProduct->execute([
                    ':product_name' => $newTitle,
                    ':description' => $newDescription,
                    ':price' => $price, 
                    ':quantity' => $quantity,
                    ':category_id' => $categoryId,
                    ':seller_id' => $userId,
                    ':conditions' => $condition
                ]);

                $insertId = $connection->lastInsertId();
                
                if($imageData){
                $insertImage = $connection->prepare("INSERT INTO Images (image_data, image_type, product_id) VALUES (:image_data, :image_type, :product_id)"); 
                $insertImage->execute([
                    ':image_data' => $imageData,
                    ":image_type" => $imageType,
                    ':product_id' => $insertId
                ]);
                $connection->commit();
                $msg =  "<p class='message' style='color:green;'>New product added successfully!</p>";
                }
                else {
                    $connection->rollBack(); 
                    $msg = "<p class='message' style='color:red;'>image_data cant be null</p>";
                }
            } catch (PDOException $e) {
                $connection->rollBack();
                $msg = "<p class='message' style='color:red;'>Error adding new product: " . $e->getMessage() . "</p>";
                //$msg =  "<p class='message' style='color:red;'>Something went wrong while listing your product. Please try again or contact support.</p>";
            }
        }
    } else {
        $existingRequest = $connection->prepare("SELECT * FROM Products WHERE product_id = :product_id AND category_id = :category_id");
        $existingRequest->execute([':product_id' => $productId, ':category_id' => $categoryId]); 
                
        $existingProduct = $existingRequest->fetch(PDO::FETCH_ASSOC);
        
        $existingUserProduct = NULL;
        // Check if the user is already selling the same product in the same category
        $checkExisting = $connection->prepare("SELECT * FROM Products WHERE product_name = :product_name AND category_id = :category_id AND seller_id = :seller_id");
        if ($existingProduct) {
            $checkExisting->execute([
                ':product_name' => $existingProduct['product_name'],
                ':category_id' => $categoryId,
                ':seller_id' => $userId
            ]);
            $existingUserProduct = $checkExisting->fetch(PDO::FETCH_ASSOC);
        } else {
            $msg = "<p class='message' style='color:red;'>Selected product does not exist.</p>";
            echo $msg;
            exit;
        }

        if ($existingUserProduct) {
            // If the product is already listed by the user, increase its quantity
            $newQuantity = $existingUserProduct['quantity'] + $quantity;

            $updateQuantity = $connection->prepare("UPDATE Products SET quantity = :quantity WHERE product_id = :product_id AND category_id = :category_id AND seller_id = :seller_id");
            $updateQuantity->execute([
                ':quantity' => $newQuantity,
                ':product_id' => $existingUserProduct['product_id'],
                ':category_id' => $categoryId, 
                ':seller_id' => $userId
            ]);

            $checkImage = $connection->prepare("SELECT * FROM Images WHERE product_id = :product_id"); 
            $checkImage->execute([
                ':product_id' => $existingUserProduct['product_id']
            ]);

            $imageResult = $checkImage->fetch(PDO::FETCH_ASSOC);

            if($imageResult) {
                $insertImage = $connection->prepare("UPDATE Images SET image_data = :image_data, image_type = :image_type WHERE product_id = :product_id"); 
                $insertImage->execute([
                    ':image_data' => $imageData,
                    ':image_type' => $imageType,
                    ':product_id' => $existingUserProduct['product_id']
                ]);
            }
            else{
                $insertImage = $connection->prepare("INSERT INTO Images (image_data, image_type, product_id) VALUES (:image_data, :image_type, :product_id)"); 
                $insertImage->execute([
                    ':image_data' => $imageData,
                    ':image_type' => $imageType,
                    ':product_id' => $existingUserProduct['product_id']
                ]);
            }


            $msg = "<p class='message' style='color:green;'>Quantity of the product updated successfully!</p>";
        } else {
            $connection->beginTransaction();
            try{// If the product is not listed by the user, create a new entry under the user's ownership 

                $condition = 'used'; // Always mark user-submitted products as 'used'
                $price = isset($existingProduct['price']) ? $existingProduct['price'] / 2 : 0.00; // Keep existing price, halved for user products

                $insertProduct = $connection->prepare("
                    INSERT INTO Products (product_name, description, price, quantity, category_id, seller_id, conditions)
                    VALUES (:product_name, :description, :price, :quantity, :category_id, :seller_id, :conditions)
                ");
                $insertProduct->execute([
                    ':product_name' => $existingProduct['product_name'],
                    ':description' => $existingProduct['description'],
                    ':price' => $price,
                    ':quantity' => $quantity,
                    ':category_id' => $existingProduct['category_id'],
                    ':seller_id' => $userId,
                    ':conditions' => $condition
                ]);

                $insertId = $connection->lastInsertId();

                $insertImage = $connection->prepare("INSERT INTO Images (image_data, image_type, product_id) VALUES (:image_data, :image_type, :product_id)");
                $insertImage->execute([
                    ':image_data' => $imageData,
                    ':image_type' => $imageType,
                    ':product_id' => $insertId
                ]);

                $connection->commit();
                $msg = "<p class='message' style='color:green;'>Product(s) listed successfully!</p>";

            } 
            catch (PDOException $e) {
                $connection->rollBack();
                $msg = "<p class='message' style='color:red;'>Error adding new product: " . $e->getMessage() . "</p>";
                //$msg =  "<p style='color:red;'>Something went wrong while listing your product. Please try again or contact support.</p>";

            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    
    <title>Game & Stop - Create Listing</title>
    <?php include'Header.php';?>
    <link rel="stylesheet" href="css/style.css" type="text/css">

<body>
<h2>List Second Hand Item For Sale</h2>
<form method="POST" id="listingForm" enctype="multipart/form-data">
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
    
    <div id="imageSection" class="hidden">
        <label>New Product Image *<span style="font-size: 10px;">(if you have a listing of the same product, this will replace the image in that.)</span>:</label>
        <input type="file" name="image" accept="image/*">
    </div>

    <div id="quantitySection" class="hidden">
        <label for="quantityInput">Quantity:</label>
        <input type="number" id="quantityInput" name="quantity" min="1" value="1">
    </div>
        

    <div id="priceSection" class="hidden">
        <label for="priceInput">Price:</label>
        <input type="number" id="price" name="price" min="0.00" step="0.01" value="0.00">
    </div>
    
    <div id="newProductFields" class="hidden">
        <label>New Product Title:</label>
        <input type="text" name="new_title">

        <label>Description:</label>
        <textarea name="new_description"></textarea>    

    </div>

    <input type="submit" value="Upload Product">
</form>

<?php if($msg != ""){
    echo $msg;
} ?>
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
        fetch(`util/fetch_products.php?category_id=${categoryId}`)
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
    const selectedValue = this.value;
    const quantitySection = document.getElementById("quantitySection");
    const newProductFields = document.getElementById("newProductFields");
    const imageSection = document.getElementById("imageSection");
    const priceSection = document.getElementById("priceSection");

    if (selectedValue === "new") {
        // User wants to add a new product
        newProductFields.classList.remove("hidden");
        quantitySection.classList.remove("hidden");
        imageSection.classList.remove("hidden");
        priceSection.classList.remove("hidden");
    } else if (selectedValue !== "") {
        // Existing product selected
        newProductFields.classList.add("hidden");
        quantitySection.classList.remove("hidden");
        imageSection.classList.remove("hidden");
        priceSection.classList.remove("hidden");
    } else {
        // No selection
        newProductFields.classList.add("hidden");
        quantitySection.classList.add("hidden");
        imageSection.classList.add("hidden");
        priceSection.classList.add("hidden");
    }
});
</script>
    
</body>

<?php include'Footer.php';?>
</html>