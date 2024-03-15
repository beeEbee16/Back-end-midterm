<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Blog Post Object
    $post = new Post($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to delete. If no ID, exit
    if (isset($data->id)) {
        $post->id = $data->id;
    } else {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        echo json_encode(
            array('message' => 'Category Not Deleted')
        );
        return;
    }

    // Check if quote id exists
    if (!$post->id_exists($post->id, 'categories')) {
        echo json_encode(
            array('message' => 'Category Not Found')
        );
        echo json_encode(
            array('message' => 'Category Not Updated')
        );
        return;
    }

    // Delete post
    if($post->delete()) {
        echo json_encode(
            array('message' => 'Category Deleted')
        );
    } else {
        echo json_encode(
            array('message' => 'Category Not Deleted')
        );
    }