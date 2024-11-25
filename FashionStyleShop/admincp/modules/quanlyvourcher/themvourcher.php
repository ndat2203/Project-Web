<?php
require_once("../../database/database.php");

$query = null;
$matchFound = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kiểm tra và lấy dữ liệu từ POST
    $ID = isset($_POST["IDVourcher"]) ? intval($_POST["IDVourcher"]) : null;
    $Code = isset($_POST["VourcherCode"]) ? $_POST["VourcherCode"] : null;
    $Count = isset($_POST["Count"]) ? intval($_POST["Count"]) : null;
    $Time = isset($_POST["VourcherTime"]) ? ($_POST["VourcherTime"]) : null;
    $Discount = isset($_POST["Discount"]) ? $_POST["Discount"] : null;

    // Kiểm tra điều kiện đầu vào
    if (!is_null($ID) && is_numeric($ID) && !is_null($Code) && !is_null($Count)  && !is_null($Discount)) {
        // Sử dụng câu lệnh chuẩn bị để ngăn chặn SQL Injection
        $stmt = $mysqli->prepare("SELECT * FROM vourcher WHERE VourcherID = ?");
        $stmt->bind_param("i", $ID);  // Kiểm tra xem ID có tồn tại không
        $stmt->execute();
        $resultProduct = $stmt->get_result();
        $matchFound = $resultProduct->num_rows > 0;
        $stmt->close();

        if (!$matchFound) {
            // Chèn dữ liệu mới nếu không tìm thấy bản ghi trùng
            $stmt = $mysqli->prepare("INSERT INTO vourcher (VourcherID, VourcherCode, VoucherCount, VourcherTime, VourcherDiscount) 
                                      VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("isisi", $ID, $Code, $Count, $Time, $Discount);  // Sửa bind_param theo đúng kiểu dữ liệu
            
            $query = $stmt->execute();
            
            // Điều hướng sau khi chèn thành công
            if ($query) {
                header("Location: danhsachvourcher.php");
                exit();  // Dừng lại sau khi chuyển hướng
            }
            $stmt->close();
        } else {
            $query = false; // Đặt $query là false nếu bản ghi đã tồn tại
        }
    } else {
        $query = false;  // Đảm bảo rằng tất cả các tham số là hợp lệ
    }
} else {
    $query = null;  
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

    <title>SB Admin 2 - Dashboard</title>
    
    <!-- Custom fonts for this template-->
     <link href="../../vendor/fontawesome-free/css/all.min.css"  rel="stylesheet" type="text/css">
     
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    
    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    
    <script src="https://kit.fontawesome.com/ff4b23649f.js" crossorigin="anonymous"></script>
    <style>
        .w-30 {
            width: 30%;
             display: flex;
            justify-content: center;
        }
        .w-70{
            width: 70%;
        }
        .bg-success,.bg-danger{
            margin-left: 20px;
            margin-right: 20px;
        }
    </style>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
    <?php
        include("../menu.php");
    ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
    <?php
        include("../header.php");
    ?>
    <section class="content px-6 py-6 flex flex-col gap-3 bg-white" style="">
                <div class="  w-100 p-3 bg-white d-flex justify-content-between gap-3 align-items-start">
                    <h3>Thêm sản phẩm </h3>
                </div>

                <!-- thong bao them thanh cong hay that bai  -->
                <?php
                if ($query != null || is_bool($query)) {
                    echo  !$query ? "<div class=\"bg-danger text-white p-3 mb-4 rounded\">
                        Thêm thất bại
                    </div>" : " <div class=\"bg-success text-white p-3 mb-4 rounded\">
                        Thêm thành công
                    </div>";
                }

                if ($matchFound) {
                    echo " <div class=\"bg-danger text-white p-3 mb-4 rounded\">
                            ID đã tồn tại
                        </div>";
                }
                ?>
                <!-- Success message -->

                <form method="POST" class="w-full max-w-sm" >
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label text-center">VourcherID</label>
                    <div class="col-sm-10">
                    <input type="text" name="IDVourcher" class="form-control" style="width: 200px;" id="inputPassword" placeholder="Nhập ID vourcher">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label text-center">VourcherCode</label>
                    <div class="col-sm-10">
                    <input type="text" name="VourcherCode" class="form-control" style="width: 200px;" id="inputPassword" placeholder="Nhập vourcher">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label text-center">VourcherCount</label>
                    <div class="col-sm-10">
                    <input type="text" name="Count" class="form-control" style="width: 200px;" id="inputPassword" placeholder="Nhập số lượng">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label text-center">VourcherTime</label>
                    <div class="col-sm-10">
                    <input type="date" name="VourcherTime" class="form-control" style="width: 200px;" id="inputPassword" >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label text-center">VourcherDiscount</label>
                    <div class="col-sm-10">
                    <input type="text" name="Discount" class="form-control" style="width: 200px;" id="inputPassword" placeholder="Nhập giảm giá">
                    </div>
                </div>
               
                
               
               
                
                
               
              
                <div>
                    <div class="w-30">
                        <button type="submit" class="btn btn-primary mb-2 flex justify-between">Thêm</button>
                    </div>
                    <div class="w-70">
                        
                    </div>
                    
                </div>
                
                </form>
    </section>
    <?php
        include("../footer.php");
    ?>
                                           
            </div>
            <!-- End of Main Content -->
          
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
    
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../js/demo/chart-area-demo.js"></script>
    <script src="../../js/demo/chart-pie-demo.js"></script>

</body>

</html>