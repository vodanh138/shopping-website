<?php
include_once ("header.php");
if (!isset($_SESSION["uid"]) || !($_SESSION["uid"] == $_GET['uid'])) {
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
    if (($row["uid"] == $_SESSION["uid"])) {
        echo '<script>
            alert("You are not allowed buy your item.");
            window.location.href = "home.php";
          </script>';
        exit();
    }
    $uid = $_GET['uid'];
    $number = $_GET['number'];
    $sql = "SELECT * FROM cart_table WHERE uid = '$uid' AND pid = '$pid'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $add_amount = "UPDATE cart_table SET buyNumber = buyNumber + $number WHERE uid = '$uid' AND pid = '$pid'";
            $result = mysqli_query($con, $add_amount);
            echo '<script>
            alert("Add amount successful");
            window.location.href = "item_info.php?pid=' . $pid . '";
          </script>';
        } else {
            $sql = "INSERT INTO cart_table (uid,pid,buyNumber) VALUES ($uid,$pid,$number)";
            $result = mysqli_query($con, $sql);
            echo '<script>
                alert("Add to Cart successful");
                window.location.href = "item_info.php?pid=' . $pid . '";
              </script>';
        }
    } else {
        echo '<script>
            alert("Something wrong happenned");
            window.location.href = "item_info.php?pid=' . $pid . '";
          </script>';
    }

} else {
    echo "Invalid request.";
    echo 'window.location.href = "home.php"';
    
}
include_once ("footer.php");