<?php

include_once("order.php");
include_once("validation.php");

$order = new Order();
$validation = new Validation();

$noofrows = $_POST['noofrows'];
for ($i = 1; $i <= $noofrows; $i++) {
    $product_name = $order->escape_string($_POST['product_name_' . $i]);
    $product_id = $_POST['product_id_' . $i];
    $product_quantity = $_POST['product_quantity_' . $i];
    $product_price = $_POST['product_price_' . $i];
    $msg[] = $validation->check_empty($_POST, array('noofrows', 'total_amount', 'line_item_amount', 'total_tax'));
    $product_data_array[] = array(
        'product_id' => $product_id,
        'product_name' => $product_name,
        'product_quantity' => $product_quantity,
        'product_price' => $product_price,
    );
// checking empty fields
}

$data_insert = array(
    'items' => json_encode($product_data_array),
    'total_line_item_amount' => $_POST['line_item_amount'],
    'total_tax' => $_POST['total_tax'],
    'total_amount' => $_POST['total_amount'],
    'order_date' => date('Y-m-d')
);
//insert data to database    
if ($order->insert($data_insert)) {
    echo json_encode(array('status' => 200, 'msg' => 'Order Placed Successfully.'));
} else {
    echo json_encode(array('status' => 304, 'msg' => 'Failed to add Order'));
}
?>