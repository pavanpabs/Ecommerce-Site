<?php include '../db/db.php' ?>

<?php 
  if(isset($_POST['name'])){
	$username=$_POST['name'];
	$email=$_POST['email'];
	$pass=$_POST['password'];

    $sql="SELECT * From user where username='$username' OR email='$email'";
    $run=mysqli_query($con,$sql);
    $count=mysqli_num_rows($run);

    if($count==0){
        $sql="INSERT INTO userlogin(username,email,password) values('$username','$email','$pass')";
        $run=mysqli_query($con,$sql);
        $id= mysqli_insert_id($con);
        $sql1="INSERT INTO user(uID,username,email) values($id,'$username','$email')";
        $run1=mysqli_query($con,$sql1) ;
        if($run && $run1){
            echo 1;
        }else{
            echo mysqli_error($con);
        }

    }else if($count>0){
        echo 2;
    }
  }
 ?>