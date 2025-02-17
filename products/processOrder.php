<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['selectedItems']) && !empty($_POST['selectedItems']) && isset($_POST['itemNumber']) && !empty($_POST['itemNumber'])) {
        $selectedItemsString = $_POST['selectedItems'];
        $itemNumberString = $_POST['itemNumber'];
        $uid = $_POST['uid'];
        if (is_string($selectedItemsString) && is_string($itemNumberString)) {
            $selectedItems = explode(',', $selectedItemsString);
            $itemNumber = explode(',', $itemNumberString);
            if (is_array($selectedItems) && is_array($itemNumber)) {
                require "../database/connect.php";
                for ($i = 0; $i < count($selectedItems); $i++) {
                    $itemId = $selectedItems[$i];
                    $num = $itemNumber[$i];
                    echo $itemId . '      ' . $num . '      ' . $uid;

                    $order = "INSERT INTO order_table (uid,pid,number,status) VALUES ($uid,$itemId,$num,'pending')";
                    $ordering = mysqli_query($con, $order);

                    $amount_desc = "UPDATE product_table SET amount = amount - $num WHERE pid = '$itemId'";
                    $descing = mysqli_query($con, $amount_desc);

                    $cart_check = "SELECT * FROM cart_table WHERE uid = '$uid' AND pid = '$itemId'";
                    $cart_checking = mysqli_query($con, $cart_check);
                    if ($cart_checking) {
                        if (mysqli_num_rows($cart_checking) >= 1) {
                            $row = mysqli_fetch_array($cart_checking);
                            if ($row["buyNumber"] > $num) {
                                $cart_desc = "UPDATE cart_table SET buyNumber = buyNumber - $num WHERE uid = '$uid' AND pid = '$itemId'";
                                $cart_descing = mysqli_query($con, $cart_desc);
                            } else {
                                $cart_remove = "DELETE FROM cart_table WHERE uid = '$uid' AND pid = '$itemId'";
                                $cart_removing = mysqli_query($con, $cart_remove);
                            }
                        }
                    }
                }
                echo '<script>
                            alert("Order successfully");
                            window.location.href = "mycart.php";
                          </script>';
            } else {
                echo '<script>
                            alert("Something wrong happenned");
                            window.location.href = "home.php";
                        </script>';
            }
        } else {
            echo '<script>
                    alert("Something wrong happenned");
                    window.location.href = "home.php";
                </script>';
        }

        echo "Đã thêm các sản phẩm vào đơn hàng thành công!";
        echo "Không có sản phẩm nào được chọn.";
    } else {
        echo '<script>
                alert("Something wrong happenned");
                window.location.href = "home.php";
            </script>';
    }
}