<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
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

    $post->quote = $data->quote;
    $post->author_id = isset($data->author_id) ? $data->author_id : null;
    $post->category_id = isset($data->category_id) ? $data->category_id : null;

    // Check if missing parameters
    // Determine parameters that are passed in
    if (isset($data->quote)) {
        if ($data->quote === '') {
            echo json_encode(
                array('message' => 'Missing Required Parameters')
            );
           /*  echo json_encode(
                array('message' => 'Quote Not Updated')
            ); */
            return;
        }
        $post->quote = $data->quote;
        $hasQuote = true;
    } else {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
    }

    if ($post->author_id === null || $post->category_id === null) {
        if ($post->author_id === null) {
            echo json_encode(
                array('message' => 'Missing Required Parameters')
            );
        }
        if ($post->category_id === null) {
            echo json_encode(
                array('message' => 'Missing Required Parameters')
            );
        }
 /*        echo json_encode(
            array('message' => 'Quote Not Created')
        ); */
        return;
    }

    $hasAuthor = false;
    $hasCategory = false;
    $newId = 0;

    // Make sure author exists
    if (!$post->id_exists($post->author_id, 'authors')) {
        echo json_encode(
            array('message' => 'author_id Not Found')
        );
    } else $hasAuthor = true;

    // Make sure category exists
    if (!$post->id_exists($post->category_id, 'categories')) {
        echo json_encode(
            array('message' => 'category_id Not Found')
        );
    } else $hasCategory = true;

    if ($hasAuthor && $hasCategory) {
        // Create post
        $newId = $post->create();
        if($newId) {
            echo json_encode(
                array('id' => $newId, 'quote' => $post->quote, 'author_id' => $post->author_id, 'category_id' => $post->category_id)
            );
        } else {
            echo json_encode(
                array('message' => 'Quote Not Created')
            );
        }
    } /* else {
        echo json_encode(
            array('message' => 'Quote Not Created')
        );
    } */
