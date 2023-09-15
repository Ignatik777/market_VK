<?php
// Подключение к базе данных
session_start();
require_once("conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $totalAmount = $_POST['totalAmount'];
  $userId = $_SESSION['user_id'];

  // Получение товаров из корзины
  $query = "SELECT * FROM basket WHERE user_id = $userId";
  $result = mysqli_query($conn, $query);

  while ($row = mysqli_fetch_assoc($result)) {
    $productId = $row['product_id'];
    $quantity = $row['available'];

    // Обновление значения available в таблице products
    $query = "UPDATE products SET available = available - $quantity WHERE product_id = $productId";
    mysqli_query($conn, $query);
  }

  // Проверка, существует ли уже запись о пользователе в таблице истории заказов
  $query = "SELECT * FROM history_orders WHERE user_id = $userId";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) == 0) {
    // Если записи не существует, создать новую запись
    $query = "INSERT INTO history_orders (date_order, user_id, cost) VALUES (CURRENT_TIMESTAMP, $userId, $totalAmount)";
  } else {
    // Если запись уже существует, создать новую запись с обновленной суммой заказа
    $query = "INSERT INTO history_orders (date_order, user_id, cost) VALUES (CURRENT_TIMESTAMP, $userId, $totalAmount)";
  }

  if (mysqli_query($conn, $query)) {
    // Успешное сохранение заказа, теперь очищаем корзину
    $query = "DELETE FROM basket WHERE user_id = $userId";
    mysqli_query($conn, $query);

    echo "Заказ успешно сохранен.";
  } else {
    echo "Ошибка при сохранении заказа: " . mysqli_error($conn);
  }
}
?>