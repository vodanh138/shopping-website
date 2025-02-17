<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style1/paging_products.css" />
    <link rel="stylesheet" href="../style1/products.css" />
    <link rel="stylesheet" href="../style1/item_info.css" />
    <link rel="stylesheet" href="../style1/mycart.css" />


    <title>Item Details</title>
</head>

<body style="display: flex;
    flex-direction: column;
    min-height: 100vh;">
    <div style="flex: 1;">
        <?php
        include_once("header.php");
        require "../database/connect.php";

        if (isset($_GET["pid"])) {
            $items_per_page = isset($_GET['item_num']) ? (int) $_GET['item_num'] : 8;
            $current_page = isset($_GET['pagee']) ? (int) $_GET['pagee'] : 1;
            if (isset($_GET["uid"])) {
                echo '<a class="my-item-link" href="my_product.php?item_num=' . $items_per_page . '&pagee=' . $current_page . '"><span>&larr;</span>My Item</a>';
            } else {
                $search = isset($_GET['search_bar']) ? $_GET["search_bar"] : "";
                echo '<a class="my-item-link" href="paging_products.php?search_bar=' . $search . '&item_num=' . $items_per_page . '&pagee=' . $current_page . '"><span>&larr;</span>Search Item</a>';
            }

            $pid = $_GET["pid"];
            $sql = "SELECT * 
                FROM product_table 
                JOIN user_table ON product_table.uid = user_table.uid
                WHERE product_table.pid = '$pid'AND user_table.uid != 1";
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result);
            if (!$row)
                echo '<script>
                alert("Item not found.");
                window.location.href = "../index.php";
            </script>';

            $view_inc = "UPDATE product_table SET view = view + 1 WHERE pid = '$pid'";
            mysqli_query($con, $view_inc);
            echo '<form id="cartForm" action="processOrder.php" method="POST">
                    <div class="product_display">
                        <img src="' . $row['image'] . '"> <br>' .
                "<p>Product's name:</p>" .
                '<p>' . $row['pname'] . '</p><br>
                        <p>Price: ' . $row['price'] . 'VND </p><br>
                        <p>Description: ' . $row['des'] . '</p><br>
                        <p>Remain: ' . $row['amount'] . '</p><br>
                    </div>';
            if (isset($_GET["uid"])) {
                if (!isset($_SESSION["uid"]) || !($_SESSION["uid"] == $row['uid'])) {
                    echo '<script>
                        alert("You need to log in to access this page.");
                        window.location.href = "../index.php?page=login";
                      </script>';
                    exit();
                } else if ($_GET["uid"] === $_SESSION["uid"]) {
                    $uid = $_SESSION["uid"];
                    
                    echo '</form><button class="edit-btn" onclick="edititem(' . $pid . ',' . $uid . ')">Edit</button>';
                    echo '<button class="delete-btn" onclick="deleteitem(' . $pid . ',' . $uid . ')">Delete</button>';
                }
            } else if (isset($_SESSION["uid"]) && !($_SESSION["uid"] == $row['uid'])) {
                $uid = $_SESSION["uid"];
                echo '
                
                    <input type="hidden"  name="uid" id="uid" value="' . $uid . '">
                    <input type="hidden"  name="selectedItems" id="selectedItems" value="">
                    <input type="hidden"  name="itemNumber" id="itemNumber" value="">
                    </form>
                    <input class="buyNumber" name="buyNumber" id="buyNumber" type="number">
                    <button class="edit-btn" type="button" onclick="addtocart(' . $pid . ',' . $uid . ',' . $row['amount'] .  ')">
                        Add to Cart
                    </button>
                    <button class="order-btn" type="button" onclick="submitForm(' . $pid . ',' . $uid . ',' . $row['amount'] . ',' . $row['price'] . ')">Order</button>
                
                <div id="confirmationPopup" class="popup">
                    <div class="popup-content">
                        <span class="close" onclick="closePopup()">&times;</span>
                        <h2>Order Confirmation</h2>
                        <p id="totalAmount"></p><br>
                        <div class="payment-options">
                            <button id="directPaymentBtn" class="payment-btn">Cash on Delivery</button>
                            <button id="onlinePaymentBtn" class="payment-btn disabled" disabled>Online Payment (Coming Soon)</button>
                        </div>
                    </div>
                </div>';
            }
        }
        echo '</div>';
        include_once("footer.php");
        ?>

        <script>
            function edititem(pid, uid) {
                window.location.href = 'edit.php?pid=' + pid + '&uid=' + uid;
            }

            function deleteitem(pid, uid) {
                if (confirm('Are you sure you want to delete this item?')) {
                    window.location.href = 'delete.php?pid=' + pid + '&uid=' + uid;
                }
            }

            function addtocart(pid, uid, amount) {
                const number = parseInt(document.getElementById('buyNumber').value, 10);
                if (isNaN(number) || number <= 0) {
                    alert('Buying amount must be a positive integer ');
                } else {
                    window.location.href = 'addtocart.php?pid=' + pid + '&uid=' + uid + '&number=' + number;
                }
            }

            function submitForm(pid, uid, amount, price) {
                const number = parseInt(document.getElementById('buyNumber').value, 10);
                const totalAmount = amount * price;
                if (number > amount) {
                    alert('Buy amount cannot be greater than available amount.');
                }
                else if (isNaN(number) || number <= 0) {
                    alert('Buying amount must be a positive integer ');
                } else {
                    document.getElementById('totalAmount').textContent = `Total Payment: ${totalAmount} VND`;
                    document.getElementById('confirmationPopup').style.display = "block";

                    document.getElementById('directPaymentBtn').onclick = function() {
                        document.getElementById('selectedItems').value = pid;
                        document.getElementById('itemNumber').value = number;
                        document.getElementById('cartForm').submit();
                    }
                }
            }

            function closePopup() {
                document.getElementById('confirmationPopup').style.display = "none";
            }
        </script>
</body>

</html>