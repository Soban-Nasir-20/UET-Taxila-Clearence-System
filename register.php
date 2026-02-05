<?php
include("../db/connection.php");

if (isset($_POST['register'])) {

    $name = $_POST['name'];
    $roll = $_POST['roll'];
    $session = $_POST['session'];
    $dept = $_POST['department'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, 
        "INSERT INTO students (full_name, roll_number, session, department, phone, password)
         VALUES ('$name','$roll','$session','$dept','$phone','$password')"
    );

    $student_id = mysqli_insert_id($conn);

    mysqli_query($conn,
        "INSERT INTO clearances (student_id) VALUES ($student_id)"
    );

    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="login-body">

<div class="login-box">
<h2>Student Registration</h2>

<form method="POST">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="text" name="roll" placeholder="Roll Number" required>
    <input type="text" name="session" placeholder="Session" required>
    <input type="text" name="department" placeholder="Department" required>
    <input type="text" name="phone" placeholder="Phone" required>
    <input type="password" name="password" placeholder="Password" required>
    <button name="register">Register</button>
</form>
</div>

</body>
</html>
