<?php

namespace Agata\Repositories;

use Agata\Core\MysqliDbConnection;
use Agata\Models\Post;
use Agata\Services\MysqliDatabaseConnector;

class PostRepository extends MysqliDbConnection
{
    public function loadPostById($id)
    {
        $db = $this->db;
        var_dump($db);
        $statement = $db->query("SELECT * FROM Posts WHERE id = $id");
//            ->bind_param('i', $id);
//
//        if ($statement->execute() !== false) {
//            //var_dump($statement);die;
//            $result = $statement->get_result();
//            $row = $result->fetch_assoc();
//            $post = new Post($row['id'], $row['user_id'], $row['title'], $row['post_text'], $row['post_date']);
//            $statement->close();
//            return $post;
//        }
        var_dump($statement);
        return false;
    }
}