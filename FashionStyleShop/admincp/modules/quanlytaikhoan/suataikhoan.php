<?php

require_once("../../database/database.php");

function getUserList($mysqli)
{
  $query = "SELECT * FROM customer";
  $stmt = $mysqli->prepare($query);
  $stmt->execute();
  $result = $stmt->get_result();
  $userList = array();

  while ($row = $result->fetch_assoc()) {
    $userList[] = $row;
  }

  return $userList;
}


if (isset($_GET['sid'])) {
    $id = $_GET["sid"];
    $userList = getUserList($mysqli);
    $userToUpdate = null;

    foreach ($userList as $user) {
    if ($user['id'] == $id) {
      $userToUpdate = $user;
      break;
    }
  }
}


$query = null;
$matchFound = null;
if ($_SERVER['REQUEST_METHOD'] == "POST" && $userToUpdate  ) {
    $CustomerName = isset($_POST["customername"]) ? $_POST["customername"] : null;
    $Address = isset($_POST["Address"]) ? $_POST["Address"] : null;
    $Phone = isset($_POST["Phone"]) ? $_POST["Phone"] : null;
    $email = isset($_POST["email"]) ? $_POST["email"] : null;
    $password = isset($_POST["password"]) ? $_POST["password"] : null;
    $role = isset($_POST["isAdmin"]) ? $_POST["isAdmin"] : null;
    $userToUpdate['role'] = $role;
   
    $query = "UPDATE customer SET customername=?, Phone=?, Address=?, email=?, password=?, role=? WHERE id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sssssis", $CustomerName, $Phone, $Address, $email, $password, $role, $id);

    if ($stmt->execute()) {
        header("Location: danhsachtaikhoan.php");
        exit();
      } else {
        echo "Có lỗi xảy ra khi cập nhật thông tin";
        var_dump($userToUpdate);
      }
      $stmt->close();
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
                    <h3>Sửa tài khoản </h3>
                </div>

              
                <!-- Success message -->
                <?php if ($userToUpdate) { ?>
                <form method="POST" class="w-full max-w-sm" >
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label text-center">ID</label>
                    <div class="col-sm-10">
                        <?php
                        echo"<input type=\"text\" disabled value=". $userToUpdate['id'] ." name=\"UserID\" class=\"form-control\" style=\"width: 200px;\" id=\"inputPassword\" placeholder=\"Nhập ID\">"
                        ?>
                    
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label text-center">CustomerName</label>
                    <div class="col-sm-10">
                    <?php
                        echo"<input type=\"text\"  value=\"" . $userToUpdate["customername"] . "\" name=\"customername\" class=\"form-control\" style=\"width: 200px;\" id=\"inputPassword\" placeholder=\"Nhập tên\">"
                        ?>
                    </div> 
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label text-center">Address</label>
                    <div class="col-sm-10">
                    <?php
                        echo"<input type=\"text\"  value=\"" . $userToUpdate["Address"] . "\" name=\"Address\" class=\"form-control\" style=\"width: 200px;\" id=\"inputPassword\" placeholder=\"Nhập tên danh mục\">"
                        ?>
                    </div> 
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label text-center">Phone</label>
                    <div class="col-sm-10">
                    <?php
                        echo"<input type=\"text\"  value=". $userToUpdate["Phone"] ." name=\"Phone\" class=\"form-control\" style=\"width: 200px;\" id=\"inputPassword\" placeholder=\"Nhập tên danh mục\">"
                        ?>
                    </div> 
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label text-center">Email</label>
                    <div class="col-sm-10">
                    <?php
                        echo"<input type=\"text\"  value=". $userToUpdate["email"] ." name=\"email\" class=\"form-control\" style=\"width: 200px;\" id=\"inputPassword\" placeholder=\"Nhập tên danh mục\">"
                        ?>
                    </div> 
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label text-center">Password</label>
                    <div class="col-sm-10">
                    <?php
                        echo"<input type=\"text\"  value=". $userToUpdate["password"] ." name=\"password\" class=\"form-control\" style=\"width: 200px;\" id=\"inputPassword\" placeholder=\"Nhập tên danh mục\">"
                        ?>
                    </div> 
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label text-center">Phân quyền</label>
                    <div class="col-sm-10">
                    <select id="is-admin" name="isAdmin" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                          <option value="1" <?php echo ($userToUpdate['role'] == 1) ? 'selected' : ''; ?>>Admin</option>
                          <option value="0" <?php echo ($userToUpdate['role'] == 0) ? 'selected' : ''; ?>>User</option>
                    </select>
                    </div>
                </div>
                <div>
                    <div class="w-30">
                        <button type="submit" class="btn btn-primary mb-2 flex justify-between">Sửa</button>
                    </div>
                    <div class="w-70">
                        
                    </div>
                    
                </div>
                
                </form>
                <?php } else {
                        echo "User không tồn tại";
                        // var_dump($userToUpdate);
                    }
                ?>
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