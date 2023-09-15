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

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $supplier_id = $_POST['supplier_id'];
    $expiration_date = $_POST['expiration_date'];
    $available = $_POST['available'];
    $isGood = $_POST['isGood'];

    // Получение текущего изображения продукта
    $query = "SELECT img FROM products WHERE product_id = $id";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);
    $currentImg = $product['img'];

    // Загрузка нового файла изображения, если он был выбран
    if ($_FILES['img']['name'] != "") {
        $targetDir = "../assets/img/prod-cards/";
        $filename = basename($_FILES['img']['name']);
        $targetFile = $targetDir . $filename;
        $newImg = "./assets/img/prod-cards/" . $filename;

        // Если текущее изображение существует, удалите его
        if (file_exists($currentImg)) {
            unlink($currentImg);
        }

        // Перемещение загруженного файла в папку prod-cards с новым именем
        move_uploaded_file($_FILES["img"]["tmp_name"], $targetFile);
    } else {
        // Если новое изображение не было выбрано, используйте текущее изображение
        $newImg = $currentImg;
    }

    // Обновление продукта в базе данных
    $query = "UPDATE products 
    SET category_id = $category_id, name = '$name', price = $price, supplier_id = $supplier_id, expiration_date = '$expiration_date', available = $available, img = '$newImg', isGood = $isGood 
    WHERE product_id = $id";

    $result = mysqli_query($conn, $query);

    if ($result) {
        header('Location: ../admin.php');
    } else {
        echo "Ошибка при изменении продукта";
    }

    mysqli_close($conn); // Закрытие соединения с базой данных
} else {
    // Поиск продукта в базе данных по идентификатору
    $query = "SELECT * FROM products WHERE product_id = $id";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);

    // Форма для обновления продукта
    echo '<h3>Изменение продукта</h3>';
    echo '<form action="update_product.php?id='.$id.'" method="post" enctype="multipart/form-data">';
    echo '<p>category</p>';
    echo '<select name="category_id" required>';
    $categories = mysqli_query($conn, "SELECT * FROM categories");
    $categories = mysqli_fetch_all($categories);
    foreach ($categories as $category) {
        $selected = $category[0] == $product['category_id'] ? 'selected' : '';
        echo '<option value="'. $category[0] .'" '. $selected .'>'. $category[1] .'</option>';
    }
    echo '</select> <br> <br>';
    echo '<p>name</p>';
    echo '<input type="text" name="name" value="'. $product['name'] .'" required> <br> <br>';
    echo '<p>price</p>';
    echo '<input type="text" name="price" value="'. $product['price'] .'" required> <br> <br>';
    echo '<p>supplier</p>';
    echo '<select name="supplier_id" required>';
    $suppliers = mysqli_query($conn, "SELECT * FROM suppliers");
    $suppliers = mysqli_fetch_all($suppliers);
    foreach ($suppliers as $supplier) {
        $selected = $supplier[0] == $product['supplier_id'] ? 'selected' : '';
        echo '<option value="'. $supplier[0] .'" '. $selected .'>'. $supplier[1] .'</option>';
    }
    echo '</select> <br> <br>';
    echo '<p>expiration_date</p>';
    echo '<input type="date" name="expiration_date" value="'. $product['expiration_date'] .'" required> <br> <br>';
    echo '<p>available</p>';
    echo '<input type="text" name="available" value="'. $product['available'] .'" required> <br> <br>';
    echo '<p>img</p>';
    echo '<input type="file" name="img"> <br> <br>';
    echo '<p>isGood</p>';
    echo '<input type="text" name="isGood" value="'. $product['isGood'] .'" required> <br> <br>';
    echo '<input type="submit" value="Изменить">';
    echo '</form>';
}

?>