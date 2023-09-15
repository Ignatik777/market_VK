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
    // Получение ID категории из параметра URL
    $category_id = $_GET['id'];

    // Удаление записи из базы данных
    $query = "DELETE FROM categories WHERE ID_category = $category_id";
    mysqli_query($conn, $query);

    // Перенаправление на главную страницу или другую страницу, где отображается таблица категорий
    header('Location: ../admin.php');
    exit;
?>
