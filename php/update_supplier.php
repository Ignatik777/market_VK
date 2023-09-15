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
    // Получение ID поставщика из параметра URL
    $supplier_id = $_GET['id'];

    // Если форма была отправлена
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Получение новых данных из формы
        $new_name = $_POST['name'];

        // Обновление записи в базе данных
        $query = "UPDATE suppliers SET name = '$new_name' WHERE supplier_id = $supplier_id";
        mysqli_query($conn, $query);

        // Перенаправление на главную страницу или другую страницу, где отображается таблица "Поставщики"
        header('Location: ../admin.php');
        exit;
    }

    // Получение текущих данных поставщика по его ID
    $supplier = mysqli_query($conn, "SELECT * FROM suppliers WHERE supplier_id = $supplier_id");
    $supplier = mysqli_fetch_assoc($supplier);
?>

<form action="" method="post">
    <p>name</p>
    <input type="text" name="name" value="<?= $supplier['name'] ?>" required> <br> <br>
    <button type="submit">Сохранить</button>
</form>