<?php
session_start();
require 'config/connectdb.php';
require 'lib_xlsx/SimpleXLSX.php';

if(empty($_SESSION['session_employee_number'])){
  // ส่งกลับไปหน้า login (index.php)
  header('location:index.php');
}

$file_temp = "";
// การอ่านข้อมูลจาก excel มาแสดงในตาราง
if(@$_POST['btnSubmit']){
    // อ่านไฟล์
    $file_temp = $_FILES['uploadfile']['tmp_name'];
    /*
    echo '<pre>';
    if ( $xlsx = SimpleXLSX::parse($file_temp) ) {
        print_r( $xlsx->rows() );
    } else {
        echo SimpleXLSX::parseError();
    }
    echo '<pre>';
    */
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Read Exel</title>

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
          <form method="post" action="read_excel.php" enctype="multipart/form-data">
            <div class="row">
                <div class="col-8">
                    <h1 class="h3 mb-4 text-gray-800">Read Execl Data</h1>
                </div>
                <div class="col-3 text-right">
                    <input type="file" name="uploadfile" id="uploadfile" class="form-control">
                </div>
                <div class="col-1 text-right">
                    <input type="submit" name="btnSubmit" class="btn btn-success"  value="Show">
                </div>
            </div>
        </form>
         
        <div class="card">
             <?php
                    if ( $xlsx = SimpleXLSX::parse( $file_temp) ) {
                        echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';
                        foreach( $xlsx->rows() as $r ) {
                            echo '<tr><td>'.implode('</td><td>', $r ).'</td></tr>';
                        }
                        echo '</table>';
                        // or $xlsx->toHTML();	
                    } else {
                        echo SimpleXLSX::parseError();
                    }
             ?>
         </div>
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
          <a class="btn btn-primary" href="login.html">Logout</a>
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
