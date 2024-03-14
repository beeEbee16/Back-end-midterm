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

    // Determine parameters that are passed in
    if (isset($data->quote)) {
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

    // If at least one item to update, then update. Otherwise, display error
    if ($hasQuote || $hasAuthor || $hasCategory) {
        // Update post
        if($post->update($hasQuote, $hasAuthor, $hasCategory)) {
            echo json_encode(
                array('message' => 'Quote Updated')
            );
        } else {
            echo json_encode(
                array('message' => 'Quote Not Updated')
            );
        }
    } else {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
    }

    