<?php

namespace Agata\Repositories;

use Agata\Models\Post;
use Agata\Services\MysqliDatabaseConnector;

class PostRepository
{
    public function loadPostById($id)
    {
        $db = MysqliDatabaseConnector::loadDb();
        //dostajemy instancję. bez połączenia. połaczenie wewnątrz funkcji queryParams
        $result = $db->queryParams("SELECT * FROM Posts WHERE id = ?", [$id]);
        //używam stworzonej przez siebie funkcji do bind_param

        if ($result) {
            $row = $result->fetch_assoc();
            $post = new Post($row['id'], $row['user_id'], $row['title'], $row['post_text'], $row['post_date']);
            return $post;
        }
        return false;
    }
}