<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style1/products.css" />
    <link rel="stylesheet" href="../style1/paging_products.css" />
    <title>Document</title>
</head>

<body style="display: flex;
    flex-direction: column;
    min-height: 100vh;">
    <?php
    include_once ("header.php");
    ?>
    <div style="flex: 1;">
        <p>Top viewed Item:</p><br>
    
    <?php
    require "../database/connect.php";
    $sql = "SELECT *
        FROM product_table
        Where uid != 1
        ORDER BY view DESC
        LIMIT 4;
        ";
    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) > 0) {
        echo '<div class="page_display" >';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<a  href="item_info.php?pid=' . $row["pid"] . '"class="product_display">
                <img src="' . $row['image'] . '"> <br>' .
                "<p>Product's name:</p>" .
                '<p>' . $row['pname'] . '</p><br>
                <p>Price: ' . $row['price'] . ' VND </p>
            </a>';
        }
        echo '</div>';
    }
    ?>
    </div>
    <?php
    include_once ("footer.php");
    ?>
</body>

</html>