<?php
// Проверка на администратора
session_start();

?>
<?php
require_once("conn.php");

$sql = "SELECT * FROM products WHERE expiration_date >= CURDATE() AND expiration_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["product_id"]."</td>
                <td>".$row["category_id"]."</td>
                <td>".$row["name"]."</td>
                <td>".$row["price"]."</td>
                <td>".$row["supplier_id"]."</td>
                <td>".$row["expiration_date"]."</td>
                <td>".$row["available"]."</td>
                <td>".$row["img"]."</td>
                <td>".$row["isGood"]."</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='9'>0 results</td></tr>";
}