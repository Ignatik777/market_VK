var selectedCategoryId = "all";

function getCategories() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "./php/categories_ajax.php", true);
  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onload = function() {
    if (xhr.status === 200) {
      var categories = JSON.parse(xhr.responseText);
      updateCategoryList(categories);
    }
  };

  xhr.send();
}

function updateCategoryList(categories) {
  var categoryList = document.getElementById("category-list");
  categoryList.innerHTML = "";

  categories.forEach(function(category) {
    var listItem = document.createElement("li");
    var link = document.createElement("a");
    link.className = "category__list-item";
    link.href = "#";
    link.setAttribute("data-category-id", category.ID_category);
    link.textContent = category.name;

    link.addEventListener("click", function(event) {
      event.preventDefault();
      var categoryId = this.getAttribute("data-category-id");
      filterProducts(categoryId);
      updateSelectedCategory(categoryId);
    });

    listItem.appendChild(link);
    categoryList.appendChild(listItem);
  });
}

function updateSelectedCategory(categoryId) {
  var categoryItems = document.getElementsByClassName("category__list-item");

  for (var i = 0; i < categoryItems.length; i++) {
    if (categoryItems[i].getAttribute("data-category-id") === categoryId) {
      categoryItems[i].classList.add("active");
    } else {
      categoryItems[i].classList.remove("active");
    }
  }

  selectedCategoryId = categoryId;
}

function filterProducts(categoryId) {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "./php/products_ajax.php?category=" + categoryId, true);
  xhr.setRequestHeader("Content-Type", "application/json");

  xhr.onload = function() {
    if (xhr.status === 200) {
      var products = JSON.parse(xhr.responseText);
      updateProductList(products, categoryId);
    }
  };

  xhr.send();
}

function updateProductList(products, categoryId) {
  var productCards = document.getElementsByClassName("prod-cards__list");

  for (var i = 0; i < productCards.length; i++) {
    var prodCategoryId = productCards[i].getAttribute("data-category-id");
    var productId = productCards[i].getAttribute("data-product-id");

    if (categoryId === "all" || prodCategoryId === categoryId) {
      productCards[i].style.display = "block";
    } else {
      productCards[i].style.display = "none";
    }
    
    console.log("Product ID: " + productId);
  }
}

window.onload = function() {
  getCategories();
  filterProducts(selectedCategoryId);

  const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
  addToCartButtons.forEach(button => {
    button.addEventListener('click', function() {
      const productId = this.getAttribute('data-product-id');
      const action = this.getAttribute('data-action');

      const xhr = new XMLHttpRequest();
      xhr.open('POST', './php/update_cart.php', true);
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          const data = JSON.parse(xhr.responseText);
          const quantityElement = document.querySelector(`li[data-product-id="${data.product_id}"] .prod-cards__list-available`);
          if (quantityElement) {
            quantityElement.textContent = data.available;
          }
        }
      };
      xhr.send(`product_id=${productId}&action=${action}`);
    });
  });
};