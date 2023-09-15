$(document).ready(function() {
  $('.basket').on('click', '.add-to-cart-btn', function() {
    var $row = $(this).closest('tr');
    var available = parseInt($row.find('td:nth-child(2)').text());
    var quantity = 1;
    var productId = $row.find('td:nth-child(2)').data('product-id');
    var basketId = $(this).data('basket-id');
    var productPrice = $row.find('td[data-product-price]').data('product-price');
    updateQuantity(productId, quantity, 'add', basketId, productPrice);
  });

  $('.basket').on('click', '.remove-from-cart-btn', function() {
    var $row = $(this).closest('tr');
    var available = parseInt($row.find('td:nth-child(2)').text());
    var quantity = -1; // Исправлено: установить количество равным -1 для уменьшения товара
    if (available > 0 && available >= Math.abs(quantity)) {
      var productId = $row.find('td:nth-child(2)').data('product-id');
      var basketId = $(this).data('basket-id');
      var productPrice = $row.find('td[data-product-price]').data('product-price');
      updateQuantity(productId, quantity, 'remove', basketId, productPrice);
    }
  });

  $('.basket').on('click', '.delete-from-cart-btn', function() {
    var $row = $(this).closest('tr');
    var basketId = $(this).data('basket-id');
    deleteFromCart(basketId, $row);
  });

  $('.checkout-btn').on('click', function() {
    var totalAmount = getTotalAmount();
    $.ajax({
      url: './php/save_order.php',
      method: 'POST',
      data: { totalAmount: totalAmount },
      success: function(response) {
        console.log(response);
        $('.basket tbody').empty();
        updateTotalAmount();
        $('.order-history').load('./php/load_order_history.php'); // Загружаем данные истории заказов на страницу
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      }
    });
  }); 
});

function getTotalAmount() {
  var totalAmount = 0;
  $('td[data-product-price]').each(function() {
    var productPrice = parseFloat($(this).data('product-price'));
    var quantity = parseInt($(this).prev('td[data-product-id]').text());
    var totalPrice = productPrice * quantity;
    totalAmount += totalPrice;
  });
  return totalAmount;
}

function updateQuantity(productId, quantity, action, basketId, productPrice) {
  $.ajax({
    url: './php/update_available_quantity.php',
    method: 'POST',
    data: { productId: productId, quantity: quantity, action: action, basketId: basketId },
    success: function(response) {
      console.log(response);
      
      var $row = $('td[data-product-id="' + productId + '"]');
      var currentQuantity = parseInt($row.text());
      var newQuantity = currentQuantity + quantity;
      
      if (newQuantity <= 0) {
        var $tableRow = $row.closest('tr');
        deleteFromCart(basketId, $tableRow);
      } else {
        $row.text(newQuantity);
        
        var $priceRow = $row.next('td[data-product-price]');
        var totalPrice = newQuantity * productPrice;
        $priceRow.text(totalPrice.toLocaleString('ru-RU') + ' руб.');
        
        updateTotalAmount();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
    }
  });
}

function deleteFromCart(basketId, $row) {
  $.ajax({
    url: './php/delete_from_cart.php',
    method: 'POST',
    data: { basketId: basketId },
    success: function(response) {
      console.log(response);

      $row.remove();
      updateTotalAmount();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
    }
  });
}

function updateTotalAmount() {
  var totalAmount = 0;
  $('td[data-total-price]').each(function() {
    var totalPrice = parseInt($(this).text());
    totalAmount += totalPrice;
  });
  $('.total-amount').text(totalAmount.toLocaleString('ru-RU') + ' руб.');
}

function loadOrderHistory() {
  $.ajax({
    url: './php/load_order_history.php',
    method: 'GET',
    success: function(response) {
      $('.order-history').html(response); // Вставьте данные истории заказов на страницу
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
    }
  });
}

// Вызов функции для загрузки и отображения истории заказов при загрузке страницы
loadOrderHistory();