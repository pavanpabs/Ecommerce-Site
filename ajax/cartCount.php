<?php include '../db/db.php';?>
<?php
$user=$_POST['user'];
$sql2="SELECT * FROM cart WHERE uId='$user'";
$result=mysqli_query($con,$sql2);
$count=mysqli_num_rows($result);
echo $count;
?>