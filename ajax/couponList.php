<?php include '../db/db.php' ?>


<div class="col-12 col-md-6 float-right">
    <h3>Existing Categories</h3>
    <?php
    $sql = "SELECT * FROM coupons";
    $run = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($run)) {
        $c_Name = $row['coupon_name'];
        $c_Id = $row['coupon_id'];
        $c_discount = $row['coupon_discount'];

    ?>
        <div class="form-group overflow-auto">
            <div class="col-8 col-sm-8 col-md-8 float-left m-2" ><h5><?= $c_Name ?>-<?= $c_discount ?>% Off</h5></div>
            <input type="button" id="del<?= $c_Id  ?>" name="catDel" class="col-3 col-sm-3 col-md-3 btn btn-danger float-right p-1 " value="Delete">
           
        </div>
        
        <script>
            $(document).ready(function() {

               

                $('#del<?= $c_Id  ?>').on('click', function() {
                    var editId = '<?= $c_Id  ?>';
                    toastr.warning("<br /><button type='button' class='btn ' value='yes'>Yes</button><button type='button' class='btn clear ml-1'  value='no' >No</button>", 'Are you sure you want to delete this item?', {
                        allowHtml: true,
                        onclick: function(toast) {
                            value = toast.target.value
                            if (value == 'yes') {
                                toastr.remove();
                                $.ajax({
                                    type: 'post',
                                    url: 'ajax/addCoupons.php',
                                    data: {
                                        del: editId
                                    },
                                    success: function(data) {
                                        $('#couList').load("ajax/couponList.php", {});
                                        if (data.toString() ==1) {
                                            toastr.success("Deleted sucessfully!");
                                        } else {
                                            toastr.info("Something went wrong!");
                                        }

                                    }
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