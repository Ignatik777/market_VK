// Получаем инпут и все изображения
const searchInput = document.querySelector('.contact-search');
const images = document.querySelectorAll('.con-img');

// Слушаем событие ввода символов в инпуте
searchInput.addEventListener('keyup', function() {
    const searchText = searchInput.value.toLowerCase();

    // Перебираем все изображения и проверяем содержимое атрибута "alt"
    images.forEach(function(image) {
        const altText = image.getAttribute('alt').toLowerCase();

        // Показываем или скрываем изображение в зависимости от результата поиска
        if (altText.includes(searchText) || searchText === '') {
            image.style.display = 'block';
        } else {
            image.style.display = 'none';
        }
    });
});