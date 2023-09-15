<?php
    // Подключение к базе данных
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'market';

    $conn = mysqli_connect($host, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }