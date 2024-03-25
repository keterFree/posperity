<?php
// Database connection parameters
$servername = "posper-server.mysql.database.azure.com";
$dbusername = "mqsvqcmdyl";
$dbpassword = "@posperity1";
$database = "posper";

// $servername = "localhost";
// $dbusername = "root";
// $dbpassword = "";
// $database = "posper";

// Attempt to establish a database connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $database);

// Check connection
if ($conn->connect_error) {
    // Display error message using JavaScript alert
    echo "<script>alert('Could Not Connect To Database\\n\\n" . $conn->connect_error . "');</script>";
    
    // Terminate script execution
    die("Connection failed: " . $conn->connect_error);
} else {
    
    // You can optionally uncomment the following line to confirm successful connection
    // echo "<script>alert('Connection successful');</script>";
}
