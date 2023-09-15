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

    // Получение ID заказа из URL
    $order_id = $_GET['id'];

    // Удаление заказа из таблицы history_orders
    $query = "DELETE FROM history_orders WHERE ho_id = $order_id";
    mysqli_query($conn, $query);

    // Перенаправление на страницу с историей заказов
    header('Location: ../admin.php');
?>