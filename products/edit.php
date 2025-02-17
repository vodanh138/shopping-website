<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
</head>

<body style="display: flex;
    flex-direction: column;
    min-height: 100vh;">
    <div style="flex: 1;">
    <?php
    include_once ("header.php");
    require "../database/connect.php";

    if (!isset($_GET["pid"]) || !isset($_GET["uid"]) || !isset($_SESSION["uid"]) || !($_GET["uid"] == $_SESSION["uid"])) {
        echo '<script>
                            alert("You need to log in to access this page.");
                            window.location.href = "../index.php?page=login";
                        </script>';
        exit();
    }

    $pid = $_GET["pid"];
    $uid = $_GET["uid"];
    $sql = "SELECT * 
                FROM product_table 
                WHERE pid = '$pid'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    if (!($row['uid'] == $_SESSION["uid"])) {
        echo '<script>
                            alert("You need to log in to access this page.");
                            window.location.href = "../index.php?page=login";
                        </script>';
        exit();
    }

    if (isset($_POST["edit_name"]) && isset($_POST["btn_edit"])) {
        $new_pname = $_POST["edit_name"];
        $sql = "UPDATE product_table Set pname = '$new_pname' WHERE pid = '$pid'";
        $result = mysqli_query($con, $sql);
        if ($result) {
            echo '<script>
            window.location.href = "my_product.php";
        </script>';
        }
    }
    ?>
    <form method="post" id="edit_form">
        <label class="p_name">Product's Name:</label>
        <input type="text" name="edit_name" class="edit_name" id="edit_name" value=<?php echo '"' . $row['pname'] . '"' ?>><br>
        <button type="submit" name="btn_edit" class="btn_edit"> Edit</button>
    </form>
    </div>
    <?php
    include_once ("footer.php");
    ?>
</body>

</html>