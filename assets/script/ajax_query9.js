$(document).ready(function() {
    $.ajax({
        url: "./php/query9.php",
        type: "post",
        success: function(response) {
            $("#productsTable").html(response);
        }
    });
});