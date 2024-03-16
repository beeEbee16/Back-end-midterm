<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Blog Post Object
    $post = new Post($db);

    // Get author and category ID
    $post->author_id = isset($_GET['author_id']) ? $_GET['author_id'] : 0;
    $post->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;

    // Blog Post Query
    $result = $post->read();
    
    // Get Row Count
    $num = $result->rowCount();

    // Check if any posts
    if($num) {
        // Post array
        $posts_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $post_item = array(
                'id' => $id,
                'quote' => $quote,
                'author' => $author,
                'category' => $category
            );

            // Push to 'data'
            array_push($posts_arr, $post_item);
        }

        // Turn to JSON & output
        echo json_encode($posts_arr);
    } else {
        // No posts
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }