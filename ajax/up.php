<?php include '../db/db.php';?>
<?php
// Start the session
session_start();
$userId=$_SESSION['userID'];
?>
<?php
    if(isset($_POST['updateId'])){
       $id= $_POST['updateId'];
        $qty= $_POST['qty'];
        $price= $_POST['price'];
        $tot=$price* $qty;
        $sql="UPDATE cartorders set qty=$qty,total=$tot  WHERE id=$id";
        echo "in...";
    }
echo "out";
?>