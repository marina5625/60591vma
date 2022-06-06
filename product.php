<?php
//require('products_db.php');
require('auth.php');
require('dbconnect.php');
require('components/header.php');

$id = $_GET['product_id'];

$result = $conn->query("SELECT * FROM products WHERE id=".$id);
$row = $result->fetch();
$title = $row['title'];
$img_url = $row['img_url'];
$price = $row['price'];
$colors = $row['colors'];
if ($is_violet_tuesday) {
    require('components/product_violet.php');
}

require('components/product_info.php');
require ('components/message.php');
require('components/footer.php');


