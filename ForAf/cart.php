
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<script>
    $(document).ready(function(){ 
           
        $('#cartTable').load("ajax/updateCart.php",{
               
        });
      
         
        

    });
     

  </script>

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

  <div class="toast m-5 alert alert-success shadow " id="myToast" style="position: fixed; top:0; right: 0;z-index:10000" data-delay="5000">
         <div class="toast-header">
      <img src="img/bell.png" width="20px" class="rounded mr-2" alt="..."/>
      <strong class="mr-auto"> </strong>
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="toast-body">
        <strong class="" style="font-size:20px;">Please fill the shipping form!</strong>
    </div>
    </div>
  

<div id="cartTable">
  
            
                      
</div>




