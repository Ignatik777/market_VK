<?php
session_start();
include 'conn.php'; // Подключение к базе данных

// Получение данных пользователя, например, из сессии
$userId = $_SESSION['user_id'];

// Получение истории заказов пользователя
$query = "SELECT * FROM history_orders WHERE user_id = $userId";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $ho_id = $row['ho_id'];
    $date_order = $row['date_order'];
    $cost = $row['cost'];

    // Отобразить данные заказов
    echo "<p>Заказ #$ho_id, Дата заказа: $date_order, Сумма: $cost руб.</p>";
  }
} else {
  echo "<p>У вас еще нет заказов.</p>";
}

?>