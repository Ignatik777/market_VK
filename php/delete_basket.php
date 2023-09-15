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

if(isset($_GET['id'])) {
    $basket_id = $_GET['id'];
    
    $delete_query = "DELETE FROM basket WHERE basket_id = $basket_id";
    mysqli_query($conn, $delete_query);
    
    header("Location: ../admin.php");
    exit();
}
?>