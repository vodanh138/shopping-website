<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style1/products.css" />
    <link rel="stylesheet" href="../style1/paging_products.css" />
    <link rel="stylesheet" href="../style1/adminDashBoard.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Manage User</title>
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
                <input class="search_bar" name="search_bar" id="search_bar" type="text" placeholder="Searching...."
                    value="<?php echo isset($_GET['search_bar']) ? $_GET['search_bar'] : ''; ?>">
            </div>
            <div id="search-suggestions" class="search-suggestions"></div>
            <label>Number of users per page:</label>
            <select id="user_num" name="user_num" class="user_num">
                <option value="8" <?php if (isset($_GET['user_num']) && $_GET['user_num'] == 8)
                                        echo 'selected'; ?>>8
                </option>
                <option value="12" <?php if (isset($_GET['user_num']) && $_GET['user_num'] == 12)
                                        echo 'selected'; ?>>12
                </option>
                <option value="16" <?php if (isset($_GET['user_num']) && $_GET['user_num'] == 16)
                                        echo 'selected'; ?>>16
                </option>
                <option value="20" <?php if (isset($_GET['user_num']) && $_GET['user_num'] == 20)
                                        echo 'selected'; ?>>20
                </option>
            </select>
        </form>

        <form id="delete_form" method="post" action="processDeleteUser.php">
            <input type="hidden" name="delete_user_id" id="delete_user_id">
        </form>

        <main>
            <?php
            require "../database/connect.php";
            $users_per_page = isset($_GET['user_num']) ? (int) $_GET['user_num'] : 8;
            $current_page = isset($_GET['pagee']) ? (int) $_GET['pagee'] : 1;
            $offset = ($current_page - 1) * $users_per_page;


            $search = isset($_GET['search_bar']) ? $_GET['search_bar'] : '';
            $sql_count = "SELECT COUNT(*) as total FROM user_table WHERE ori_username LIKE '%$search%' AND role = 'user'";
            $result_count = mysqli_query($con, $sql_count);
            $row_count = mysqli_fetch_assoc($result_count);
            $total_users = $row_count['total'];

            $sql = "SELECT * FROM user_table WHERE ori_username LIKE '%$search%' AND role = 'user' LIMIT $users_per_page OFFSET $offset";
            echo "<p>Searching for: " . $search . '</p><br>';
            $result = mysqli_query($con, $sql);
            if (mysqli_num_rows($result) > 0) {
                echo '<div class="users_display" >';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="user_display">' .
                        "<p>User's name: " . $row['ori_username'] . "</p>" .
                        '<button type="button" onclick="deleteUser(' . $row['uid'] . ')"><i class="fas fa-trash-alt"></i> Delete</button>' .
                        '</div>';
                }
                echo '</div>';
                $total_pages = ceil($total_users / $users_per_page);
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
                            echo '<a href="?item_num=' . $users_per_page . '&pagee=' . $mid_num . '" class = "page_num">...' . $mid_num . '...</a>';
                            $pre_num = 0;
                        }
                        echo '<a href="?item_num=' . $users_per_page . '&pagee=' . $i . '"';
                        if ($current_page === $i)
                            echo 'class = "page_chosen"';
                        else
                            echo 'class = "page_num"';
                        echo '>' . $i . '</a>';
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
        </main>
    </div>
    <?php
    include_once("footer.php");
    ?>
    <script>
        function deleteUser(uid) {
            if (confirm("Are you sure you want to delete this user?")) {
                document.getElementById('delete_user_id').value = uid;
                document.getElementById('delete_form').submit();
            }
        }
    </script>
</body>

</html>