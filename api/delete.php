<?php
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

    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog post object
    $product = new Products($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));
    $parsedArray = $data->selected;
    $checkError = false;

    foreach ($parsedArray as $i => $item) {
        $product->sc_sku = $item;

        if($product->delete() === false) {
            $checkError = true;
            break;
        }
    }

    if ($checkError) {
        http_response_code(400);
        echo json_encode(
            array('message' => 'Something went wrong..')
        );
    } else {
        http_response_code(200);
        echo json_encode(
            array('message' => 'Products Deleted..')
        );
    }