<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/custom.css" />
<script src="js/jquery.min.js"></script>


<?php
/*
  Index page
 */

//including the database connection file
include_once("classes/order.php");

$order = new Order();

//fetching data in descending order (lastest entry first)
$query = "SELECT * FROM products where available_sale=1 ORDER BY id DESC";
$result = $order->getData($query);

$query_order = "SELECT * FROM orders ORDER BY id ASC";
$result_order = $order->getData($query_order);

//echo '<pre>'; print_r($result); exit;
?>

<div class="row">
    <div class="col-md-12">
        <div class="col-md-6 border pull-left item-table-add">
            <table class="table">
                <thead class="">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($result as $product) {
                        ?>
                        <tr class="<?= $i ?>">
                            <th scope="row"><?= $i; ?></th>
                            <td class="product_name"><?= $product['name']; ?></td>
                            <td class="product_price"><?= $product['price']; ?></td>
                            <td>
                                <select class="product_quantity" name="quantity">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </td>
                            <td class="button_class">
                    <ipnut type="hidden" value="<?= $product['id']; ?>" name="product_id" class="product_id"></ipnut>
                    <button data-product_id ="<?= $product['id']; ?>" type="button" class="add_button btn btn-primary">Add Product</button>
                    </td>

                    </tr>
                    <?php
                    $i++;
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-6 border item-table-cart">
            <form id="product_form" method="POST">
                <table class="table">
                    <thead class="">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Remove</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Price</th>
                        </tr>
                    </thead>
                    <input type="hidden" id="noofrows" name="noofrows">
                    <tbody class="product_tbody">



                    </tbody>
                </table>

                <div class="col-md-12" id="cart_item_details" style="display:none">
                    <div class="col-md-6 pull-left"></div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr><td>Total Line Item Amount</td><td><input type="text" name="line_item_amount" id="line_item_amount" readonly></td></tr>
                            <tr><td>Total Tax</td><td><input type="text" name="total_tax" id="total_tax" readonly></td></tr>
                            <tr><td>Total</td><td><input type="text" name="total_amount" id="total_amount"></td></tr>
                        </table>
                    </div>
                    <button id="complete_order" type="button" class="btn btn-primary pull-right">Complete Order</button>
                </div>
            </form> 
        </div>
    </div>
</div>

<div class="row border item-table-list">
    <h2>Order List</h2>
    <table class="table">
        <thead class="">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Amount</th>
                <th scope="col">Total Tax Amount</th>
                <th scope="col">Total Amount</th>
                <th scope="col">Order Date</th>
            </tr>
        </thead>
        <tbody id="previous_orders" class="previous_orders">
            <?php
            $i = 1;
            foreach ($result_order as $order) {
                ?>
                <tr>
                    <th scope="row"><?= $i; ?></th>
                    <td><?= $order['total_line_item_amount']; ?></td>
                    <td><?= $order['total_tax']; ?></td>
                    <td><?= $order['total_amount']; ?></td>
                    <td><?= $order['order_date']; ?></td>
                </tr>
                <?php
                $i++;
            }
            ?>
        </tbody>
    </table>
</div>
<script src="js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/notify.min.js"></script>