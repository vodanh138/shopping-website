<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./style1/register.css" />
</head>

<body>
  <h2>Register</h2>
  <form id="register_form" action="user/register_processing.php" method="post">
    <div class="input__field">
      <input id="username" type="text" placeholder="Username" name="username" />
    </div>
    <div class="input__field">
      <input id="email" type="text" placeholder="Email" name="email" />
    </div>
    <div class="input__field">
      <input id="password" type="password" placeholder="Password" name="password" />
    </div>
    <div id="error-mess" class="error-mess" style=color:red>*Your password must contain at least: </div>
    <div id="error-length" class="error-length" style=color:red><span>&#10060;</span>8 characters
    </div>
    <div id="error-upper" class="error-upper" style=color:red><span>&#10060;</span>1 uppercase letter
    </div>
    <div id="error-num" class="error-num" style=color:red><span>&#10060;</span>1 number</div>
    <div id="error-special" class="error-special" style=color:green><span>&#10004;</span>*Your password must contain
      only letters and numbers</div>
    <button type="submit" class="btn-register" name="btn-register">Register</button>
  </form>

  <script src="./js/register.js"></script>

</body>

</html>