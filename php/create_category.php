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
    // Если форма была отправлена
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Получение данных из формы
        $name = $_POST['name'];

        // Вставка новой записи в базу данных
        $query = "INSERT INTO categories (name) VALUES ('$name')";
        mysqli_query($conn, $query);

        // Перенаправление на главную страницу или другую страницу, где отображается таблица категорий
        header('Location: ../admin.php');
        exit;
    }
?>

<form action="" method="post">
    <p>name</p>
    <input type="text" name="name" required> <br> <br>
    <button type="submit">Добавить</button>
</form>