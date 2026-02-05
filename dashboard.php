<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
}
include("../db/connection.php");

$id = $_SESSION['student_id'];

$data = mysqli_fetch_assoc(
    mysqli_query($conn,
        "SELECT s.*, c.*
         FROM students s
         JOIN clearances c ON s.id = c.student_id
         WHERE s.id=$id")
);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
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
<h2>Welcome, <?php echo $_SESSION['student_name']; ?></h2>

<div class="cards">
<div class="card">Academic: <?php echo $data['academic_status']; ?></div>
<div class="card">Library: <?php echo $data['library_status']; ?></div>
<div class="card">DSA: <?php echo $data['dsa_status']; ?></div>
<div class="card">Fine: <?php echo $data['fine_status']; ?></div>
</div>
<div style="border: 3px solid red; margin-top: 50px; background-color:powderblue">
<p><b>Note:</b> Uploads your documents with your roll number and discription of fee. Like,</p>
<p style="padding-left: 50px;">"23-department-rollnumber fee discription"</p>
<p><b>Example: "23-cp-o1 library fee"</b>
</p>
</div>
<?php
if (
    $data['academic_status'] == 'Cleared' &&
    $data['library_status'] == 'Cleared' &&
    $data['dsa_status'] == 'Cleared' &&
    $data['fine_status'] == 'Cleared'
) {
?>
    <br>
    <a href="generate-certificate.php" class="btn-cert">
        Generate Clearance Certificate (PDF)
    </a>
<?php } ?>


</body>
</html>
