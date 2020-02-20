<?php
require 'config/connectdb.php';

$employeeNumber = $_POST['employeeNumber'];
$jobTitle = $_POST['jobTitle'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$password = md5($_POST['password']);

if(!empty($employeeNumber) && !empty($firstName) && !empty($lastName)  && !empty($email)){
    $sql = "INSERT INTO employees(employeeNumber,lastName,firstName,extension,email,password,officeCode,jobTitle) 
                VALUES('$employeeNumber','$lastName','$firstName','x1234','$email','$password','1','$jobTitle')";
    $query = mysqli_query($connect, $sql);

    if($query){
        echo "register_success";
        exit();
    }else{
        // ข้อมูลเข้าระบบไม่ถูกต้อง
        echo "register_fail";
        exit();
    }
}else{
    echo "register_fail";
    exit();
}