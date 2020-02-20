<?php
session_start();

// ล้างข้อมูล session ออก
session_destroy();

 // ส่งกลับไปหน้า login (index.php)
 header('location:index.php');