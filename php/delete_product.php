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

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $product_id = $_GET["id"];

    // Удаление продукта из таблицы "products"
    mysqli_query($conn, "DELETE FROM products WHERE product_id='$product_id'");

    // Редирект на страницу продуктов
    header("Location: ../admin.php");
    exit();
}
?>