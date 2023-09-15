<?php
// Проверка на администратора
session_start();

if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] != 1) {
    header("Location: ../index.php");
    exit();
}
?>
<?php
    // Подключение к базе данных
    require_once("conn.php");

    // Получение ID заказа из URL
    $order_id = $_GET['id'];

    // Получение данных заказа
    $order = mysqli_query($conn, "SELECT * FROM history_orders WHERE ho_id = $order_id");
    $order = mysqli_fetch_assoc($order);

    // Отображение формы для обновления заказа
    ?>
    <form action="update_order.php?id=<?= $order_id ?>" method="post">
        <p>date_order</p>
        <input type="date" name="date_order" value="<?= $order['date_order'] ?>" required> <br> <br>
        <p>user</p>
        <select name="user_id" required>
            <?php
                $users = mysqli_query($conn, "SELECT * FROM users");
                $users = mysqli_fetch_all($users);
                foreach ($users as $user) {
                    $selected = ($user[0] == $order['user_id']) ? 'selected' : '';
                    echo "<option value='".$user[0]."' ".$selected.">".$user[1]."</option>";
                }
            ?>
        </select> <br> <br>
        <p>cost</p>
        <input type="text" name="cost" value="<?= $order['cost'] ?>" required> <br> <br>
        <button type="submit">Обновить</button>
    </form>
    <?php

    // Обновление заказа в базе данных
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $date_order = $_POST['date_order'];
        $user_id = $_POST['user_id'];
        $cost = $_POST['cost'];

        $query = "UPDATE history_orders SET date_order = '$date_order', user_id = '$user_id', cost = '$cost' WHERE ho_id = $order_id";
        mysqli_query($conn, $query);

        // Перенаправление на страницу с историей заказов
        header('Location: ../admin.php');
    }
?>
