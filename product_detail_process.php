<?php
session_start();
require 'config/connectdb.php';

$product_id = $_POST['product_id'];

// ดึงสินค้าออกมา
$sql_product = "SELECT * FROM products WHERE productCode='$product_id'";
$query_product = mysqli_query($connect, $sql_product);
$data_product = mysqli_fetch_assoc($query_product);

echo json_encode($data_product);

?>