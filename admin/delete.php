<?php
include_once ("header.php");

if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    require "../database/connect.php";
    $check = "SELECT * FROM product_table WHERE pid = '$pid'";
    $checking = mysqli_query($con, $check);
    $row = mysqli_fetch_array($checking);

    $sql = "UPDATE product_table SET uid = 1 where pid = '$pid'";
    $result = mysqli_query($con, $sql);
    header('Location: manageItems.php');
    exit;
} else {
    echo "Invalid request.";
}
include_once ("footer.php");