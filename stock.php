<?php
session_start();
require_once("php/conn.php");


// Запрос всех категорий
$categories_sql = "SELECT ID_Category, name FROM categories";
$result_categories = $conn->query($categories_sql);

// Создание массива для категорий
$categories = array();

// Добавление категорий в массив
if ($result_categories->num_rows > 0) {
    while ($row = $result_categories->fetch_assoc()) {
        $categories[] = $row;
    }
}

$is_logged_in = false; // по умолчанию пользователь не авторизован
$is_admin = false; // по умолчанию пользователь не админ

if (isset($_SESSION['city'])) {
    $selectedCity = $_SESSION['city'];
} else {
    $selectedCity = 'Город';
}

if (isset($_SESSION['user_id'])) {
    // пользователь авторизован
    $is_logged_in = true;
    
    // Получение информации о пользователе из базы данных
    $sql = "SELECT isAdmin FROM users WHERE ID_User = ".$_SESSION['user_id'];
    $result = mysqli_query($conn, $sql);

    if($result && mysqli_num_rows($result) == 1) {
        // получаем данные пользователя
        $row = mysqli_fetch_assoc($result);

        // Проверка значения столбца isAdmin
        if($row['isAdmin'] == 1) {
            $is_admin = true; // Пользователь является администратором
        }
    }
}

$supplierCity = $_SESSION['city'] ?? '';

// Проверка наличия выбранной категории

$products_sql = "SELECT products.product_id, products.category_id, products.name, products.price, products.supplier_id, products.expiration_date, products.available, products.img, products.isGood, suppliers.name AS supplier_name, categories.name AS category_name
        FROM products
        INNER JOIN suppliers ON products.supplier_id = suppliers.supplier_id
        INNER JOIN categories ON products.category_id = categories.id_category
        WHERE suppliers.name = '{$supplierCity}'";

// Если выбрана категория, добавьте условие WHERE для фильтрации по категории
if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $products_sql .= " AND products.category_id = '{$category}'";
}

$result_products = $conn->query($products_sql);

$products = array();
if ($result_products->num_rows > 0) {
    while ($row = $result_products->fetch_assoc()) {
        $products[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="./assets/style/main.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <script src="assets/script/stock_ajax.js"></script>
  <script src="assets/script/changeCity.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Lato&family=Rubik:wght@400;600&display=swap" rel="stylesheet">
  <title>Акции в магазинах</title>
</head>
<body>
    <header class="header">
      <div class="header__wrapper">
        <div class="header__wrapper-left">
          <a href="./index.php" class="logo-link"><img src="./assets/img/logo.svg" alt="logo" class="logo"></a>
          <div class="city-block">
          <a href="##" class="dropdown__city"><?php echo $selectedCity; ?> <img src="./assets/img/city_icon.svg" alt="city" class="city-icon"></a>
          <div class="dropdown__city-wrapper">
            <span class="dropdown__city-title">Выберите город</span>
            <span class="dropdown__city-selected">
            <?php echo $selectedCity; ?>
            </span>
          <div class="dropdown__city-list_wrapper">
            <ul class="dropdown__city-list">
                <?php
                // Запрос к базе данных для получения городов
                $sql = "SELECT name FROM suppliers";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // Вывод городов в dropdown
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<li class="dropdown__city-list_item"><a href="#" class="dropdown__city-link" onclick="changeCity(\'' . $row['name'] . '\')">' . $row['name'] . '</a></li>';
                    }
                }
                ?>
            </ul>
          </div>
        </div>
      </div>
        </div>
        <nav class="header__navigation">
        <nav class="header__navigation">
          <ul class="header__navigation_list">
            <li>
              <a href="./stock.php" class="header__navigation_list-link">Акции</a>
            </li>
            <li>
              <a href="./about.php" class="header__navigation_list-link">О компании</a>
            </li>
            <li>
              <a href="./contacts.php" class="header__navigation_list-link">Контакты</a>
            </li>
            <li>
              <a href="./shops.php" class="header__navigation_list-link">Магазины</a>
            </li>
          </ul>
        </nav>

        <div class="modal-block">
          <a href="##" class="btn__search"><img class="img__search-icon" src="./assets/img/search-icon.svg" cl alt="search"></a>
          <?php
            if ($is_logged_in) {
            // Проверяем, является ли пользователь админом
            if ($is_admin) {
            echo '<a href="admin.php" class="btn__lk"><img class="img__lk-icon" src="./assets/img/lk-icon.svg" cl alt="admin"></a>';
            } else {
            echo '<a href="lk.php" class="btn__lk"><img class="img__lk-icon" src="./assets/img/lk-icon.svg" cl alt="lk"></a>';
            }
            } else {
            echo '<a href="##" class="btn__lk" id="open-modal"><img class="img__lk-icon" src="./assets/img/lk-icon.svg" cl alt="lk"></a>';
            }
          ?>
        </div>
      </div>
      <div id="modal" class="modal">
      <div class="modal-content">
          <span class="close">&times;</span>
          <h2>Вход / Регистрация</h2>
          <div class="tab">
          <button class="tablinks active" onclick="openTab(event, 'login-form')">Вход</button>
          <button class="tablinks" onclick="openTab(event, 'register-form')">Регистрация</button>
          </div>
          <form id="login-form" class="tabcontent" style="display: block;">
          <label for="username">Имя пользователя:</label>
          <input type="text" id="username" name="username" required>
          <label for="password">Пароль:</label>
          <input type="password" id="password" name="password" required>
          <button type="submit">Войти</button>
          </form>
          <form id="register-form" class="tabcontent">
          <label for="new-username">Имя пользователя:</label>
          <input type="text" id="new-username" name="new-username" required>
          <label for="new-email">Email:</label>
          <input type="email" id="new-email" name="new-email" required>
          <label for="new-password">Пароль:</label>
          <input type="password" id="new-password" name="new-password" required>
          <button type="submit">Зарегистрироваться</button>
          </form>
      </div>
      </div>
      
    </header>
      <main class="main">
        <section class="stock">
            <div class="container">
                <h2 class="title__second center">
                    <span class="color">Акции</span> в магазинах
                </h2>
                <div class="stock__tools">
                    <button class="stock__btn-filter"><img src="./assets/img/shop__icon.svg" alt="Магазин" class="shop-icon">Магазин</button>
                    <button class="stock__btn-filter">Сортировать<img src="./assets/img/shop__icon.svg" alt="Магазин" class="shop-icon"></button>
                    <input class="stock__search" type="text" placeholder="Поиск по товарам">
                    <button class="stock__find">Найти</button>
                </div>
                <div class="stock__layout">
                    <div class="stock__col-1">
                    <ul class="category__list" id="category-list"></ul>
                        <a href="#" class="btn__category" id="all-categories" ><img src="./assets/img/btn.png" alt="icon" class="btn__icon">Все категории</a>
                    </div>
                    <div class="columns" id="product-list">
                    <?php $count = 0; // Счетчик для ограничения вывода товаров до 4 ?>
                    <?php for ($i = 0; $i < count($products); $i++) : ?>
                        <?php if ($count == 0) : ?>
                            <div class="cards">
                        <?php endif; ?>
                        
                        <?php if ($products[$i]['available'] > 0) : ?> <!-- Добавте проверку на значение available -->
                            <ul class="prod-cards__list" data-category-id="<?php echo $products[$i]['category_id']; ?>" data-product-id="<?php echo $products[$i]['product_id']; ?>">
                                <li><img src="<?php echo $products[$i]['img']; ?>" alt="Акция" class="prod-cards__list-img"></li>
                                <li><span class="prod-cards__list-description"><?php echo $products[$i]['name']; ?></span></li>
                                <li><button class="add-to-cart-btn" data-product-id="<?php echo $products[$i]['product_id']; ?>" data-action="add">Добавить в корзину</button></li>
                            </ul>
                        <?php endif; ?>

                        <?php $count++; ?>
                        
                        <?php if ($count == 4 || $i == count($products) - 1) : ?>
                            </div>
                            <?php $count = 0; ?>
                        <?php endif; ?>
                    <?php endfor; ?>
                  </div>
                </div>
            </div>
          </section>
      </main>


  <footer class="footer">
    <div class="container">
      <nav class="footer__navigation">
        <ul class="footer__navigation-list">
          <li><a href="./buyers.html" class="footer__navigation-list_link color">Покупателям</a></li>
          <li><a href="./stock.html" class="footer__navigation-list_link">Акции</a></li>
          <li><a href="./about.html" class="footer__navigation-list_link">О компании</a></li>
        </ul>
        <ul class="footer__navigation-list">
          <li><a href="./delivery.html" class="footer__navigation-list_link">Доставка</a></li>
          <li><a href="./contacts.html" class="footer__navigation-list_link">Контакты</a></li>
          <li><a href="./shops.html" class="footer__navigation-list_link">Магазины</a></li>
        </ul>
      </nav>
      <a href="./index.html" class="logo-link"><img src="./assets/img/logo.svg" alt="logo" class="logo"></a>
      <nav class="footer__contacts">
        <p class="footer__contacts-title">Горячая линия</p>
        <a href="tel: +7777777777" class="footer__contacts-phone">8 - 800 - 555 - 35 - 35</a>
      </nav>
      <nav class="footer__social-link">
        <ul class="footer__social-link_list">
          <li><a href="#"><img src="./assets/img/1.svg" alt="Инста" class="footer-social-link_img"></a></li>
          <li><a href="#"><img src="./assets/img/2.svg" alt="Инста" class="footer-social-link_img"></a></li>
          <li><a href="#"><img src="./assets/img/3.svg" alt="Инста" class="footer-social-link_img"></a></li>
          <li><a href="#"><img src="./assets/img/4.svg" alt="Инста" class="footer-social-link_img"></a></li>
          <li><a href="#"><img src="./assets/img/5.svg" alt="Инста" class="footer-social-link_img"></a></li>
        </ul>
        <p class="footer__privacy">Политика конфиденциональности</p>
      </nav>
    </div>
  </footer>
  <script src="./assets/script/index.js"></script>
  <script src="./assets/script/searchProduct.js"></script>
</body>
</html>