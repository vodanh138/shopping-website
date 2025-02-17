<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style1/products.css" />
    <link rel="stylesheet" href="../style1/paging_products.css" />
    <link rel="stylesheet" href="../style1/item_info.css" />
    <link rel="stylesheet" href="../style1/mycart.css" />
    <title>My Item</title>
</head>

<body style="display: flex;
    flex-direction: column;
    min-height: 100vh;">
    <?php
    include_once("header.php");
    ?>
    <div style="flex: 1;">
        <form id="searching_form" method="get">
            <div class="searching_form">
                <input class="search_bar" name="search_bar" id="search_bar" type="text" placeholder="Searching...." value="<?php echo isset($_GET['search_bar']) ? $_GET['search_bar'] : ''; ?>">
            </div>
            <div id="search-suggestions" class="search-suggestions"></div>
            <label>Number of items per page:</label>
            <select id="item_num" name="item_num" class="item_num">
                <option value="8" <?php if (isset($_GET['item_num']) && $_GET['item_num'] == 8)
                                        echo 'selected'; ?>>8
                </option>
                <option value="12" <?php if (isset($_GET['item_num']) && $_GET['item_num'] == 12)
                                        echo 'selected'; ?>>12
                </option>
                <option value="16" <?php if (isset($_GET['item_num']) && $_GET['item_num'] == 16)
                                        echo 'selected'; ?>>16
                </option>
                <option value="20" <?php if (isset($_GET['item_num']) && $_GET['item_num'] == 20)
                                        echo 'selected'; ?>>20
                </option>
            </select>
        </form>

        <main>
            <?php
            require "../database/connect.php";
            if (!isset($_SESSION["uid"])) {
                echo '<script>
                    alert("You need to log in to access this page.");
                    window.location.href = "../index.php?page=login";
                  </script>';
                exit();
            }
            $items_per_page = isset($_GET['item_num']) ? (int) $_GET['item_num'] : 8;
            $current_page = isset($_GET['pagee']) ? (int) $_GET['pagee'] : 1;
            $offset = ($current_page - 1) * $items_per_page;
            $uid = $_SESSION["uid"];
            $search = '';
            if (isset($_GET["search_bar"]))
                $search = $_GET["search_bar"];

            $sql_count = "SELECT COUNT(*) as total FROM cart_table WHERE uid = '$uid'";
            $result_count = mysqli_query($con, $sql_count);
            $row_count = mysqli_fetch_assoc($result_count);
            $total_items = $row_count['total'];

            $sql = "SELECT * FROM cart_table JOIN product_table ON cart_table.pid = product_table.pid WHERE cart_table.uid = '$uid'AND pname LIKE '%$search%' LIMIT $items_per_page OFFSET $offset";
            $result = mysqli_query($con, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo '<form id="cartForm" action="processOrder.php" method="POST">
                        <div class="page_display">';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '
                    <div style="display: flex;
                        flex-direction: column;">
                        <div class="cart product_display" data-id="' . $row['pid'] . '">
                            <img src="' . $row['image'] . '"> <br>' .
                        "<p>Product's name:</p>" .
                        '<p>' . $row['pname'] . '</p><br>
                            <p>Price: ' . $row['price'] . ' VND </p><br>
                            <p>Description: ' . $row['des'] . '</p><br>
                            <p>Remain: ' . $row['amount'] . '</p><br>
                            <p>Buy amount: <input type="number" name="buyNumber[' . $row['cid'] . ']" value="' . $row['buyNumber'] . '" min="1" max="' . $row['amount'] . '" 
                            class="buyNumberInput" data-amount="' . $row['amount'] . '"></p><br>
                        </div>
                    <div class="delete-btn"  onclick="removefromcart(' . $uid . ',' . $row['cid'] . ')" style ="margin-top: 0px;margin-bottom: 20px;align-self: center;">Remove from Cart</div>
                    </div>';
                }

                echo '
                        </div>
                        <input type="hidden"  name="uid" id="uid" value="' . $uid . '">
                        <input type="hidden"  name="selectedItems" id="selectedItems" value="">
                        <input type="hidden"  name="itemNumber" id="itemNumber" value="">
                        <button class="order-btn" type="button" onclick="submitForm()">Order</button>
                    </form>
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
                $total_pages = ceil($total_items / $items_per_page);
                $numberSet = [1, $current_page - 1, $current_page, $current_page + 1, $current_page - 2, $current_page + 2, $total_pages];
                $blank = false;
                $pre_num = 0;
                echo '<br>';
                echo '<div class="pagination">';
                for ($i = 1; $i <= $total_pages; $i++) {
                    if (in_array($i, $numberSet)) {
                        if ($blank === true) {
                            $blank = false;
                            $mid_num = floor(($pre_num + $i) / 2);
                            echo '<a href="?item_num=' . $items_per_page . '&pagee=' . $mid_num . '" class = "page_num">...' . $mid_num . '...</a>';
                            $pre_num = 0;
                        }
                        echo '<a href="?item_num=' . $items_per_page . '&pagee=' . $i . '"';
                        if ($current_page === $i)
                            echo 'class = "page_chosen"';
                        else
                            echo 'class = "page_num"';
                        echo ">$i</a>";
                    } else {
                        $blank = true;
                        if ($pre_num === 0)
                            $pre_num = $i;
                    }
                }
                echo '</div>';
            } else {
                echo "<p>No result found</p>";
            }
            ?>
    </div>
    <?php
    include_once("footer.php");
    ?>
    <style>
        .selected {
            background-color: #d3f9d8;
            border-color: #34c759;
        }

        .invalid {
            background-color: #ffe6e6;
            border-color: #ff4d4d;
            color: #ff0000;
        }

        .invalid::placeholder {
            color: #ff4d4d;
        }
    </style>

    <script src="../js/paging_products.js"></script>
    <script>
        document.querySelectorAll('.cart').forEach(function(item) {
            item.addEventListener('click', function() {
                item.classList.toggle('selected');
            });
        });

        function submitForm() {
            let selectedItems = [];
            let itemNumber = [];
            let valid = true;
            let totalAmount = 0;

            document.querySelectorAll('.cart.selected').forEach(function(item) {
                const buyNumberInput = item.querySelector('.buyNumberInput');
                const buyNumber = parseInt(buyNumberInput.value);
                const amount = parseInt(buyNumberInput.getAttribute('data-amount'));
                const price = parseInt(item.querySelector('p:nth-of-type(3)').textContent.replace('Price: ', '').replace(' VND', ''));

                if (buyNumber > amount) {
                    valid = false;
                    item.classList.toggle('invalid');
                    item.classList.toggle('selected');
                    setTimeout(() => {
                        item.classList.toggle('invalid');
                    }, 2000);
                } else {
                    selectedItems.push(item.getAttribute('data-id'));
                    itemNumber.push(buyNumber);
                    totalAmount += buyNumber * price;
                }
            });

            if (valid) {
                document.getElementById('totalAmount').textContent = `Total Payment: ${totalAmount} VND`;
                document.getElementById('confirmationPopup').style.display = "block";

                document.getElementById('directPaymentBtn').onclick = function() {
                    document.getElementById('selectedItems').value = selectedItems.join(',');
                    document.getElementById('itemNumber').value = itemNumber.join(',');
                    document.getElementById('cartForm').submit();
                }
            } else {
                alert('Buy amount cannot be greater than available amount.');
            }
        }

        function closePopup() {
            document.getElementById('confirmationPopup').style.display = "none";
        }

        function removefromcart(uid, cid) {
            if (confirm('Are you sure you want to remove this item from your cart?')) {
                window.location.href = 'removecart.php?uid=' + uid + '&cid=' + cid;
            }
        }
    </script>
    </main>
</body>

</html>