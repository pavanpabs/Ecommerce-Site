<?php include 'db/db.php';
session_start();
if (isset($_SESSION['role']) && $_SESSION['role'] == "Admin") {
  $_SESSION['role'] = "Admin";
} else {
  header('Location: ./login.php');
}

if (isset($_POST['checkBoxArray'])) {
  $checkBoxArray = $_POST['checkBoxArray'];
  foreach ($_POST['checkBoxArray'] as $checkboxvalue) {
    $bulk_options = $_POST['bulk_options'];
    if ($_SESSION['role'] == 'Admin') {
      switch ($bulk_options) {
        case 'Sent':
          $p_query = "UPDATE orders SET oStatus='Sent' WHERE oId=$checkboxvalue";
          $run_p_query = mysqli_query($con, $p_query);
          break;
        case 'Pending':
          $d_query = "UPDATE orders SET oStatus='Pending' WHERE oId=$checkboxvalue";
          $run_d_query = mysqli_query($con, $d_query);
          break;
        case 'delete':
          $del_query = "DELETE orderproducts,orders FROM orderproducts LEFT JOIN  orders ON orders.oId=orderproducts.oId WHERE orderproducts.oId=$checkboxvalue";
          $run_del_query = mysqli_query($con, $del_query);
          header('Location: ./orders.php');
          break;
        default:
          echo "Error";
          break;
      }
    } else {
      header('Location: ./orders.php');
    }
  }
}


if (isset($_POST['confirm'])) {
  $confirm = $_POST['confirm'];
  if ($confirm == "delete") {
    $moodle_del = $_POST['confirm_del_id'];


    $del_query = "DELETE orderproducts,orders FROM orderproducts LEFT JOIN  orders ON orders.oId=orderproducts.oId WHERE orderproducts.oId=$moodle_del";
    if (mysqli_query($con, $del_query)) {
      header('Location: ./orders.php');
    } else {
      echo "<script> alert('Somehing Went Wrong!')</script>";
    }
  } else {
    header('Location: ./orders.php');
  }
}

if (isset($_POST['approved'])) {
  $o_id = $_POST['approved'];
  $o_sts = $_POST['sts'];
  if ($o_sts == "Pending") {
    $approved_query = "UPDATE orders SET oStatus='Sent' WHERE oId=$o_id";
  } else if ($o_sts == "Sent") {
    $approved_query = "UPDATE orders SET oStatus='Pending' WHERE oId=$o_id";
  }
  if (mysqli_query($con, $approved_query)) {
    header('Location: ./orders.php');
  } else {
    echo mysqli_error($con);

    echo "<script> alert('Somehing Went Wrong!')</script>";
  }
} ?>
<link rel="stylesheet" type="text/css" href="https://cdn.daatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.foundation.min.css">
<?php include 'includes/refs.php' ?>
<?php include 'includes/header.php' ?>
<?php

if (isset($_GET['del']) || isset($_GET['approvedId'])) {
  if (isset($_GET['del'])) {
    $del_id = $_GET['del']; ?>
    <div class="alert alert-danger" role="alert">
      <h4>Are you sure?</h4>
      <br>
      <form action="" method="POST">
        <input type="hidden" name="confirm_del_id" value="<?php echo $del_id ?>">
        <input type="submit" class="btn btn-light" name="confirm" value="close">
        <input type="submit" class="btn btn-danger" name="confirm" value="delete">
      </form>
    </div>
  <?php
  } else {

    $edit_id = $_GET['approvedId'];
    $del_stat = $_GET['sts'];
  ?>
    <div class="alert alert-danger" role="alert">
      <h4>Are you sure?</h4>
      <br>
      <form action="" method="POST">
        <input type="hidden" name="approved" value="<?php echo $edit_id ?>">
        <input type="hidden" name="sts" value="<?php echo $del_stat ?>">
        <input type="submit" class="btn btn-light" name="confirm" value="close">
        <input type="submit" class="btn btn-danger" name="" value="Yes">
      </form>
    </div>
<?php
  }
}
?>
<?php include 'includes/refs.php' ?>

<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="category">
  <div class="container h-100">
    <div class="blog-banner">
      <div class="text-center">
        <h1>Orders</h1>
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
          <form action="" method="post">
            <div class="col-md-12 form-group ">
              <select class="country_select" name="bulk_options">
                <option value="">Select Option</option>
                <option value="Sent">Sent</option>
                <option value="Pending">Pending</option>
                <option value="delete">Delete</option>
              </select>
              <input type="submit" name="submit" class="button button-blog" value="Apply">
            </div>
            <table id="example" class="table table-striped table-bordered" style="width:100%">
              <thead>
                <th><input type="checkbox" name="checkBoxArra" class='checkBoxes'></th>
                <th>ID</th>
                <th></th>
                <th>Product</th>
                <th>Address</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Status</th>
                <th>Delete</th>
              </thead>
              <tbody>
                <?php

                $query = "SELECT * FROM orders c,orderproducts o,product p,user u WHERE c.oId=o.oId AND p.pId= o.pId AND u.ID=c.uID ";
                $run_query = mysqli_query($con, $query);

                while ($row = mysqli_fetch_array($run_query)) {
                  $cust_fullName = $row['name'];
                  $cust_fullName1 = explode("@@", $cust_fullName);
                  $cust_address = $row['address'];
                  $cust_zip = $row['zipCode'];
                  $cust_phone = $row['phone'];
                  $cId = $row['oId'];
                  $cOd = $row['pId'];
                  $name = $row['pname'];
                  $price = $row['price'];
                  $qty = $row['qty'];
                  $images = $row['images'];
                  $image = explode("|", $images);
                  $order_status = $row['oStatus'];
                  $tot = $row['total'];

                ?>
                  <tr>
                    <td><input type="checkbox" name="checkBoxArray[]" class="checkbox" value="<?php echo $cId; ?>"></td>
                    <td><?php echo $cId ?></td>
                    <td>
                      <div class="d-flex" height="100px">
                        <img width="150px" src="img/product/<?php echo $image[0] ?>" alt="">
                      </div>
                    </td>
                    <td><?php echo $name ?></td>
                    <td>
                      <p><?php echo $cust_fullName1[0] ?> <?php echo $cust_fullName1[1] ?><br>
                        <?php echo $cust_address ?><br>
                        <?php echo $cust_zip ?><br>
                        <?php echo $cust_phone ?></p>
                    </td>
                    <td>
                      <h5>Rs.<?php echo $price ?></h5>
                    </td>
                    <td><?php echo $qty ?></td>
                    <td>
                      <h5>Rs.<?php echo $tot ?></h5>
                    </td>
                    <td><a href='orders.php?approvedId=<?php echo $cId ?>&sts=<?php echo $order_status ?>'><?php echo $order_status ?></a></td>
                    <td><a href="orders.php?del=<?php echo $cId ?>" <i class="fa fa-times" style="color: red;"></i></a></td>
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



<!--================ Start footer Area  =================-->
<?php include 'includes/footer.php' ?>
<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" language="javascript" class="init">
  $(document).ready(function() {
    $('#example').DataTable();
  });
</script>