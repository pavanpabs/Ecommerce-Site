<?php include 'db/db.php' ?>

<?php include 'includes/refs.php' ;
session_start();
if(isset($_SESSION['role'])&& $_SESSION['role']=="Admin"){
  $_SESSION['role']="Admin" ;
}else{
  header('Location: ./login.php');
}
?>
<?php include 'includes/header.php'; ?>
<script>
  $(document).ready(() => {
    $(function() {

      $('#catList').load("ajax/categoryList.php", {});

      $('#catAddFrm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
          type: 'post',
          url: 'ajax/addCategories.php',
          data: $(this).serialize(),
          success: function(data) {
            $('#catList').load("ajax/categoryList.php", {});
            if (data.toString() == 1) {
              toastr.success("Category added successfully!");
            } else {
              toastr.info("Something went wrong!");
            }

          }
        });
      });
    });
  });
</script>
<?php
// $sql = "SELECT * FROM categories";
// $run = mysqli_query($con, $sql);

// while ($row = mysqli_fetch_assoc($run)) {
//   $catName = $row['name'];
//   $catId = $row['id'];

?> 
  


<?php //} ?>
<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="category">
  <div class="container h-100">
    <div class="blog-banner">
      <div class="text-center">
        <h1>Category Insert</h1>
        <nav aria-label="breadcrumb" class="banner-breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active" aria-current="page">Panel</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<!-- ================ end banner area ================= -->


<!--================Checkout Area =================-->
<section class="checkout_area section-margin--small">
  <div class="container">


    <div class="billing_details">
      <div class="row">
        <div class="col-lg-12 overflow-auto">
          <div class="col-12 col-md-6 float-left">
            <h3>Insert Categories</h3>
            <form id="catAddFrm">
              <div class="form-group">
                <input class="col-8 col-sm-8 col-md-8  m-1" type="text" id="catInput" name="catName" placeholder="Enter Category Name">
                <input type="submit" name="catSub" class="col-3 col-sm-3 col-md-3 btn btn-primary float-right p-1 " value="Add">
              </div>
              <form>
          </div>
          <div id="catList"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!--================End Checkout Area =================-->

<?php include 'includes/footer.php' ?>