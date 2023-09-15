<?php
// Проверка на администратора
session_start();

if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: ../index.php");
    exit();
}
?>
<?php

require_once('conn.php');

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $isAdmin = $_POST['isAdmin'];

    $query = "UPDATE users 
              SET email = '$email', name = '$name', password = '$password', isAdmin = $isAdmin
              WHERE ID_User = $id";

    $result = mysqli_query($conn, $query);

    if ($result) {
        header('Location: ../admin.php');
    } else {
        echo "Ошибка при обновлении пользователя: " . mysqli_error($conn);
    }
} else {
    // Получение информации о пользователе
    $query = "SELECT * FROM users WHERE ID_User = $id";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    // Форма для обновления пользователя
    echo '<h3>Изменение пользователя</h3>';
    echo '<form action="update_user.php?id='.$id.'" method="post">';
    echo '<p>email</p>';
    echo '<input type="email" name="email" value="'. $user['email'] .'" required> <br> <br>';
    echo '<p>name</p>';
    echo '<input type="text" name="name" value="'. $user['name'] .'" required> <br> <br>';
    echo '<p>password</p>';
    echo '<input type="password" name="password" value="'. $user['password'] .'" required> <br> <br>';
    echo '<p>isAdmin</p>';
    echo '<select name="isAdmin" required>';
    echo '<option value="0" '. ($user['isAdmin'] == 0 ? 'selected' : '') .'>Нет</option>';
    echo '<option value="1" '. ($user['isAdmin'] == 1 ? 'selected' : '') .'>Да</option>';
    echo '</select> <br> <br>';
    echo '<input type="submit" value="Изменить">';
    echo '</form>';
}


?>
