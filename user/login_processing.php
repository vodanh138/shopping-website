<?php
require "../database/connect.php";
if (isset($_POST['username'], $_POST['password'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $regex = '/^[a-zA-Z0-9]*$/';

    if (empty($username) || empty($password)) {
        echo "Please enter all the requested information <br>";
    } else if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match($regex, $password)){
        echo "Your input is not valid <br>";
    }
    else {
        $md5_username = md5($username);
        $md5_password = md5($password);
        $sql = "SELECT * from user_table WHERE username = '$md5_username'AND password = '$md5_password'";
        $result = $con->query($sql);

        if ($result) {
            if (mysqli_num_rows($result) == 1) {
                $user_data = mysqli_fetch_assoc($result);
                session_start();
                $_SESSION['ori_username'] = $user_data['ori_username'];
                $_SESSION['uid'] = $user_data['uid'];
                $_SESSION['role'] = $user_data['role'];
                if ($user_data['role'] == 'admin')
                    header("Location: ../admin/adminDashboard.php");
                else
                    header("Location: ../index.php");
            } else {
                header("Location: ../index.php?page=login&ic=0");
            }
        } else {
            echo "Error: " . mysqli_error($con);
        }

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style1/login_processing.css" />
    <title>Website</title>
</head>

<body>

</body>

</html>