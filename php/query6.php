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
$category_id = $_POST['category_id'];

$sql = "SELECT * FROM products WHERE category_id = $category_id";
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

?>