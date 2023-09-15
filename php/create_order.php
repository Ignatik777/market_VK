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
    // Получение данных из формы
    $date_order = $_POST['date_order'];
    $user_id = $_POST['user_id'];
    $cost = $_POST['cost'];

    // Вставка новой записи в таблицу history_orders
    $query = "INSERT INTO history_orders (date_order, user_id, cost) VALUES ('$date_order', '$user_id', '$cost')";
    mysqli_query($conn, $query);

    // Перенаправление на страницу с историей заказов
    header('Location: ../admin.php');
?>