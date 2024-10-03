<?php
include 'dbinit.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hair Accessories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .edit-btn {
            margin-left: 5px;
        }
        .delete-btn {
            margin-left: 15px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Hair Accessories</h2>
    <a href="register.php" class="btn btn-success mb-3">Add New Accessory</a>
    <table id="accessoriesTable" class="table table-striped">
        <thead>
            <tr>
                <th>Accessory ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Gender</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Brand</th>
                <th>Color</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM hair_accessories");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>{$row['AccessoryName']}</td>";
                echo "<td>{$row['AccessoryDescription']}</td>";
                echo "<td>{$row['GenderCategory']}</td>";
                echo "<td>{$row['QuantityAvailable']}</td>";
                echo "<td>{$row['Price']}</td>";
                echo "<td>{$row['Brand']}</td>";
                echo "<td>{$row['Color']}</td>";
                echo "<td><img src='{$row['ImagePath']}' alt='Image' width='50'></td>";
                echo "<td>
                        <a href='register.php?edit={$row['id']}' class='text-warning edit-btn'><i class='fas fa-edit'></i></a>
                        <a href='register.php?delete={$row['id']}' class='text-danger delete-btn' onclick='return confirm(\"Are you sure you want to delete this item?\");'><i class='fas fa-trash'></i></a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#accessoriesTable').DataTable();
    });
</script>
</body>
</html>