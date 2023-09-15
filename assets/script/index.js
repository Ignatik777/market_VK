function openTab(evt, tabName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Добавляем обработчик событий на кнопку открытия модального окна
if (document.getElementById("open-modal")) {
  document.getElementById("open-modal").addEventListener("click", function() {
  document.getElementById("modal").style.display = "block";
  });
}

// Добавляем обработчик событий на кнопку закрытия модального окна
document.getElementsByClassName("close")[0].addEventListener("click", function() {
  document.getElementById("modal").style.display = "none";
});

// Добавляем обработчик событий на клик вне модального окна
window.addEventListener("click", function(event) {
  if (event.target == document.getElementById("modal")) {
    document.getElementById("modal").style.display = "none";
  }
});


const dropdownCity = document.querySelector('.dropdown__city');
const dropdownCityWrapper = document.querySelector('.dropdown__city-wrapper');

dropdownCity.addEventListener('click', function() {
  dropdownCityWrapper.classList.toggle('active');
});
