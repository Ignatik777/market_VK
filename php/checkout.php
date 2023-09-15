<?php
session_start();
require_once("conn.php");

if (isset($_SESSION['user_id'])) {
  $userId = $_SESSION['user_id'];
  $orderDate = $_POST['orderDate'];
  $totalPrice = $_POST['totalPrice'];

  // Добавление записи в таблицу history_orders
  $sqlOrder = "INSERT INTO history_orders (user_id, order_date, total_price) VALUES ('$userId', '$orderDate', $totalPrice)";
  $resultOrder = mysqli_query($conn, $sqlOrder);
  
  if ($resultOrder) {
    $orderId = mysqli_insert_id($conn);
    $products = $_POST['products'];

    // Добавление записей о товарах в заказе в таблицу history_orders
    foreach ($products as $product) {
      $productId = $product['productId'];
      $quantity = $product['quantity'];
      $totalPricePerItem = $product['totalPricePerItem'];

      // Обновление значения available в таблице products
      $sqlUpdateAvailable = "UPDATE products SET available = available - $quantity WHERE product_id = $productId";
      mysqli_query($conn, $sqlUpdateAvailable);

      // Добавление записи о товаре в заказе в таблицу order_items
      $sqlInsertItem = "INSERT INTO order_items (order_id, product_id, quantity, total_price) VALUES ($orderId, $productId, $quantity, $totalPricePerItem)";
      mysqli_query($conn, $sqlInsertItem);
    }

    echo "Order placed successfully.";
  } else {
     echo "Error placing order.";
  }
}
else {
  echo "User not logged in.";
}
?>