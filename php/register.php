<?php
include_once "db_connect.php";

if (isset($_GET['register'])) {
$username = $_GET['username'];
$password = $_GET['password'];

$firstname = $_GET['first_name'];
$lastname = $_GET['last_name'];
$phone = $_GET['phone_number'];
$email = $_GET['email'];
$age = $_GET['age'];
$gender = $_GET['gender'];
$nation = $_GET['nationality'];

$sql = "INSERT INTO customers (customer_first_name, customer_last_name, customer_phone, customer_email, customer_age, customer_gender, customer_nationality) VALUES ('$firstname', '$lastname', '$phone', '$email', '$age', '$gender', '$nation')";

if (mysqli_query($conn, $sql)) {
    echo "New Customer Added Successfully";
    $last_id = mysqli_insert_id($conn);
    $sql = "INSERT INTO login (username, password, customer_id) VALUES ('$username', '$password', '$last_id')";
    if (mysqli_query($conn, $sql)) {
        echo "New Web Account Added Successfully";
        echo '<button onclick="location.href=\'../index.php\';">Go Back</button>';
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        echo "<br>";
        echo "<br>";
        echo '<button onclick="location.href=\'../index.php\';">Go Back</button>';
    }
    
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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


mysqli_close($conn);
?>