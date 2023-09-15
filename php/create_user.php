<?php
// Проверка на администратора
session_start();

if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: ../index.php");
    exit();
}
?>
<?php

require_once("conn.php"); // Подключение к базе данных

$email = $_POST['email'];
$name = $_POST['name'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Хеширование пароля
$isAdmin = $_POST['isAdmin'];

$query = "INSERT INTO users (email, name, password, isAdmin) 
          VALUES ('$email', '$name', '$password', $isAdmin)";

$result = mysqli_query($conn, $query);

header('Location: ../admin.php');
?>