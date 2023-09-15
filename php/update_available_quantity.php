<?php
session_start();

require_once 'conn.php';

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
} else {
    echo 'Ошибка: Не установлен идентификатор пользователя';
    exit;
}

$productId = $_POST['productId'];
$quantity = $_POST['quantity'];

if (isset($_POST['action'])) {
    $action = $_POST['action'];
} else {
    echo 'Ошибка: Не указано действие';
    exit;
}

if (isset($_POST['basketId'])) {
    $basketId = $_POST['basketId'];
} else {
    echo 'Ошибка: Не указан идентификатор корзины';
    exit;
}

// Обновление записи в БД, в зависимости от действия
if ($action === 'add') {
    $sql_update = "UPDATE basket SET available = available + $quantity WHERE basket_id = $basketId AND product_id = $productId";
} elseif ($action === 'remove') {
    $sql_update = "UPDATE basket SET available = available - $quantity WHERE basket_id = $basketId AND product_id = $productId";
} elseif ($action === 'delete') {
  $sql_update = "DELETE FROM basket WHERE basket_id = $basketId AND product_id = $productId";
}

$result_update = mysqli_query($conn, $sql_update);

// Проверка результата выполнения запроса
if ($result_update) {
    echo 'Успешно обновлено';
} else {
    echo 'Ошибка при обновлении';
}

mysqli_close($conn);
?>