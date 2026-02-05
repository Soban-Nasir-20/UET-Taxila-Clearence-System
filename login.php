<?php
session_start();
include("../db/connection.php");

if (isset($_POST['login'])) {

    $roll = $_POST['roll'];
    $password = $_POST['password'];

    $query = mysqli_query($conn,
        "SELECT * FROM students WHERE roll_number='$roll' AND password='$password'"
    );

    if (mysqli_num_rows($query) == 1) {
        $student = mysqli_fetch_assoc($query);
        $_SESSION['student_id'] = $student['id'];
        $_SESSION['student_name'] = $student['full_name'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid Roll No or Password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="login-body">

<div class="login-box">
<h2>Student Login</h2>

<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

<form method="POST">
    <input type="text" name="roll" placeholder="Roll Number" required>
    <input type="password" name="password" placeholder="Password" required>
    <button name="login">Login</button>
</form>

<p>New Student? <a href="register.php">Register</a></p>
</div>

</body>
</html>
