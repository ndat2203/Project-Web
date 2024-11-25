<?php
    session_start();
    require_once("database/database.php");
    require_once "../utils/utils.php";
    // $email = $_POST['email'];
    // $IdCustomerQuery = "SELECT id FROM customer WHERE email = '$email' LIMIT 1";
    // $result_IdCustomer = $mysqli->query($IdCustomerQuery);
    // $row_IdCustomer = $result_IdCustomer->fetch_assoc();
    // $id = $row_IdCustomer['id'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];            
            
            if (!empty($email) && !empty($password)) {
                if (Authentication($mysqli, $email, $password)) {
                    Authorization($mysqli, $email);  
                    
                  
                    
                    // Chuyển hướng người dùng sau khi xác thực thành công
                    if ($_SESSION['role'] == 0) {
                          // Sau khi xác thực thành công, lấy ID khách hàng
                    $customerId = $_SESSION['UserID']; // Giả sử UserID được lưu trong session từ hàm Authorization
                    
                    // Lấy ngày giờ hiện tại
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    $currentDate = date("Y-m-d H:i:s");
                    var_dump($customerId);
                    
                        // Tạo mới giỏ hàng nếu chưa có
                        $createBillQuery = "INSERT INTO bills (CustomerID, DateOrder, TotalPrice, TotalQuantity, StatusID, created_at, updated_at) VALUES (?, ?, 0, 0, 1, ?, ?)";
                        $stmt_create = $mysqli->prepare($createBillQuery);
                        $stmt_create->bind_param("isss", $customerId, $currentDate, $currentDate, $currentDate);
                        if ($stmt_create->execute()) {
                            // Tạo giỏ hàng thành công
                            error_log("New bill created successfully for customer ID: $customerId");
                        } else {
                            // Báo lỗi nếu không thành công
                            error_log("Failed to create bill for customer ID: $customerId. Error: " . $stmt_create->error);
                        }
                    
                        header("Location: ../index.php");
                        exit();
                    } else {
                        header("Location: index.php");
                        exit();
                    }
                } else {
                    showAlert("Sai email hoặc mật khẩu!");
                    error_log("Login failed: incorrect email or password for user $email");
                }
            } else {
                showAlert("Vui lòng điền đầy đủ thông tin!");
            }
         }
    }
    
    $mysqli->close();
    
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                        </div>
                                        <form class="user" method="POST" autocomplete="on">
                                            <div class="form-group">
                                                <input type="text" name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Nhập email">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Nhập mật khẩu">

                                            </div>
                                            <div class="form-group row  ">
                                                <div class="custom-control custom-checkbox small px-5">
                                                    <input type="checkbox" class="custom-control-input" id="showCheckbox">
                                                    <label class="custom-control-label" for="showCheckbox">Show</label>
                                                   </div>
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck">
                                                    <label class="custom-control-label" for="customCheck">Remember Me</label>
                                                </div>
                                            </div>
                                            <button name = "dangnhap" class=" btn btn-primary btn-user btn-block ">
                                                Login
                                            </button>
                                            <!-- <a href="index.html " >
                                                
                                            </a> -->
                                            <hr>
                                            <a href="index.html " class="btn btn-google btn-user btn-block ">
                                                <i class="fab fa-google fa-fw "></i> Login with Google
                                            </a>
                                            <a href="index.html " class="btn btn-facebook btn-user btn-block ">
                                                <i class="fab fa-facebook-f fa-fw "></i> Login with Facebook
                                            </a>
                                        </form>
                                        <hr>
                                        <div class="text-center ">
                                            <a class="small " href="forgot-password.html ">Forgot Password?</a>
                                        </div>
                                        <div class="text-center ">
                                            <a class="small " href="register.php ">Create an Account!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js "></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js "></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js "></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js "></script>
    <script>
        const pwd = document.getElementById("exampleInputPassword");
        const chk = document.getElementById("showCheckbox");
        chk.onchange = function(e){
            pwd.type = chk.checked ? "text" : "password";
        };
    </script>

</body>

</html>