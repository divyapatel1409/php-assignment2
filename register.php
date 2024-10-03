<?php
include 'dbinit.php';

$accessoryName = $accessoryDescription = $genderCategory = $quantityAvailable = $price = $brand = $color = $imagePath = "";
$productAddedBy = "Divyangini"; // Hardcoded value for 'Product Added By'
$update = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['save'])) {
        $accessoryName = $_POST['AccessoryName'];
        $accessoryDescription = $_POST['AccessoryDescription'];
        $genderCategory = $_POST['GenderCategory'];
        $quantityAvailable = $_POST['QuantityAvailable'];
        $price = $_POST['Price'];
        $brand = $_POST['Brand'];
        $color = $_POST['Color'];

        // Handle image upload
        $image = $_FILES['Image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);

        if (move_uploaded_file($_FILES['Image']['tmp_name'], $target_file)) {
            // Prepare SQL statement
            $sql_query = "INSERT INTO hair_accessories (AccessoryName, AccessoryDescription, GenderCategory, QuantityAvailable, Price, Brand, Color, ProductAddedBy, ImagePath) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql_query);
            $stmt->bind_param("sssidssss", $accessoryName, $accessoryDescription, $genderCategory, $quantityAvailable, $price, $brand, $color, $productAddedBy, $target_file);
            if ($stmt->execute()) {
                header('Location: index.php');
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Error uploading image.";
        }
    }

    if (isset($_POST['update'])) {
        $accessoryID = $_POST['id'];
        $accessoryName = $_POST['AccessoryName'];
        $accessoryDescription = $_POST['AccessoryDescription'];
        $genderCategory = $_POST['GenderCategory'];
        $quantityAvailable = $_POST['QuantityAvailable'];
        $price = $_POST['Price'];
        $brand = $_POST['Brand'];
        $color = $_POST['Color'];
        
        // Handle image upload
        if (!empty($_FILES['Image']['name'])) {
            $image = $_FILES['Image']['name'];
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($image);
            move_uploaded_file($_FILES['Image']['tmp_name'], $target_file);
        } else {
            $target_file = $_POST['CurrentImage']; // Keep current image if no new image uploaded
        }

        $stmt = $conn->prepare("UPDATE hair_accessories SET AccessoryName=?, AccessoryDescription=?, GenderCategory=?, QuantityAvailable=?, Price=?, Brand=?, Color=?, ImagePath=? WHERE id=?");
        $stmt->bind_param("sssidssss", $accessoryName, $accessoryDescription, $genderCategory, $quantityAvailable, $price, $brand, $color, $target_file, $accessoryID);
        $stmt->execute();
        header('Location: index.php');
    }
}

// Delete accessory
if (isset($_GET['delete'])) {
    $accessoryID = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM hair_accessories WHERE id=?");
    $stmt->bind_param("i", $accessoryID);
    $stmt->execute();
    header('Location: index.php');
}

// Edit accessory
if (isset($_GET['edit'])) {
    $accessoryID = $_GET['edit'];
    $update = true;
    $result = $conn->query("SELECT * FROM hair_accessories WHERE id=$accessoryID");
    $row = $result->fetch_array();
    $accessoryName = $row['AccessoryName'];
    $accessoryDescription = $row['AccessoryDescription'];
    $genderCategory = $row['GenderCategory'];
    $quantityAvailable = $row['QuantityAvailable'];
    $price = $row['Price'];
    $brand = $row['Brand'];
    $color = $row['Color'];
    $imagePath = $row['ImagePath'];
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $update ? "Update Accessory" : "Add New Accessory"; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center"><?php echo $update ? "Update Accessory" : "Add New Accessory"; ?></h2>
    <form method="POST" action="" enctype="multipart/form-data" class="mt-4">
        <input type="hidden" name="id" value="<?php echo $accessoryID; ?>">
        <input type="hidden" name="CurrentImage" value="<?php echo $imagePath; ?>">
        
        <!-- Accessory Name -->
        <div class="mb-3">
            <label for="AccessoryName" class="form-label">Accessory Name:</label>
            <input type="text" class="form-control" name="AccessoryName" value="<?php echo $accessoryName; ?>" required>
        </div>

        <!-- Accessory Description -->
        <div class="mb-3">
            <label for="AccessoryDescription" class="form-label">Accessory Description:</label>
            <textarea class="form-control" name="AccessoryDescription" required><?php echo $accessoryDescription; ?></textarea>
        </div>

        <!-- Gender Category -->
        <div class="mb-3">
            <label for="GenderCategory" class="form-label">Gender Category:</label>
            <select class="form-control" name="GenderCategory" required>
                <option value="Select" <?php if($genderCategory == 'Select') echo 'selected'; ?>>Select</option>
                <option value="Male" <?php if($genderCategory == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if($genderCategory == 'Female') echo 'selected'; ?>>Female</option>
                <option value="Unisex" <?php if($genderCategory == 'Unisex') echo 'selected'; ?>>Unisex</option>
            </select>
        </div>

        <!-- Quantity Available -->
        <div class="mb-3">
            <label for="QuantityAvailable" class="form-label">Quantity Available:</label>
            <input type="number" class="form-control" name="QuantityAvailable" value="<?php echo $quantityAvailable; ?>" required>
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label for="Price" class="form-label">Price:</label>
            <input type="text" class="form-control" name="Price" value="<?php echo $price; ?>" required>
        </div>

        <!-- Brand -->
        <div class="mb-3">
            <label for="Brand" class="form-label">Brand:</label>
            <input type="text" class="form-control" name="Brand" value="<?php echo $brand; ?>" required>
        </div>

        <!-- Color -->
        <div class="mb-3">
            <label for="Color" class="form-label">Color:</label>
            <input type="text" class="form-control" name="Color" value="<?php echo $color; ?>" required>
        </div>

        <!-- Image Upload -->
        <div class="mb-3">
            <label for="Image" class="form-label">Accessory Image:</label>
            <input type="file" class="form-control" name="Image" accept="image/*">
            <?php if ($update): ?>
                <img src="<?php echo $imagePath; ?>" alt="Current Image" class="img-fluid mt-2" width="100">
            <?php endif; ?>
        </div>

        <!-- Product Added By (Hardcoded) -->
        <div class="mb-3">
            <label for="ProductAddedBy" class="form-label">Product Added By:</label>
            <input type="text" class="form-control" value="<?php echo $productAddedBy; ?>" disabled>
        </div>

        <!-- Submit Button -->
        <button type="submit" name="<?php echo $update ? 'update' : 'save'; ?>" class="btn btn-<?php echo $update ? 'warning' : 'primary'; ?>">
            <?php echo $update ? 'Update' : 'Add'; ?>
        </button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>