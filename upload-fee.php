<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
}
include("../db/connection.php");

$id = $_SESSION['student_id'];

if (isset($_POST['upload'])) {

    foreach ($_FILES as $key => $file) {
        if ($file['name'] != "") {
            $name = time().$file['name'];
            move_uploaded_file($file['tmp_name'], "../uploads/".$name);
            mysqli_query($conn,
                "UPDATE clearances SET $key='$name' WHERE student_id=$id"
            );
        }
    }
    $msg = "Files uploaded successfully";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Upload Fees</title>
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
<h2>Upload Fee Receipts</h2>

<?php if(isset($msg)) echo "<p>$msg</p>"; ?>

<form method="POST" enctype="multipart/form-data">
Academic Fee: <input type="file" name="academic_fee"><br><br>
Library Fee: <input type="file" name="library_fee"><br><br>
DSA Fee: <input type="file" name="dsa_fee"><br><br>
Fine: <input type="file" name="fine_fee"><br><br>
<button name="upload">Upload</button>
</form>
</div>

</body>
</html>
