
document.getElementById("add_form").addEventListener("submit", function (event) {
    event.preventDefault();

    var add_name = document.getElementById("add_name").value;
    var add_price = document.getElementById("add_price").value;
    var add_des = document.getElementById("add_des").value;
    var add_amount = document.getElementById("add_amount").value;
    var add_file = document.getElementById("add_file").value;
    
    if (!add_name || !add_price || !add_des || !add_amount || !add_file) {
      document.getElementById("miss_info").innerText = "*Please enter all the requested information";
      miss_info.style.color = 'red';
    }
    else {
      this.submit();
    }
  });
document.getElementById('add_file').addEventListener('change', function() {
    var fileInput = document.getElementById('add_file');
    var fileName = document.getElementById('file_name');
    fileName.textContent = fileInput.files[0].name + "  has been chosen";
});
