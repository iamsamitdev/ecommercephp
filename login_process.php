<?php
session_start();
require 'config/connectdb.php';

$email = $_POST['email'];
$password = md5($_POST['password']);

$sql = "SELECT  count(*) as total, employeeNumber FROM employees 
            WHERE email='$email' and password='$password'";
$query = mysqli_query($connect, $sql);
$result = mysqli_fetch_assoc($query);
# print_r($query);
# echo $result['total'];

if( $result['total']==1){
    // ข้อมูลเข้าระบบถูกต้อง
    echo "login_success";
    // เก็บ อีเมล์และ รหัสพนักงานลงตัวแปร session
    $_SESSION['session_email'] = $email;
    $_SESSION['session_employee_number'] = $result['employeeNumber'];
    exit();
}else{
    // ข้อมูลเข้าระบบไม่ถูกต้อง
    echo "login_fail";
    exit();
}