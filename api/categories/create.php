<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
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

    $post->category = isset($data->category) ? $data->category : '';

     // Check if missing parameters
     if ($post->category === '') {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        return;
    }

    $newId = 0;

    // Create post
    $newId = $post->create();
    if($newId) {
        echo json_encode(
            array('id' => $newId, 'category'=> $post->category)
        );
    } else {
        echo json_encode(
            array('message' => 'Category Not Created')
        );
    }