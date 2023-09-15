<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['new-username']) && isset($_POST['new-email']) && isset($_POST['new-password'])) {
    $name = $_POST['new-username'];
    $email = $_POST['new-email'];
    $password = $_POST['new-password'];
    
    require_once("conn.php");
    
    // Проверка уникальности имени пользователя и электронной почты в базе данных
    $checkQuery = "SELECT * FROM users WHERE name = '$name' OR email = '$email' LIMIT 1";
    $checkResult = $conn->query($checkQuery);
    
    if ($checkResult && $checkResult->num_rows > 0) {
      echo 'Пользователь с таким именем или электронной почтой уже существует';
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      // Добавление нового пользователя в базу данных
    $insertQuery = "INSERT INTO users (email, name, password, isAdmin) VALUES ('$email', '$name', '$hashedPassword', 0)";
      
      if ($conn->query($insertQuery) === TRUE) {
        // Установка сессии для хранения информации о входе пользователя после регистрации
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['username'] = $name;
        
        header('Location: ../lk.php'); // Перенаправление на личный кабинет
        exit();
      } else {
        echo 'Ошибка при регистрации пользователя';
      }
    }
    
    $conn->close();
  }
}
?>