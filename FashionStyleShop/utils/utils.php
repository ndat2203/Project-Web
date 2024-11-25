<?php
    require_once("../admincp/database/database.php");
function showAlert($message)
{
  echo "<script type='text/javascript'>alert('$message');</script>";
}
// kiem tra de dam bao la email duy nhat
function isEmailExist($mysqli, $email)
{
  $query = "SELECT COUNT(*) as total FROM customer WHERE email = ?";
  $stmt = $mysqli->prepare($query);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  return $row['total'] > 0;
}
function executePreparedStatement($mysqli, $query, $types, ...$params)
{
  $stmt = $mysqli->prepare($query);
  $stmt->bind_param($types, ...$params);
  $stmt->execute();
  return $stmt;
}
// kiem tra thong tin dang nhap
function Authentication($mysqli, $email, $password)
{
    $query = "SELECT * FROM `customer` WHERE email=?";
    $stmt = executePreparedStatement($mysqli, $query, "s", $email);
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // So sánh mật khẩu người dùng nhập vào với mật khẩu đã băm trong cơ sở dữ liệu
        if (password_verify($password, $user['password'])) {
            return true; // Đăng nhập thành công
        }
    }
    return false; // Đăng nhập thất bại
}
// thiết lập các thông tin phiên làm việc (session) cho người dùng sau khi họ đã được xác thực thành công
function Authorization($mysqli, $email)
{
  $query = "SELECT id, customername, role FROM `customer` WHERE email=?";
  $stmt = executePreparedStatement($mysqli, $query, "s", $email);
  $result = $stmt->get_result();
  if($result->num_rows === 1){
    $row = $result->fetch_assoc();
    $_SESSION['email'] = $email;
    $_SESSION['UserID'] = $row['id'];
    $_SESSION['UserName'] = $row['customername'];
    $_SESSION['role'] = $row['role'];
  }else{
    echo "Người dùng không tồn tại.";
    exit();
  }
  
}
// Function to unset and destroy user session
function unsetUserSession()
{
  $_SESSION = array();
  session_destroy();
  if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
  }
}

// Chức năng kiểm tra vai trò truy cập và chuyển hướng nếu cần thiết
function checkAccessRole($requiredRole)
{
  if (!isset($_SESSION["email"])) {
    header("Location: ../admincp/login.php");
    exit();
  }
  $email = $_SESSION["email"];
  require_once("../admincp/database/database.php");
  $query = "SELECT role FROM customer WHERE email=?";
  $stmt = executePreparedStatement($mysqli, $query, "s", $email);
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if ($user["role"] != $requiredRole) {
    unsetUserSession();
    header("Location: ../admincp/login.php");
    exit();
  }
}
// Function to get entity ID from the database
function getEntityID($mysqli, $table, $columnName, $value)
{
  $query = "SELECT {$table}ID FROM {$table} WHERE {$columnName}=?";
  $stmt = executePreparedStatement($mysqli, $query, "s", $value);
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  return $row["{$table}ID"];
}
// them nguoi dung
function insertUserData($mysqli, $UserName, $email, $password)
{
  $query = "INSERT INTO customer(customername, email, password) VALUES (?,?,?);";
  $stmt = $mysqli->prepare($query);
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $stmt->bind_param("sss", $UserName, $email, $hashedPassword);

  return $stmt->execute();
}
function autoLogoutAfterInactivity($timeoutInSeconds, $redirectURL)
{
  if (!isset($_SESSION["last_activity"])) {
    $_SESSION["last_activity"] = time();
  }

  if ((time() - $_SESSION["last_activity"]) > $timeoutInSeconds) {
    session_unset();
    session_destroy();
    if (isset($_COOKIE[session_name()])) {
      setcookie(session_name(), '', time() - 3600, '/');
    }
    header("Location: ../pages/$redirectURL");
    exit();
  }

  $_SESSION["last_activity"] = time();
}
?>