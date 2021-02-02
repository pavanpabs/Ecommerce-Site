<?php include 'db/db.php';?>
<?php include 'includes/refs.php'?>

<?php
// Start the session
session_start();
?>
<?php include 'includes/header.php';
?>

<script>
    $(document).ready(function(){ 
      var userId='<?= $userId ?>';
      if(userId==0){
        toastr.info(
						'Please Log on to the system !','', {
							timeOut: 3000,
							onHidden: function() {
								window.location.replace('login.php?redirect=cart.php');
							}
						}
					);
      }else{
        $('#cartTable').load("ajax/updateCart.php",{
               
              });
      }
        
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
<div id="cartTable">
  
            
                      
</div>
  <!--================End Cart Area =================-->



<?php include 'includes/footer.php'?>