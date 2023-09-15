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

    if(isset($_POST['submit'])) {
        $user_id = $_POST['user_id'];
        $product_id = $_POST['product_id'];
        $available = $_POST['available'];

        $update_query = "UPDATE basket SET user_id='$user_id', product_id='$product_id', available='$available' WHERE basket_id=$basket_id";
        mysqli_query($conn, $update_query);

        header("Location: ../admin.php");
        exit();
    }
    
    $basket_query = "SELECT * FROM basket WHERE basket_id=$basket_id";
    $basket_result = mysqli_query($conn, $basket_query);
    $basket = mysqli_fetch_assoc($basket_result);
    
    $users_query = "SELECT * FROM users";
    $users_result = mysqli_query($conn, $users_query);
    
    $products_query = "SELECT * FROM products";
    $products_result = mysqli_query($conn, $products_query);
}
?>

<h2>Изменить запись в корзине</h2>
<form action="" method="post">
    <p>Пользователь:</p>
    <select name="user_id" required>
        <?php
        while($user = mysqli_fetch_assoc($users_result)) {
            if($user['ID_User'] == $basket['user_id']) {
                echo "<option value='".$user['ID_User']."' selected>".$user['name']."</option>";
            } else {
                echo "<option value='".$user['ID_User']."'>".$user['name']."</option>";
            }
        }
        ?>
    </select>
    <br><br>
    <p>Продукт:</p>
    <select name="product_id" required>
        <?php
        while($product = mysqli_fetch_assoc($products_result)) {
            if($product['product_id'] == $basket['product_id']) {
                echo "<option value='".$product['product_id']."' selected>".$product['name']."</option>";
            } else {
                echo "<option value='".$product['product_id']."'>".$product['name']."</option>";
            }
        }
        ?>
    </select>
    <br><br>
    <p>Доступность:</p>
    <input type="text" name="available" value="<?php echo $basket['available']; ?>" required>
    <br><br>
    <input type="submit" name="submit" value="Изменить">
</form>