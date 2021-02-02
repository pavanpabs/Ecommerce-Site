<?php include 'db/db.php' ?>
<?php
session_start();
if (isset($_SESSION['role']) && $_SESSION['role'] == "Admin") {
  $_SESSION['role'] = "Admin";
} else {
  header('Location: ./login.php');
}
$product_id = null;
$product_name = null;
$product_description = null;
$product_category ="Product's Category";
$product_price = null;
$product_date = null;
$product_tags = null;
$product_images = null;
$product_status = null;
$product_pkeys = [];
$product_pvals = [];
$submit = "submit";
if (isset($_GET['source'])) {
  $product_id = $_GET['p_id'];
  $sql = "SELECT * FROM product WHERE pId=$product_id";
  $run = mysqli_query($con, $sql);
  while ($row = mysqli_fetch_array($run)) {
    $product_id = $row['pId'];
    $product_name = $row['pname'];
    $product_description = $row['description'];
    $product_category = $row['category'];
    $product_price = $row['price'];
    $product_date = $row['date'];
    $product_tags = $row['tags'];
    $product_images = $row['images'];
    $product_status = $row['status'];
    $p_pkeys = $row['pkeys'];
    $product_pkeys = explode("@@", $p_pkeys);
    $p_vvals = $row['pvals'];
    $product_pvals = explode("@@", $p_vvals);
    $submit = "edit";
  }
}
?>
<?php
if (isset($_POST['submit'])) {
  $pName = $_POST['name'];
  $pDescription = $_POST['description'];
  $pCategory = $_POST['category'];
  $pTags = $_POST['tags'];
  $pPrice = $_POST['price'];

  //---Key preparation---
  $pkeys = array();
  $i = 0;
  while (sizeof($_POST['k'])>$i) {
    array_push($pkeys, $_POST['k'][$i]);
    $i++;
  } 
  $keys = implode("@@", $pkeys);
  //---End Key preparation---
  //---Value preparation---
  $pvals = array();
  $i = 0;
   while (sizeof($_POST['v'])>$i) {
    array_push($pvals, $_POST['v'][$i]);
    $i++;
  } 
  $vals = implode("@@", $pvals);
  //---End Value preparation---

  //---IMAGES UPLOAD BEGIN-----
  $imageData = array();
  if (isset($_FILES['files'])) {
    $errors = array();
    foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
      $file_name = $key . $_FILES['files']['name'][$key];
      $file_size = $_FILES['files']['size'];
      $file_tmp = $_FILES['files']['tmp_name'][$key];
      if ($file_size < 297152) {
        $errors[] = 'File size must be less than 2 MB';
      }
      array_push($imageData, $file_name);

      $desired_dir = "img/product";
      if (empty($errors) == true) {
        if (is_dir($desired_dir) == false) {
          mkdir("$desired_dir", 0700);    // Create directory if it does not exist
        }
        if (is_dir("$desired_dir/" . $file_name) == false) {
          if (move_uploaded_file($file_tmp, "$desired_dir/" . $file_name)) {
            $imgDt = implode("|", $imageData);
          }
        } else {                  //rename the file if another one exist
          $new_dir = "$desired_dir/" . $file_name . time();
          if (rename($file_tmp, $new_dir)) {
            $imgDt = implode("|", $imageData);
          }
        }
      } else {
        print_r($errors);
      }
    }
  }
  //---IMAGES UPLOAD END-----	


  $sql = "INSERT INTO product(pname,description,category,price,tags,images,pkeys,pvals) values('$pName','$pDescription','$pCategory','$pPrice','$pTags','$imgDt','$keys','$vals')";

  if (mysqli_query($con, $sql)) {
  } else {
    echo "error";
    echo mysqli_error($con);
  }
}
?>
<?php include 'includes/refs.php'; ?>
<?php include 'includes/header.php'; ?>
<?php
if (isset($_POST['edit'])) {
  $pName = $_POST['name'];
  $pDescription = $_POST['description'];
  $pCategory = $_POST['category'];
  $pTags = $_POST['tags'];
  $pPrice = $_POST['price'];
  $pId = $_POST['pro_id'];
  $kPost=$_POST['k'];
  $vPost=$_POST['v'];

  //---Key preparation---
  $pkeys = array();
  $i = 0;
  while (sizeof($kPost)>$i) {
    array_push($pkeys, $_POST['k'][$i]);
    $i++;
  }
  $keys = implode("@@", $pkeys);
  //---End Key preparation---
  //---Value preparation---
  $pvals = array();
  $i = 0;

  while (sizeof($vPost)>$i) {
    array_push($pvals, $_POST['v'][$i]);
    $i++;
  } 
  $vals = implode("@@", $pvals);
  //---End Value preparation---
  $update_query = "UPDATE product SET pname='{$pName}',";
  $update_query .= "description='{$pDescription}',";
  $update_query .= "category='{$pCategory}',price='{$pPrice}',";
  $update_query .= "tags='{$pTags}', pkeys='{$keys}',";
  $update_query .= "pvals='{$vals}' WHERE pId={$pId}";
  if (mysqli_query($con, $update_query)) { ?>
    <div class="alert alert-success" role="alert">
      <h4>Successfully Updated</h4>
      <a href="products.php"><input type="button" class="btn btn-light" name="confirm" value="To Products List"></a>
    </div>
<?php }
}

?>



<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="category">
  <div class="container h-100">
    <div class="blog-banner">
      <div class="text-center">
        <h1>Product Insert</h1>
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
        <div class="col-lg-12">
          <h3>Product Details</h3>
          <form class="row contact_form" action="" method="post" novalidate="novalidate" id="dynalicKey" enctype="multipart/form-data">

            <div class="col-md-12 form-group">
              <input type="text" class="form-control" id="company" name="name" value="<?php echo $product_name ?>" placeholder="Product's Name">
            </div>
            <div class="col-md-12 form-group">
              <textarea class="form-control" name="description" id="message" rows="1" placeholder="Product's Description"><?php echo $product_description ?></textarea>
            </div>
            <div class="col-md-12 form-group">
              <input type="text" class="form-control" id="company" name="price" value="<?php echo $product_price ?>" placeholder="Product's Price">
            </div>
            <div class="col-md-12 form-group p_star">
              <select class="country_select" name="category">
                <option value="<?php echo $product_category ?>"><?= $product_category ?></option>
                <?php
                $sql = "SELECT * FROM categories";
                $run = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_assoc($run)) {
                  $cat_id = $row['id'];
                  $cat_name = $row['name'];
                ?>
                  <option value="<?= $cat_id ?>"><?= $cat_name ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-md-12 form-group">
              <input type="text" class="form-control" id="company" name="tags" value="<?php echo $product_tags ?>" placeholder="Search Tags(Insert by using commas)">
            </div>
            <div class="col-md-12 form-group p_star">
              <span class="placeholder">Import Images</span>
              <input type="file" class="form-control" name="files[]" multiple>
            </div>
            <input type="hidden" class="form-control" name="pro_id" value="<?php echo $product_id ?>">

            <h3 class="col-md-12 form-group ">Specifications</h3>
            <?php
            if (sizeof($product_pkeys)>0) {
              $i = 0;
              while (sizeof($product_pkeys)>$i) { ?>
                <div class="col-md-6 form-group p_star">
                  <input type="text" class="form-control" id="number" name="k[]" value="<?php echo $product_pkeys[$i] ?>">
                </div>
                <div class="col-md-6 form-group p_star">
                  <input type="text" class="form-control" id="email" name="v[]" value="<?= ($product_pvals[$i]!=null)?$product_pvals[$i]:"" ?>" placeholder="Spec 1">
                </div>
              <?php
                $i++;
              }
            } else {
              ?>
              <div class="col-md-6 form-group p_star">
                <input type="text" class="form-control" id="number" name="k[]" value="Brand">
              </div>
              <div class="col-md-6 form-group p_star">
                <input type="text" class="form-control" id="email" name="v[]" placeholder="Spec 1">
              </div>
              <div class="col-md-6 form-group p_star">
                <input type="text" class="form-control" id="number" name="k[]" value="Dimentions" placeholder="">
              </div>
              <div class="col-md-6 form-group p_star">
                <input type="text" class="form-control" id="email" name="v[]" placeholder="Spec 2">
              </div>
              <div class="col-md-6 form-group p_star">
                <input type="text" class="form-control" id="number" name="k[]" value="Compatible Devices" placeholder="">
              </div>
              <div class="col-md-6 form-group p_star">
                <input type="text" class="form-control" id="email" name="v[]" placeholder="Spec 3">
              </div>
            <?php } ?>
            <div id="dynamicKey" class="col-md-6 form-group p_star">

            </div>
            <div id="dynamicVal" class="col-md-6 form-group p_star">

            </div>
            <div class="col-md-12 form-group ">
              <button type="button" class="button button-blog float-right" id="addField">+ Field</button>
              <button type="button" class="button button-blog float-right removeField" id="removeField">- Field</button>
            </div>

            <div class="cupon_area">
              <button type="submit" class="button button-coupon" name="<?php echo $submit ?>" id="addField">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!--================End Checkout Area =================-->



<script>
  $(document).ready(function() {
    var i = 4;
    $('#addField').click(function() {
      $('#dynamicKey').append('<input type="text" class="form-control form-group" id="key' + i + '" name="k[]" value=""  placeholder="Field ' + i + '">');
      $('#dynamicVal').append('<input type="text" class="form-control form-group" id="val' + i + '" name="v[]" value=""  placeholder="Spec ' + i + '">');
      $('.removeField').attr("id", i);
      i++;
    });

    $(document).on('click', '.removeField', function() {
      var button_id = $(this).attr("id");
      $('#key' + button_id + '').remove();
      $('#val' + button_id + '').remove();
      $('.removeField').attr("id", --button_id);
      if(i>4){
        i--;
      }
     
    });

    $('#submit').click(function() {
      $.ajax({
        url: "name.php",
        method: "POST",
        data: $('#add_name').serialize(),
        success: function(data) {
          alert(data);
          $('#add_name')[0].reset();
        }
      });
    });

  });
</script>

<?php include 'includes/footer.php' ?>