<?php include '../db/db.php'; ?>
<?php
// Start the session
session_start();
$userId = $_SESSION['userID'];
?>

<?php
if (isset($_POST['updateId'])) {
    $id = $_POST['updateId'];
    $qty = $_POST['qty'];
    $price = $_POST['price'];
    $tot = $price * $qty;
    $sql = "UPDATE cartorders set qty=$qty,total=$tot  WHERE id=$id";
    $run = mysqli_query($con, $sql);
}

?>
<?php
if (isset($_POST['delId'])) {
    echo "testing";
    $id = $_POST['delId'];
    $sql = "DELETE FROM cartorders WHERE id=$id";
    $run = mysqli_query($con, $sql);
    $sql1 = "DELETE FROM cart WHERE cartId=$id";
    $run = mysqli_query($con, $sql1);
}
$sql = "SELECT * FROM cart c,cartorders o,product p WHERE c.cartId=o.cartId AND p.pId= o.pID AND c.uId=$userId";
$run1 = mysqli_query($con, $sql);
$count = mysqli_num_rows($run1);

if ($count > 0) {


?>
    <section class="cart_area mb-0">
        <div class="container ">
            <div class="cart_inner ">
                <div class="table-responsive d-none d-md-block">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $sql1 = "SELECT SUM(o.total) as sum FROM cart c,cartorders o,product p WHERE c.cartId=o.cartId AND p.pId= o.pID AND c.uId=$userId";
                            $run = mysqli_query($con, $sql1);
                            if ($row1 = mysqli_fetch_assoc($run)) {
                                $sum = $row1['sum'];
                            }

                            $subt = 0;
                            while ($row = mysqli_fetch_assoc($run1)) {
                                $cId = $row['cartId'];
                                $cOd = $row['id'];
                                $name = $row['pname'];
                                $price = $row['price'];
                                $qty = $row['qty'];
                                $images = $row['images'];
                                $image = explode("|", $images);
                                $tot = $row['total'];



                            ?>
                                <div class=" d-none d-md-block">
                                    <tr>
                                        <td>
                                            <div class="media">
                                                <div class="my-4 mr-3">
                                                    <button id="del<?php echo $cId ?>" type="button" class="page-link"><i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                                <div class="d-flex" height="100px">
                                                    <img width="150px" src="img/product/<?php echo $image[0] ?>" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <p><?php echo $name ?></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h5>Rs.<?php echo $price ?></h5>
                                        </td>
                                        <td>
                                            <div class="product_count">
                                                <input type="hidden" id="price<?php echo $cId ?>" value="<?php echo $price ?>">
                                                <input type="hidden" id="cOd<?php echo $cId ?>" value="<?php echo $price ?>">
                                                <input type="text" name="qty" id="sst<?php echo $cId ?>" maxlength="12" value="<?php echo $qty ?>" title="Quantity:" class="input-text qty">

                                                <button id="up<?php echo $cId ?>" class="increase " type="button"><i class="lnr lnr-chevron-up"></i></button>
                                                <button id="down<?php echo $cId ?>" class="reduced " type="button"><i class="lnr lnr-chevron-down"></i></button>
                                            </div>
                                        </td>
                                        <td>
                                            <h5>Rs.<?php echo $tot ?></h5>
                                        </td>

                                    </tr>


                                    <script>
                                        $(document).ready(function() {

                                            var subt = <?php echo $sum ?>;

                                            $('#up<?php echo $cId ?>').click(function() {
                                                var qty = $('#sst<?php echo $cId ?>').val();
                                                var price = $('#price<?php echo $cId ?>').val();
                                                var uId = <?php echo $cId ?>;
                                                if (qty > 0) {
                                                    qty++;
                                                    $('#sst<?php echo $cId ?>').val(qty);
                                                }
                                                $('#cartTable').load("ajax/updateCart.php", {
                                                    updateId: uId,
                                                    qty: qty,
                                                    price: price
                                                });



                                            });
                                            $('#down<?php echo $cId ?>').click(function() {
                                                var qty = $('#sst<?php echo $cId ?>').val();
                                                var price = $('#price<?php echo $cId ?>').val();

                                                var uId = <?php echo $cId ?>;
                                                if (qty > 1) {
                                                    qty--;
                                                    var test = $('#sst<?php echo $cId ?>').val(qty);

                                                }
                                                $('#cartTable').load("ajax/updateCart.php", {
                                                    updateId: uId,
                                                    qty: qty,
                                                    price: price
                                                });



                                            });
                                            $('#sst<?php echo $cId ?>').change(function() {
                                                var qty = $('#sst<?php echo $cId ?>').val();
                                                var price = $('#price<?php echo $cId ?>').val();
                                                var uId = <?php echo $cId ?>;

                                                $('#cartTable').load("ajax/updateCart.php", {
                                                    updateId: uId,
                                                    qty: qty,
                                                    price: price
                                                });

                                            });
                                            $(document).on('click', '#del<?php echo $cId ?>', function() {
                                                var delId = <?php echo $cId ?>;
                                                toastr.warning("<br /><button type='button' class='btn ' value='yes'>Yes</button><button type='button' class='btn clear ml-1'  value='no' >No</button>", 'Are you sure you want to delete this item?', {
                                                    allowHtml: true,
                                                    onclick: function(toast) {
                                                        value = toast.target.value
                                                        if (value == 'yes') {

                                                            $('#cartTable').load("ajax/updateCart.php", {
                                                                delId: delId
                                                            });
                                                        } else {
                                                            toastr.remove();
                                                        }
                                                    }

                                                })





                                            });
                                            $(document).on('change', '#district', function() {
                                                var method = $('input[name="ship"]:checked').val();
                                                var district = $(this).val();
                                                var c = parseInt(subt, 10) + parseInt(district, 10);
                                                if (method != null || district != null) {
                                                    $('#shippingPrice').html(district);
                                                    $('#tot').html(c);
                                                } else {
                                                    toastr.error("Please fill the shipping form");
                                                }

                                            });
                                            $(document).on('click', '#shippingSubmit', function() {
                                                var method = $('input[name="ship"]:checked').val();
                                                var district = $('input[name="district"]').val();
                                                if (method != null && district != 0) {
                                                    document.getElementById('shipping-form').submit();
                                                } else {
                                                    toastr.error("Please fill the shipping form");
                                                }

                                            });
                                            $(document).on('submit', '#couponFrm', function(e) {
                                                e.preventDefault();
                                                var cartId = '<?= $cId ?>';
                                                var sum = '<?= $sum ?>';
                                                $.ajax({
                                                    type: 'post',
                                                    url: 'ajax/couponVerify.php',
                                                    data: $(this).serialize(),
                                                    success: function(data) {
                                                        // $('#cartCount').load("ajax/cartCount.php", {
                                                        //     user: userId
                                                        // });
                                                        if (data.toString() > 0) {
                                                            $('#tot').html((sum / 100) * (100 - data));
                                                            $('#discount').html(data + "% off");
                                                            $('#discName').html("Discount");
                                                            toastr.success("Coupon Code added successfully!");
                                                        } else {
                                                            toastr.info("Something went wrong!");
                                                        }
                                                    }
                                                });


                                            });

                                        });
                                    </script>


                                <?php }
                                ?>





                        </tbody>
                    </table>

                </div>



                <div class="d-block-xs d-md-none " style="overflow: auto;">

                    <?php
                    $sql = "SELECT * FROM cart c,cartorders o,product p WHERE c.cartId=o.cartId AND p.pId= o.pID AND c.uId=$userId";
                    $run1 = mysqli_query($con, $sql);
                    $subt = 0;
                    while ($row1 = mysqli_fetch_assoc($run1)) {
                        $cId = $row1['cartId'];
                        $cOd = $row1['id'];
                        $name = $row1['pname'];
                        $price = $row1['price'];
                        $qty = $row1['qty'];
                        $images = $row1['images'];
                        $image = explode("|", $images);
                        $tot = $row1['total'];

                    ?>

                        <div style="overflow: auto;">
                            <div class="col-4 float-left ">
                                <img width="100%" src="img/product/<?php echo $image[0] ?>" alt="">
                            </div>
                            <div style="float: right;" class="col-7 float-right">
                                <div class="">
                                    <h6><?php echo $name  ?></h6>

                                </div>
                                <div class="float-left col-6">
                                    <h6>Rs.<?php echo $price ?><span class="ml-4">x</span></h6>
                                </div>
                                <div class="product_count float-right col-6">

                                    <input type="hidden" id="price1<?php echo $cId ?>" value="<?php echo $price ?>">
                                    <input type="hidden" id="cOd1<?php echo $cId ?>" value="<?php echo $price ?>">
                                    <input type="text" name="qty1" id="sst1<?php echo $cId ?>" maxlength="12" value="<?php echo $qty ?>" title="Quantity:" class="input-text qty">

                                    <button id="up1<?php echo $cId ?>" class="increase " type="button"><i class="lnr lnr-chevron-up"></i></button>
                                    <button id="down1<?php echo $cId ?>" class="reduced " type="button"><i class="lnr lnr-chevron-down"></i></button>
                                </div>
                                <br>
                                <br>



                                <div>
                                    <div class="col-5 float-left">

                                        <P>Total : </P>
                                    </div>
                                    <div class="col-4 float-left">

                                        <h6>Rs.<?php echo $tot ?></h6>
                                    </div>
                                    <div class="col-3 float-right ">
                                        <button id="del1<?php echo $cId ?>" type="button" class="page-link"><i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>


                            </div>

                        </div>
                        <hr>

                        <script>
                            $(document).ready(function() {

                                // var subt = <?php echo $sum ?>;

                                $('#up1<?php echo $cId ?>').click(function() {
                                    var qty = $('#sst1<?php echo $cId ?>').val();
                                    var price = $('#price1<?php echo $cId ?>').val();
                                    var uId = <?php echo $cId ?>;
                                    if (qty > 0) {
                                        qty++;
                                        $('#sst1<?php echo $cId ?>').val(qty);
                                    }
                                    $('#cartTable').load("ajax/updateCart.php", {
                                        updateId: uId,
                                        qty: qty,
                                        price: price
                                    });



                                });
                                $('#down1<?php echo $cId ?>').click(function() {
                                    var qty = $('#sst1<?php echo $cId ?>').val();
                                    var price = $('#price1<?php echo $cId ?>').val();
                                    var uId = <?php echo $cId ?>;
                                    if (qty > 1) {
                                        qty--;
                                        $('#sst1<?php echo $cId ?>').val(qty);
                                    }
                                    $('#cartTable').load("ajax/updateCart.php", {
                                        updateId: uId,
                                        qty: qty,
                                        price: price
                                    });



                                });
                                $('#sst1<?php echo $cId ?>').change(function() {
                                    var qty = $('#sst1<?php echo $cId ?>').val();
                                    var price = $('#price1<?php echo $cId ?>').val();
                                    var uId = <?php echo $cId ?>;

                                    $('#cartTable').load("ajax/updateCart.php", {
                                        updateId: uId,
                                        qty: qty,
                                        price: price
                                    });

                                });
                                $(document).on('click', '#del1<?php echo $cId ?>', function() {
                                    var delId = <?php echo $cId ?>;

                                    toastr.warning("<br /><button type='button' class='btn ' value='yes'>Yes</button><button type='button' class='btn clear ml-1'  value='no' >No</button>", 'Are you sure you want to delete this item?', {
                                        allowHtml: true,
                                        onclick: function(toast) {
                                            value = toast.target.value
                                            if (value == 'yes') {

                                                $('#cartTable').load("ajax/updateCart.php", {
                                                    delId: delId
                                                });
                                            } else {
                                                toastr.remove();
                                            }
                                        }

                                    })

                                });
                            });
                        </script>

                    <?php } ?>

                </div>





            </div>

        </div>
        </div>

    </section>

    <section class="checkout_area section-margin--small mt-0">
        <div class="container">

            <div class="billing_details">
                <div class="row">
                    <div class="col-lg-6">
                        <h3>Shipping Details</h3>
                        <form class="row contact_form" action="checkout.php" method="post" id="shipping-form">

                            <div class="col-md-12 ">
                                <span class="placeholder mb-2" data-placeholder="Town/City"><strong>Method</strong></span>
                            </div>
                            <div class="col-md-12 ">
                                <ul class="list ">
                                    <li class=" ml-3"><span class="float-left">Pick Up</span><input class="pixel-radio float-right " type="radio" value="Pick Up" name="ship" checked></li>
                                </ul>
                            </div>
                            <div class="col-md-12 ">
                                <ul class="list ">
                                    <li class="ml-3  "><span class="float-left">Local Post</span><input class="pixel-radio float-right " type="radio" value="LocalPost" name="ship"></li>
                                </ul>
                            </div>
                            <div class="col-md-12 ">
                                <ul class="list ">
                                    <li class="ml-3  "><span class="float-left">Domex</span><input class="pixel-radio float-right " type="radio" value="LocalPost" name="ship"></li>
                                </ul>
                            </div>


                            <div class="col-md-12 form-group p_star">
                                <span class="placeholder mb-2" data-placeholder="Town/City"><strong>Shipping Location</strong></span>
                                <select class="country_select ml-2" id="district" name="district">
                                    <option value="0">Select a District</option>
                                    <option value="150">Colombo</option>
                                    <option value="250">Other</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <span class="placeholder mb-2" data-placeholder="Town/City"><strong>Zip Code</strong></span>
                                <input type="text" class="form-control ml-2" id="city" placeholder="600##" name="zip">

                            </div>

                        </form>

                    </div>
                    <div class="col-lg-1">

                    </div>

                    <div class="col-lg-5 float-right ">
                        <div>
                            <form id="couponFrm" method="POST">

                                <!-- <div class="col-md-9 form-group ">
                                            
                                        </div> -->
                                <div class="form-group">
                                    <input type="hidden" name="cartId" value="<?php echo $cId  ?>">
                                    <input class="col-8 col-sm-8 col-md-8 p-1 m-1" type="text" name="couponCode" placeholder="Have a Coupon?">
                                    <input type="submit" name="couponSubmit" class="col-3 col-sm-3 col-md-3 btn btn-primary float-right p-2 " value="Apply">
                                </div>
                                <form>
                        </div>
                        <div class="order_box" style="overflow: auto;">

                            <h2>Your Order</h2>

                            <ul class="list list_2">
                                <li><a>Subtotal <span id="subt"><?php echo $sum ?></span><span>Rs.</span></a></li>
                                <li><a>Shipping <span id="shippingPrice">0</span><span>Rs.</span></a></li>
                                <li style="overflow: auto;"><a> <strong><span id="discount" class="float-right"></span></strong></a></li>
                                <li><a>Total <strong><span id="tot"><?php echo $sum ?></span><span>Rs.</span></strong></a></li>

                            </ul>

                            <div class="text-center">
                                <button class="button button-paypal" id="shippingSubmit">Proceed to Checkout</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 
        <div class="d-none d-sm-block"> hidden-xs
            <div class="d-none d-md-block"> visible-md and up (hidden-sm and down)
                <div class="d-none d-lg-block"> visible-lg and up (hidden-md and down)
                    <div class="d-none d-xl-block"> visible-xl </div>
                </div>
            </div>
        </div> -->
    </section>
<?php

} else {
    echo "<div class='text-center'>
            <h4> You have zero items in your cart </h4>
        </div>";
}

?>