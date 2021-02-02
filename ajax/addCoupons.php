<?php include '../db/db.php' ?>
<?php


if (isset($_POST['couName'])) {
  $cou_name = $_POST['couName'];
  $cou_name =strtolower($cou_name);
  $cou_discount = $_POST['couDiscount'];

  $sql = "INSERT INTO coupons(coupon_name,coupon_discount) values('$cou_name',$cou_discount)";

  if (mysqli_query($con, $sql)) {
    echo 1;
  } else{
    echo 2;
  }
}

if (isset($_POST['just'])) {
    $cat_name = $_POST['just'];
    $cat_id = $_POST['id'];
  
    $sql = "UPDATE categories set name='$cat_name' where id= $cat_id";
  
    if (mysqli_query($con, $sql)) {
      echo 1;
    } else{
      echo 2;
    }
  }
  if (isset($_POST['del'])) {
    $cat_del= $_POST['del'];
  
    $sql = "DELETE FROM coupons where coupon_id= $cat_del";
  
    if (mysqli_query($con, $sql)) {
      echo 1;
    } else{
      echo 2;
    }
  }

?>