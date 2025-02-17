<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
</head>

<body>
    <div class="logo-con">
        <a href="index.php?page=home">
            <div class="logo-container">
                <img src="./asset/hcmut.png">
            </div>
        </a>
        <div class="link">
            <p>
                Welcome to MSW
            </p>
            <?php
            session_start();
            if (isset($_SESSION['ori_username'])) {

                $username = $_SESSION['ori_username'];
                echo '<div class = "user_info">
                            <a href = "index.php?page=logout">
                                <img src="./asset/user.png">';
                echo "$username";
                echo '</a>
                        </div>';
                echo '' .
                    // <div class = "sproduct">
                    //     <a href="./products/products.php">Search Product Lazy</a>
                    // </div>
            
                    '<div class = "mproduct">
                    <a href="./products/my_product.php">My Item</a>
                </div>
                    
    
                    <div class = "aproduct">
                        <a href="./products/add_product.php">Add Item</a>
                    </div>
    
                    <div class = "sproduct">
                        <a href="./products/paging_products.php">Search Item</a>
                    </div>';
            } else {
                echo '  <div class="login">
                            <a href="index.php?page=login">Login</a>
                        </div>
                        <a href="index.php?page=register">Register</a>
                        <a href="./products/paging_products.php">Products</a>';
            }

            ?>

            <a href="./products/home.php">Home</a>
        </div>
    </div>
</body>

</html>