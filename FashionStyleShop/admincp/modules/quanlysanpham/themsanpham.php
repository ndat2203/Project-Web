<?php   
    require_once("../../database/database.php");

    $query = null;
    $matchFound = null;
    $sql = "SELECT ID, TypeName FROM typeproduct";
    $result = mysqli_query($mysqli, $sql);  // Đổi tên biến để rõ ràng
    $sql1 = "SELECT * FROM color";
    $result1 = mysqli_query($mysqli, $sql1);  // Đổi tên biến để rõ ràng

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Kiểm tra và lấy dữ liệu từ POST
        $ID = isset($_POST["IDProduct"]) ? intval($_POST["IDProduct"]) : null;
        $Name = isset($_POST["NameProduct"]) ? $_POST["NameProduct"] : null;
        $TypeID = isset($_POST["TypeID"]) ? $_POST["TypeID"] : null;
        $Description = isset($_POST["Description"]) ? $_POST["Description"] : null;
        $Price = isset($_POST["Price"]) ? $_POST["Price"] : null;
        $ColorID = isset($_POST["ColorID"]) ? $_POST["ColorID"] : null;
        $Quantity = isset($_POST["Quantity"]) ? $_POST["Quantity"] : null;
        $hinhanh1 = isset($_POST["hinhanh1"]) ? $_POST["hinhanh1"] : null;
        $hinhanh2 = isset($_POST["hinhanh2"]) ? $_POST["hinhanh2"] : null;
        $hinhanh3 = isset($_POST["hinhanh3"]) ? $_POST["hinhanh3"] : null;

        // Kiểm tra điều kiện đầu vào
        if(!is_null($ID) && is_numeric($ID)){
            // Sử dụng câu lệnh chuẩn bị để ngăn chặn SQL Injection
            $stmt = $mysqli->prepare("SELECT * FROM product WHERE ID = ?");
            $stmt->bind_param("i", $ID);
            $stmt->execute();
            $resultProduct = $stmt->get_result();
            $matchFound = $resultProduct->num_rows > 0;
            $stmt->close();

            if (!$matchFound) {
                // Chèn dữ liệu mới nếu không tìm thấy bản ghi trùng
                $stmt = $mysqli->prepare("INSERT INTO product (ID, Name, TypeID, Description, Price, ColorID, Quantity, image1, image2, image3, created_at) 
                                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)");
                $stmt->bind_param("isissiiiss", $ID, $Name, $TypeID, $Description, $Price, $ColorID, $Quantity, $hinhanh1, $hinhanh2, $hinhanh3);
                
                $query = $stmt->execute();
                
                // Điều hướng sau khi chèn thành công
                if ($query) {
                    header("Location: danhsachsanpham.php");
                    exit();  // Nên thêm exit sau header để dừng thực thi mã phía dưới
                }
                $stmt->close();
            } else {
                $query = false; // Đặt $query là false nếu bản ghi đã tồn tại
            }
        } else {
            $query = false;
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
                    <label for="staticEmail" class="col-sm-2 col-form-label text-center">ID</label>
                    <div class="col-sm-10">
                    <input type="text" name="IDProduct" class="form-control" style="width: 200px;" id="inputPassword" placeholder="Nhập ID sản phẩm">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label text-center">Name</label>
                    <div class="col-sm-10">
                    <input type="text" name="NameProduct" class="form-control" style="width: 200px;" id="inputPassword" placeholder="Nhập tên sản phẩm">
                    </div>
                </div>
                <div class="form-group row">
                        <label for="TypeID" class="col-sm-2 col-form-label text-center">TypeID</label>
                    <div class="col-sm-10">
                            <select name="TypeID" class="form-control" style="width: 250px;" id="TypeID">
                                <option value="">Chọn danh mục</option>
                                <?php
                                    // Duyệt qua các kết quả và thêm vào <option> trong <select>
                                         while ($row = mysqli_fetch_assoc($result)) {
                                             echo '<option value="' . $row['ID'] . '">' . $row['TypeName'] . '</option>';
                                }
                                ?>
                            </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label text-center">Description</label>
                    <div class="col-sm-10">
                        <textarea name="Description" class="form-control" style="width:400px;" id="Description" rows="4" placeholder="Nhập mô tả..."></textarea>
                    </div> 
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label text-center">Price</label>
                    <div class="col-sm-10">
                         <input type="text" name="Price" class="form-control" style="width: 250px;" id="inputPassword" placeholder="Nhập giá">
                    </div> 
                </div>
                <div class="form-group row">
                        <label for="ColorID" class="col-sm-2 col-form-label text-center">ColorID</label>
                    <div class="col-sm-10">
                            <select name="ColorID" class="form-control" style="width: 250px;" id="ColorID">
                                <option value="">Chọn color</option>
                                <?php
                                    // Duyệt qua các kết quả và thêm vào <option> trong <select>
                                         while ($row = mysqli_fetch_assoc($result1)) {
                                             echo '<option value="' . $row['ID'] . '">' . $row['ColorName'] . '</option>';
                                }
                                ?>
                            </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label text-center">Quantity</label>
                    <div class="col-sm-10">
                         <input type="text" name="Quantity" class="form-control" style="width: 250px;" id="inputPassword" placeholder="Nhập số lượng    ">
                    </div> 
                </div>
                
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label text-center">Image1</label>
                    <div class="col-sm-10">
                        <input class="w-full" type="file" name="hinhanh1">
                    </div> 
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label text-center">Image2</label>
                    <div class="col-sm-10">
                        <input class="w-full" type="file" name="hinhanh2">
                    </div> 
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label text-center">Image3</label>
                    <div class="col-sm-10">
                        <input class="w-full" type="file" name="hinhanh3">
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