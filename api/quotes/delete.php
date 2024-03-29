<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

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
        return;
    }

    // Check if quote id exists
    if (!$post->id_exists($post->id, 'quotes')) {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
        return;
    }

    // Delete post
    if($post->delete()) {
        echo json_encode(
            array('id'=> $post->id)
        );
    } else {
        echo json_encode(
            array('message' => 'Quote Not Deleted')
        );
    }