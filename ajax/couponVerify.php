<?php include '../db/db.php';?>

<?php

//checking
$count=0;
if(isset($_POST['couponCode'])){
$cname=$_POST['couponCode'];
$cartId=$_POST['cartId'];

$sql="SELECT * FROM coupons WHERE coupon_name='$cname'";     
$run=mysqli_query($con,$sql);
$count=mysqli_num_rows($run);

if($count==1 && $run){
    while($row=mysqli_fetch_assoc($run)){
        $coupon_id=$row['coupon_id'];
        $discount=$row['coupon_discount'];
    }

    $sql2="UPDATE cart SET coupon=$coupon_id where cartId=$cartId"; 
    $run3=mysqli_query($con,$sql2);

   
    if($discount!==null && $run3){
        echo $discount;
    }
}else{
    echo 0;
}

}else{
    echo 0;
}


?>
