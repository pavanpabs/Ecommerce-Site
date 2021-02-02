<?php
// Start the session
session_start();
$userId=$_SESSION['userID'];
?>
<?php include 'db/db.php';?>
<?php include 'includes/header.php'?>
<?php include 'includes/refs.php'?>


	<!--================ End Header Menu Area =================-->
  
	<!-- ================ start banner area ================= -->	
	<section class="blog-banner-area" id="category">
		<div class="container h-100">
			<div class="blog-banner">
				<div class="text-center">
					<h1>Order Confirmation</h1>
					<nav aria-label="breadcrumb" class="banner-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Shop Category</li>
            </ol>
          </nav>
				</div>
			</div>
    </div>
	</section>
	<!-- ================ end banner area ================= -->
                 <?php 
                 $orderId=$_GET['oid'];
            $sql="SELECT * FROM orders c,orderproducts o,user u WHERE c.oId=o.oId AND c.uID=u.ID AND c.uID=$userId AND c.oId= $orderId";     
            $sql1="SELECT SUM(o.total) as sum FROM orders c,orderproducts o,product p WHERE c.oId=o.oId AND p.pId= o.pID AND c.uId=$userId AND c.oId= $orderId";
            $run=mysqli_query($con,$sql1);
            if($row1=mysqli_fetch_assoc($run)){
                $sum=$row1['sum'];
            }
            
            $run=mysqli_query($con,$sql);
            $subt=0;
            while($row=mysqli_fetch_assoc($run)){
                $order_id=$row['oId'];
                $order_time=date("Y-m-d  H:i ",strtotime($row['time']));
                $pay_method=$row['payMethod'];
                $names=$row['name'];
                $uName=explode("@@",$names);
                $address=$row['address'];
                $district=$row['district'];
                $phone=$row['phone'];
                $zipCode=$row['zipCode'];
               
            }
                          
            ?>
  <!--================Order Details Area =================-->
  <section class="order_details section-margin--small">
    <div class="container">
      <p class="text-center billing-alert">Thank you. Your order has been received.</p>
        <p class="text-center billing-alert">One of our agents will contact you soon..!</p>
      <div class="row mb-5">
        <div class="col-md-6 col-xl-6 mb-4 mb-xl-0">
          <div class="confirmation-card">
            <h3 class="billing-title">Order Info</h3>
            <table class="order-rable">
              <tr>
                <td>Order number</td>
                <td>: <?php echo $order_id?></td>
              </tr>
              <tr>
                <td>Date</td>
                <td>: <?php echo $order_time?></td>
              </tr>
              <tr>
                <td>Total</td>
                <td>: Rs. <?php echo $sum?></td>
              </tr>
              <tr>
                <td>Payment method</td>
                <td>: <?php echo $pay_method?></td>
              </tr>
            </table>
          </div>
        </div>
       
        <div class="col-md-6 col-xl-6 mb-4 mb-xl-0">
          <div class="confirmation-card">
            <h3 class="billing-title">Shipping Address</h3>
            <table class="order-rable">
             <tr>
                <td>Street</td>
                <td>: <?php echo $address?></td>
              </tr>
              <tr>
                <td>City</td>
                <td>: <?php echo $district?></td>
              </tr>
              <tr>
                <td>Country</td>
                <td>: Sri Lanka</td>
              </tr>
              <tr>
                <td>Postcode</td>
                <td>: <?php echo $zipCode?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="order_details_table">
        <h2>Order Details</h2>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Product</th>
                <th scope="col">Quantity</th>
                <th scope="col">Total</th>
              </tr>
            </thead>
            <tbody>
             <?php 
            $sql="SELECT * FROM orders c,orderproducts o,product p WHERE c.oId=o.oId AND p.pId= o.pID AND c.uId=$userId AND c.oId= $orderId";     
            $sql1="SELECT SUM(o.total) as sum FROM orders c,orderproducts o,product p WHERE c.oId=o.oId AND p.pId= o.pID AND c.uId=$userId AND c.oId= $orderId";
            $run=mysqli_query($con,$sql1);
            if($row1=mysqli_fetch_assoc($run)){
                $sum=$row1['sum'];
            }
            
            $run=mysqli_query($con,$sql);
            $subt=0;
            while($row=mysqli_fetch_assoc($run)){
                $name=$row['pname'];
                $price=$row['price'];
                $qty=$row['qty'];
                $ship_method=$row['shipMethod'];
                $ship_price=$row['shipPrice'];
                $tot=$row['total'];
                $subt=$subt + $price;
                          
                          
            ?>
                            
                <tr>
                    <td>
                      <p><?php echo $name?></p>
                    </td>
                    <td>
                      <h5>x <?php echo $qty?></h5>
                    </td>
                    <td>
                      <p>Rs. <?php echo $tot?></p>
                    </td>
              </tr>
                    <?php }
            ?>
              
              <tr>
                <td>
                  <h4>Subtotal</h4>
                </td>
                <td>
                  <h5></h5>
                </td>
                <td>
                  <p><p>Rs. <?php echo $subt?></p>
                </td>
              </tr>
              <tr>
                <td>
                  <h4>Shipping</h4>
                </td>
                <td>
                  <h5></h5>
                </td>
                <td>
                  <p><?php echo $ship_method?>:Rs.<?php echo $ship_price?></p>
                </td>
              </tr>
              <tr>
                <td>
                  <h4>Total</h4>
                </td>
                <td>
                  <h5></h5>
                </td>
                <td>
                  <h4>Rs. <?php echo $subt + $ship_price ?></h4>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
      
<div class="text-center col-md-2 m-5 float-right">
        <a class="button button-paypal" href="my-orders.php">Go to My Orders</a>
    </div>
  </section>
  <!--================End Order Details Area =================-->


  <?php include 'includes/footer.php'?>