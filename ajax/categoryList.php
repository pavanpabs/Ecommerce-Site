<?php include '../db/db.php' ?>


<div class="col-12 col-md-6 float-right">
    <h3>Existing Categories</h3>
    <?php
    $sql = "SELECT * FROM categories";
    $run = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($run)) {
        $catName = $row['name'];
        $catId = $row['id'];

    ?>
        <div class="form-group">
            <input type="hidden" name="just" value="test">
            <input class="col-8 col-sm-8 col-md-8  m-1" id="edit<?= $catId ?>" type="text" name="CatName" value="<?= $catName ?>">
            <input type="button" id="del<?= $catId ?>" name="catDel" class="col-3 col-sm-3 col-md-3 btn btn-danger float-right p-1 " value="Delete">
        </div>
        <script>
            $(document).ready(function() {

                $('#edit<?= $catId ?>').on('change', function() {
                    var editName = $(this).val();
                    var editId = '<?= $catId ?>';
                    $('catInput').val = editName;;
                    $.ajax({
                        type: 'post',
                        url: 'ajax/addCategories.php',
                        data: {
                            just: editName,
                            id: editId
                        },
                        success: function(data) {
                            // $('#cartCount').load("ajax/cartCount.php", {
                            // 	user: userId
                            // });
                            if (data.toString() ==1) {
                                toastr.success("Category Edited sucessfully!");
                            } else {
                                toastr.info("Something went wrong!");
                            }

                        }
                    });
                });

                $('#del<?= $catId ?>').on('click', function() {
                    var editName = $(this).val();
                    var editId = '<?= $catId ?>';
                    toastr.warning("<br /><button type='button' class='btn ' value='yes'>Yes</button><button type='button' class='btn clear ml-1'  value='no' >No</button>", 'Are you sure you want to delete this item?', {
                        allowHtml: true,
                        onclick: function(toast) {
                            value = toast.target.value
                            if (value == 'yes') {
                                toastr.remove();
                                $.ajax({
                                    type: 'post',
                                    url: 'ajax/addCategories.php',
                                    data: {
                                        del: editId
                                    },
                                    success: function(data) {
                                        $('#catList').load("ajax/categoryList.php", {});
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