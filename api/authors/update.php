<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models//Author.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Blog Post Object
    $post = new Post($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to update. If no ID, exit
    if (isset($data->id)) {
        $post->id = $data->id;
    } else {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        echo json_encode(
            array('message' => 'Author Not Updated')
        );
        return;
    }

    // Check if author_id exists
    if (!$post->id_exists($post->id, 'authors')) {
        echo json_encode(
            array('message' => 'author_id Not Found')
        );
        echo json_encode(
            array('message' => 'Author Not Updated')
        );
        return;
    }

    // Determine parameters that are passed in
    if (isset($data->author)) {
        if ($data->author === '') {
            echo json_encode(
                array('message' => 'Missing Required Parameters')
            );
            echo json_encode(
                array('message' => 'Author Not Updated')
            );
            return;
        }
        $post->author = $data->author;

        // Update post
        if($post->update()) {
            echo json_encode(
                array('message' => 'Author Updated')
            );
        } else {
            echo json_encode(
                array('message' => 'Author Not Updated')
            );
        }
    } else {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        echo json_encode(
            array('message' => 'Author Not Updated')
        );
    }
