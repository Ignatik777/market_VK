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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = $_POST["category_id"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $supplier_id = $_POST["supplier_id"];
    $expiration_date = $_POST["expiration_date"];
    $available = $_POST["available"];
    $isGood = $_POST["isGood"];

    // Загрузка файла изображения
    $img = $_FILES["img"]["name"];
    $img_tmp = $_FILES["img"]["tmp_name"];
    $img_path = "../assets/img/prod-cards/$img";
    move_uploaded_file($img_tmp, $img_path);

    // Вставка данных в таблицу "products"
    mysqli_query($conn, "INSERT INTO products (category_id, name, price, supplier_id, expiration_date, available, img, isGood) VALUES ('$category_id', '$name', '$price', '$supplier_id', '$expiration_date', '$available', './assets/img/prod-cards/$img', '$isGood')");

    // Редирект на страницу продуктов
    header("Location: ../admin.php");
    exit();
}
?>