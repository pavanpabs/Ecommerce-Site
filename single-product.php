<?php include 'db/db.php'; ?>

<?php include 'includes/refs.php' ?>
<?php
// Start the session
session_start();
?>
<?php include 'includes/header.php' ?>
<?php
$product_id = $_GET['prd'];
?>
<style>
	/* Rating Star Widgets Style */
	.rating-stars ul {
		list-style-type: none;
		padding: 0;

		-moz-user-select: none;
		-webkit-user-select: none;
	}

	.rating-stars ul>li.star {
		display: inline-block;

	}

	/* Idle State of the stars */
	.rating-stars ul>li.star>i.fa {
		font-size: 2em;
		/* Change the size of the stars */
		color: #ccc;
		/* Color on idle state */
	}

	/* Hover state of the stars */
	.rating-stars ul>li.star.hover>i.fa {
		color: #FFCC36;
	}

	/* Selected state of the stars */
	.rating-stars ul>li.star.selected>i.fa {
		color: #FF912C;
	}
	.img-container {
		object-fit: cover;
  width:100%;
  height:auto;
	}

</style>


<script>
	$(document).ready(function() {

		$('#commentView').load("ajax/commentView.php", {
			product_id: '<?= $product_id ?>'
		});

		$('#addToCart').on('submit', function(e) {

			e.preventDefault();
			var usr = $('input[name="usr"]').val();
			var prd = $('input[name="prd"]').val();

			if (usr == 0) {
				toastr.info(
					'Please Log on to the system !', '', {
						timeOut: 3000,
						onHidden: function() {
							window.location.replace('login.php?redirect=single-product.php?prd=' + prd);
						}
					}
				);


			} else {

				$.ajax({
					type: 'post',
					url: 'ajax/addToCart.php',
					data: $(this).serialize(),
					success: function(data) {
						$('#cartCount').load("ajax/cartCount.php", {
							user: usr
						});
						if (data.toString() == 2) {
							toastr.error("You have already added this Item to the cart!");
						} else if (data.toString() == 1) {
							toastr.success("Added one item to the cart successfully!");
						} else {
							toastr.info("Something went wrong!");
						}

					}
				});
			}


		});

		/* 1. Visualizing things on Hover - See next part for action on click */
		$('#stars li').on('mouseover', function() {
			var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

			// Now highlight all the stars that's not after the current hovered star
			$(this).parent().children('li.star').each(function(e) {
				if (e < onStar) {
					$(this).addClass('hover');
				} else {
					$(this).removeClass('hover');
				}
			});

		}).on('mouseout', function() {
			$(this).parent().children('li.star').each(function(e) {
				$(this).removeClass('hover');
			});
		});

		/* 2. Action to perform on click */
		$('#stars li').on('click', function() {
			var onStar = parseInt($(this).data('value'), 10); // The star currently selected
			var stars = $(this).parent().children('li.star');

			for (i = 0; i < stars.length; i++) {
				$(stars[i]).removeClass('selected');
			}

			for (i = 0; i < onStar; i++) {
				$(stars[i]).addClass('selected');
			}

			// JUST RESPONSE (Not needed)
			var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
			var msg = "";
			if (ratingValue > 1) {
				msg = "Thanks! You rated this " + ratingValue + " stars.";
			} else {
				msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
			}
			responseMessage(msg, ratingValue);

		});

		$('#commentForm').on('submit', function(e) {

			e.preventDefault();
			var usr = $('input[name="usr"]').val();
			var prd = $('input[name="p_id"]').val();

			if (usr == 0) {
				toastr.info(
					'Please Log on to the system !', '', {
						timeOut: 3000,
						onHidden: function() {
							window.location.replace('login.php?redirect=single-product.php?prd=' + prd);
						}
					}
				);


			} else {

				$.ajax({
					type: 'post',
					url: 'ajax/addComments.php',
					data: $(this).serialize(),
					success: function(data) {
						if (data.toString() == 2) {
							toastr.info("You have already reviwed this item!");
						} else if (data.toString() == 1) {

							toastr.success("Review Added successfully!");
							$('#commentView').load("ajax/commentView.php", {
								product_id:prd
							});
						} else {
							toastr.info("Something went wrong!");
						}

					}
				});
			}


		});
	});

	function responseMessage(msg, rate) {
		$('.success-box').fadeIn(200);
		$('.success-box').html("<span>" + msg + "</span>");
		$('#ratingH').val(rate);
	}
</script>






<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="blog">
	<div class="container h-100">
		<div class="blog-banner">
			<div class="text-center">
				<h1>Shop Single</h1>
				<nav aria-label="breadcrumb" class="banner-breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">Shop Single</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</section>
<!-- ================ end banner area ================= -->
<?php
$sql = "SELECT * FROM product where pID=$product_id";
$query = mysqli_query($con, $sql);
while ($row = mysqli_fetch_assoc($query)) {
	$pkeys = explode("@@", $row['pkeys']);
	$pvals = explode("@@", $row['pvals']);
	$descrip = $row['description'];
	$images = $row['images'];
	$images = explode("|", $images)
?>



	<!--================Single Product Area =================-->
	<div class="product_image_area" id="cartToast">
		<div class="container">
			<div class="row s_product_inner">
				<div class="col-lg-6">
					<div class="owl-carousel owl-theme s_Product_carousel ">
						<?php
						$i = 0;
						for ($i = 0; $i < sizeof($images); $i++) {
						?>
							<div class=" img-container">
								<img class="img-fluid img-container" src="img/product/<?php echo $images[$i] ?>" alt="<?php echo $images[$i] ?>">
								
							</div>
							
						<?php
						}


						?>
					</div>
				</div>
				<div class="col-lg-5 offset-lg-1">
					<div class="s_product_text">
						<h3><?php echo $row['pname'] ?></h3>
						<h2>Rs. <?php echo $row['price'] ?></h2>
						<ul class="list">
							<li><a class="active" href="#"><span>Category</span> : <?php echo $row['category'] ?></a></li>
							<li><a href="#"><span>Availibility</span> : In Stock</a></li>
						</ul>
						<p><?php echo $descrip ?></p>
						<form id="addToCart">
							<div class="product_count">
								<label for="qty">Quantity:</label>
								<input type="text" name="qty" id="sst" size="2" maxlength="12" value="1" title="Quantity:" class="input-text qty ">
								<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;" class="increase items-count" type="button"><i class="ti-angle-up"></i></button>

								<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) && sst>1)result.value--;return false;" class="reduced items-count" type="button"><i class="ti-angle-down"></i></button>

							</div>
							<input type="hidden" name="prd" value="<?php echo $product_id ?>">
							<input type="hidden" name="usr" value="<?php echo $userId ?>">
							<input type="submit" name="firstSubmit" class="button primary-btn" value="Add to Cart">
						</form>
						<div class="card_area d-flex align-items-center">
							<a class="icon_btn" href="#"><i class="lnr lnr lnr-diamond"></i></a>
							<a class="icon_btn" href="#"><i class="lnr lnr lnr-heart"></i></a>
						</div>

					</div>

				</div>
			</div>
		</div>
	</div>
	<!--================End Single Product Area =================-->
<?php } ?>
<!--================Product Description Area =================-->
<section class="product_description_area">
	<div class="container">
		<ul class="nav nav-tabs" id="myTab" role="tablist">

			<li class="nav-item">
				<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Specification</a>
			</li>
			<li class="nav-item">
				<a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">Reviews</a>
			</li>
		</ul>
		<div class="tab-content" id="myTabContent">

			<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
				<div class="table-responsive">
					<table class="table">
						<tbody>

							<?php
							$i = 0;
							while (!empty($pkeys[$i])) {
								echo "<tr>";
								echo "<td>";
								echo "<h5>{$pkeys[$i]}</h5>";
								echo "</td>";
								echo "<td>";
								echo "<h5>{$pvals[$i]}</h5>";
								echo "</td>";
								$i++;
								echo "<tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>

			<div class="tab-pane fade show active" id="review" role="tabpanel" aria-labelledby="review-tab">
				<div class="row">
					<div class="col-lg-6" id="commentView"></div>
					<div class="col-lg-6">
						<div class="review_box">
							<h4>Add a Review</h4>
							<p>Your Rating:</p>
							
							<div class='rating-stars text-center'>
								<ul id='stars'>
									<li class='star' title='Poor' data-value='1'>
										<i class='fa fa-star fa-fw'></i>
									</li>
									<li class='star' title='Fair' data-value='2'>
										<i class='fa fa-star fa-fw'></i>
									</li>
									<li class='star' title='Good' data-value='3'>
										<i class='fa fa-star fa-fw'></i>
									</li>
									<li class='star' title='Excellent' data-value='4'>
										<i class='fa fa-star fa-fw'></i>
									</li>
									<li class='star' title='WOW!!!' data-value='5'>
										<i class='fa fa-star fa-fw'></i>
									</li>
								</ul>
							</div>
							<div class="success-box"></div>
							<form id="commentForm" class="form-contact form-review mt-3">
								<div class="form-group">
									<input type="hidden" name="usr" value="<?php echo $userId ?>">
									<input name="p_id" type="hidden" value="<?php echo $product_id ?>">
									<input name="rating" id="ratingH" type="hidden" value="">
									<input class="form-control" name="name" type="text" placeholder="Display name" required>
								</div>
								<div class="form-group">
									<textarea class="form-control" name="body" cols="4" rows="5" placeholder="Enter Message"></textarea>
								</div>
								<div class="form-group text-center text-md-right mt-3">
									<button type="submit" class="button button--active button-review">Submit Now</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!--================End Product Description Area =================-->

<!-- ================ Start related Product area =================   -->
<!-- <section class="related-product-area section-margin--small mt-0">
		<div class="container">
			<div class="section-intro pb-60px">
        <p>Popular Item in the market</p>
        <h2>Top <span class="section-intro__style">Product</span></h2>
      </div>
			<div class="row mt-30">
        <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
          <div class="single-search-product-wrapper">
            <div class="single-search-product d-flex">
              <a href="#"><img src="img/product/product-sm-1.png" alt=""></a>
              <div class="desc">
                  <a href="#" class="title">Gray Coffee Cup</a>
                  <div class="price">$170.00</div>
              </div>
            </div>
            <div class="single-search-product d-flex">
              <a href="#"><img src="img/product/product-sm-2.png" alt=""></a>
              <div class="desc">
                <a href="#" class="title">Gray Coffee Cup</a>
                <div class="price">$170.00</div>
              </div>
            </div>
            <div class="single-search-product d-flex">
              <a href="#"><img src="img/product/product-sm-3.png" alt=""></a>
              <div class="desc">
                <a href="#" class="title">Gray Coffee Cup</a>
                <div class="price">$170.00</div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
          <div class="single-search-product-wrapper">
            <div class="single-search-product d-flex">
              <a href="#"><img src="img/product/product-sm-4.png" alt=""></a>
              <div class="desc">
                  <a href="#" class="title">Gray Coffee Cup</a>
                  <div class="price">$170.00</div>
              </div>
            </div>
            <div class="single-search-product d-flex">
              <a href="#"><img src="img/product/product-sm-5.png" alt=""></a>
              <div class="desc">
                <a href="#" class="title">Gray Coffee Cup</a>
                <div class="price">$170.00</div>
              </div>
            </div>
            <div class="single-search-product d-flex">
              <a href="#"><img src="img/product/product-sm-6.png" alt=""></a>
              <div class="desc">
                <a href="#" class="title">Gray Coffee Cup</a>
                <div class="price">$170.00</div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
          <div class="single-search-product-wrapper">
            <div class="single-search-product d-flex">
              <a href="#"><img src="img/product/product-sm-7.png" alt=""></a>
              <div class="desc">
                  <a href="#" class="title">Gray Coffee Cup</a>
                  <div class="price">$170.00</div>
              </div>
            </div>
            <div class="single-search-product d-flex">
              <a href="#"><img src="img/product/product-sm-8.png" alt=""></a>
              <div class="desc">
                <a href="#" class="title">Gray Coffee Cup</a>
                <div class="price">$170.00</div>
              </div>
            </div>
            <div class="single-search-product d-flex">
              <a href="#"><img src="img/product/product-sm-9.png" alt=""></a>
              <div class="desc">
                <a href="#" class="title">Gray Coffee Cup</a>
                <div class="price">$170.00</div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-xl-3 mb-4 mb-xl-0">
          <div class="single-search-product-wrapper">
            <div class="single-search-product d-flex">
              <a href="#"><img src="img/product/product-sm-1.png" alt=""></a>
              <div class="desc">
                  <a href="#" class="title">Gray Coffee Cup</a>
                  <div class="price">$170.00</div>
              </div>
            </div>
            <div class="single-search-product d-flex">
              <a href="#"><img src="img/product/product-sm-2.png" alt=""></a>
              <div class="desc">
                <a href="#" class="title">Gray Coffee Cup</a>
                <div class="price">$170.00</div>
              </div>
            </div>
            <div class="single-search-product d-flex">
              <a href="#"><img src="img/product/product-sm-3.png" alt=""></a>
              <div class="desc">
                <a href="#" class="title">Gray Coffee Cup</a>
                <div class="price">$170.00</div>
              </div>
            </div>
          </div>
        </div>
      </div>
		</div>
	</section> -->
<!--================ end related Product area =================-->

<?php include 'includes/footer.php' ?>