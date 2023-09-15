$(document).ready(function() {
    $("#categoryForm").submit(function(event) {
        event.preventDefault();
        var category_id = $("#category_name").val();
        $.ajax({
            url: "./php/query6.php",
            type: "post",
            data: {category_id: category_id},
            success: function(response) {
                $("#resultTable").html(response);
            }
        });
    });
});
