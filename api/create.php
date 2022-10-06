<?php
    // Headers
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

    include_once "../config/database.php";
    include_once "../models/products.php";

    $database = new Database();
    $db = $database->connect();

    $product = new Products($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $product->sc_sku = $data->sc_sku;
    $product->sc_name = $data->sc_name;
    $product->sc_price = $data->sc_price;
    $product->sc_attr = $data->sc_attr;

    // Create Product
    if($product->create()) {
        echo json_encode(
            array('message' => 'Product Created')
        );
    } else {
        echo json_encode(
            array('message' => 'Product Not Created')
        );
    }