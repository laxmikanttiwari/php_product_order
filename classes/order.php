<?php

include_once 'dbconfig.php';

class Order extends DbConfig {

    public function __construct() {
        parent::__construct();
    }

    public function getData($query) {
        $result = $this->connection->query($query);
        if ($result == false) {
            return false;
        }

        $rows = array();

        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function execute($query) {
        $result = $this->connection->query($query);

        if ($result == false) {
            echo 'Error: cannot execute the command';
            return false;
        } else {
            return true;
        }
    }

    public function delete($id, $table) {
        $query = "DELETE FROM $table WHERE id = $id";

        $result = $this->connection->query($query);

        if ($result == false) {
            echo 'Error: cannot delete id ' . $id . ' from table ' . $table;
            return false;
        } else {
            return true;
        }
    }

    public function escape_string($value) {
        return $this->connection->real_escape_string($value);
    }

    public function insert($data) {
        $sql = "INSERT INTO orders(items,total_line_item_amount,total_tax,total_amount,order_date) VALUES('" . $data['items'] . "','" . $data['total_line_item_amount'] . "','" . $data['total_tax'] . "','" . $data['total_amount'] . "','" . $data['order_date'] . "')";
        return $this->execute($sql);
    }

}

?>