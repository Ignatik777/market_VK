
<?php
session_start();

require_once("php/conn.php");

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админка</title>
    <link rel="stylesheet" href="assets/style/admin.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/script/ajax_query6.js"></script>
    <script src="assets/script/ajax_query7.js"></script>
    <script src="assets/script/ajax_query8.js"></script>
    <script src="assets/script/ajax_query9.js"></script>
    <script src="assets/script/ajax_query10.js"></script>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <div class="user-info">
                <span class="username"><?php echo $_SESSION['username']; ?></span>
                <a href="php/logout.php" class="logout-btn">Выйти</a>
            </div>
            <div class="burger-menu">
                <div class="menu-icon"></div>
            </div>
            <ul class="menu">
                <li class="menu-item active" onclick="showContent('categories')" data-content="categories">Категории</li>
                <li class="menu-item" onclick="showContent('suppliers')" data-content="suppliers">Поставщики</li>
                <li class="menu-item" onclick="showContent('order-history')" data-content="order-history">История заказов</li>
                <li class="menu-item" onclick="showContent('products')" data-content="products">Продукты</li>
                <li class="menu-item" onclick="showContent('users')" data-content="users">Пользователи</li>
                <li class="menu-item" onclick="showContent('cart')" data-content="cart">Корзина</li>
                <li class="menu-item" onclick="showContent('requests')" data-content="requests">Запросы</li>
            </ul>
        </div>
        <div class="content">
        <div id="categories" class="content-item">
            <h2>Категории</h2>
            <!-- Здесь будет содержимое таблицы "Категории" -->
            <table>
                <tr>
                    <th>ID_category</th>
                    <th>name</th>
                </tr>
                <?php

                $categories = mysqli_query($conn, "SELECT * FROM categories");

                $categories = mysqli_fetch_all($categories);
                foreach ($categories as $category) {
                    ?>
                        <tr>
                            <td><?= $category[0] ?></td>
                            <td><?= $category[1] ?></td>
                            <td><a href="php/update_category.php?id=<?= $category[0] ?>">Изменить</a></td>
                            <td><a style="color: red;" href="php/delete_category.php?id=<?= $category[0] ?>">Удалить</a></td>
                        </tr>
                    <?php
                }
            ?>
            </table>

            <h3>Добавьте новую категорию</h3>
            <form action="php/create_category.php" method="post">
                <p>name</p>
                <input type="text" name="name" required> <br> <br>
                <button type="submit">Добавить 
            </form>
        </div>
        <div id="suppliers" class="content-item">
            <h2>Поставщики</h2>
            <!-- Здесь будет содержимое таблицы "Поставщики" -->
            <table>
                <tr>
                    <th>supplier_id</th>
                    <th>name</th>
                </tr>
                <?php

                $suppliers = mysqli_query($conn, "SELECT * FROM suppliers");

                $suppliers = mysqli_fetch_all($suppliers);
                foreach ($suppliers as $supplier) {
                    ?>
                        <tr>
                            <td><?= $supplier[0] ?></td>
                            <td><?= $supplier[1] ?></td>
                            <td><a href="./php/update_supplier.php?id=<?= $supplier[0] ?>">Изменить</a></td>
                            <td><a style="color: red;" href="php/delete_supplier.php?id=<?= $supplier[0] ?>">Удалить</a></td>
                        </tr>
                    <?php
                }
            ?>
            </table>

            <h3>Добавьте нового поставщика</h3>
            <form action="php/create_supplier.php" method="post">
                <p>name</p>
                <input type="text" name="name" required> <br> <br>
                <button type="submit">Добавить 
            </form>
        </div>
        <div id="order-history" class="content-item">
            <h2>История заказов</h2>
    <!-- Здесь будет содержимое таблицы "История заказов" -->
            <table>
                <tr>
                    <th>ho_id</th>
                    <th>date_order</th>
                    <th>user</th>
                    <th>cost</th>
                </tr>
                <?php
                $history = mysqli_query($conn, "SELECT * FROM history_orders");
                $history = mysqli_fetch_all($history);
                foreach ($history as $order) {
                $user_id = $order[2];
                $user = mysqli_query($conn, "SELECT name FROM users WHERE ID_User = $user_id");
                $user = mysqli_fetch_assoc($user);
                ?>
                <tr>
                    <td><?= $order[0] ?></td>
                    <td><?= $order[1] ?></td>
                    <td><?= $user['name'] ?></td>
                    <td><?= $order[3] ?></td>
                    <td><a href="php/update_order.php?id=<?= $order[0] ?>">Изменить</a></td>
                    <td><a style="color: red;" href="php/delete_order.php?id=<?= $order[0] ?>">Удалить</a></td>
                </tr>
                <?php
                    }
                ?>
            </table>
            <h3>Добавьте новый заказ</h3>
            <form action="php/create_order.php" method="post">
                <p>date_order</p>
                <input type="date" name="date_order" required> <br> <br>
                <p>user</p>
                <select name="user_id" required>
                    <?php
                        $users = mysqli_query($conn, "SELECT * FROM users");
                        $users = mysqli_fetch_all($users);
                        foreach ($users as $user) {
                            echo "<option value='".$user[0]."'>".$user[1]."</option>";
                        }
                    ?>
                </select> <br> <br>
                <p>cost</p>
                <input type="text" name="cost" required> <br> <br>
                <button type="submit">Добавить</button>
            </form>
        </div>
        <div id="products" class="content-item">
            <h2>Продукты</h2>
            <!-- Здесь будет содержимое таблицы "Продукты" -->
            <table>
                <tr>
                    <th>product_id</th>
                    <th>category</th>
                    <th>name</th>
                    <th>price</th>
                    <th>supplier</th>
                    <th>expiration_date</th>
                    <th>available</th>
                    <th>img</th>
                    <th>isGood</th>
                </tr>
                <?php
                $products = mysqli_query($conn, "SELECT * FROM products");
                $products = mysqli_fetch_all($products);
                foreach ($products as $product) {
                    $category_id = $product[1];
                    $category = mysqli_query($conn, "SELECT name FROM categories WHERE ID_category = $category_id");
                    $category = mysqli_fetch_assoc($category);
                    $supplier_id = $product[5];
                    $supplier = mysqli_query($conn, "SELECT suppliers.name FROM suppliers WHERE supplier_id = $supplier_id");
                    $supplier = mysqli_fetch_assoc($supplier);
                ?>
                <tr>
                    <td><?= $product[0] ?></td>
                    <td><?= $category['name'] ?></td>
                    <td><?= $product[2] ?></td>
                    <td><?= $product[3] ?></td>
                    <td><?= $product[5] ?></td>
                    <td><?= $product[4] ?></td>
                    <td><?= $product[6] ?></td>
                    <td><img src="<?= $product[7] ?>"></td>
                    <td><?= $product[8] ?></td>
                    <td><a href="php/update_product.php?id=<?= $product[0] ?>">Изменить</a></td>
                    <td><a style="color: red;" href="php/delete_product.php?id=<?= $product[0] ?>">Удалить</a></td>
                </tr>
                <?php
                    }
                ?>
            </table>
            <h3>Добавьте новый продукт</h3>
            <form action="php/create_product.php" method="post" enctype="multipart/form-data">
                <p>category</p>
                <select name="category_id" required>
                    <?php
                        $categories = mysqli_query($conn, "SELECT * FROM categories");
                        $categories = mysqli_fetch_all($categories);
                        foreach ($categories as $category) {
                            echo "<option value='".$category[0]."'>".$category[1]."</option>";
                        }
                    ?>
                </select> <br> <br>
                <p>name</p>
                <input type="text" name="name" required> <br> <br>
                <p>price</p>
                <input type="text" name="price" required> <br> <br>
                <p>supplier</p>
                <select name="supplier_id" required>
                    <?php
                        $suppliers = mysqli_query($conn, "SELECT * FROM suppliers");
                        $suppliers = mysqli_fetch_all($suppliers);
                        foreach ($suppliers as $supplier) {
                            echo "<option value='".$supplier[0]."'>".$supplier[1]."</option>";
                        }
                    ?>
                </select> <br> <br>
                <p>expiration_date</p>
                <input type="date" name="expiration_date" required> <br> <br>
                <p>available</p>
                <input type="text" name="available" required> <br> <br>
                <p>img</p>
                <input type="file" name="img" required> <br> <br>
                <p>isGood</p>
                <select name="isGood" required>
                    <option value="0">Нет</option>
                    <option value="1">Да</option>
                </select> <br> <br>
                <button type="submit">Добавить</button>
            </form>
        </div>
        <div id="users" class="content-item">
            <h2>Пользователи</h2>
            <?php
            // Получение списка пользователей
            $users = mysqli_query($conn, "SELECT * FROM users");
            $users = mysqli_fetch_all($users);
            ?>
            <table>
                <tr>
                    <th>ID_User</th>
                    <th>email</th>
                    <th>name</th>
                    <th>password</th>
                    <th>isAdmin</th>
                    <th>Изменить</th>
                    <th>Удалить</th>
                </tr>
                <?php
                foreach ($users as $user) {
                    ?>
                    <tr>
                        <td><?= $user[0] ?></td>
                        <td><?= $user[1] ?></td>
                        <td><?= $user[2] ?></td>
                        <td><?= $user[3] ?></td>
                        <td><?= $user[4] ?></td>
                        <td><a href="php/update_user.php?id=<?= $user[0] ?>">Изменить</a></td>
                        <td><a style="color: red;" href="php/delete_user.php?id=<?= $user[0] ?>">Удалить</a></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <h3>Добавьте нового пользователя</h3>
            <form action="php/create_user.php" method="post">
                <p>email</p>
                <input type="email" name="email" value="" required> <br> <br>
                <p>name</p>
                <input type="text" name="name" required> <br> <br>
                <p>password</p>
                <input type="password" name="password" value="" required> <br> <br>
                <p>isAdmin</p>
                <select name="isAdmin" required>
                    <option value="0">Нет</option>
                    <option value="1">Да</option>
                </select> <br> <br>
                <input type="submit" value="Создать">
            </form>
        </div>
            <div id="cart" class="content-item">
                <h2>Корзина</h2>
                <table>
                <tr>
                    <th>basket_id</th>
                    <th>name</th>
                    <th>name</th>
                    <th>available</th>
                </tr>
                <?php
                $basket = mysqli_query($conn, "SELECT * FROM basket");
                $basket = mysqli_fetch_all($basket);
                foreach ($basket as $basket) {
                    $user_id = $basket[1];
                    $user = mysqli_query($conn, "SELECT name FROM users WHERE ID_User = $user_id");
                    $user = mysqli_fetch_assoc($user);
                    $product_id = $basket[2];
                    $product = mysqli_query($conn, "SELECT name FROM products WHERE product_id = $product_id");
                    $product = mysqli_fetch_assoc($product);
                ?>
                <tr>
                    <td><?= $basket[0] ?></td>
                    <td><?= $user['name'] ?></td>
                    <td><?= $product['name'] ?></td>
                    <td><?= $basket[3] ?></td>
                    <td><a href="php/update_basket.php?id=<?= $basket[0] ?>">Изменить</a></td>
                    <td><a style="color: red;" href="php/delete_basket.php?id=<?= $basket[0] ?>">Удалить</a></td>
                </tr>
                <?php
                    }
                ?>
                </table>
                <h3>Добавьте новый продукт</h3>
                <form action="php/create_basket.php" method="post" enctype="multipart/form-data">
                    <p>username</p>
                    <select name="user_id" required>
                        <?php
                            $users = mysqli_query($conn, "SELECT * FROM users");
                            $users = mysqli_fetch_all($users);
                            foreach ($users as $user) {
                                echo "<option value='".$user[0]."'>".$user[1]."</option>";
                            }
                        ?>
                    </select> <br> <br>
                    <p>product_name</p>
                    <select name="product_id" required>
                        <?php
                            $products = mysqli_query($conn, "SELECT * FROM products");
                            $products = mysqli_fetch_all($products);
                            foreach ($products as $product) {
                                echo "<option value='".$product[0]."'>".$product[2]."</option>";
                            }
                        ?>
                    </select> <br> <br>
                    <p>available</p>
                    <input type="text" name="available" required> <br> <br>
                    <button type="submit">Добавить</button>
                </form>
            </div>
            <div id="requests" class="content-item">
        <h2>Запросы</h2>
        <h3>Запрос 1: SELECT * FROM products;</h3>
        <?php
            $sql_1 = "SELECT * FROM products";
            $result_1 = $conn->query($sql_1);

            if ($result_1->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Product ID</th><th>Category ID</th><th>Name</th><th>Price</th><th>Supplier ID</th><th>Expiration Date</th><th>Available</th><th>Image</th><th>Is Good</th></tr>";
                while($row = $result_1->fetch_assoc()) {
                    echo "<tr><td>".$row["product_id"]."</td><td>".$row["category_id"]."</td><td>".$row["name"]."</td><td>".$row["price"]."</td><td>".$row["supplier_id"]."</td><td>".$row["expiration_date"]."</td><td>".$row["available"]."</td><td>".$row["img"]."</td><td>".$row["isGood"]."</td></tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
        ?>

        <h3>Запрос 2: SELECT * FROM categories;</h3>
        <?php
            $sql_2 = "SELECT * FROM categories";
            $result_2 = $conn->query($sql_2);

            if ($result_2->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>ID</th><th>Name</th></tr>";
                while($row = $result_2->fetch_assoc()) {
                    echo "<tr><td>".$row["ID_category"]."</td><td>".$row["name"]."</td></tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
        ?>

        <h3>Запрос 3: SELECT * FROM suppliers;</h3>
        <?php
            $sql_3 = "SELECT * FROM suppliers";
            $result_3 = $conn->query($sql_3);

            if ($result_3->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Supplier ID</th><th>Name</th></tr>";
                while($row = $result_3->fetch_assoc()) {
                    echo "<tr><td>".$row["supplier_id"]."</td><td>".$row["name"]."</td></tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
        ?>

<h3>Запрос 4: SELECT * FROM users WHERE isAdmin = 0;</h3>
        <?php

            $sql_4 = "SELECT * FROM users WHERE isAdmin = 0";
            $result_4 = $conn->query($sql_4);

            if ($result_4->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>User ID</th><th>Email</th><th>Name</th><th>Password</th></tr>";
                while($row = $result_4->fetch_assoc()) {
                    echo "<tr><td>".$row["ID_User"]."</td><td>".$row["email"]."</td><td>".$row["name"]."</td><td>".$row["password"]."</td></tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
        ?>

        <h3>Запрос 5: SELECT * FROM history_orders;</h3>
        <?php

            $sql_5 = "SELECT * FROM history_orders";
            $result_5 = $conn->query($sql_5);

            if ($result_5->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Order ID</th><th>Date Order</th><th>User ID</th><th>Cost</th></tr>";
                while($row = $result_5->fetch_assoc()) {
                    echo "<tr><td>".$row["ho_id"]."</td><td>".$row["date_order"]."</td><td>".$row["user_id"]."</td><td>".$row["cost"]."</td></tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }
        ?>

        <h3>Запрос 6: SELECT * FROM products WHERE category_id = [category_id];</h3>
        <form id="categoryForm">
            <select name="category_name" id="category_name">
                <?php
                    $sql = "SELECT * FROM categories";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='".$row["ID_category"]."'>".$row["name"]."</option>";
                        }
                    }
                ?>
            </select>
            <input type="submit" value="Submit">
        </form>
        <table>
            <tr>
                <th>Product ID</th>
                <th>Category ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Supplier ID</th>
                <th>Expiration Date</th>
                <th>Available</th>
                <th>Image</th>
                <th>Is Good</th>
            </tr>
            <tbody id="resultTable">
                <!-- Здесь будут отображаться данные из запроса -->
            </tbody>
        </table>

        <h3>Запрос 7: SELECT * FROM history_orders WHERE user_id = [user_id];</h3>
        <form id="userForm">
            <select name="user_id" id="user_id">
                <?php

                    $sql = "SELECT * FROM users";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='".$row["ID_User"]."'>".$row["name"]."</option>";
                        }
                    }
                ?>
            </select>
            <input type="submit" value="Submit">
        </form>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Date Order</th>
                <th>User ID</th>
                <th>Cost</th>
            </tr>
            <tbody id="ordersTable">
                <!-- Здесь будут отображаться данные из запроса -->
            </tbody>
        </table>

        <h3>Запрос 8: SELECT * FROM history_orders WHERE date_order >= [start_date] AND date_order <= [end_date];</h3>
        <form id="dateForm">
            <input type="date" name="start_date" id="start_date" required>
            <input type="date" name="end_date" id="end_date" required>
            <input type="submit" value="Submit">
        </form>

        <table>
            <tr>
                <th>Order ID</th>
                <th>Date Order</th>
                <th>User ID</th>
                <th>Cost</th>
            </tr>
            <tbody id="historyTable">
                <!-- Здесь будут отображаться данные из запроса -->
            </tbody>
        </table>
        <h3>Запрос 9: SELECT * FROM products WHERE expiration_date >= CURDATE() AND expiration_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY);</h3>
        <table>
            <tr>
                <th>Product ID</th>
                <th>Category ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Supplier ID</th>
                <th>Expiration Date</th>
                <th>Available</th>
                <th>Image</th>
                <th>Is Good</th>
            </tr>
            <tbody id="productsTable">
                <!-- Здесь будут отображаться данные из запроса -->
            </tbody>
        </table>
        <h3>Запрос 10: SELECT suppliers.name FROM suppliers INNER JOIN products ON suppliers.supplier_id = products.supplier_id WHERE products.expiration_date >= CURDATE() AND products.expiration_date <= DATE_ADD(CURDATE(), INTERVAL 3 DAY);</h3>
        <table>
            <tr>
                <th>Supplier Name</th>
            </tr>
            <tbody id="suppliersTable">
                <!-- Здесь будут отображаться данные из запроса -->
            </tbody>
        </table>
    </div>
    <script src="assets/script/admin.js"></script>
</body>
</html>