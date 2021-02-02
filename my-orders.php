<?php
// Start the session
session_start();
?>
<?php include 'db/db.php';?>
<?php include 'includes/refs.php'?>
<?php include 'includes/header.php'?>

<script>
    $(document).ready(function(){ 
           
        $('#myOrderTable').load("ajax/myOrders.php",{
               
        });
      
         
        

    });
     

  </script>
	<!-- ================ start banner area ================= -->	
	<section class="blog-banner-area" id="category">
		<div class="container h-100">
			<div class="blog-banner">
				<div class="text-center">
					<h1>Shopping Cart</h1>
					<nav aria-label="breadcrumb" class="banner-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
            </ol>
          </nav>
				</div>
			</div>
    </div>
	</section>
	<!-- ================ end banner area ================= -->
 
  

  <!--================Cart Area =================-->
<div id="myOrderTable">
  
            
                      
</div>
  <!--================End Cart Area =================-->



<?php include 'includes/footer.php'?>