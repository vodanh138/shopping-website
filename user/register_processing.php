<?php
require '../database/connect.php';
if (isset($_POST['username'], $_POST['email'], $_POST['password'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $regex = '/^[a-zA-Z0-9]*$/';

    $md5_username = md5($username);
    $check = "SELECT * from user_table Where username = '$md5_username'";
    $search = $con->query($check);
    if ($search->num_rows > 0) {
        echo "The username already exist, please choose another";
    }
    else if (empty($username) || empty($email) || empty($password)) {
        echo "Please enter all the requested information <br>";
    } else if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match($regex, $password)) {
        echo "Your input is not valid <br>";
    } else {
        echo "Your password";
        echo "<pre>";
        print_r($_POST);
        $sql = "INSERT INTO user_table (username, email, password, ori_username,role) VALUES (md5('$username'), '$email', md5('$password'), '$username','user')";
        if ($con->query($sql) === TRUE) {
            echo "Register successfull";
            header("Location: ../index.php");
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
        }
    }
} else {
    echo " fail";
}
$con->close();
?>