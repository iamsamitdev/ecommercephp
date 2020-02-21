<?php
session_start();
require 'config/connectdb.php';
require 'config/uploadfile.php';

if(empty($_SESSION['session_employee_number'])){
  // ส่งกลับไปหน้า login (index.php)
  header('location:index.php');
}

// ส่วนของการอัพเดทข้อมูลผู้ใช้
if(@$_POST['btnUpdate'])
{
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $email = $_POST['email'];
  
  // ส่วนของการอัพโหลดไฟล์
  // เช็คว่าผู้ใช้อัพโหลดมาหรือไม่
	if(!empty($_FILES['picprofile']['name']))
	{
            $inputname = "picprofile";
            $maxfilesize = "6000000";
            $orgdirectory = "img/original"; // โฟลเดอร์ภาพต้นฉบับ
            $thumbdirectory = "img/thumbnail"; // โฟล์เดอร์ภาพย่อ
            $thumbwidth = "400";
            $thumbheight = "400";
            // Upload รูปเข้า folder
            $path = $_FILES[$inputname]['name'];

            $ext = pathinfo($path, PATHINFO_EXTENSION);

            if ($ext == "jpg" or $ext == "jpeg" or $ext == "png" or $ext == "gif") {
                $filename = time(). "." . pathinfo($_FILES[$inputname]['name'], PATHINFO_EXTENSION);
                $filesize = $_FILES[$inputname]['size'];
                $filetmp = $_FILES[$inputname]['tmp_name'];
                $filetype = $_FILES[$inputname]['type'];

                $upload = genius_uploadimg_with_org(
                	$inputname, 
			    	$filename, 
				    $filesize, 
				    $filetmp, 
				    $filetype, 
				    $maxfilesize, 
				    $orgdirectory, 
				    $thumbdirectory, 
				    $thumbwidth, 
				    $thumbheight);
            }else{
                echo "File type not allow";
                exit();
            }
	  }

  // ตรวจว่าผู้ใช้เลือกรูปมาหรือไม่
  if(!empty($_FILES['picprofile']['name'])){
    $sql_update = "UPDATE employees 
        SET firstName='$firstName', lastName='$lastName', email='$email', picprofile='$filename' 
        WHERE employeeNumber='$_SESSION[session_employee_number]'";
  }else{
    $sql_update = "UPDATE employees 
    SET firstName='$firstName', lastName='$lastName', email='$email'
    WHERE employeeNumber='$_SESSION[session_employee_number]'";
  }

  $query_update = mysqli_query($connect, $sql_update);
}

// ดึงข้อมูลสมาชิกออกมาแสดง
$sql_employee = "SELECT * FROM employees WHERE employeeNumber='$_SESSION[session_employee_number]'";
$query_employee = mysqli_query($connect, $sql_employee);
$data_employee = mysqli_fetch_assoc($query_employee);


?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Proflie</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  
  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php
      require 'includes/sidebar.php';
    ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php 
          require 'includes/topbar.php';
        ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Edit Profile</h1>
        
          <form name="updateprofile" action="profile.php" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="firstName" class="col-sm-2 col-form-label">Firstname</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $data_employee['firstName'];?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="lastName" class="col-sm-2 col-form-label">Lastname</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo $data_employee['lastName'];?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $data_employee['email'];?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Picture profile</label>
                <div class="col-sm-10">
                <img src="img/thumbnail/<?php echo $data_employee['picprofile'];?>" height="100">
                <input type="file" class="form-control" id="picprofile" name="picprofile">
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    <input type="submit" name="btnUpdate" class="btn btn-primary" value="Update">
                </div>
            </div>
            </form>


        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php
        require 'includes/footer.php';
      ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="index.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
