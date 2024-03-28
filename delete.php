<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $_SESSION['selectedId'] = $_GET['product_id'];
}

include 'dbconfig.php';

// Prepare and bind the SQL query with a placeholder for the ID
$sql = "DELETE FROM `product` WHERE `product_id` = ?";
$stmt = $conn->prepare($sql);

// Bind the ID variable to the prepared statement
$id = intval($_SESSION['selectedId']);
$stmt->bind_param("i", $id);

// Execute the statement
$stmt->execute();

// Check if the deletion was successful
if ($stmt->affected_rows > 0) {
    echo "Product deleted successfully.";
} else {
    echo "Failed to delete product.";
}
echo '<script>window.location.href = "inventory.php"</script>';

$stmt->close();
$conn->close();