<?php include '../db/db.php';?>

<?php

//checking
$count=0;
if(isset($_POST['prd'])){
$product_id=$_POST['prd'];
$qty=$_POST['qty'];
$user=$_POST['usr'];

$sql="SELECT * FROM cart c,cartorders o WHERE c.cartId=o.cartId AND o.pID=$product_id AND c.uId=$user";     
$run=mysqli_query($con,$sql);
$count=mysqli_num_rows($run);
if($count==0 && $run){
    $sqli="SELECT * FROM product WHERE pId=$product_id ";
    $result=mysqli_query($con,$sqli);
    while($row=mysqli_fetch_assoc($result)){
        $price=$row['price'];
    }
    $tot=$price*$qty;
    
    $sql="insert INTO cart(uId) VALUES('$user')";
    $result1=mysqli_query($con,$sql);
    echo mysqli_error($con);
    $id= mysqli_insert_id($con);
    $sql1="INSERT INTO cartorders(cartId,pID,qty,total) values($id,$product_id,$qty,$tot)";
    $run=mysqli_query($con,$sql1);
    if($run && $result1){
        echo 1;
    }
}else{
    echo 2;
}

}else{
    echo 3;
}


?>
