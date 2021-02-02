<?php include '../db/db.php' ?>
<?php

$cat_name = null;

if (isset($_POST['catName'])) {
  $cat_name = $_POST['catName'];

  $sql = "INSERT INTO categories(name) values('$cat_name')";

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
  
    $sql = "DELETE FROM categories where id= $cat_del";
  
    if (mysqli_query($con, $sql)) {
      echo 1;
    } else{
      echo 2;
    }
  }

?>