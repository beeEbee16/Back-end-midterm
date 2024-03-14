<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';
    //include_once '../../models/Author.php';

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
    if ($post->author_id === null || $post->category_id === null) {
        if ($post->author_id === null) {
            echo json_encode(
                array('message' => 'author_id Not Found')
            );
        }
        if ($post->category_id === null) {
            echo json_encode(
                array('message' => 'category_id Not Found')
            );
        }
        echo json_encode(
            array('message' => 'Quote Not Created')
        );
        return;
    }

    $hasAuthor = false;
    $hasCategory = false;

    // Make sure author exists
    // Instantiate Blog Post Object
    //$database2 = new Database();
    //$db2 = $database->connect();
    //$author = new Author($db2);

    if (!$post->author_exists($post->author_id)) {
        echo json_encode(
            array('message' => 'author_id Not Found')
        );
    } else $hasAuthor = true;

    /* $query = 'SELECT 
                    id
                FROM
                    authors 
                WHERE
                    id = ?';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindparam(1, $this->id);

    // Execute query
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        echo json_encode(
            array('message' => 'author_id Not Found')
        );
    } else $hasAuthor = true; */

    // Make sure category exists
    /* $query = 'SELECT 
                    id
                FROM
                    categories 
                WHERE
                    id = ?';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindparam(1, $this->id);

    // Execute query
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        echo json_encode(
            array('message' => 'category_id Not Found')
        );
    } else $hasCategory = true;

    if (!$hasAuthor || !$hasCategory) {
        echo json_encode(
            array('message' => 'Quote Not Created')
        );
        return;
    } */


    // Create post
    if($post->create()) {
        echo json_encode(
            array('message' => 'Quote Created')
        );
    } else {
        echo json_encode(
            array('message' => 'Quote Not Created')
        );
    }