<?php
require "../database/connect.php";
$name = "test";
$price = 300;
$id = 2;
$des = 1;
$amount = 1;
$image_path = "../asset/user.png";
$sql = "INSERT INTO product_table (pname, price, des, image, amount,uid) VALUES ('$name', $price,'$des', '$image_path',$amount,$id)";
for ($i = 1; $i < 100; $i++) {
    mysqli_query($con, $sql);
}