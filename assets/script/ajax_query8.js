$(document).ready(function() {
    $("#dateForm").submit(function(event) {
        event.preventDefault();
        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();
        $.ajax({
            url: "./php/query8.php",
            type: "post",
            data: {start_date: start_date, end_date: end_date},
            success: function(response) {
                $("#historyTable").html(response);
            }
        });
    });
});