<?php
if (isset($_GET['sid'])) {
    $id = $_GET["sid"];
}

require_once("../../database/database.php");


$deletesql = "DELETE FROM typeproduct WHERE ID = $id";



if($mysqli->query($deletesql)===TRUE){
   echo "xoa thanh cong !";
} else {
  echo "that bai :".$mysqli->error;
}


header("Location: danhsachdanhmuc.php");
