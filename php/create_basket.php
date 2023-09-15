<?php
// Проверка на администратора
session_start();

if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: ../index.php");
    exit();
}
?>
<?php
require_once("conn.php");

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];
    $available = $_POST['available'];

    $insert_query = "INSERT INTO basket (user_id, product_id, available) VALUES ('$user_id', '$product_id', '$available')";
    mysqli_query($conn, $insert_query);

    header("Location: ../admin.php");
    exit();
}
?>