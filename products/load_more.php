<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style1/products.css" />
    <title>Document</title>
</head>

<body>
    <main>
        <?php
        require "../database/connect.php";

        if ( isset($_POST["item_num"]) && isset($_POST["pagee"])) {
            echo$_POST["pagee"];
            $search = $_POST["search_bar"];
            $item_num = (int) $_POST["item_num"];
            $page = (int) $_POST["pagee"];
            $offset = ($page - 1) * $item_num;

            $search = mysqli_real_escape_string($con, $search);
            $sql = "SELECT * FROM product_table WHERE pname LIKE '%$search%' AND uid != 1 LIMIT $item_num OFFSET $offset";
            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {
                echo '<div class = "page_display">';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="product_display">
                    <img src="' . htmlspecialchars($row['image']) . '"> <br>
                    <p>Product\'s name:</p>
                    <p>' . htmlspecialchars($row['pname']) . '</p><br>
                    <p>Price: ' . htmlspecialchars($row['price']) . '</p>
                  </div>';
                }
                echo '</div>';
            } else {
                echo "<p>No more results</p>";
            }
        } else {
            echo "A";
        }
        ?>
    </main>
</body>

</html>