<?php
require_once("DBConnection.php");

if(isset($_GET['id'])){
    $qry = $conn->query("SELECT p.*, GROUP_CONCAT(c.name) as categories FROM `product_list` p
                         INNER JOIN `product_category` pc ON p.product_id = pc.product_id
                         INNER JOIN `category_list` c ON pc.category_id = c.category_id
                         WHERE p.product_id = '{$_GET['id']}' GROUP BY p.product_id");

    $result = $qry->fetch_assoc();

    if($result){
        extract($result);
    }
}
?>
<style>
    #uni_modal .modal-footer{
        display:none !important;
    }
</style>

<br>
<div class="container-fluid">
    <div class="col-12">
        <div class="w-100 mb-1">
          <div class="fs-6"><b>Product Code (ISBN):</b></div>
          <div class="fs-5 ps-4"><?php echo isset($product_code) ? $product_code : '' ?></div>
        </div>
        <div class="w-100 mb-1">
            <div class="fs-6"><b>Category:</b></div>
            <div class="fs-5 ps-4"><?php echo isset($categories) ? $categories : '' ?></div>
        </div>
        <div class="w-100 mb-1">
            <div class="fs-6"><b>Product:</b></div>
            <div class="fs-5 ps-4"><?php echo isset($name) ? $name : '' ?></div>
        </div>
        <div class="w-100 mb-1">
            <div class="fs-6"><b>Description:</b></div>
            <div class="fs-6 ps-4"><?php echo isset($description) ? $description : '' ?></div>
        </div>
        <div class="w-100 mb-1">
            <div class="fs-6"><b>Price:</b></div>
            <div class="fs-5 ps-4"><?php echo isset($price) ? number_format($price,2) : '' ?></div>
        </div>
        <div class="w-100 mb-1">
            <div class="fs-6"><b>Status:</b></div>
            <div class="fs-5 ps-4">
                <?php
                    if(isset($status) && $status == 1){
                        echo "<small><span class='badge rounded-pill bg-success'>Active</span></small>";
                    }else{
                        echo "<small><span class='badge rounded-pill bg-danger'>Inactive</span></small>";
                    }
                ?>
            </div>
        </div>
        <div class="w-100 d-flex justify-content-end">
            <button class="btn btn-sm btn-dark rounded-0" type="button" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>
