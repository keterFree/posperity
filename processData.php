<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    session_start();
    // Receive the values sent from JavaScript via GET parameters
    $_SESSION['usn'] = $_GET['usn'];
    $_SESSION['mname'] = $_GET['mname'];
    $_SESSION['merid'] = $_GET['merid'];
    $_SESSION['suid'] = $_GET['suid'];

    // Set PHP variables with received values

    // Now you can use $php_usn, $php_mname, $php_merid, $php_suid as needed in your PHP script
    echo $php_mname; // This will be part of the response sent back to JavaScript
    echo ' received'; // This will also be part of the response
}
$php_usn = $_SESSION['usn'];
$php_mname = $_SESSION['mname'];
$php_merid = $_SESSION['merid'] ;
$php_suid = $_SESSION['suid'] ;
?>
