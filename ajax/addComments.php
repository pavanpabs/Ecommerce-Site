<?php include '../db/db.php' ?>
<?php


if (isset($_POST['rating'])) {
  $com_rating = $_POST['rating'];
  $com_user = $_POST['usr'];
  $com_name = $_POST['name'];
  $com_body = $_POST['body'];
  $pro_id = $_POST['p_id'];

  $sql1 = "SELECT * FROM comments where user_id=$com_user AND product_id=$pro_id";
  $run=mysqli_query($con, $sql1);
  $count=mysqli_num_rows($run);
    if ($count > 0) {
        echo 2;
    } else if ($count == 0) {
        $sql = "INSERT INTO comments(user_id,product_id,rating,display_name,body) values($com_user,$pro_id,$com_rating,'$com_name','$com_body')";
        if (mysqli_query($con, $sql)) {
            echo 1;
        } else {
            echo 3;
        }
    }
}
if (isset($_POST['editVal'])) {
    $com_body = $_POST['editVal'];
    $com_id = $_POST['editId'];
  
  
    $sql1 = "UPDATE comments SET body='$com_body' where id=$com_id";
    $run=mysqli_query($con, $sql1);
      if ($run) {
          echo 1;
      } else {
         echo 3;
      }
  }
  if (isset($_POST['delVal'])) {
    $com_id = $_POST['delVal'];

    $sql1 = "DELETE FROM comments where id=$com_id";
    $run=mysqli_query($con, $sql1);
      if ($run) {
          echo 1;
      } else {
         echo 3;
      }
  }

?>