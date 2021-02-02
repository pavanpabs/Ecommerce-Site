<?php
// Start the session
session_start();
$userId=$_SESSION['userID'];
?>
<?php include '../db/db.php';?>


<?php

    if(isset($_POST['fname'])){
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $pnumber=$_POST['pnumber'];
        $district=$_POST['district'];
        $address=$_POST['address'];
        $zip=$_POST['zip'];
        $ship_method=$_POST['shippingMetho'];
        $ship_price=$_POST['shippingPrice'];
        $payingMehod=$_POST['paySelector'];
        $coupon=$_POST['coupon'];
        $cname = array();
        array_push($cname,$fname,$lname);
        $name=implode("@@",$cname);
        $sql="UPDATE user SET name='$name',address='$address',district='$district',phone='$pnumber',zipCode='$zip' WHERE ID=$userId";
        $result=mysqli_query($con,$sql);
        
        //Checking if exists
        // $sql="SELECT * FROM cart c,cartorders o,product p WHERE c.cartId=o.cartId AND p.pId= o.pID AND c.uId=$userId";     
        // $run=mysqli_query($con,$sql);
        // $subt=0;
        // while($row=mysqli_fetch_assoc($run)){
        //     $cId=$row['cartId'];
        //     $product_id=$row['pID'];
        //     $coupon=$row['coupon'];
        //     $name=$row['pname'];
        //     $qty=$row['qty'];
        //     $tot=$row['total'];
            
        // $sql2="SELECT * FROM orders o, orderProducts p where o.oId=p.oId and p.pId=$product_id and o.uID=$userId";
        // $result1=mysqli_query($con,$sql2);
        // $count=mysqli_num_rows($result1);
        // if($count==0){
        
        $sql2="SELECT * FROM orders o, orderProducts p where o.iId=p.oId and p.pId= and o.uID=$userId";

        $sql1="INSERT INTO orders(uID,payMethod,shipMethod,shipPrice,o_coupon) values('$userId','$payingMehod','$ship_method','$ship_price',$coupon)";
        $result=mysqli_query($con,$sql1);
        $id= mysqli_insert_id($con);
                      
            $sql="SELECT * FROM cart c,cartorders o,product p WHERE c.cartId=o.cartId AND p.pId= o.pID AND c.uId=$userId";     
            $run=mysqli_query($con,$sql);
            $subt=0;
            while($row=mysqli_fetch_assoc($run)){
                $cId=$row['cartId'];
                $product_id=$row['pID'];
                $name=$row['pname'];
                $qty=$row['qty'];
                $tot=$row['total'];
                
            $sql2="INSERT INTO orderproducts(oId,pId,qty,total) values($id,$product_id,$qty,$tot)"; 
            $result1=mysqli_query($con,$sql2);
            }
            
          if($result && $result1){
              $sql="DELETE cartorders,cart FROM cartorders LEFT JOIN  cart ON cart.cartId=cartorders.cartId WHERE cart.uId=$userId";
              $run=mysqli_query($con,$sql);
              if($run){
            //   header('Location:http://localhost/aroma/confirmation.php');
              echo $id;
              }else{
                  echo "-1";
              }
          }else{
            echo "-1";
          }   
        // }else{
        //     mysqli_error($con);
        //     header('Location:http://localhost/aroma/index.php?error');
        // }
        



        
    }
?>