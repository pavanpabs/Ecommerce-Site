<?php include 'db/db.php';
$_SESSION['role'] = "Admin" ?>

<?php include 'includes/refs.php' ?>
<?php
// Start the session
session_start();
?>
<?php include 'includes/header.php' ;
if(isset($_POST['searchBox'])){
  $searchVal=$_POST['searchBox'];
}else{
  $searchVal="";
}
?>

<script>
  $(document).ready(function() {
    var selectedVal = $('.cat:checked').val();
    var searchVal="<?=$searchVal ?>";
    var page = 1;
    var firstRes = (page - 1) * 12;
    var numPage = 12;
    $('#selling_cat').load("ajax/loadItems.php", {
      sVal: selectedVal,
      fRes: firstRes,
      nPerPage: numPage,
      cPage: page,
      searVal: searchVal
    });
    $('.cat').change(function() {
      var selectedVal = $(this).val();
      var page = 1;
      var firstRes = (page - 1) * 12;
      var numPage = 12;
      $('#selling_cat').load("ajax/loadItems.php", {
        sVal: selectedVal,
        fRes: firstRes,
        nPerPage: numPage,
        cPage: page
      });
    });

    $(document).on('click', '.link-sqr', function() {
      var selectedVal = $('.cat:checked').val();
      var searchVal = $('#searchBox').val();
      page = $(this).attr("id");
      var firstRes = (page - 1) * 12;
      numPage = $('.limitItems').find(":selected").val();
      $('#selling_cat').load("ajax/loadItems.php", {
        sVal: selectedVal,
        fRes: firstRes,
        nPerPage: numPage,
        cPage: page,
        searVal: searchVal
      });
    });
    $(document).on('click', '#page-up', function() {
      var selectedVal = $('.cat:checked').val();
      var searchVal = $('#searchBox').val();
      var pageCount = $('#page_count').val();
      if (page != pageCount) {
        page++;
      }

      var firstRes = (page - 1) * 12;
      numPage = $('.limitItems').find(":selected").val();
      $('#selling_cat').load("ajax/loadItems.php", {
        sVal: selectedVal,
        fRes: firstRes,
        nPerPage: numPage,
        cPage: page,
        searVal: searchVal
      });
    });
    $(document).on('click', '#page-down', function() {
      var selectedVal = $('.cat:checked').val();
      var searchVal = $('#searchBox').val();
      if (page != 1) {
        page--;
      }
      var firstRes = (page - 1) * 12;
      numPage = $('.limitItems').find(":selected").val();
      $('#selling_cat').load("ajax/loadItems.php", {
        sVal: selectedVal,
        fRes: firstRes,
        nPerPage: numPage,
        cPage: page,
        searVal: searchVal
      });
    });
    $(document).on('submit', '#searchFrm', function(e) {
      e.preventDefault();
      var page = 1;
      var firstRes = (page - 1) * 12;
      var selectedVal = $('.cat:checked').val();
      var searchVal = $('#searchBox').val();
      numPage = $('.limitItems').find(":selected").val();
      $('#selling_cat').load("ajax/loadItems.php", {
        sVal: selectedVal,
        fRes: firstRes,
        nPerPage: numPage,
        cPage: page,
        searVal: searchVal
      });
    });
    $('.sortItems').change(function() {
      var sortVal = $(this).val();
      var selectedVal = $('.cat:checked').val();
      var searchVal = $('#searchBox').val();
      var page = 1;
      var firstRes = (page - 1) * 12;
      var numPage = 12;
      $('#selling_cat').load("ajax/loadItems.php", {
        sVal: selectedVal,
        fRes: firstRes,
        nPerPage: numPage,
        sortVal: sortVal,
        cPage: page,
        searVal: searchVal
      });
    });
    $('.limitItems').change(function() {
      var limitVal = $(this).val();
      var sortVal = $('.sortItems:checked').val();
      var searchVal = $('#searchBox').val();
      var selectedVal = $('.cat:checked').val();
      var page = 1;
      var firstRes = (page - 1) * limitVal;
      var numPage = limitVal;
      $('#selling_cat').load("ajax/loadItems.php", {
        sVal: selectedVal,
        fRes: firstRes,
        nPerPage: numPage,
        sortVal: sortVal,
        cPage: page,
        searVal: searchVal
      });
    });
  });
</script>

<!-- ================ start banner area ================= -->
<section class="blog-banner-area" id="category">
  <div class="container h-100">
    <div class="blog-banner">
      <div class="text-center">
        <h1>Shop Category</h1>
        <nav aria-label="breadcrumb" class="banner-breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shop Category</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</section>
<!-- ================ end banner area ================= -->


<!-- ================ category section start ================= -->
<section class="section-margin--small mb-5">
  <div class="container">
    <div class="row">
      <div class="col-xl-3 col-lg-3 col-md-5">
        <div class="sidebar-categories">
          <div class="head">Browse Categories</div>
          <ul class="main-categories">
            <li class="common-filter">
              <form action="#">
                <ul>
                  <?php
                  $sql = "SELECT * FROM categories";
                  $run = mysqli_query($con, $sql);
                  while ($row = mysqli_fetch_assoc($run)) {
                    $cat_id = $row['id'];
                    $cat_name = $row['name'];
                    $sql = "SELECT COUNT(*) as cnt FROM product where category= $cat_id";
                    $data = mysqli_query($con, $sql);
                    $row = mysqli_fetch_assoc($data);
                    $count = $row['cnt'];
                  ?>
                    <li class="filter-list"><input class="pixel-radio cat" type="radio" name="brand" value="<?= $cat_id ?>"><label for="<?= $cat_name ?>"><?= $cat_name ?><span> (<?= $count ?>)</span></label></li>
                  <?php } ?>
                </ul>
              </form>
            </li>
          </ul>
        </div>

      </div>
      <div class="col-xl-9 col-lg-8 col-md-7">
        <!-- Start Filter Bar -->
        <div class="filter-bar d-flex flex-wrap align-items-center">
          <div class="sorting">
            <select class="sortItems">
              <option value="1">Popularity</option>
              <option value="2">Price low to high</option>
              <option value="3">Price high to low</option>
            </select>
          </div>
          <div class="sorting mr-auto">
            <select class="limitItems">
              <option value="12">Show 12</option>
              <option value="24">Show 24</option>
            </select>
          </div>
          <div>
            <form id="searchFrm">
              <div class="input-group filter-bar-search">
                <input type="text" id="searchBox" placeholder="Search" value="<?= $searchVal ?>">
                <div class="input-group-append">
                  <button id="searchButton" type="submit"><i class="ti-search"></i></button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- End Filter Bar -->
        <!-- Start Best Seller -->
        <div id="selling_cat">




        </div>
        <!-- End Best Seller -->
      </div>
    </div>
  </div>
</section>
<!-- ================ category section end ================= -->

<!-- ================ top product area start ================= -->
<section class="related-product-area">
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
</section>
<!-- ================ top product area end ================= -->

<!-- ================ Subscribe section start ================= -->
<section class="subscribe-position">
  <div class="container">
    <div class="subscribe text-center">
      <h3 class="subscribe__title">Get Update From Anywhere</h3>
      <p>Bearing Void gathering light light his eavening unto dont afraid</p>
      <div id="mc_embed_signup">
        <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01" method="get" class="subscribe-form form-inline mt-5 pt-1">
          <div class="form-group ml-sm-auto">
            <input class="form-control mb-1" type="email" name="EMAIL" placeholder="Enter your email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Your Email Address '">
            <div class="info"></div>
          </div>
          <button class="button button-subscribe mr-auto mb-1" type="submit">Subscribe Now</button>
          <div style="position: absolute; left: -5000px;">
            <input name="b_36c4fd991d266f23781ded980_aefe40901a" tabindex="-1" value="" type="text">
          </div>

        </form>
      </div>

    </div>
  </div>
</section>
<!-- ================ Subscribe section end ================= -->


<?php include 'includes/footer.php' ?>