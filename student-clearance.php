<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
}
include("../db/connection.php");

if (isset($_POST['update'])) {
    $id = $_POST['id'];

    mysqli_query($conn, "UPDATE clearances SET
        academic_status='{$_POST['academic']}',
        library_status='{$_POST['library']}',
        dsa_status='{$_POST['dsa']}',
        fine_status='{$_POST['fine']}'
        WHERE id=$id");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Clearance</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<?php include("sidebar.php"); ?>

<div class="main-content">
    <h2>Student Clearance</h2>

    <table>
        <tr>
            <th>Name</th>
            <th>Academic</th>
            <th>Library</th>
            <th>DSA</th>
            <th>Fine</th>
            <th>Action</th>
        </tr>

        <?php
        $res = mysqli_query($conn,
            "SELECT s.full_name, c.* 
             FROM students s 
             JOIN clearances c ON s.id = c.student_id");

        while ($row = mysqli_fetch_assoc($res)) {
        ?>
        <tr>
        <form method="POST">
            <td><?php echo $row['full_name']; ?></td>

            <td>
                <select name="academic">
                    <option <?php if($row['academic_status']=="Pending") echo "selected"; ?>>Pending</option>
                    <option <?php if($row['academic_status']=="Cleared") echo "selected"; ?>>Cleared</option>
                </select>
            </td>

            <td>
                <select name="library">
                    <option <?php if($row['library_status']=="Pending") echo "selected"; ?>>Pending</option>
                    <option <?php if($row['library_status']=="Cleared") echo "selected"; ?>>Cleared</option>
                </select>
            </td>

            <td>
                <select name="dsa">
                    <option <?php if($row['dsa_status']=="Pending") echo "selected"; ?>>Pending</option>
                    <option <?php if($row['dsa_status']=="Cleared") echo "selected"; ?>>Cleared</option>
                </select>
            </td>

            <td>
                <select name="fine">
                    <option <?php if($row['fine_status']=="Pending") echo "selected"; ?>>Pending</option>
                    <option <?php if($row['fine_status']=="Cleared") echo "selected"; ?>>Cleared</option>
                </select>
            </td>

            <td>
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <button name="update">Save</button>
            </td>
        </form>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
