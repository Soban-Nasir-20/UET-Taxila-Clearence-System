<?php
$conn = mysqli_connect("localhost", "root", "", "clearance_system");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
