function changeCity(city) {
    var dropdownCity = document.querySelector('.dropdown__city');
    dropdownCity.innerHTML = city + ' <img src="./assets/img/city_icon.svg" alt="city" class="city-icon">';

    dropdownCity.parentNode.querySelector('.dropdown__city-selected').innerHTML = city;

    // Сохранение выбранного города в сессии
    var selectedCity = '<?php echo $selectedCity ?>';
    if (selectedCity !== city) {
        selectedCity = city;

        var sessionId = '<?php echo session_id(); ?>';
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'php/save_city.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Обработка успешного сохранения города на сервере
                console.log('Город сохранен в сессии');
            }
        };
        var data = 'sessionId=' + sessionId + '&selectedCity=' + selectedCity;
        xhr.send(data);
    }
}