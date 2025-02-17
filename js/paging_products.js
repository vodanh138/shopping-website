document.getElementById("item_num").addEventListener("change",function(){
    document.getElementById("searching_form").submit();
});

$(document).ready(function () {
    $('#search_bar').on('input', function () {
        var searchQuery = $(this).val();
        if (searchQuery.length > 0) {
            $.ajax({
                url: 'search_suggestions.php',  // Ensure this is the correct path to the script
                method: 'GET',
                data: { query: searchQuery },
                success: function (data) {
                    $('#search-suggestions').html(data).show();
                }
            });
        } else {
            $('#search-suggestions').hide();
        }
    });
});