<?php   
    require_once("../../database/database.php");

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
        .w-100px {
            width: 100px;
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
             <!-- Begin Page Content -->
        <div class="container-fluid">

                <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Quản lý sản phẩm</h1>

                <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 flex">
                     
                     <div>
                     <a href="./themsanpham.php" class="btn btn-primary font-weight-bold py-2 px-4 rounded mr-2">Thêm sản phẩm</a>
                     </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">         
                         <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    
                                    <th>Description</th>
                                    <th>Price</th>
                                    
                                    <th>Quantity</th>
                                    <th>Image1</th>
                                    <th>Image2</th>
                                    <th>Image3</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>                  
                            <tbody>
                                <?php
                                    $sql = "SELECT * FROM product";
                                    $query = mysqli_query($mysqli, $sql);                                   
                                    while($result = mysqli_fetch_assoc($query)){   
                                        $formatted_price =number_format($result['Price'], 0, '', '.');    
                                ?>
                                        <tr>
                                            <td><?php echo $result['ID']; ?></td>
                                            <td><?php echo htmlspecialchars($result['Name']); ?></td>
                                             
                                            <td><?php echo $result['Description']; ?></td>
                                             <td><?php echo $formatted_price ?><sup>đ</sup></td>
                                            
                                             <td><?php echo $result['Quantity']; ?></td>
                                            <td>
                                            <img class="w-100px mb-2"  src="../../../../Uploads/<?php echo htmlspecialchars($result['Image1']); ?>">                                                                                                                     
                                            </td>
                                            <td>
                                            <img class="w-100px mb-2"  src="../../../../Uploads/<?php echo htmlspecialchars($result['Image2']); ?>">                                                                           
                                            </td>
                                            <td>
                                            <img class="w-100px mb-2"  src="../../../../Uploads/<?php echo htmlspecialchars($result['Image3']); ?>">                                                                           
                                            </td>
                                            <td>
                                                <a class="btn btn-primary font-weight-bold py-2 px-4 rounded mr-2"  href="sua.php?sid=<?php echo $result['ID'];?> ">Sửa</a>
                                                <a onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm này')" class="btn btn-primary font-weight-bold py-2 px-4 rounded mr-2" href="xoasanpham.php?sid=<?php echo $result['ID'];?>">Xóa</a>
                                            </td>
                                   
                                        </tr>
                                        

                                <?php
                                    }
                                ?>
                                
                    
                            </tbody>
                         </table>
                    </div>
                </div>
            </div>

            
        </div>
<!-- /.container-fluid -->
    
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
                    <a class="btn btn-primary" href="../../logout.php">Logout</a>
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