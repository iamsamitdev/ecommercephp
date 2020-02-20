<?php
// กำหนดตัวแปรเชื่อมต่อฐานข้อมูล
$host = "localhost";
$user = "root";
$pass = "1234";
$dbname = "ecommercedb";
$port = "3306";

// คำสั่งเชื่อมต่อฐานข้อมูล
$connect = mysqli_connect($host,$user,$pass,$dbname,$port);
// เข้ารหัส utf8
mysqli_set_charset($connect,'utf8');

// ตรวจสอบว่าเชื่อมต่อได้หรือไม่
if($connect){
    // echo "Connect Database Success";
}else{
    echo "Connect Database Fail!!!";
}

