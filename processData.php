<?php
$php_usn   = 'usn';
$php_mname = 'mname';
$php_merid = 'merid';
$php_suid  = 'suid';
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    session_start();
    // Receive the values sent from JavaScript via GET parameters
    // $_SESSION['usn'] =   $_GET['usn'];
    // $_SESSION['mname'] = $_GET['mname'];
    // $_SESSION['merid'] = $_GET['merid'];
    // $_SESSION['suid'] =  $_GET['suid'];

    $php_usn = $_GET['usn'];
    $php_mname = $_GET['mname'];
    $php_merid = $_GET['merid'];
    $php_suid = $_GET['suid'];
    echo "<script>alert('setting session: " . $_SESSION['merid'] . "');</script>";
    // Set PHP variables with received values

    // Now you can use $php_usn, $php_mname, $php_merid, $php_suid as needed in your PHP script
    echo $php_mname; // This will be part of the response sent back to JavaScript
    echo ' received'; // This will also be part of the response
}
// $php_usn = $_SESSION['usn'];
// $php_mname = $_SESSION['mname'];
// $php_merid = $_SESSION['merid'] ;
// $php_suid = $_SESSION['suid'] ;
// echo "<script>alert('check session: " . $_SESSION['merid'] . "');</script>";
echo "<script>alert('var value" . $php_merid . "');</script>";
