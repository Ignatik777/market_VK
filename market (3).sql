-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 10 2023 г., 04:03
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `market`
--

-- --------------------------------------------------------

--
-- Структура таблицы `basket`
--

CREATE TABLE `basket` (
  `basket_id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `available` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `basket`
--

INSERT INTO `basket` (`basket_id`, `user_id`, `product_id`, `available`) VALUES
(4, 106, 3, 1),
(5, 106, 6, 1),
(6, 106, 8, 1),
(7, 106, 9, 20);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `ID_category` int NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`ID_category`, `name`) VALUES
(1, 'Фрукты'),
(2, 'Кондитерские изделия'),
(3, 'Мясные изделия'),
(4, 'Кофе и чай'),
(5, 'Хозтовары');

-- --------------------------------------------------------

--
-- Структура таблицы `history_orders`
--

CREATE TABLE `history_orders` (
  `ho_id` int NOT NULL,
  `date_order` date NOT NULL,
  `user_id` int NOT NULL,
  `cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `history_orders`
--

INSERT INTO `history_orders` (`ho_id`, `date_order`, `user_id`, `cost`) VALUES
(3, '2023-09-16', 106, '320.00');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `product_id` int NOT NULL,
  `category_id` int NOT NULL,
  `name` varchar(110) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `supplier_id` int NOT NULL,
  `expiration_date` date NOT NULL,
  `available` int DEFAULT NULL,
  `img` varchar(450) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `isGood` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `name`, `price`, `supplier_id`, `expiration_date`, `available`, `img`, `isGood`) VALUES
(2, 2, 'Шоколад Dove молочный 90г', '110.00', 9, '2023-09-29', 137, './assets/img/prod-cards/Group 19.png', 1),
(3, 1, 'Персики 1кг', '140.00', 9, '2023-11-16', 129, './assets/img/prod-cards/Group 20.png', 1),
(4, 2, 'Шоколад Ritter Sport  100г', '140.00', 9, '2023-10-18', 192, './assets/img/prod-cards/Group 21.png', 1),
(5, 3, 'Колбаски Grillbox 400г', '238.00', 9, '2023-12-21', 43, './assets/img/prod-cards/Group 22.png', 1),
(6, 1, 'Горошек Bonduelle 400 мл', '120.00', 9, '2023-12-21', 35, './assets/img/prod-cards/Group 23.png', 1),
(7, 2, 'Шоколад KINDER  100г', '36.00', 9, '2023-11-16', 115, './assets/img/pdor/Group 10.png', 0),
(8, 1, 'Сок ФрутоНяня 200мл', '199.00', 9, '2023-11-24', 22, './assets/img/pdor/Group 11.png', 0),
(9, 5, 'Бумага Zewa Plus 2 слоя 4 шт.', '250.00', 9, '2026-11-11', 66, './assets/img/pdor/12.png', 0),
(10, 5, 'Пена для бритья Nivea Men  200мл', '199.00', 9, '2023-11-16', 62, './assets/img/pdor/Group 16.png', 0),
(11, 4, 'Чай Майский листовой, 200 г', '43.00', 9, '2024-02-14', 22, './assets/img/pdor/Group 14.png', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int NOT NULL,
  `name` varchar(77) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `name`) VALUES
(1, 'Шинск'),
(2, 'Екатеринбург'),
(3, 'Ижевск'),
(4, 'Казань'),
(5, 'Липецк'),
(6, 'Набережные челны'),
(7, 'Нижний Новгород'),
(8, 'Новосибирск'),
(9, 'Омск'),
(10, 'Оренбург'),
(11, 'Пермь'),
(12, 'Ростов-На-Дону'),
(13, 'Рязань'),
(14, 'Санкт-Петербург'),
(15, 'Самара'),
(16, 'Тюмень'),
(17, 'Уфа'),
(18, 'Челябинск'),
(19, 'Ярославль'),
(20, 'Владивосток');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `ID_User` int NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `isAdmin` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID_User`, `email`, `name`, `password`, `isAdmin`) VALUES
(106, '11123@mail.ru', 'lolka123', '$2y$10$ht3pGzr2k7/II61W0ysD/ebZKvXjAkUCzydHH70Q8NEu6SVnX0aLe', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `basket`
--
ALTER TABLE `basket`
  ADD PRIMARY KEY (`basket_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID_category`);

--
-- Индексы таблицы `history_orders`
--
ALTER TABLE `history_orders`
  ADD PRIMARY KEY (`ho_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `supplier_id` (`supplier_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID_User`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `basket`
--
ALTER TABLE `basket`
  MODIFY `basket_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `ID_category` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `history_orders`
--
ALTER TABLE `history_orders`
  MODIFY `ho_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `ID_User` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `basket`
--
ALTER TABLE `basket`
  ADD CONSTRAINT `basket_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `basket_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID_User`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `history_orders`
--
ALTER TABLE `history_orders`
  ADD CONSTRAINT `history_orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`ID_User`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`ID_category`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
