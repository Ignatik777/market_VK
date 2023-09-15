<?php
session_start();
if (isset($_POST['sessionId']) && isset($_POST['selectedCity'])) {
    session_id($_POST['sessionId']);
    session_start();

    $_SESSION['city'] = $_POST['selectedCity'];

    echo 'Город сохранен в сессии';
} else {
    echo 'Ошибка при сохранении города';
}
?>