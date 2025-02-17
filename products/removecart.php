<?php
include_once ("header.php");
if(!isset($_SESSION["uid"]) || !($_SESSION["uid"] == $_GET['uid'])) {
    echo '<script>
            alert("You need to log in to access this page.");
            window.location.href = "../index.php?page=login";
          </script>';
    exit();
}

if (isset($_GET['cid'])) {
    $cid = $_GET['cid'];
    require "../database/connect.php";
    $check = "SELECT * FROM cart_table WHERE cid = '$cid'";
    $checking = mysqli_query($con, $check);
    $row = mysqli_fetch_array($checking);
    if (!($row["uid"] == $_SESSION["uid"])){
        echo '<script>
            alert("You are not allowed to remove this item.");
            window.location.href = "../index.php?page=login";
          </script>';
    exit();
    }
    $sql = "DELETE FROM cart_table WHERE cid = '$cid'";
    $result = mysqli_query($con, $sql);
    header('Location: mycart.php');
    exit;
} else {
    echo "Invalid request.";
}
include_once ("footer.php");
