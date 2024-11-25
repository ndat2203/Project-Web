<?php
session_start();
require_once("admincp/database/database.php");
if (isset($_SESSION['UserID'])) {
  // Nếu có, lấy giá trị UserID
  $userID = $_SESSION['UserID'];
  
 
} else {
  // Nếu không có UserID, có thể người dùng chưa đăng nhập
  echo "Bạn chưa đăng nhập.";
}
date_default_timezone_set('Asia/Ho_Chi_Minh'); // Đặt múi giờ cho Việt Nam
$currentDateTime = date('Y-m-d H:i:s');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $productid = $_POST['productid'];
    $soluongmua = $_POST['soluongmua'];
    $price = $_POST['price'];
    $size = $_POST['sizes'];
   



    // Truy vấn để lấy BillID
    $idbill = "SELECT * FROM bills WHERE CustomerID = $userID";
    $result_idbill = mysqli_query($mysqli, $idbill);
    
    if ($result_idbill && mysqli_num_rows($result_idbill) > 0) {
        $row_idbill = mysqli_fetch_assoc($result_idbill);
        $billid = $row_idbill['ID'];
        
        // Câu lệnh INSERT vào bảng billdetail
        $query = "INSERT INTO billdetail (BillID, ProductID, Price, Quantity, Size, created_at)
                  VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $mysqli->prepare($query);
        
        // Kiểm tra xem câu lệnh chuẩn bị thành công không
        if ($stmt === false) {
            echo "Lỗi trong việc chuẩn bị câu lệnh: " . $mysqli->error;
            exit;
        }
        
        // Bind tham số
        $stmt->bind_param("iiisss", $billid, $productid, $price, $soluongmua, $size, $currentDateTime);
        
        // Thực thi câu lệnh
         $stmt->execute();
          

        // Đóng statement
        $stmt->close();
    } else {
        echo "Không tìm thấy hóa đơn cho người dùng này.";
    }
}
?>
    <!DOCTYPE html>
    <html>

    <head>
      <title>Xác nhận thêm sản phẩm vào giỏ hàng</title>
      <!-- Nạp các tệp CSS của Bootstrap -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>

    <body>

      <div class="container mt-5 h-[500px]">
        <!-- Sử dụng lớp "alert alert-success" để tạo thông báo thành công -->
        <div class="alert alert-success rounded shadow-sm " role="alert">
          <h4 class="alert-heading">Sản phẩm đã được thêm vào giỏ hàng thành công!</h4>
          <p>Sản phẩm của bạn đã được thêm vào giỏ hàng thành công lúc: <?php echo $currentDateTime ?> .</p>
          <hr>
          <p class="mb-0">Bạn muốn tiếp tục mua sắm hoặc đi đến trang thanh toán?</p>
          <div class="mt-3">
            <a href="./index.php" class="btn btn-primary mr-2">Tiếp tục mua hàng</a>
            <a href="checkout.php" class="btn btn-success">Đến trang thanh toán</a>
          </div>
        </div>
      </div>

      <!-- Nạp tệp JavaScript của Bootstrap (tùy chọn) -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </body>

    </html>
 