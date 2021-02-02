<?php include 'db/db.php';
session_start();
if(isset($_SESSION['role'])&& $_SESSION['role']=="Admin"){
  $_SESSION['role']="Admin" ;
}else{
  header('Location: ./login.php');
}
?>

<?php 
if (isset($_POST['checkBoxArray'])) {
	$checkBoxArray = $_POST['checkBoxArray'];
	foreach ($_POST['checkBoxArray'] as $checkboxvalue) {

		$bulk_options = $_POST['bulk_options'];
		if ($_SESSION['role'] == 'Admin') {
			
			
			switch ($bulk_options) {

			case 'publish':
				$p_query = "UPDATE product SET status='Publish' WHERE pId={$checkboxvalue}";
				$run_p_query = mysqli_query($con, $p_query);
				break;
			case 'draft':
				$d_query = "UPDATE product SET status='Draft' WHERE pId={$checkboxvalue}";
				$run_d_query = mysqli_query($con, $d_query);
				break;
      case 'delete':
        
        $d_query = "SELECT images FROM product where pId={$checkboxvalue}";
        $run_d_query = mysqli_query($con, $d_query);
        while($row=mysqli_fetch_assoc($run_d_query)){

          $images=$row['images'];
          $images=explode("|",$images);
        }
        foreach ($images as $key) {
          $dirPath="img/product/$key";
          if(is_dir($dirPath)){
            if (!unlink($dirPath)) {
              echo "Not Working";
            } else {
              $del_query = "DELETE FROM product WHERE pId={$checkboxvalue}";
              $run_del_query = mysqli_query($con, $del_query);
              header('Location: ./products.php');
            }
          }else{
            $del_query = "DELETE FROM product WHERE pId={$checkboxvalue}";
              $run_del_query = mysqli_query($con, $del_query);
              header('Location: ./products.php');
          }
        }
				break;
			default:
				echo "Error";
				break;
			}
		} else {
			header('Location: ./products.php');
		}
	}

}
?>
  <?php

  if (isset($_POST['confirm'])) {
  $confirm=$_POST['confirm'];
      if($confirm=="delete"){
         $moodle_del = $_POST['confirm_del_id'];

        $d_query = "SELECT images FROM product where pId=$moodle_del";
        $run_d_query = mysqli_query($con, $d_query);
        while($row=mysqli_fetch_assoc($run_d_query)){

          $images=$row['images'];
          $images=explode("||",$images);
        }
        foreach ($images as $key) {
          $dirPath="img/product/$key";
          if(is_dir($dirPath)){
            echo "<script> alert('Can not complete, Used by another!')</script>";
            if (!unlink($dirPath)) {
              echo "<script> alert('Can not complete, Used by another!')</script>";
            } else {
              echo "<script> alert('Can not complete, Used by another!')</script>";
              $del_query = "DELETE FROM product WHERE pId=$moodle_del";
              $run_del_query = mysqli_query($con, $del_query);
              header('Location: ./products.php');
            }
          }else{
            
            $del_query = "DELETE FROM product WHERE pId=$moodle_del";
            $run_del_query = mysqli_query($con, $del_query);
            $err=mysqli_error($con);
            echo "<script> alert('.$err.')</script>";
            header('Location: ./products.php');
          }
          
        }
        
  
    // $del_query = "DELETE FROM product WHERE pId={$moodle_del}";
    //     if(mysqli_query($con, $del_query)){
    //       header('Location: ./products.php');
    //     }else{
    //       echo "<script> alert('Somehing Went Wrong!')</script>";
    //     }
    
    
    
      }else{
        header('Location: ./products.php');
      }
  }
  if (isset($_GET['approved'])) {
    $p_id = $_GET['approved'];
    $p_sts = $_GET['sts'];
    if($p_sts=="Draft"){
      $approved_query = "UPDATE product SET status='Publish' WHERE pId={$p_id}";
    }else{
      $approved_query = "UPDATE product SET status='Draft' WHERE pId={$p_id}";
    }
    if(mysqli_query($con, $approved_query)){
      header('Location: ./products.php');
    }else{
      echo mysqli_error($con);
      echo $p_id;
      echo "<script> alert('Somehing Went Wrong!')</script>";
    }
  }


?>
<?php include 'includes/refs.php'?>
  <?php include 'includes/header.php'?>
  <link rel="stylesheet" type="text/css" href="https://cdn.daatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.foundation.min.css">

	<!-- ================ start banner area ================= -->	
	<section class="blog-banner-area" id="category">
		<div class="container h-100">
			<div class="blog-banner">
				<div class="text-center">
					<h1>Products</h1>
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
  <?php
    if(isset($_GET['del'])){
        $del_id=$_GET['del'];
        ?>
        <div class="alert alert-danger" role="alert">
        <h4>Do you really want to Delete This Record?</h4>
        <br>
        <form action="" method="POST">
            <input type="hidden" name="confirm_del_id" value="<?php echo $del_id ?>">
            <input type="submit" class="btn btn-light" name="confirm" value="close">
            <input type="submit" class="btn btn-danger" name="confirm" value="delete">
        </form>
        </div>
   <?php }
?>
  
  <!--================Checkout Area =================-->
  <section class="checkout_area section-margin--small">
    <div class="container">
    <div class="billing_details">
            <div class="row">
                <div class="col-lg-12">
                <form action="" method="post">
              <div class="col-md-12 form-group ">
            	<select class="country_select" name="bulk_options">
            		<option value="">Select Option</option>
            		<option value="publish">Publish</option>
            		<option value="draft">Draft</option>
            		<option value="delete">Delete</option>
            	</select>
            <input type="submit" name="submit" class="button button-blog" value="Apply">
            </div>
                  <table id="example" class="table table-striped table-bordered" style="width:100%">
              
                    <thead>
                      <tr>
                        <th><input type="checkbox" name="checkBoxArray"  class='checkBoxes'></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Edit/View</th>
                        <th>Delete</th>
                      
                      </tr>
                    </thead>
                    <tbody>
                    <?php

                      $query = "SELECT * FROM product";
                      $run_query = mysqli_query($con, $query);

                      while ($row = mysqli_fetch_array($run_query)) {
                        $product_id = $row['pId'];
                        $product_name = $row['pname'];
                        $product_description = $row['description'];
                        $product_category = $row['category'];
                        $product_price = $row['price'];
                        $product_date = $row['date'];
                        $product_tags = $row['tags'];
                        $product_images = $row['images'];
                        $product_status = $row['status'];
                        $product_pkeys = $row['pkeys'];
                        $product_pvals = $row['pvals'];

                        ?>

                        <tr>
                        <td><input type="checkbox" name="checkBoxArray[]" class="checkbox" value="<?php echo $product_id; ?>"></td>
                        <td><?php echo $product_id ?></td>
                        <td><?php echo $product_name?></td>
                        <td><?php echo $product_category?></td>
                        <td><?php echo $product_price ?></td>
                        <td><?php echo $product_date ?></td>
                        <td><a href='products.php?approved=<?php echo $product_id?>&sts=<?php echo $product_status?>'><?php echo $product_status ?></a></td>
                        <td><a href="product-insert.php?source=edit_product&p_id=<?php echo $product_id ?>"><i class="fas fa-edit" style="color: green;"></i></a></td>
                        <td><a href="products.php?del=<?php echo $product_id?>"><i class="fa fa-times" style="color: red;"></i></a></td>
                        </tr>
                      <?php } ?>
                      
                    </tbody>
                    <tfoot>
                      
                    </tfoot>
                  </table>
                  </form>
                </div>   
            </div>
        </div>
    </div>
  </section>
  
  <!--================End Checkout Area =================-->

  <?php include 'includes/footer.php'?>
  <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
      $('#example').DataTable();
    } );
  </script>

