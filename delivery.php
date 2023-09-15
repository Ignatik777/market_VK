<?php
session_start();
require_once("php/conn.php");

if (isset($_SESSION['city'])) {
    $selectedCity = $_SESSION['city'];
} else {
    $selectedCity = 'Город';
}
$is_logged_in = false; // по умолчанию пользователь не авторизован
$is_admin = false; // по умолчанию пользователь не админ
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
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="./assets/style/main.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <script src="assets/script/changeCity.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Lato&family=Rubik:wght@400;600&display=swap" rel="stylesheet">
  <title>Главная</title>
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
  <section class="hero">
    <div class="container">
      <div class="hero__box">
        <img src="./assets/img/hero__bg.png" alt="hero image" class="hero__img img__gen">
        <h1 class="title__first">
            Доставляем еду, <br>
            а не ходим!
        </h1>
      </div>
    </div>
  </section>
  <section class="delivery-one">
    <div class="container">
      <h2 class="title__second center">
        Лучшее по акции
      </h2>
      <div class="flex-box">
        <div class="card">
            <div class="card__text">
              <h2 class="card__heading">Доставка от 30 минут</h2>
            </div>
          </div>
          
          <div class="card card--orange">
            <div class="card__text">
              <h2 class="card__heading">Всегда свежие продукты</h2>
            </div>
          </div>
          
          <div class="card card--green">
            <div class="card__text">
              <h2 class="card__heading">Цены как в магазине</h2>
            </div>
          </div>
          
          <div class="card card--blue">
            <div class="card__text">
              <h2 class="card__heading">Безопасная доставка</h2>
            </div>
          </div>
      </div>
      <div class="other">
        <h2 class="title__second center">
            Лучшее по акции
        </h2>
        <div class="box-description flex-box-2">
            <img src="./assets/img/cards/Group 49.png" alt="Доставка" class="box-description__img">
            <img src="./assets/img/cards/Group 50.png" alt="Доставка" class="box-description__img">
            <img src="./assets/img/cards/Group 51.png" alt="Доставка" class="box-description__img">
        </div>
      </div>
    </div>
  </section>
  <article class="app-box">
    <div class="container">
        <img src="./assets/img/app.png" alt="app" class="app">
    </div>
  </article>
  

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
</body>
</html>