<?php

namespace Agata\Repositories;

use Agata\Models\Post;
use Agata\Services\MysqliDatabaseConnector;

class PostRepository
{
    public function loadPostById($id)
    {
        $db = MysqliDatabaseConnector::loadDb();
        $result = $db->queryParams("SELECT * FROM Posts WHERE id = ?", [$id]);

        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $post = new Post($row['id'], $row['user_id'], $row['title'], $row['post_text'], $row['post_date']);
            return $post;
        }
        return false;
    }
}