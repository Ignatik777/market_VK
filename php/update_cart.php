
<?php
session_start();
require_once("conn.php");

$userId = $_SESSION["user_id"];
$product_id = $_POST['product_id'];
$action = $_POST['action'];

$sql = "SELECT * FROM basket WHERE product_id = '$product_id' AND user_id = '$userId'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  $update_sql = "UPDATE basket SET available = available + 1 WHERE product_id = '$product_id' AND user_id = '$userId'";
  $update_result = mysqli_query($conn, $update_sql);

  if ($update_result) {
    $data = [
      'product_id' => $product_id,
      'available' => 1,
    ];
    echo json_encode($data);
  } else {
    echo '{"error": "Ошибка при обновлении товара"}';
  }
} else {
  $insert_sql = "INSERT INTO basket (product_id, available, user_id) VALUES ('$product_id', 1, '$userId')";
  $insert_result = mysqli_query($conn, $insert_sql);

  if ($insert_result) {
    $data = [
      'product_id' => $product_id,
      'available' => 1,
    ];
    echo json_encode($data);
  } else {
    echo '{"error": "Ошибка при добавлении товара в корзину"}';
  }
}
?>