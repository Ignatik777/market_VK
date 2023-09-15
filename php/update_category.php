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
    // Получение ID категории из параметра URL
    $category_id = $_GET['id'];

    // Если форма была отправлена
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Получение новых данных из формы
        $new_name = $_POST['name'];

        // Обновление записи в базе данных
        $query = "UPDATE categories SET name = '$new_name' WHERE ID_category = $category_id";
        mysqli_query($conn, $query);

        // Перенаправление на главную страницу или другую страницу, где отображается таблица категорий
        header('Location: ../admin.php');
        exit;
    }

    // Получение текущих данных категории по ее ID
    $category = mysqli_query($conn, "SELECT * FROM categories WHERE ID_category = $category_id");
    $category = mysqli_fetch_assoc($category);
?>

<form action="" method="post">
    <p>name</p>
    <input type="text" name="name" value="<?= $category['name'] ?>" required> <br> <br>
    <button type="submit">Сохранить</button>
</form>