<?php include '../db/db.php';?>

<style>
.zoom {
  transition: transform .2s; /* Animation */
}

.zoom:hover {
  transform: scale(1.08); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
  box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
}
.squareasd {
    width: 100%;
    padding-bottom: 100%;
    background-size: cover;
    background-position: center;
    }

   </style>
<section class="lattest-product-area pb-40 category-list">
            <div class="row" >
<?php 
 $que="";
    

    $iems_per_page=$_POST['nPerPage'];
    $first_item=$_POST['fRes'];
    $current_page=$_POST['cPage'];
    if(isset($_POST['sVal'])){ 
      if(isset($_POST['searVal'])){ 
        $searchData=$_POST['searVal'];
        $que="AND pname like '%$searchData%' ";
      }
      $cat=$_POST['sVal'];
        if(isset($_POST['sortVal'])){
          $sortingVal=$_POST['sortVal'];
          if($sortingVal=="2"){
            $sql="SELECT * FROM product WHERE category=$cat $que  ORDER BY price ASC LIMIT $first_item , $iems_per_page ";
          }else if($sortingVal=="3"){
            $sql="SELECT * FROM product WHERE category=$cat $que ORDER BY price DESC LIMIT $first_item , $iems_per_page ";
          }else{
            $sql="SELECT * FROM product WHERE category=$cat $que LIMIT $first_item , $iems_per_page";
          }
        }else{
          $sql="SELECT * FROM product WHERE category=$cat $que LIMIT $first_item , $iems_per_page";
        }
      }else{
        if(isset($_POST['searVal'])){ 
          $searchData=$_POST['searVal'];
          $que="WHERE pname like '%$searchData%' ";
        }
        if(isset($_POST['sortVal'])){
          $sortingVal=$_POST['sortVal'];
          if($sortingVal=="2"){
            $sql="SELECT * FROM product $que ORDER BY price ASC LIMIT $first_item , $iems_per_page ";
          }else if($sortingVal=="3"){
            $sql="SELECT * FROM product $que ORDER BY price DESC LIMIT $first_item , $iems_per_page ";
          }else{
            $sql="SELECT * FROM product $que LIMIT $first_item , $iems_per_page";
          }
        }else{
          $sql="SELECT * FROM product $que LIMIT $first_item , $iems_per_page";
          
        }
      }
    //echo $iems_per_page;
    //echo $first_item-- ;
    
    $result=mysqli_query($con,$sql);
    
    while($row=mysqli_fetch_array($result)){
      $images=$row['images'];
      $image=explode("|",$images);
      ?>
        
        <div class="col-4 col-sm-6 col-md-6 col-lg-3">
          <div >
                <div class="card text-center card-product  zoom" >
                  <a href="single-product.php?prd=<?php echo $row['pId']?>">
                  <div class="card-product__img card-img square" style="background-image:url('img/product/<?php echo $image[0]?>')">
  
                  
                   
                    </a>
                    <ul class="card-product__imgOverlay">
                      <li><button ><i class="ti-search"></i></button></li>
                      <li><button><i class="ti-shopping-cart"></i></button></li>
                      <li><button><i class="ti-heart"></i></button></li>
                    </ul>
                  </div>
                  
                  <div class="card-body p-0 m-0">
                  <a href="single-product.php?prd=<?php echo $row['pId']?>">
                    <h4 class="card-product__title p-0 m-0"><a href="single-product.php?prd=<?php echo $row['pId']?>" ><?php echo $row['pname']?></a></h4>
                    <p class="card-product__price p-0 m-0">Rs.<?php echo $row['price']?></p></a>
                  </div>
                </div>
          </div>
        </div>
    
            
 <?php   } ?>
            </div>
          </section>
 <?php
   if(isset($_POST['sVal'])){ 
    if(isset($_POST['searVal'])){ 
      $searchData=$_POST['searVal'];
      $que=" AND pname like '%$searchData%' ";
    }
    $cat=$_POST['sVal'];
      if(isset($_POST['sortVal'])){
        $sortingVal=$_POST['sortVal'];
        if($sortingVal=="2"){
          $sql1="SELECT * FROM product WHERE category=$cat $que ";
        }else if($sortingVal=="3"){
          $sql1="SELECT * FROM product WHERE category=$cat $que";
        }else{
          $sql1="SELECT * FROM product WHERE category=$cat $que";
        }
      }else{
        $sql1="SELECT * FROM product WHERE category=$cat $que";
      }
    }else{
      if(isset($_POST['searVal'])){ 
        $searchData=$_POST['searVal'];
        $que=" Where pname like '%$searchData%' ";
      }
      if(isset($_POST['sortVal'])){
        $sortingVal=$_POST['sortVal'];
        if($sortingVal=="2"){
          $sql1="SELECT * FROM product $que";
        }else if($sortingVal=="3"){
          $sql1="SELECT * FROM product $que";
        }else{
          $sql1="SELECT * FROM product $que";
        }
      }else{
        $sql1="SELECT * FROM product $que";
        
      }
    }
    $result1=mysqli_query($con,$sql1);
    $rows_count=mysqli_num_rows($result1);
    $pageCount=ceil($rows_count/$iems_per_page);
?>  
<nav class="blog-pagination justify-content-center d-flex">
      <ul class="pagination">
          <li class="page-item">
                <Button type="button" class="page-link" id ="page-down" ><span class="lnr lnr-chevron-left"></span></button>
          </li>
          <?php
          
        for ($page=1;$page<=$pageCount;$page++) {
          if($page==$current_page){
            echo '<li class="page-item active">';
          //echo '<a class="page-link" value="'.$page.'" >' . $page . '</a> ';
          echo '<input type="button" class="page-link link-sqr" id ="'.$page.'" value="'.$page.'" >';
          
          echo '</li>';
          }else{
            echo '<li class="page-item">';
          //echo '<a class="page-link" value="'.$page.'" >' . $page . '</a> ';
          echo '<input type="button" class="page-link link-sqr" id ="'.$page.'" value="'.$page.'" >';
          echo '</li>';
          }
          
        }
        echo '<input type="hidden" id ="page_count" value="'.$pageCount.'" >';
          ?>
          
          <li class="page-item">
              <Button type="button" class="page-link" id ="page-up" ><span class="lnr lnr-chevron-right"></span></button>
          </li>
      </ul>
      </nav>
     