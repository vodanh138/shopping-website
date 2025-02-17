<?php
include_once ("header.php");

if (isset($_POST['delete_user_id'])) {
    $uid = $_POST['delete_user_id'];
    require "../database/connect.php";
    $sql = "DELETE FROM user_table WHERE uid = '$uid'";
    $result = mysqli_query($con, $sql);
    header('Location: adminDashboard.php');
    exit;
} else {
    echo "Invalid request.";
}
include_once ("footer.php");