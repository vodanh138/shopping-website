<?php
include_once ("header.php");
if(!isset($_SESSION["uid"]) || !($_SESSION["uid"] == $_GET['uid'])) {
    echo '<script>
            alert("You need to log in to access this page.");
            window.location.href = "../index.php?page=login";
          </script>';
    exit();
}

if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    require "../database/connect.php";
    $check = "SELECT * FROM product_table WHERE pid = '$pid'";
    $checking = mysqli_query($con, $check);
    $row = mysqli_fetch_array($checking);
    if (!($row["uid"] == $_SESSION["uid"])){
        echo '<script>
            alert("You are not allowed to delete this item.");
            window.location.href = "../index.php?page=login";
          </script>';
    exit();
    }
    $sql = "UPDATE product_table SET uid = 1 where pid = '$pid'";
    $result = mysqli_query($con, $sql);
    header('Location: my_product.php');
    exit;
} else {
    echo "Invalid request.";
}
include_once ("footer.php");