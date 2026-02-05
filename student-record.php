<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
}
include("../db/connection.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Record</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include("sidebar.php"); ?>

<div class="main-content">
    <h2>Student Record</h2>

    <table>
        <tr>
            <th>Name</th>
            <th>Roll No</th>
            <th>Session</th>
            <th>Department</th>
            <th>Phone</th>
        </tr>

        <?php
        $result = mysqli_query($conn, "SELECT * FROM students");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>{$row['full_name']}</td>
                <td>{$row['roll_number']}</td>
                <td>{$row['session']}</td>
                <td>{$row['department']}</td>
                <td>{$row['phone']}</td>
            </tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
