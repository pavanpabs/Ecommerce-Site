
<section class="cart_area mb-0">
      <div class="container ">
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


               <tr>
                              <td>
                                  <div class="media">
                                      <div class="my-4 mr-3">
                                          <button id="" type="button"  class="page-link"><i class="fas fa-trash-alt"></i>
                                          </button>
                                      </div>
                                      <div class="d-flex"  height="100px">
                                          <img width="150px" src="img/product/" alt="">
                                      </div>
                                      <div class="media-body">
                                          <p>Item 1</p>
                                      </div>
                                  </div>
                              </td>
                              <td>
                                  <h5>Rs.100</h5>
                              </td>
                              <td >
                                  <div class="product_count">
                                    
                                      <input type="text" name="qty" id="" title="Quantity:"
                                          class="input-text qty">
                                      
                                      <button  id="up"
                                          class="increase " type="button"><i class="lnr lnr-chevron-up"></i></button>
                                      <button id="down"
                                          class="reduced " type="button"><i class="lnr lnr-chevron-down"></i></button>
                                  </div>
                              </td>
                              <td >
                                  <h5>Rs.100</h5>
                              </td>
                                
                          </tr> 
                        
        
                          
                        
                          <tr class="bottom_button ">
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
                          
                          
                        </tbody>
                  </table>
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
                    <form class="row contact_form"action="" method="post" id="shipping-form">
                        
                       
                            
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
                
                <div class="col-lg-5 ml-5">
                    <div class="order_box">
                        <h2>Your Order</h2>
                        
                        <ul class="list list_2">
                            <li><a href="#">Subtotal <span id="subt">1000</span><span>Rs.</span></a></li>
                            <li><a href="#">Shipping <span id="shippingPrice" >0</span><span>Rs.</span></a></li>
                            <li><a href="#">Total <strong ><span id="tot">1000</span><span>Rs.</span></strong></a></li>
                        </ul>
                    
                        <div class="text-center">
                          <button class="button button-paypal"  id="shippingSubmit">Proceed to Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>
                   