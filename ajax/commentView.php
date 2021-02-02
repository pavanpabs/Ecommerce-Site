<?php include '../db/db.php' ?>
<?php session_start();
if (isset($_SESSION['userID'])) {
    $userId = $_SESSION['userID'];
} else {
    $userId = 0;
}
$name = true;
if (isset($_POST['product_id'])) {
    $pid = $_POST['product_id'];
}
?>
<style>
    .textareaASD:disabled {
        background: #ffffff;
        border: none;
        overflow: auto;
        outline: none;
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        box-shadow: none;

        resize: none;
        /*remove the resize handle on the bottom right*/
    }


    #editDeleteIcons {
        visibility: hidden;
    }

    .review_item:hover #editDeleteIcons {
        visibility: visible;
    }

    #hideElement {
        display: none;
    }
</style>
<script>
    function editText(id) {
        var disVal = $('#text' + id).prop('disabled');
        var editClas = $('#edit' + id).prop('class')

        if (disVal == true) {
            $('#text' + id).prop('disabled', false);
            $('#edit' + id).prop('class', 'fas fa-check fa-lg');
        } else {
            var value = $('#text' + id).prop('value');
            $.ajax({
                type: 'post',
                url: 'ajax/addComments.php',
                data: {
                    editVal: value,
                    editId: id
                },
                success: function(data) {
                    if (data.toString() == 1) {

                        toastr.success("Review updated successfully!");

                    } else {
                        toastr.info("Something went wrong!");
                    }

                }
            });

            $('#text' + id).prop('disabled', true);
            $('#edit' + id).prop('class', 'far fa-edit fa-lg');
        }


    }

    function deleteComment(id) {
        var pId='<?= $pid ?>';
        toastr.warning("<br /><button type='button' class='btn ' value='yes'>Yes</button><button type='button' class='btn clear ml-1'  value='no' >No</button>", 'Are you sure you want to delete this item?', {
            allowHtml: true,
            onclick: function(toast) {
                value = toast.target.value
                if (value == 'yes') {
                    $.ajax({
                        type: 'post',
                        url: 'ajax/addComments.php',
                        data: {
                            delVal: id
                        },
                        success: function(data) {
                            if (data.toString() == 1) {

                                toastr.success("Review Deleted successfully!");

                            } else {
                                toastr.info("Something went wrong!");
                            }

                        }
                    });
                    toastr.remove();
                    $('#commentView').load("ajax/commentView.php", {
								product_id:pId 
					});
                } else {
                    toastr.remove();
                }
            }

        })


    }
</script>
<div>
    <?php
    
    $one = 0;
    $two = 0;
    $three = 0;
    $four = 0;
    $five = 0;
    $average = 0.0;
    $count = 0;
    $sql = "SELECT * FROM comments where product_id=$pid";
    $run = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_assoc($run)) {
        $user_name = $row['display_name'];
        $com_body = $row['body'];
        $com_rating = $row['rating'];
        $com_time = $row['time'];
        $com_user = $row['user_id'];
if($com_rating>0){
    if ($com_rating == 1) {
        $one++;
    } else if ($com_rating == 2) {
        $two++;
    } else if ($com_rating == 3) {
        $three++;
    } else if ($com_rating == 4) {
        $four++;
    } else {
        $five++;
    }
}
$count = $one + $two + $three + $four + $five;
$average = (1 * $one + 2 * $two + 3 * $three + 4 * $four + 5 * $five) / ($count);
}

       


    ?>
    <div class="row total_rate">
        <div class="col-6">
            <div class="box_total">
                <h5>Overall</h5>
                <h4><?= $average ?></h4>
                <h6>(<?= $count ?> Reviews)</h6>
            </div>
        </div>
        <div class="col-6">
            <div class="rating_list">
                <h3>Based on <?= $count ?> Reviews</h3>
                <ul class="list">
                    <li><a href="#">5 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><?= $five ?></a></li>
                    <li><a href="#">4 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><?= $four ?></a></li>
                    <li><a href="#">3 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><?= $three ?></a></li>
                    <li><a href="#">2 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><?= $two ?></a></li>
                    <li><a href="#">1 Star <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><?= $one ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="review_list">
        <?php
        $show = "";
        

        $sql = "SELECT * FROM comments where product_id=$pid";
        $run = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_assoc($run)) {
            $com_id = $row['id'];
            $user_name = $row['display_name'];
            $com_body = $row['body'];
            $com_rating = $row['rating'];
            $com_time = $row['time'];
            $com_user = $row['user_id'];
            if ($userId == $com_user) {
                $show = "editDeleteIcons";
            } else {
                $show = "hideElement";
            }

        ?>
            <div class="review_item">
                <div class="media">
                    <div class="d-flex">
                        <img src="img/product/review-1.png" alt="">
                    </div>
                    <div class="media-body">
                        <h4><?= $user_name ?></h4>
                        <?php
                        for ($i = 0; $i < $com_rating; $i++) {
                            echo "<i class='fa fa-star'></i>";
                        }
                        for ($i = $com_rating; $i < 5; $i++) {
                            echo "<i class='far fa-star'></i>";
                        }
                        ?>
                        <!-- <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i> -->
                    </div>
                </div>
                <span id="<?= $show ?>"><i id="edit<?= $com_id ?>" class="far fa-edit fa-lg" onclick="editText(<?= $com_id ?>)"></i><i onclick="deleteComment(<?= $com_id ?>)" class="far fa-trash-alt fa-lg"></i></span>
            </div>
            <textarea class="form-control different-control w-100 textareaASD" name="message" id="text<?= $com_id ?>" cols="30" value="" disabled=true><?= $com_body ?></textarea>

    </div>

</div>

<?php } ?>
</div>
</div>