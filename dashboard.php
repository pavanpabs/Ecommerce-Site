<?php include 'includes/refs.php' ?>
<?php
// Start the session
session_start();
if(isset($_SESSION['role'])&& $_SESSION['role']=="Admin"){
  $_SESSION['role']="Admin" ;
}else{
  header('Location: ./login.php');
}

if (isset($_SESSION['userID'])) {
  $username = $_SESSION['username'];
  $role=$_SESSION['role'];
}
?>
<?php include 'includes/header.php'?>


  <!-- ================ start banner area ================= -->	
  <section class="blog-banner-area" id="blog">
    <div class="container h-100">
      <div class="blog-banner">
        <div class="text-center">
          <h1>Admin Panel</h1>
          <nav aria-label="breadcrumb" class="banner-breadcrumb">
            <ol class="breadcrumb">
              
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>
  <!-- ================ end banner area ================= -->


  <!--================Blog Categorie Area =================-->
  <section class="blog_categorie_area">
    <div class="container">
      <div class="row">
        <div class="col-sm-6 col-lg-4 mb-4 mb-lg-0">
            <div class="categories_post">
                <img class="card-img rounded-0" src="img/blog/cat-post/cat-post-3.jpg" alt="post">
                <div class="categories_details">
                    <div class="categories_text">
                        <a href="orders.php">
                            <h5>Orders</h5>
                        </a>
                        <div class="border_line"></div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4 mb-4 mb-lg-0">
            <div class="categories_post">
                <img class="card-img rounded-0" src="img/blog/cat-post/cat-post-1.jpg" alt="post">
                <div class="categories_details">
                    <div class="categories_text">
                        <a href="products.php">
                            <h5>Products</h5>
                        </a>
                        <div class="border_line"></div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4 mb-4 mb-lg-0">
          <div class="categories_post">
            <img class="card-img rounded-0" src="img/blog/cat-post/cat-post-2.jpg" alt="post">
            <div class="categories_details">
              <div class="categories_text">
                <a href="product-insert.php">
                    <h5>Insert Items</h5>
                </a>
                <div class="border_line"></div>
                
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-4 mb-4 mb-lg-0">
            <div class="categories_post">
                <img class="card-img rounded-0" src="img/blog/cat-post/cat-post-1.jpg" alt="post">
                <div class="categories_details">
                    <div class="categories_text">
                        <a href="category-insert.php">
                            <h5>Insert Categories</h5>
                        </a>
                        <div class="border_line"></div>
                       
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4 mb-4 mb-lg-0">
            <div class="categories_post">
                <img class="card-img rounded-0" src="img/blog/cat-post/cat-post-1.jpg" alt="post">
                <div class="categories_details">
                    <div class="categories_text">
                        <a href="coupon-insert.php">
                            <h5>Insert Coupons</h5>
                        </a>
                        <div class="border_line"></div>
                       
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </section>
  <!--================Blog Categorie Area =================-->

  <?php include 'includes/footer.php'?>