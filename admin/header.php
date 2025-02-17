<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style1/index.css" />
    <title>Document</title>
</head>

<body>
    <div class="logo-con">
        <a href="../index.php?page=home">
            <div class="logo-container">
                <img src="../asset/hcmut.png">
            </div>
        </a>
        <div class="link">
            <p>
                Welcome to MSW
            </p>
            <?php
            session_start();
            if (isset($_SESSION['ori_username'])) {
                if (isset($_SESSION['role']) && $_SESSION['role'] === 'user'){
                    echo '  <script>
                                alert("You are not admin");
                                window.location.href = "../index.php";
                            </script>';
                }
                $username = $_SESSION['ori_username'];
                echo '<div class = "user_info">
                            <a href = "">
                                <img src="../asset/user.png">';
                echo "$username";
                echo '</a>
                            <div class="dropdown-content">
                              <a href="profile.php">Profile</a>
                              <a href="../index.php?page=logout">Logout</a>
                            </div>
                        </div>';
                echo '' .
                    // <div class = "sproduct">
                    //     <a href="./products/products.php">Search Product Lazy</a>
                    // </div>
                    '
                    <div class = "sproduct">
                        <a href="manageItems.php">Manage Items</a>
                    </div>';
            } else {
                echo '  <div class="login">
                            <a href="../index.php?page=login">Login</a>
                        </div>
                        <a href="../index.php?page=register">Register</a>
                        <a href="paging_products.php">Products</a>';
            }

            ?>

            <a href="adminDashboard.php">Manage Users</a>
        </div>
    </div>
</body>

</html>