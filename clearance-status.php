<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
}
include("../db/connection.php");

$id = $_SESSION['student_id'];

$data = mysqli_fetch_assoc(
    mysqli_query($conn,
        "SELECT * FROM clearances WHERE student_id=$id")
);
?>
<!DOCTYPE html>
<html>
<head>
<title>Clearance Status</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="sidebar">
<h3>Student Panel</h3>
<a href="dashboard.php">Dashboard</a>
<a href="upload-fee.php">Upload Fees</a>
<a href="clearance-status.php">Clearance Status</a>
<a href="logout.php">Logout</a>
</div>

<div class="main-content">
<h2>Clearance Status</h2>

<table>
<tr><th>Department</th><th>Status</th></tr>
<tr><td>Academic</td><td><?php echo $data['academic_status']; ?></td></tr>
<tr><td>Library</td><td><?php echo $data['library_status']; ?></td></tr>
<tr><td>DSA</td><td><?php echo $data['dsa_status']; ?></td></tr>
<tr><td>Fine</td><td><?php echo $data['fine_status']; ?></td></tr>
</table>

</div>
</body>
</html>
