<?php
include_once ("header.php");
require "../database/connect.php";

if (!isset($_SESSION["uid"])) {
    echo '<script>
            alert("You need to log in to access this page.");
            window.location.href = "../index.php?page=login";
          </script>';
    exit();
}
if (isset($_POST["add_amount"]))
    echo $_POST["add_amount"];
if (isset($_POST["add_name"]) && isset($_POST["add_price"]) && isset($_POST["add_des"]) && isset($_POST["add_amount"])) {
    $target_directory = "../asset/";
    $target_file = $target_directory . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $name = $_POST["add_name"];
    $price = $_POST["add_price"];
    $des = $_POST["add_des"];
    $amount = $_POST["add_amount"];
    $id = $_SESSION["uid"];

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        if ($_FILES["image"]["size"] > 5000000) {
            $error = "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var miss_info = document.getElementById('miss_info');
                if (miss_info) {
                    miss_info.innerHTML = 'Sorry, your file is too large.';
                    miss_info.style.color = 'red';
                }
            });
            </script>";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = $target_file;
                $sql = "INSERT INTO product_table (pname, price, des, image, amount,uid) VALUES ('$name', $price,'$des', '$image_path',$amount,$id)";
                if (mysqli_query($con, $sql)) {
                    $error = "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var miss_info = document.getElementById('miss_info');
                if (miss_info) {
                    miss_info.innerHTML = 'The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.';
                    miss_info.style.color = 'green';
                }
            });
            </script>";
                } else {
                    $error = "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var miss_info = document.getElementById('miss_info');
                if (miss_info) {
                    miss_info.innerHTML = 'Error: " . $sql . "<br>" . mysqli_error($con) . "';
                    miss_info.style.color = 'red';
                }
            });
            </script>";
                }
            } else {
                $error = "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var miss_info = document.getElementById('miss_info');
                if (miss_info) {
                    miss_info.innerHTML = 'Sorry, there was an error uploading your file.';
                    miss_info.style.color = 'red';
                }
            });
            </script>";
            }
        }
    } else {
        $error = "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var miss_info = document.getElementById('miss_info');
                if (miss_info) {
                    miss_info.innerHTML = 'File is not an image..';
                    miss_info.style.color = 'red';
                }
            });
            </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style1/add_product.css" />
    <title>Add Item</title>
</head>

<body style="display: flex;
    flex-direction: column;
    min-height: 100vh;">
    <div style="flex: 1;">
        <form method="post" id="add_form" enctype="multipart/form-data">
            <label class="p_name" style="font-weight:bold">Item's Name:</label>
            <input type="text" name="add_name" class="add_name" id="add_name"><br>
            <label class="p_name" style="font-weight:bold">Item's Price:</label>
            <input type="number" name="add_price" class="add_price" id="add_price">(VND)<br>
            <label class="p_name" style="font-weight:bold">Item's Description:</label><br>
            <textarea type="text" name="add_des" class="add_des" id="add_des" rows="5"
                style="width: 100%;"></textarea><br>
            <label class="p_name" style="font-weight:bold">Item's Amount:</label>
            <input type="number" name="add_amount" class="add_amount" id="add_amount"><br>
            <br><br>
            <label for="add_file" id="add_label" class="add_label">Choose File</label>
            <br>
            <p id="file_name"></p>
            <input type="file" name="image" accept="image/*" id="add_file" class="add_file">
            <button type="submit" name="btn_add" class="btn_add"> Add</button><br>
            <div id="miss_info" class="miss_info" style="color:red;"></div>
        </form>
    </div>

    <?php
    if (isset($error))
        echo $error;
    include_once ("footer.php");
    ?>

    <script src="../js/add_products.js"></script>
</body>

</html>