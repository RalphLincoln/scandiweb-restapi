<?php
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");

    include_once "../config/database.php";
    include_once "../models/products.php";

    $database = new Database();
    $db = $database->connect();

    $product = new Products($db);

    $result = $product->read();

    $num = $result->rowCount();

    if ($num > 0) {
        $product_arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $product_item = array(
                "sc_sku" => $sc_sku,
                "sc_name" => $sc_name,
                "sc_price" => $sc_price,
                "sc_attr" => $sc_attr
            );
            $product_arr[] = $product_item;
        }
        echo json_encode($product_arr);
    } else {
        echo json_encode(array());
    }
