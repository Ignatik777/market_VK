<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['username']) && isset($_POST['password'])) {
    $name = $_POST['username'];
    $password = $_POST['password'];
    
    require_once("conn.php");
    
    // Запрос к базе данных для получения хэша пароля
    $hashQuery = "SELECT password FROM users WHERE name = '$name' LIMIT 1";
    $hashResult = $conn->query($hashQuery);
    
    if ($hashResult && $hashResult->num_rows === 1) {
      $hashRow = $hashResult->fetch_assoc();
      $hashedPassword = $hashRow['password'];
      
      // Сравнение паролей
      if (password_verify($password, $hashedPassword)) {
        // Пароль верный
        // Запрос к базе данных для получения других данных пользователя
        $userQuery = "SELECT * FROM users WHERE name = '$name' LIMIT 1";
        $userResult = $conn->query($userQuery);
        
        if ($userResult && $userResult->num_rows === 1) {
          $row = $userResult->fetch_assoc();
          // Установка сессии для хранения информации о входе пользователя
          $_SESSION['user_id'] = $row['ID_User'];
          $_SESSION['username'] = $row['name'];
          
          header('Location: ../lk.php'); // Перенаправление на личный кабинет
          exit();
        }
      } else {
        // Пароль неверный
        echo 'Неверное имя пользователя или пароль';
      }
    } else {
      // Ошибка при запросе к базе данных
      echo 'Ошибка при проверке пароля';
    }
    
    $conn->close();
  }
}
?>