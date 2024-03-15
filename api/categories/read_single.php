<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Blog Post Object
    $post = new Post($db);

    // Get ID
    $post->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get post
    $result = $post->read_single();

    // Get Row Count
    $num = $result->rowCount();

    // Check if any posts
    if ($num) {
        
        $row = $result->fetch(PDO::FETCH_ASSOC);

        // Create array
        $post_arr = array(
            'id' => $post->id,
            'category' => $row['category']
        );

        // Make JSON
        print_r(json_encode($post_arr));
    } else {
        // No posts
        echo json_encode(
            array('message' => 'category_id Not Found')
        );
    }