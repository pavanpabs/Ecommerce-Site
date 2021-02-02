<?php include 'db/db.php'; ?>
<?php
// Start the session
session_start();
?>
<?php include 'includes/header.php' ?>
<?php include 'includes/refs.php' ?>
<?php
$zip = null;
if (isset($_POST['ship'])) {
    $ship_type = $_POST['ship'];
    $district = $_POST['district'];
    $zip = $_POST['zip'];
}

?>
<script>
    $(document).ready(() => {

        // var i=1;
        $(function() {
            $('#confirmForm').on('submit', function(e) {

                e.preventDefault();
                // var usr = $('input[name="usr"]').val();
                // var prd = $('input[name="prd"]').val();
                var usr=1;
                if (usr == 0) {
                    toastr.info(
                        'Please Log on to the system !', '', {
                            timeOut: 3000,
                            onHidden: function() {
                                window.location.replace('login.php?redirect=single-product.php?prd=' + 74);
                            }
                        }
                    );


                } else {
                    var userId = '<?= $userId ?>';

                    $.ajax({
                        type: 'post',
                        url: 'ajax/addOrders.php',
                        data: $(this).serialize(),
                        success: function(data) {
                            // $('#cartCount').load("ajax/cartCount.php", {
                            // 	user: userId
                            // });
                            if (data.toString() != -1) {
                                toastr.success(
                                    "Your order has been added sucessfully!", '', {
                                        timeOut: 3000,
                                        onHidden: function() {
                                            window.location.replace('confirmation.php?oid='+ data.toString());
                                           
                                        }
                                    }
                                );
                            } else {
                                toastr.info("Something went wrong!");
                            }

                        }
                    });
                }


            });
        });


    });
</script>
<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="category">
    <div class="container h-100">
        <div class="blog-banner">
            <div class="text-center">
                <h1>Product Checkout</h1>
                <nav aria-label="breadcrumb" class="banner-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
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
        <?php
        if (!isset($userId)) { ?>
            <div class="returning_customer">
                <div class="check_title">
                    <h2>Returning Customer? <a href="#">Click here to login</a></h2>
                </div>
                <p>If you have shopped with us before, please enter your details in the boxes below. If you are a new
                    customer, please proceed to the Billing & Shipping section.</p>
                <form class="row contact_form" action="#" method="post" novalidate="novalidate">
                    <div class="col-md-6 form-group p_star">
                        <input type="text" class="form-control" placeholder="Username or Email*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Username or Email*'" id="name" name="name">
                        <!-- <span class="placeholder" data-placeholder="Username or Email"></span> -->
                    </div>
                    <div class="col-md-6 form-group p_star">
                        <input type="password" class="form-control" placeholder="Password*" onfocus="this.placeholder=''" onblur="this.placeholder = 'Password*'" id="password" name="password">
                        <!-- <span class="placeholder" data-placeholder="Password"></span> -->
                    </div>
                    <div class="col-md-12 form-group">
                        <button type="submit" value="submit" class="button button-login">login</button>
                        <div class="creat_account">
                            <input type="checkbox" id="f-option" name="selector">
                            <label for="f-option">Remember me</label>
                        </div>
                        <a class="lost_pass" href="#">Lost your password?</a>
                    </div>
                </form>
            </div>
            <div class="cupon_area">
                <div class="check_title">
                    <h2>Have a coupon? <a href="#">Click here to enter your code</a></h2>
                </div>
                <input type="text" placeholder="Enter coupon code">
                <a class="button button-coupon" href="#">Apply Coupon</a>
            </div>
        <?php } else {
            $sql = "SELECT * FROM user u WHERE ID='$userId' ";
            $run = mysqli_query($con, $sql);

            while ($row = mysqli_fetch_assoc($run)) {
                $userId = $row['ID'];
                $email = $row['email'];
                $name = $row['name'];
                $name = explode('@@', $name);
                $addres = $row['address'];
                // $district=$row['district'];
                $phone = $row['phone'];
                $zip = $row['zipCode'];
            }

        ?>

            <div class="billing_details">
                <div class="row">
                    <div class="col-lg-8">
                        <h3>Billing Details</h3>
                        <form class="row contact_form" id="confirmForm">
                            <div class="col-md-6 form-group p_star">
                                <span class="placeholder ml-2">First Name *</span>
                                <input type="text" class="form-control" id="first" name="fname" placeholder="" value="<?php echo $name[0] ?>" required>

                            </div>
                            <div class="col-md-6 form-group p_star">
                                <span class="placeholder ml-2">Last Name</span>
                                <input type="text" class="form-control" id="last" name="lname" value="<?php echo $name[1] ?>" placeholder="">
                                <span class="placeholder" data-placeholder=""></span>
                            </div>

                            <div class="col-md-6 form-group p_star">
                                <span class="placeholder ml-2">Phone Number *</span>
                                <input type="text" class="form-control" id="number" name="pnumber" placeholder="" value="<?php echo $phone ?>" required pattern="(0)\d{9}">

                            </div>
                            <div class="col-md-6 form-group p_star">
                                <span class="placeholder ml-2">Email Address</span>
                                <input type="text" class="form-control" id="email" name="compemail" placeholder="Email Address" value="<?php echo $email ?>" disabled>

                            </div>
                            <!--<div class="col-md-12 form-group p_star">
                            <select class="country_select">
                                <option value="1">Country</option>
                                <option value="2">Country</option>
                                <option value="4">Country</option>
                            </select>
                        </div>-->
                            <div class="col-md-12 form-group p_star">
                                <span class="placeholder ml-2">Address *</span>
                                <textarea class="form-control" name="address" id="message" rows="1" placeholder="" required><?php echo $addres ?></textarea>
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <span class="placeholder ml-2">District</span>
                                <select class="country_select" name="district">
                                    <option value="">District</option>
                                    <option value="Colombo">Colombo</option>
                                    <option value="2">District</option>
                                    <option value="4">District</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group">
                                <span class="placeholder ml-2">Postcode/ZIP</span>
                                <input type="text" class="form-control" id="zip" name="zip" placeholder="" value="<?php echo $zip ?>">
                            </div>
                            <!-- <div class="col-md-12 form-group">
                            <div class="creat_account">
                                <input type="checkbox" id="f-option2" name="selector">
                                <label for="f-option2">Create an account?</label>
                            </div>
                        </div> -->
                            <!--<div class="col-md-12 form-group mb-0">
                            <div class="creat_account">
                                <h3>Shipping Details</h3>
                                <input type="checkbox" id="f-option3" name="selector">
                                <label for="f-option3">Ship to a different address?</label>
                            </div>
                            <textarea class="form-control" name="message" id="message" rows="1" placeholder="Order Notes"></textarea>
                        </div>-->

                    </div>
                <?php } ?>

                <div class="col-lg-4">
                    <div class="order_box">
                        <h2>Your Order</h2>
                        <ul class="list">
                            <li><a href="#">
                                    <h4>Product <span>Total</span></h4>
                                </a></li>
                            <?php
                            $sql = "SELECT * FROM cart c,cartorders o,product p,coupons s WHERE c.cartId=o.cartId AND p.pId= o.pID AND s.coupon_id=c.coupon AND  c.uId=$userId";
                            $sql1 = "SELECT SUM(o.total) as sum FROM cart c,cartorders o,product p WHERE c.cartId=o.cartId AND p.pId= o.pID AND c.uId=$userId";
                            $run = mysqli_query($con, $sql1);
                            if ($row1 = mysqli_fetch_assoc($run)) {
                                $sum = $row1['sum'];
                            }

                            $run = mysqli_query($con, $sql);
                            $subt = 0;
                            $discount=0;
                            $d_id=0;
                            while ($row = mysqli_fetch_assoc($run)) {
                                $cId = $row['cartId'];
                                $cOd = $row['id'];
                                $name = $row['pname'];
                                $price = $row['price'];
                                $qty = $row['qty'];
                                $images = $row['images'];
                                $image = explode("|", $images);
                                $tot = $row['total'];
                                $discount = $row['coupon_discount'];
                                $d_name = $row['coupon_name'];
                                $d_id = $row['coupon_id'];
                                $subt = $subt + ($price * $qty);


                            ?>

                                <li><a href="#"><?php echo $name ?> <span class="middle ">x <?php echo $qty ?></span> <span class="last">Rs.<?php echo $tot ?></span></a></li>
                            <?php }
                            $discounted = ($subt / 100) * (100 - $discount);
                            ?>
                        </ul>
                        <ul class="list list_2">
                            <li><a href="#">Subtotal <span>Rs.<?php echo $discounted ?></span></a></li>
                            <?php
                            if ($d_id > 0) { ?>
                                <li><a href="#">Discount <span><?php echo $d_name ?>-<strong><?php echo $discount ?>% Off</span></strong></a></li>
                            <?php  }
                            ?>
                            <li><a href="#">Shipping <span><?php echo $ship_type ?>:Rs <?php echo $district ?></span></a></li>
                            <input type="hidden" name="shippingMetho" value="<?php echo $ship_type ?>">
                            <input type="hidden" name="shippingPrice" value="<?php echo $district ?>">
                            <input type="hidden" name="coupon" value="<?php echo $d_id?>">
                            <li><a href="#">Total <span>Rs.<?php echo $discounted + $district ?></span></a></li>
                        </ul>
                        <div class="payment_item">
                            <div class="radion_btn">
                                <input type="radio" id="f-option5" name="paySelector" value="Cash on Delivery" checked>
                                <label for="f-option5">Cash on Delivery</label>
                                <div class="check"></div>
                            </div>
                            <!-- <p>Please send a check to Store Name, Store Street, Store Town, Store State / County,
                                Store Postcode.</p> -->
                        </div>
                        <div class="payment_item active">
                            <div class="radion_btn">
                                <input type="radio" id="f-option6" name="paySelector" value="Bank Transfer">
                                <label for="f-option6">Bank Transfer</label>
                                <!--<img src="img/product/card.jpg" alt="">-->
                                <div class="check"></div>
                            </div>
                            <!-- <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal
                                account.</p> -->
                        </div>
                        <div class="creat_account">
                            <input type="checkbox" id="f-option4" name="selector">
                            <label for="f-option4">I’ve read and accept the </label>
                            <a href="#">terms & conditions*</a>
                        </div>
                        <div class="text-center">
                            <input type="submit" name="orderConfirm" class="button" value="Order Confirmation">
                        </div>
                        </form>
                        <!-- <div class="text-center">
                          <a class="button button-paypal"  onclick="document.getElementById('confirmForm').submit();">Order Confirmation</a>
                        </div> -->
                    </div>
                </div>

                </div>
            </div>
    </div>
</section>
<!--================End Checkout Area =================-->



<?php include 'includes/footer.php' ?>