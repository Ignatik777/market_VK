<?php
// Проверка на администратора
session_start();

?>
<?php
require_once("conn.php");
$sql = "SELECT suppliers.name FROM suppliers INNER JOIN products ON suppliers.supplier_id = products.supplier_id WHERE products.expiration_date >= CURDATE() AND products.expiration_date <= DATE_ADD(CURDATE(), INTERVAL 3 DAY)";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["name"]."</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='1'>0 results</td></tr>";
}