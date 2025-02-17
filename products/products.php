<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style1/products.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <?php
    include_once ("header.php");
    ?>
    <form id="searching_form" method="post">
        <div class="searching_form">
            <input class="search_bar" name="search_bar" id="search_bar" type="text" placeholder="Searching....">
            <button type="submit" name="btn_searching" class="btn_searching"> Search </button>
        </div>
        <label>Number of items per page:</label>
        <select id="item_num" name="item_num" class="item_num">
            <option value="6">6</option>
            <option value="9">9</option>
            <option value="12">12</option>
            <option value="15">15</option>
        </select>
        <select id="pagee" name="pagee" class="pagee" style="display:none">
            <option value="1"></option>
        </select>
    </form>
    <main>
        <?php
        include_once "load_more.php";
        ?>
        <!-- <?php
        require "../database/connect.php";
        if (isset($_POST["btn_searching"])) {
            $search = $_POST["search_bar"];
            $item_num = (int) $_POST["item_num"];
            $sql = "SELECT * FROM product_table WHERE pname LIKE '%$search%' AND uid != 1 LIMIT $item_num";
            $result = mysqli_query($con, $sql);
            echo "<p>Searching for: " . $search . '</p><br>';
            if (mysqli_num_rows($result) > 0) {
                echo '<div class = "page_display">';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class = "product_display">
                                    <img src = "' .
                        $row['image'] .
                        '"> <br>' .
                        "<p>Product's name:</p>" .
                        '<p>' . $row['pname'] . '</p><br>
                                    <p>Price: ' . $row['price'] . '$ </p>
                                </div>';
                }
                echo '</div>';
            } else {
                echo "<p>No result found</p>";
            }
        }
        include_once ("footer.php");
        ?> -->
    </main>

    <script>
        let pagee = 1; // Bắt đầu ở trang đầu tiên
        const item_num = $('#item_num').val();

        function loadMore() {
            const search_bar = $('#search_bar').val(); // Lấy giá trị của ô tìm kiếm mỗi lần tải thêm dữ liệu

            $.ajax({
                type: 'POST',
                url: 'load_more.php',
                data: {
                    search_bar: search_bar,
                    item_num: item_num,
                    pagee: pagee,
                },
                success: function (response) {
                    if (response.trim() !== "<p>No more results</p>") {
                        $('#main-content .page_display').append(response);
                        pagee++;
                    } else {
                        $(window).off('scroll', handleScroll);
                    }
                }
            });
        }

        function handleScroll() {
            if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
                loadMore();
            }
        }

        $(document).ready(function () {
            $(window).on('scroll', handleScroll);
        });
    </script>

</body>

</html>