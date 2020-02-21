<?php
session_start();
require 'config/connectdb.php';

// ดึงรายชื่อหมวดหมู่มาแสดง
$sql_product_line = "SELECT * FROM productlines";
$query_product_line = mysqli_query($connect, $sql_product_line);

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Filiter Product</title>

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
          
          <div class="row">
            <div class="col-2">
                <h1 class="h3 mb-4 text-gray-800">Filter</h1>
            </div>
            <div class="col-3">
                <form name="search_barcode_form" action="filter_product.php" method="post">
                    <input type="text" name="product_code" id="product_code" class="form-control" placeholder="Enter barcode">
                </form>
            </div>
            <div class="col-2">
                  <select class="form-control" name="category" id="category">
                    <option value="">Select Category</option>

                    <?php
                        while($data = mysqli_fetch_assoc($query_product_line)){
                            echo "<option value='".$data['productLine']."'>".$data['productLine']."</option>";
                        }
                    ?>
                    
                  </select>
            </div>
            <div class="col-3">
                <select class="form-control" name="product_name" id="product_name">
                </select>
            </div>
            <div class="col-2 text-right">
                <button class="btn btn-primary" id="btnSave">Save Product</button>
            </div>
          </div> <!-- row-->

          <!-- ตารางแสดงรายการที่ฟิลเตอร์ -->
          <div class="card">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Product Line</th>
                            <th>Qty</th>
                            <th>Buy price</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
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

  <script>
      $(function(){
        $("select#category").change(function(){
            // ดึง value ของ select
            var cat_name = $(this).val();
            // alert(cat_name);
            $.ajax({
                url:"filter_product_process.php",
                method:"POST",
                dataType:"json",
                data:{"cat_name":cat_name},
                success:function(data){

                  // alert(JSON.stringify(data));
                  var option_product = "<option value=' selected='selected'>---Select Product---</option>";
                  $.each(data, function (key, val) {
                        option_product += "<option value='" + val["productCode"] + "'>" + val["productName"] + "</option>"
                  });

                  // นำค่าที่ได้เติมลงไปใน select 
                  $("select#product_name").html(option_product);

                }
            })
        });

        // ฟังก์ชันการคลิ๊กบันทึกรายการสินค้าที่เลือกลงในตาราง
        $("button#btnSave").click(function(){
            var product_id =  $("select#product_name").val();
            $.ajax({
                url:"product_detail_process.php",
                method:"POST",
                dataType:"json",
                data:{"product_id":product_id},
                success:function(data){
                    var result = JSON.parse(JSON.stringify(data));
                    var trstring = `<tr>
                                <td>${result.productCode}</td>
                                <td>${result.productName}</td>
                                <td>${result.productLine}</td>
                                <td>${result.quantityInStock}</td>
                                <td>${result.buyPrice}</td>
                            </tr>`;
                    $("table tbody").append(trstring);
                }
             });
        });

        // ฟังก์ชันการค้นหาผ่าน barcode สินค้า
        $("form[name=search_barcode_form]").submit(function(e){
            e.preventDefault(); // ป้องกันไม่ให้ฟอร์มมันรีโหลด
            var product_id = $("input#product_code").val();
            $.ajax({
                url:"product_detail_process.php",
                method:"POST",
                dataType:"json",
                data:{"product_id":product_id},
                success:function(data){
                    var result = JSON.parse(JSON.stringify(data));
                    var trstring = `<tr>
                                <td>${result.productCode}</td>
                                <td>${result.productName}</td>
                                <td>${result.productLine}</td>
                                <td>${result.quantityInStock}</td>
                                <td>${result.buyPrice}</td>
                            </tr>`;
                    $("table tbody").append(trstring);
                    // เคลียร์ค่าในฟอร์ม
                    $("form[name=search_barcode_form]").trigger('reset');
                    $("input#product_code").focus();
                }
             });
        })

      }); // Onload
  </script>

</body>

</html>
