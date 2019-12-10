<?php

include_once("order.php");
include_once("validation.php");

$order = new Order();
$validation = new Validation();

$sql = "SELECT * from orders";
$data = $order->getData($sql);

//insert data to database    
if (!empty($data)) {
    echo json_encode(array('status' => 200, 'msg' => 'Ok', 'data' => json_encode($data)));
} else {
    echo json_encode(array('status' => 304, 'msg' => 'Failed'));
}
?>