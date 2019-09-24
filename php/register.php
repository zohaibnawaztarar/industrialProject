<?php
include_once "db_connect.php";

if (isset($_GET['register'])) {
$username = $_GET['username'];
$password = $_GET['password'];

$name = $_GET['name'];
$email = $_GET['email'];
$zip = $_GET['zip'];

$sql = "INSERT INTO dbo.UserDB (fName, userEmail, userZipcode) VALUES ('$name', '$email', '$zip')";

if (sqlsrv_query($conn, $sql)) {
    echo "New Customer Added Successfully";
    $last_id = sqlsrv_query($conn, $sql);
    $sql = "INSERT INTO dbo.UserDB (userName, userPassword, userID) VALUES ('$username', '$password', '$last_id')";
    if (sqlsrv_query($conn, $sql)) {
        echo "New Web Account Added Successfully";
        echo '<button onclick="location.href=\'../index.php\';">Go Back</button>';
    } else {
        echo "Error: " . $sql . "<br>" . sqlsrv_error($conn);
        echo "<br>";
        echo "<br>";
        echo '<button onclick="location.href=\'../index.php\';">Go Back</button>';
    }
    
} else {
    echo "Error: " . $sql . "<br>" . sqlsrv_error($conn);
    echo "<br>";
    echo "<br>";
    echo '<button onclick="location.href=\'../index.php\';">Go Back</button>';
}


} else {
    echo "Insert operation cancelled!";
    echo "<br>";
    echo "<br>";
    echo '<button onclick="location.href=\'../index.php\';">Go Back</button>';
}


sqlsrv_close($conn);
?>