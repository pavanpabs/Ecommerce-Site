<?php include '../db/db.php';?>
<?php
// Start the session
session_start();

if(!isset($_SESSION['userID'])){
    header('Location: ./login.php');
}else{
    $userId=$_SESSION['userID'];
}
?>

<?php
    if(isset($_POST['updateId'])){
       $id= $_POST['updateId'];
        $qty= $_POST['qty'];
        $price= $_POST['price'];
        $tot=$price* $qty;
        $sql="UPDATE cartorders set qty=$qty,total=$tot  WHERE id=$id";
        $run=mysqli_query($con,$sql);
        
    }

?>
<?php
    if(isset($_POST['delId'])){
        echo "testing";
       $id= $_POST['delId'];
        $sql="DELETE FROM cartorders WHERE id=$id";
        $run=mysqli_query($con,$sql);
        $sql1="DELETE FROM cart WHERE cartId=$id";
        $run=mysqli_query($con,$sql1);
        
    }

?>
<section class="cart_area mb-0">
      <div class="container ">
          <div class="cart_inner">
              <div class="table-responsive">
                  <table class="table">
                      <thead>
                          <tr>
                              <th scope="col">Product</th>
                              <th scope="col">Address</th>
                              <th scope="col">Price</th>
                              <th scope="col">Quantity</th>
                              <th scope="col">Total</th>
                              
                          </tr>
                      </thead>
                      <tbody >

<?php 
            $sql="SELECT * FROM orders c,orderproducts o,product p,user u WHERE c.oId=o.oId AND p.pId= o.pId AND u.ID=c.uID AND c.uID='$userId'";     
            $sql1="SELECT SUM(o.total) as sum FROM orders c,orderproducts o,product p WHERE c.oId=o.oId AND p.pId= o.pId AND c.uID='$userId'";
            $run=mysqli_query($con,$sql1);
            if($row1=mysqli_fetch_assoc($run)){
                $sum=$row1['sum'];
            }
            
            $run=mysqli_query($con,$sql);
            $subt=0;
            while($row=mysqli_fetch_assoc($run)){
                $cust_fullName=$row['name'];
                $cust_fullName1=explode("@@",$cust_fullName);
                $cust_address=$row['address'];
                $cust_zip=$row['zipCode'];
                $cust_phone=$row['phone'];
                $cId=$row['oId'];
                $cOd=$row['pId'];
                $name=$row['pname'];
                $price=$row['price'];
                $qty=$row['qty'];
                $images=$row['images'];
                $image=explode("|",$images);
                $tot=$row['total'];
              
                          
                          
            ?>
               <tr>
                              <td>
                                  <div class="media">
                                      <div class="my-4 mr-3">
                                          <button id="del<?php echo $cId ?>" type="button"  class="page-link"><i class="fas fa-trash-alt"></i>
                                          </button>
                                      </div>
                                      <div class="d-flex"  height="100px">
                                          <img width="150px" src="img/product/<?php echo $image[0]?>" alt="">
                                      </div>
                                      <div class="media-body">
                                      <p><?php echo $name ?></p>
                                      </div>
                                  </div>
                              </td>
                              <td>
                              
                              <p><?php echo $cust_fullName1[0] ?> <?php echo $cust_fullName1[1] ?><br>
                                          <?php echo $cust_address ?><br>
                                          <?php echo $cust_zip ?><br>
                                          <?php echo $cust_phone ?></p>
                              </td>
                              <td>
                                  <h5>Rs.<?php echo $price ?></h5>
                              </td>
                              <td >
                                  <div class="product_count">
                                  <p><?php echo $qty ?></p>
                                  </div>
                              </td>
                              <td >
                                  <h5>Rs.<?php echo $tot ?></h5>
                              </td>
                                
                          </tr> 
                        <script>
    $(document).ready(function(){ 
           
           
           $(document).on('click', '#del<?php echo $cId ?>', function(){     
                var delId=<?php echo $cId ?>;
                
                $('#cartTable').load("ajax/updateCart.php",{
                    delId:delId
                });                     
                
            });
            

    });
     

  </script>
           <?php }
            ?>
                          
                        
                          
                          
                          
                        </tbody>
                  </table>
              </div>
          </div>
      </div>
  </section>
    
                   