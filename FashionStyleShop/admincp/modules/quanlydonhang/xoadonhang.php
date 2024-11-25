<?php
if (isset($_GET['sid'])) {
    $id = $_GET["sid"];
}

require_once("../../database/database.php");

// Bước 1: Xóa các bản ghi trong `billdetail` theo `BillID`
$sql = "DELETE FROM billdetail WHERE BillID = $id";
if ($mysqli->query($sql) === TRUE) {
    // Bước 2: Sau khi xóa thành công trong `billdetail`, xóa bản ghi trong `bills`
    $deletesql = "DELETE FROM bills WHERE ID = $id";
    if ($mysqli->query($deletesql) === TRUE) {
        echo "Xóa thành công!";
    } else {
        echo "Lỗi khi xóa trong bảng bills: " . $mysqli->error;
    }
} else {
    echo "Lỗi khi xóa trong bảng billdetail: " . $mysqli->error;
}
    header("Location: danhsachdonhang.php");
?>


 
