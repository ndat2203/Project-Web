<?php
session_start();
require_once("admincp/database/database.php");
$userID = $_SESSION['UserID'];
// Biến lưu thông báo cho người dùng
$response = [
    "success" => false,
    "message" => "",
    "discount_percentage" => 0
];

// Kiểm tra khi người dùng gửi mã giảm giá
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['voucher_code'])) {
    $voucher_code = trim($_POST['voucher_code']); // Lấy mã giảm giá từ form
    
    if (empty($voucher_code)) {
        // Nếu mã giảm giá trống, thông báo lỗi
        $response['message'] = "Mã giảm giá không được để trống!";
    } else {
        // Truy vấn kiểm tra mã giảm giá
        $sql = "SELECT * FROM vourcher WHERE VourcherCode = ? AND VoucherCount > 0 AND VourcherTime >= NOW()";
        $stmt = $mysqli->prepare($sql);
        
        if ($stmt === false) {
            $response['message'] = 'Lỗi hệ thống khi chuẩn bị truy vấn.';
            echo json_encode($response);
            exit;
        }

        $stmt->bind_param("s", $voucher_code); // Gán giá trị mã giảm giá vào câu truy vấn
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            // Mã giảm giá hợp lệ
            $voucher = $result->fetch_assoc();
            $discount_value = $voucher['VourcherDiscount']; // Lấy giá trị giảm giá

            // Giảm số lượng voucher
            $update_sql = "UPDATE vourcher SET VoucherCount = VoucherCount - 1 WHERE VourcherCode = ?";
            $update_stmt = $mysqli->prepare($update_sql);
            
            if ($update_stmt === false) {
                $response['message'] = 'Lỗi hệ thống khi cập nhật số lượng mã giảm giá.';
                echo json_encode($response);
                exit;
            }

            $update_stmt->bind_param("s", $voucher_code);
            $update_stmt->execute();

            // Hiển thị thông báo thành công
            $response['success'] = true;
            $response['message'] = "Mã giảm giá áp dụng thành công! Bạn được giảm {$discount_value}%.";
            $response['discount_percentage'] = $discount_value;
            // Lưu mã giảm giá và giá trị giảm vào session để áp dụng cho giỏ hàng
            $_SESSION['voucher_discount'] = $discount_value;
        } else {
            // Mã giảm giá không hợp lệ
            $response['message'] = "Mã giảm giá không hợp lệ, đã hết hạn hoặc hết số lượng!";
        }
    }
    // $customername = isset($_POST['hoTen']) ? trim($_POST['hoTen']) : null;
    // $address = isset($_POST['address']) ? trim($_POST['address']) : null;
    // $phone = isset($_POST['Phone']) ? trim($_POST['Phone']) : null;

    // $updateCustomerQuery = "UPDATE customer SET customername = ?, Address = ?, Phone = ? WHERE id = ?";
    // $stmt = $mysqli->prepare($updateCustomerQuery);
    // if (!$stmt) {
    //     die("Lỗi chuẩn bị truy vấn: " . $mysqli->error);
    // }
    // $stmt->bind_param("sssi", $customername, $address, $phone, $userID);
    // if ($stmt->execute()) {
    //     echo "Cập nhật thông tin khách hàng thành công!<br>";
    // } else {
    //     echo "Lỗi khi cập nhật thông tin khách hàng: " . $stmt->error;
    // }
  
   




}

// Trả về phản hồi JSON 
header('Content-Type: application/json');
echo json_encode($response);


?>
