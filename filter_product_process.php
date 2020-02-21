<?php
session_start();
require 'config/connectdb.php';

$cat_name = $_POST['cat_name'];

// ดึงสินค้าออกมา
$sql_product = "SELECT * FROM products WHERE productLine='$cat_name'";
$query_product = mysqli_query($connect, $sql_product);

// วนลูปอ่านข้อมูลสินค้าทั้งหมดในหมวดหมู่ที่เลือกมา
$data_product = array();
while($data = mysqli_fetch_assoc($query_product)){
    $data_product[] = $data;
}

echo json_encode($data_product);

?>