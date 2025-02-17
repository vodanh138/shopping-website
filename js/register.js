document.getElementById("register_form").addEventListener("input", function (event) {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var email = document.getElementById("email").value;
    var regex = /^[a-zA-Z0-9]*$/;

    if (!regex.test(password)) {
      document.getElementById("error-special").innerHTML= '<div id="error-special" class="error-special" style=color:red><span>&#10060;</span>*Your password must contain only letters and numbers</div>';
    } else {
      document.getElementById("error-special").innerHTML = '<div id="error-special" class="error-special" style=color:green><span>&#10004;</span>*Your password must contain only letters and numbers</div>';
    }

    if (password.length < 8 || !(/[A-Z]/.test(password)) || !(/[0-9]/.test(password))) {
      document.getElementById("error-mess").innerHTML = '<div id="error-mess" class="error-mess" style = color:red>*Your password must contain at least: </div>';
      if (password.length < 8)
        document.getElementById("error-length").innerHTML = '<div id="error-length" class="error-length"style = color:red><span >&#10060;</span>8 characters</div>';
      else
        document.getElementById("error-length").innerHTML = '<div id="error-length" class="error-length"style = color:green><span >&#10004;</span>8 characters</div>';
      if (!(/[A-Z]/.test(password)))
        document.getElementById("error-upper").innerHTML = '<div id="error-upper" class="error-upper"style = color:red><span >&#10060;</span>1 uppercase letter</div>';
      else
        document.getElementById("error-upper").innerHTML = '<div id="error-upper" class="error-upper"style = color:green><span >&#10004;</span>1 uppercase letter</div>';

      if (!(/[0-9]/.test(password)))
        document.getElementById("error-num").innerHTML = '<div id="error-num" class="error-num"style = color:red><span >&#10060;</span>1 number</div>';
      else
        document.getElementById("error-num").innerHTML = '<div id="error-num" class="error-num"style = color:green><span >&#10004;</span>1 number</div>';

    }
    else {
      document.getElementById("error-mess").innerText = "";
      document.getElementById("error-length").innerHTML = '<div id="error-length" class="error-length"style = color:green><span >&#10004;</span>8 characters</div>';
      document.getElementById("error-upper").innerHTML = '<div id="error-upper" class="error-upper"style = color:green><span >&#10004;</span>1 uppercase letter</div>';
      document.getElementById("error-num").innerHTML = '<div id="error-num" class="error-num"style = color:green><span >&#10004;</span>1 number</div>';
    }

  })
  document.getElementById("register_form").addEventListener("submit", function (event) {
    event.preventDefault();

    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;
    var email = document.getElementById("email").value;
    var regex = /^[a-zA-Z0-9]*$/;
    if (!username || !email || !password) {
      document.getElementById("error-mess").innerText = "*Please enter all the requested information";
    }
    else if (password.length < 8 || !(/[A-Z]/.test(password)) || !(/[0-9]/.test(password)) || !regex.test(password)) {
      document.getElementById("error-mess").innerText = "*Your input is not valid";
    } else {
      this.submit();
    }
  });