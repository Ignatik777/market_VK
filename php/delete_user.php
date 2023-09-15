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

$id = $_GET['id'];

$query = "DELETE FROM users WHERE ID_User = $id";

$result = mysqli_query($conn, $query);

header('Location: ../admin.php');


?>