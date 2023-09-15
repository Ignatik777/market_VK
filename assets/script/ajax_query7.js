$(document).ready(function() {
    $("#userForm").submit(function(event) {
        event.preventDefault();
        var user_id = $("#user_id").val();
        $.ajax({
            url: "./php/query7.php",
            type: "post",
            data: {user_id: user_id},
            success: function(response) {
                $("#ordersTable").html(response);
            }
        });
    });
});
