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
$user_id = $_POST['user_id'];

$sql = "SELECT * FROM history_orders WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["ho_id"]."</td>
                <td>".$row["date_order"]."</td>
                <td>".$row["user_id"]."</td>
                <td>".$row["cost"]."</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4'>0 results</td></tr>";
}

?>