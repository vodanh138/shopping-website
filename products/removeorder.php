<?php
include_once ("header.php");
if (!isset($_SESSION["uid"]) || !($_SESSION["uid"] == $_GET['uid'])) {
    echo '<script>
            alert("You need to log in to access this page.");
            window.location.href = "../index.php?page=login";
          </script>';
    exit();
}

if (isset($_GET['oid'])) {
    $oid = $_GET['oid'];
    require "../database/connect.php";

    $number = (int) $row["number"];
    $pid = (int) $row["pid"];
    $restock = "UPDATE product_table SET amount = amount + $number Where pid = '$pid'";
    $restocking = mysqli_query($con, $restock);
    if (!$restocking)
        echo '<script>
            alert("Some thing wrong happenned when restock item.");
            window.location.href = "myorder.php";
          </script>';

    $sql = "DELETE FROM order_table WHERE oid = '$oid'";
    $result = mysqli_query($con, $sql);
    if (!$result)
        echo '<script>
            alert("Some thing wrong happenned when remove order.");
            window.location.href = "myorder.php";
          </script>';
    echo '<script>
            alert("Remove order successfully.");
            window.location.href = "myorder.php";
          </script>';
    exit;
} else {
    echo "Invalid request.";
}
include_once ("footer.php");
