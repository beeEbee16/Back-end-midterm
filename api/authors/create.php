<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Blog Post Object
    $post = new Post($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $post->author = isset($data->author) ? $data->author : '';

     // Check if missing parameters
     if ($post->author === '') {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        /* echo json_encode(
            array('message' => 'Author Not Created')
        ); */
        return;
    }

    $newId = 0;

    // Create post
    $newId = $post->create();
    if($newId) {
        echo json_encode(
            array('id' => $newId, 'author'=> $post->author)
        );
    } else {
        echo json_encode(
            array('message' => 'Author Not Created')
        );
    }