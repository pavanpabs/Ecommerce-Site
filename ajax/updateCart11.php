<?php include '../db/db.php';?>
<?php
// Start the session
session_start();
$userId=$_SESSION['userID'];
?>

<?php
    if(isset($_POST['updateId'])){
       $id= $_POST['updateId'];
        $qty= $_POST['qty'];
        $price= $_POST['price'];
        $tot=$price* $qty;
        $sql="UPDATE cartorders set qty=$qty,total=$tot  WHERE id=$id";
        $run=mysqli_query($con,$sql);
        
    }

?>
<?php
    if(isset($_POST['delId'])){
        echo "testing";
       $id= $_POST['delId'];
        $sql="DELETE FROM cartorders WHERE id=$id";
        $run=mysqli_query($con,$sql);
        $sql1="DELETE FROM cart WHERE cartId=$id";
        $run=mysqli_query($con,$sql1);
        
    }

?>
<section class="cart_area">
      <div class="container">
          <div class="cart_inner">
              <div class="table-responsive">
                  <table class="table">
                      <thead>
                          <tr>
                              <th scope="col">Product</th>
                              <th scope="col">Price</th>
                              <th scope="col">Quantity</th>
                              <th scope="col">Total</th>
                              
                          </tr>
                      </thead>
                      <tbody >

<?php 
            $sql="SELECT * FROM cart c,cartorders o,product p WHERE c.cartId=o.cartId AND p.pId= o.pID AND c.uId=$userId";     $sql1="SELECT SUM(o.total) as sum FROM cart c,cartorders o,product p WHERE c.cartId=o.cartId AND p.pId= o.pID AND c.uId=$userId";
            $run=mysqli_query($con,$sql1);
            if($row1=mysqli_fetch_assoc($run)){
                $sum=$row1['sum'];
            }
            
            $run=mysqli_query($con,$sql);
            $subt=0;
            while($row=mysqli_fetch_assoc($run)){
                $cId=$row['cartId'];
                $cOd=$row['id'];
                $name=$row['name'];
                $price=$row['price'];
                $qty=$row['qty'];
                $images=$row['images'];
                $image=explode("|",$images);
                $tot=$row['total'];
                $subt=$subt + $price;
                          
                          
            ?>
               <tr>
                              <td>
                                  <div class="media">
                                      <div class="my-4 mr-3">
                                          <button id="del<?php echo $cId ?>" type="button"  class="page-link"><i class="fas fa-trash-alt"></i>
                                          </button>
                                      </div>
                                      <div class="d-flex"  height="100px">
                                          <img width="150px" src="img/product/<?php echo $image[0]?>" alt="">
                                      </div>
                                      <div class="media-body">
                                          <p><?php echo $name ?></p>
                                      </div>
                                  </div>
                              </td>
                              <td>
                                  <h5>Rs.<?php echo $price ?></h5>
                              </td>
                              <td >
                                  <div class="product_count">
                                       <input type="hidden" id="price<?php echo $cId ?>"  value="<?php echo $price ?>" >
                                      <input type="hidden" id="cOd<?php echo $cId ?>"  value="<?php echo $price ?>" >
                                      <input type="text" name="qty" id="sst<?php echo $cId ?>" maxlength="12" value="<?php echo $qty ?>" title="Quantity:"
                                          class="input-text qty">
                                      
                                      <button  id="up<?php echo $cId ?>"
                                          class="increase " type="button"><i class="lnr lnr-chevron-up"></i></button>
                                      <button id="down<?php echo $cId ?>"
                                          class="reduced " type="button"><i class="lnr lnr-chevron-down"></i></button>
                                  </div>
                              </td>
                              <td >
                                  <h5>Rs.<?php echo $tot ?></h5>
                              </td>
                                
                          </tr> 
                        <script>
    $(document).ready(function(){ 
           
 
         $('#up<?php echo $cId ?>').click(function(){ 
                var qty=$('#sst<?php echo $cId ?>').val();
                var price=$('#price<?php echo $cId ?>').val();
                var uId=<?php echo $cId ?>;
                if(qty>0){
                    qty++;
                $('#sst<?php echo $cId ?>').val(qty);                      
                }
                $('#cartTable').load("ajax/updateCart.php",{
                updateId:uId,qty:qty,price:price
                });                     
                
                                     
                                     
            });
         $('#down<?php echo $cId ?>').click(function(){ 
                var qty=$('#sst<?php echo $cId ?>').val();
                var price=$('#price<?php echo $cId ?>').val();
                var uId=<?php echo $cId ?>;
                if(qty>1){
                    qty--;
                $('#sst<?php echo $cId ?>').val(qty);                      
                }
                $('#cartTable').load("ajax/updateCart.php",{
                updateId:uId,qty:qty,price:price
                });                     
                
                                     
                                     
            });
            $('#sst<?php echo $cId ?>').change(function(){ 
                var qty=$('#sst<?php echo $cId ?>').val();
                var price=$('#price<?php echo $cId ?>').val();
                var uId=<?php echo $cId ?>;
               
                $('#cartTable').load("ajax/updateCart.php",{
                updateId:uId,qty:qty,price:price
                });                    
                                     
            });
           $(document).on('click', '#del<?php echo $cId ?>', function(){     
                var delId=<?php echo $cId ?>;
                
                $('#cartTable').load("ajax/updateCart.php",{
                    delId:delId
                });                     
                
            });
            $(document).on('change', '#district', function(){     
                var method=$('input[name="ship"]:checked').val();
                var district=$(this).val();
                if(method!=null){
                    $('#shippingPrice').html(district);
                }else{
                     $("#myToast").toast('show');
                }
                
            });

    });
     

  </script>
           <?php }
            ?>
                          
                        
                          <tr class="bottom_button">
                              <td>
                                  
                              </td>
                              <td>

                              </td>
                              <td>

                              </td>
                              <td>
                                  <div class="cupon_text d-flex align-items-center">
                                      <input type="text" placeholder="Coupon Code">
                                      <a class="primary-btn" href="#">Apply</a>
                                      <a class="button" href="#">Have a Coupon?</a>
                                  </div>
                              </td>
                          </tr>
                          <tr>
                              <td>

                              </td>
                              <td>

                              </td>
                              <td>
                                  <h5>Subtotal</h5>
                              </td>
                              <td>
                                  <h5 id="subt">Rs.<?php echo $sum ?></h5>
                              </td>
                          </tr>
               
                          <tr class="shipping_area">
                              <td class="d-none d-md-block">

                              </td>
                              <td >

                              </td>
                              <td >
                                    <h5>Shipping</h5>
                              </td>
                              
                              <td width="13%">
                                  <form action="checkout.php" method="post" id="shipping-form">
                                      <ul class="list ">
                                          <li class=" "><label class="float-left">Domex<span></span></label><input class="pixel-radio float-right " type="radio" value="Domex" name="ship"></li>       
                                          <li class=" "><span class="float-left">Local Post</span><input class="pixel-radio float-right " type="radio"  value="LocalPost" name="ship" ></li>     
                                          
                                    </ul>
                                  
                                  
                                  <div class="shipping_box">
                                      
                                      
                                     <!-- <select class="shipping_select">
                                          <option value="1">Bangladesh</option>
                                          <option value="2">India</option>
                                          <option value="4">Pakistan</option>
                                      </select>-->
                                      <select class="shipping_select"  name="district">
                                          <option value="1">Select a District</option>
                                          <option value="150">Colombo</option>
                                          <option value="250">Other</option>
                                      </select>
                                      <input type="text" placeholder="Postcode/Zipcode" name="zip">
                                      <h6 class="float-left">Shipping Cost<i class="fa fa-caret-right" aria-hidden="true"></i></h6><h4><span>Rs.</span><strong  class="float-right"></strong></h4>
                                  </div>
                                      
                                      </form>
                              </td>
                          </tr>
 
                          
                        </tbody>
                  </table>
              </div>
          </div>
      </div>
  </section>
    <section class="checkout_area section-margin--small">
    <div class="container">
        
        <div class="billing_details">
            <div class="row">
                <div class="col-lg-6">
                    <h3>Shipping Details</h3>
                    <form class="row contact_form"action="checkout.php" method="post" id="shipping-form">
                        
                       
                            
                        <div class="col-md-12 ">
                            <span class="placeholder mb-2" data-placeholder="Town/City"><strong>Method</strong></span>
                             <ul class="list ">
                                <li class=" ml-3"><label class="float-left">Domex<span></span></label><input class="pixel-radio float-right " type="radio" value="Domex" name="ship"></li>                    
                            </ul>
                        </div>
                        <div class="col-md-12 ">

                             <ul class="list ">
                                              
                                <li class="ml-3  "><span class="float-left">Local Post</span><input class="pixel-radio float-right " type="radio"  value="LocalPost" name="ship" ></li>     
                                          
                            </ul>
                        </div>
                        
                        <div class="col-md-12 form-group p_star">
                            <span class="placeholder mb-2" data-placeholder="Town/City"><strong>Shipping Location</strong></span>
                            <select class="country_select ml-2" id="district" name="district">
                                <option value="1">Select a District</option>
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
                
                <div class="col-lg-5 ml-5">
                    <div class="order_box">
                        <h2>Your Order</h2>
                        
                        <ul class="list list_2">
                            <li><a href="#">Subtotal <span>Rs.</span><span id="subt"><?php echo $sum ?></span></a></li>
                            <li><a href="#">Shipping <span>Rs.</span><strong id="shippingPrice" >0</strong></a></li>
                            <li><a href="#">Total <span>Rs.</span><span>$2210.00</span></a></li>
                        </ul>
                    
                        <div class="text-center">
                          <a class="button button-paypal" href="" onclick="document.getElementById('shipping-form').submit();" name="shippingSubmit">Proceed to Paypal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>
                   