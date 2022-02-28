<!DOCTYPE html>
<html class="no-js" lang="en">



<?php include "backend/header.php"; ?>
<?php
include "backend/db_connect.php";

//how to fetch order details from database
$sql = "SELECT * FROM sales_order_detail LEFT OUTER JOIN sales_order ON sales_order_detail.Sales_Order_idSales_Order =idSales_Order LEFT OUTER JOIN product_master on Product_Master_idProduct_Master =product_master.idProduct_Master WHERE sales_order.Retailer_idRetailer =" . $_COOKIE['idRetailer'] . "";
$ress = mysqli_query($conn, $sql);

?>

<!--Body Content-->
<br><br><br><br><br><br>
<div id="page-content">
    <!--Page Title-->
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper">
                <h1 class="page-width"><b>Your Order</b></h1>

            </div>
        </div>
    </div>
    <!--End Page Title-->

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 main-col">

                <div class="wishlist-table table-content table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>

                                <th class="product-price text-center alt-font">Images</th>
                                <th class="product-name alt-font">Name</th>
                                <th class="product-price text-center alt-font">Totle Price</th>
                                <th class="product-subtotal text-center alt-font">Order Date</th>
                                <th class="product-subtotal text-center alt-font">Status</th>
                                <th class="product-subtotal text-center alt-font">Replace</th>
                            </tr>
                        </thead>

                        <?php

                        $summ = 0;
                        $total = 0;

                        while ($saleOrder = mysqli_fetch_assoc($ress)) {
                            // echo $_COOKIE["idRetailer"];
                            $sid = $saleOrder['idSales_Order'];
                            $proid = $saleOrder['Product_Master_idProduct_Master'];

                            echo $proid;



                            if ($saleOrder['is_cancel'] == null) {
                                $status = "Pending";
                            } else if ($saleOrder['is_cancel'] == 1) {
                                $status = "Rejected";
                            } else if ($saleOrder['is_cancel'] == 0) {
                                $status = "Accepted"."<br><br><a href='invoice.php'>Invoice</a>";
                               
                            }
                            // echo $saleOrder['is_cancel'];

                            $qty = $saleOrder['Product_qty'];
                            $taxable = $saleOrder['Product_Price'];
                            $total1 = $qty * $taxable;
                            $summ = ($total1 * 12) / 100;
                            $total = $total1 + $summ;


                            echo '
                            <tbody>

                                        <tr>


                                            <td class="product-thumbnail text-center">
                                                <a href="#"><img src="admin/' . $saleOrder['image_url'] . '"  alt="" title="" /></a>
                                                </td>
                                            <td class="product-name">
                                                <h4 class="no-margin"><b>' . $saleOrder['Product_Name'] . '</b></h4>
                                                <span class="item-cat"><b>QTY-' . $saleOrder['Product_qty'] . '</b></span> &nbsp
                                                  <span class="item-cat"><b>PRICE - ₹' . $saleOrder['Product_Price'] . '</b></span><br>
                                                <span class="item-cat">' . $saleOrder['Product_Details'] . '</span>

                                            </td>
                                           
                                            <td class="product-price text-center"><span class="amount"><b>₹ ' . $total . '<small><b>.00</small></span></td>
                                            <td class="product-price text-center"><span class="amount"><b>' . $saleOrder['Sales_Order_Date'] . '</span></td>
                                            <td class="product-price text-center"><span class="amount"><b>' . $status . '</span></td>
                                            ';

                            if ($saleOrder['is_cancel'] == null) {
                                 echo '
                                <td class="product-subtotal text-center">
                                                         <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#exampleModalCenter">
                                                          Cancel</button><br> 
                                                           </td> ';
                            } else if ($saleOrder['is_cancel'] == 1) {
                            } else if ($saleOrder['is_cancel'] == 0) {

                                echo '
                                <td class="product-subtotal text-center">
                                                         <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#exampleModalCenter">
                                                          Replace</button><br> 
                                                           </td> ';
                            }

                            echo '

                        </tr>
                        </tbody>
';
                        } ?>
                        <?php echo '
               
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle"> ' . $proid . '  Reason of replace the product</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                   <input type="text" placeholder="Enter the reason" required></input>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <form method="post"><a href="salesReplace.php?idSalesOrder=' . $sid . '&idPro=' . $proid . '">
                                    <button type="button" class="btn btn-primary" name="replace">Replace</button>
                                  </a></form> 
                                </div>
                        </div>
                    </div>
                </div>
                            
                                   
                              '; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Body Content-->

<!--Footer-->
<?php
include "backend/footer.php";
?>
</body>



</html>