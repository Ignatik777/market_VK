function showContent(contentId) {
    var contentItems = document.getElementsByClassName('content-item');
    for (var i = 0; i < contentItems.length; i++) {
        contentItems[i].classList.remove('show');
    }
    document.getElementById(contentId).classList.add('show');

    var menuItems = document.getElementsByClassName('menu-item');
    for (var i = 0; i < menuItems.length; i++) {
        menuItems[i].classList.remove('active');
    }
    document.querySelector('.menu-item[data-content="' + contentId + '"]').classList.add('active');
}

document.querySelector('.burger-menu').addEventListener('click', function() {
    document.querySelector('.sidebar').classList.toggle('active');
});
