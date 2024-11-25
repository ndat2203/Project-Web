<?php
session_start();
require_once("admincp/database/database.php");

if (isset($_SESSION['UserID'])) {
    $userID = $_SESSION['UserID'];
} else {
    echo "Bạn chưa đăng nhập.";
    exit;  
}
$thanhtien = 0; 
$totalQuantity = 0;
// Truy vấn để lấy BillID từ bảng bills
$idbill = "SELECT * FROM bills WHERE CustomerID = ?";
$stmt_idbill = $mysqli->prepare($idbill);
$stmt_idbill->bind_param("i", $userID); 
$stmt_idbill->execute();
$result_idbill = $stmt_idbill->get_result();

if ($result_idbill && $result_idbill->num_rows > 0) {
    $row_idbill = $result_idbill->fetch_assoc();
    $billid = $row_idbill['ID'];

    // Truy vấn để lấy các chi tiết của hóa đơn từ bảng billdetail
      $sql = "SELECT billdetail.*, product.Name as product_name, product.Image1 as product_image FROM billdetail
              INNER JOIN product ON product.ID = billdetail.ProductID
              WHERE BillID = ?";
      $stmt_sql = $mysqli->prepare($sql);
      $stmt_sql->bind_param("i", $billid); 
      $stmt_sql->execute();
      $result_sql = $stmt_sql->get_result();

    
   
} else {
    echo "Không tìm thấy hóa đơn cho người dùng này.";
}



$stmt_idbill->close();
$stmt_sql->close();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title>Daily Shop | Cart Page</title>
    
    <!-- Font awesome -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">   
    <!-- SmartMenus jQuery Bootstrap Addon CSS -->
    <link href="css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
    <!-- Product view slider -->
    <link rel="stylesheet" type="text/css" href="css/jquery.simpleLens.css">    
    <!-- slick slider -->
    <link rel="stylesheet" type="text/css" href="css/slick.css">
    <!-- price picker slider -->
    <link rel="stylesheet" type="text/css" href="css/nouislider.css">
    <!-- Theme color -->
    <link id="switcher" href="css/theme-color/default-theme.css" rel="stylesheet">
    <!-- Top Slider CSS -->
    <link href="css/sequence-theme.modern-slide-in.css" rel="stylesheet" media="all">

    <!-- Main style sheet -->
    <link href="css/style.css" rel="stylesheet">    

    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <script src="https://kit.fontawesome.com/ff4b23649f.js" crossorigin="anonymous"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>
   
   <!-- wpf loader Two -->
    <div id="wpf-loader-two">          
      <div class="wpf-loader-two-inner">
        <span>Loading</span>
      </div>
    </div> 
    <!-- / wpf loader Two -->       
 <!-- SCROLL TOP BUTTON -->
    <a class="scrollToTop" href="#"><i class="fa fa-chevron-up"></i></a>
  <!-- END SCROLL TOP BUTTON -->
  <?php
    include("pages/header.php");
    include("pages/menu.php");
  ?>



 

 <!-- Cart view section -->
 <section id="cart-view">
   <div class="container">
     <div class="row">
       <div class="col-md-12">
         <div class="cart-view-area">
           <div class="cart-view-table">
             <form action="usevourcher.php" method="POST" id="voucher_form">
               <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Size</th>
                        <th>Giá </th>
                        <th>Số lượng</th>
                        <th>Tổng tiền</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                         while ($row_sql = $result_sql->fetch_assoc()) {
                          $totalQuantity += $row_sql['Quantity'];
                          $tongtien = $row_sql['Price'] *  $row_sql['Quantity'];
                          $thanhtien += $tongtien;
                      ?>
                      <tr>
                        <td>
                        <a onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm này')" class="remove" href="xoadonhang.php?sid=<?php echo htmlspecialchars($row_sql['ID']); ?>"><i class="fa-solid fa-trash-can"></i></a>
                          <!-- <button class="remove" type="submit" value="<?php echo htmlspecialchars($row_sql['ID']); ?>" name="billDetailID" style="border: none; outline: none; background: none; cursor: pointer;"></button> -->
                   
                      </td>
                        <td><a href="#"><img src="../Uploads/<?php echo htmlspecialchars($row_sql['product_image']); ?>" alt="img"></a></td>
                        <td><a class="aa-cart-title" href="#"><?php echo htmlspecialchars($row_sql['product_name']); ?></a></td>
                        <td><a class="aa-cart-title" href="#"><?php echo htmlspecialchars($row_sql['Size']); ?></a></td>
                        <td><?php echo number_format($row_sql['Price'], 0, ',', '.'); ?>đ</td>
                        <td><?php echo number_format($row_sql['Quantity']); ?></td>
                        <td><?php echo number_format($tongtien, 0, ',', '.'); ?>đ</td>
                      </tr>
                      <?php
                         }
                      ?>
                      <?php
                          $update_query = "UPDATE bills SET TotalPrice = ?, TotalQuantity = ? WHERE ID = ?";
                          $stmt_update = $mysqli->prepare($update_query);
                  
                          if (!$stmt_update) {
                              die("Lỗi chuẩn bị truy vấn cập nhật hóa đơn: " . $mysqli->error);
                          }
                  
                          $stmt_update->bind_param("dii", $thanhtien, $totalQuantity, $billid); // d: double, i: integer
                          $stmt_update->execute();  
                              
                          
                  
                          $stmt_update->close();
                          
                      ?>
                     
                      <tr>
                        <td colspan="6" class="aa-cart-view-bottom">
                         
                            <div class="aa-cart-coupon">
                              <input style="text-transform: lowercase;" class="aa-coupon-code" type="text" name="voucher_code" placeholder="Nhập mã giảm giá">
                              <input class="aa-cart-view-btn" type="submit" value="Áp dụng">
                              <div id="voucher_message"></div> <!-- Nơi hiển thị thông báo -->
                            </div>  
                           

                          <a href="./index.php" class="aa-cart-view-btn">Tiếp tục mua hàng</a>
                          <!-- <input class="aa-cart-view-btn" type="submit" value="Update Cart"> -->
                        </td>

                      </tr>
                      
                      </tbody>
                  </table>
                </div>
             </form>
             <!-- Cart Total view -->
             <div class="cart-view-total">
               <h4>Tổng tiền giỏ hàng</h4>
               <table class="aa-totals-table">
                 <tbody>
                   <tr>
                     <th>Giảm giá</th>
                     <td id="voucher_display">0%</td>
                   </tr>
                   <tr>
                     <th>Tổng tiền sản phẩm</th>  
                     <td><?php echo number_format($thanhtien, 0, ',', '.'); ?></td>
                   </tr>
                   <tr>
                     <th>Thành tiền </th>
                     <td><?php echo number_format($thanhtien, 0, ',', '.'); ?></td>
                   </tr>
                 </tbody>
               </table>
               <a href="checkout.php" class="aa-cart-view-btn">Thanh toán</a>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
 </section>
 <!-- / Cart view section -->



  <?php
    include("pages/footer.php");

    ?>
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
                <div class="modal-body">Bạn có chắc là muốn đăng xuất</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                    <a class="btn btn-primary" href="admincp/login.php">Logout</a>
                </div>
            </div>
        </div>
    </div> 
    <script>
        document.getElementById('voucher_form').addEventListener('submit', function(event) {
          event.preventDefault(); // Ngăn chặn reload trang khi gửi form

          // Lấy giá trị mã giảm giá từ input
          const voucherCode = document.querySelector('input[name="voucher_code"]').value.trim();

          // Gửi yêu cầu AJAX đến usevoucher.php
          fetch('usevourcher.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `voucher_code=${encodeURIComponent(voucherCode)}`,
          })
      .then(response => response.json())
      .then(data => {
        // Hiển thị thông báo cho người dùng
        const voucherMessage = document.getElementById('voucher_message');
        voucherMessage.innerHTML = data.message;

        if (data.success) {
          voucherMessage.style.color = 'green';
          const discountElement = document.getElementById('voucher_display');
          if (discountElement) {
            discountElement.innerHTML = `${data.discount_percentage}%`; // Hiển thị phần trăm giảm giá
          } else {
            console.log('Phần tử hiển thị giảm giá không tồn tại!');
          }
           // Lấy phần trăm giảm giá từ thông báo
           const discountPercentage = parseFloat(data.message.match(/(\d+)%/)[1]);

          // Tính toán lại tổng tiền sau khi giảm giá
          const totalPriceElement = document.querySelector('.cart-view-total .aa-totals-table tbody tr:nth-child(3) td');
          const originalPrice = parseFloat(totalPriceElement.textContent.replace(/\./g, ''));
          const discountValue = (originalPrice * discountPercentage) / 100;
          const newTotalPrice = originalPrice - discountValue;

          // Cập nhật hiển thị tổng tiền mới
          totalPriceElement.innerHTML = `${newTotalPrice.toLocaleString()}đ`;


        } else {
          voucherMessage.style.color = 'red';
        }
      })
      .catch(error => {
        console.error('Có lỗi xảy ra:', error);
        alert('Không thể áp dụng mã giảm giá. Vui lòng thử lại!');
      });
  });
</script>



    
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.js"></script>  
    <!-- SmartMenus jQuery plugin -->
    <script type="text/javascript" src="js/jquery.smartmenus.js"></script>
    <!-- SmartMenus jQuery Bootstrap Addon -->
    <script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>  
    <!-- To Slider JS -->
    <script src="js/sequence.js"></script>
    <script src="js/sequence-theme.modern-slide-in.js"></script>  
    <!-- Product view slider -->
    <script type="text/javascript" src="js/jquery.simpleGallery.js"></script>
    <script type="text/javascript" src="js/jquery.simpleLens.js"></script>
    <!-- slick slider -->
    <script type="text/javascript" src="js/slick.js"></script>
    <!-- Price picker slider -->
    <script type="text/javascript" src="js/nouislider.js"></script>
    <!-- Custom js -->
    <script src="js/custom.js"></script> 

  </body>
</html>