$(document).ready(function() {
    $.ajax({
        url: "./php/query10.php",
        type: "post",
        success: function(response) {
            $("#suppliersTable").html(response);
        }
    });
});