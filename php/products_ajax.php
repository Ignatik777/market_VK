<?php
session_start();
require_once("conn.php");

$category = $_GET['category'];

$supplierCity = $_SESSION['city'] ?? '';

// Запрос товаров с учетом выбранной категории
$products_sql = "SELECT products.product_id, products.category_id, products.name, products.price, products.supplier_id, products.expiration_date, products.available, products.img, products.isGood, suppliers.name AS supplier_name
        FROM products
        INNER JOIN suppliers ON products.supplier_id = suppliers.supplier_id
        WHERE suppliers.name = '{$supplierCity}' AND products.category_id = '{$category}'";

$result_products = $conn->query($products_sql);

$products = array();
if ($result_products->num_rows > 0) {
    while ($row = $result_products->fetch_assoc()) {
        $products[] = $row;
    }
}

echo json_encode($products);
?>