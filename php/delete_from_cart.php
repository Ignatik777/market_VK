<?php
// Подключение к базе данных
require_once("conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $basketId = $_POST['basketId'];

  // Удаление записи о товаре из корзины
  $query = "DELETE FROM basket WHERE basket_id = $basketId";

  if (mysqli_query($conn, $query)) {
    echo "Товар успешно удален из корзины.";
  } else {
    echo "Ошибка при удалении товара из корзины: " . mysqli_error($conn);
  }
}

?>