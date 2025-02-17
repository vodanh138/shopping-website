<?php
require "../database/connect.php";

if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];
    $sql = "SELECT pname FROM product_table WHERE pname LIKE '%$searchQuery%' LIMIT 5";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<a href="?search_bar=' . $row['pname'].'" class="search-suggestion-item">' . $row['pname'] . '</a>';
        }
    } else {
        echo '<div class="search-suggestion-item">No results found</div>';
    }
}
