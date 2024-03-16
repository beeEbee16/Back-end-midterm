<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models//Quote.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Blog Post Object
    $post = new Post($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Check parameter variables
    $hasQuote = false;
    $hasAuthor = false;
    $hasCategory = false;
    
    // Set ID to update. If no ID, exit
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

    // Determine parameters that are passed in
    if (isset($data->quote)) {
        if ($data->quote === '') {
            echo json_encode(
                array('message' => 'Missing Required Parameters')
            );
            return;
        }
        $post->quote = $data->quote;
        $hasQuote = true;
    } 

    if (isset($data->author_id)) {
        $post->author_id = $data->author_id;
        $hasAuthor = true;
    } 

    if (isset($data->category_id)) {
        $post->category_id = $data->category_id;
        $hasCategory = true;
    } 

    // Check if all data is present
    if ($hasQuote && $hasAuthor && $hasCategory) {

        $hasAuthor = false;
        $hasCategory = false;
        
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
            // Update post
            if($post->update()) {
                echo json_encode(
                    array('id' => $post->id, 'quote' => $post->quote, 'author_id' => $post->author_id, 'category_id' => $post->category_id)
                );
            } else {
                echo json_encode(
                    array('message' => 'Quote Not Updated')
                );
            }
        } 
    } else {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
    }

    