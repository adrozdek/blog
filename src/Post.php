<?php

require_once ('Security.php');

class Post
{
    static private $connection = null;

    static public function SetConnection(mysqli $connection)
    {
        Post::$connection = $connection;
    }

    static public function CreatePost($postText)
    {
        $userId = $_SESSION['userId'];

        $postDate = date('Y-m-d H:i:s', time());

        $statement = self::$connection->prepare('INSERT INTO Posts(user_id, post_text, post_date) VALUES (?,?,?)');
        $statement->bind_param('iss', intval($userId), $postText, $postDate);

        if ($statement->execute()) {
            $statement->close();
            return true;
        }
        return false;
    }

    static public function LoadPostById($id)
    {
        $statement = self::$connection->prepare('SELECT * FROM Posts where id = ?');
        $statement->bind_param('i', intval($id));

        if ($statement->execute() != false) {
            $result = $statement->get_result();
            //var_dump($result);
            $row = $result->fetch_assoc();
            //var_dump($row);
            $post = new Post($row['id'], $row['user_id'], $row['post_text'], $row['post_date']);
            $statement->close();
            return $post;

        }
        return false;
    }

    private $id;
    private $userId;
    private $postText;
    private $postDate;

    public function __construct($id, $userId, $postText, $postDate)
    {
        $this->id = intval($id);
        $this->userId = intval($userId);
        $this->setPostText($postText);
        $this->postDate = $postDate;
    }

    public function setPostText($postText)
    {
        if (strlen($postText) > 0) {
            return ($this->postText = $postText);
        }
        return false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return intval($this->userId);
    }

    public function getPostText()
    {
        return $this->postText;
    }

    public function getPostDate()
    {
        return $this->postDate;
    }


}