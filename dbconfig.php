<?php
// Database connection parameters
$servername = "posper-server.mysql.database.azure.com";
$username = "mqsvqcmdyl";
$password = "@posperity1";
$database = "posper";

try {
    $conn = new mysqli($servername, $dbusername, $dbpassword, $database);
    if ($conn->connect_error) {
        throw new Exception('connection error: ' . $conn->connect_error);
    } else {
        // Connection successful
        // echo "Connection success!";
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
    // Escaping single quotes in the error message
    $escapedErrorMessage = str_replace("'", "\'", $errorMessage);

    echo "<script>";
    echo "  alert('Could Not Connect To Database\\n\\n" . $escapedErrorMessage . "');";
    echo "</script>";

    die("Connection failed: ");
}
