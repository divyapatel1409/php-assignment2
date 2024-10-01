<?php
include 'dbinit.php';

$accessoryName = $accessoryDescription = $genderCategory = $quantityAvailable = $price = $brand = $color = $imagePath = "";
$accessoryID = 0;
$productAddedBy = "Divyangini"; // Hardcoded value for 'Product Added By'
$update = false;

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
        <input type="hidden" name="AccessoryID" value="<?php echo $accessoryID; ?>">
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