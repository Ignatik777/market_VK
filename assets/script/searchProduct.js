// Получение элементов интерфейса
var searchInput = document.querySelector(".stock__search");
var findButton = document.querySelector(".stock__find");

// Обработчик событий при нажатии кнопки "Найти"
findButton.addEventListener("click", function() {
  var keyword = searchInput.value.trim().toLowerCase();
  searchProducts(keyword);
});

// Функция поиска товаров
function searchProducts(keyword) {
  var productDescriptions = document.querySelectorAll(".prod-cards__list-description");
  
  for (var i = 0; i < productDescriptions.length; i++) {
    var description = productDescriptions[i].textContent.toLowerCase();
    var productCard = productDescriptions[i].parentNode.parentNode;
    
    if (description.includes(keyword)) {
      productCard.style.display = "block";
    } else {
      productCard.style.display = "none";
    }
  }
}