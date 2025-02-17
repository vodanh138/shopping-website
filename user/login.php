<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./style1/login.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <h2>Login</h2>

  <form id="Login_form" action="./user/login_processing.php" method="post">
  
    <div class="input__field">
      <input id="username" type="text" placeholder="Username" name="username" />
    </div>
    <div class="input__field">
      <input id="password" type="password" placeholder="Password" name="password" />
    </div>
    <?php
    if (isset($_SESSION['uid']))
      header("Location: index.php");
    if (isset($_GET["ic"]) && $_GET["ic"] == 0) {
      echo '<div id="error-pass" class="error-pass" style=color:red>*Username or password incorrect</div><br>';
    }
    ?>
    <div id="error-pass" class="error-pass" style=color:red></div>
    <div id="error-mess" class="error-mess" style=color:red>*Your password must contain at least: </div>
    <div id="error-length" class="error-length" style=color:red><span>&#10060;</span>8 characters
    </div>
    <div id="error-upper" class="error-upper" style=color:red><span>&#10060;</span>1 uppercase letter
    </div>
    <div id="error-num" class="error-num" style=color:red><span>&#10060;</span>1 number</div>
    <div id="error-special" class="error-special" style=color:green><span>&#10004;</span>*Your password must contain
      only letters and numbers</div>
    <button type="submit" class="btn-login" name="btn-login">Login</button>
  </form>
    <br><br><br><br>
  <script src="./js/login.js"></script>
</body>

</html>