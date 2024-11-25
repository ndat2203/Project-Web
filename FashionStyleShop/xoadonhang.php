<?php

if (isset($_GET['sid'])) {
    $id = $_GET["sid"];
}

require_once("admincp/database/database.php");


$deletesql = "DELETE FROM billdetail WHERE ID = $id";



if($mysqli->query($deletesql)===TRUE){
   echo "xoa thanh cong !";
} else {
  echo "that bai :".$mysqli->error;
}


header("Location: cart.php");


// xoa don hang
// if (isset($_POST["billDetailID"])) {
//     $billDetailID = $_POST["billDetailID"];
//     $delete = "DELETE FROM billdetail WHERE ID = ?";
//     $stmt_delete = $mysqli->prepare($delete);
//     $stmt_delete->bind_param("i", $billDetailID);
//     if (!$stmt_delete->execute()) {
//         echo "Lỗi khi thực hiện truy vấn xóa: " . $mysqli->error;
//     } else {
//         echo "Xóa sản phẩm thành công.";
//     }
   
//     $stmt_delete->close();
//   }

?>