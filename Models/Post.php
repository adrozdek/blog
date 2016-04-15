<?php

namespace Models;

require_once('Database.php');

class Post
{
    private $id;
    private $userId;
    private $title;
    private $postText;
    private $postDate;
    /**
     * @var \mysqli
     */
    private static $connection = null;

    public function __construct($id, $userId, $title, $postText, $postDate)
    {
        $this->id = intval($id);
        $this->userId = intval($userId);
        $this->setTitle($title);
        $this->setPostText($postText);
        $this->postDate = $postDate;
    }

    public static function SetConnection(\mysqli $connection)
    {
        Post::$connection = $connection;
    }

    public static function CreatePost($title, $postText)
    {
        $userId = $_SESSION['userId'];
        $postDate = date('Y-m-d H:i:s', time());

        $statement = self::$connection->prepare('INSERT INTO Posts(user_id, title, post_text, post_date) VALUES (?,?,?,?)');
        $statement->bind_param('isss', intval($userId), $title, $postText, $postDate);

        if ($statement->execute()) {
            $statement->close();
            return true;
        }
        return false;
    }

    public static function LoadPostById($id)
    {
        $statement = self::$connection->prepare('SELECT * FROM Posts where id = ?');
        $statement->bind_param('i', intval($id));

        if ($statement->execute() !== false) {
            //var_dump($statement);die;
            $result = $statement->get_result();
            $row = $result->fetch_assoc();
            $post = new Post($row['id'], $row['user_id'], $row['title'], $row['post_text'], $row['post_date']);
            $statement->close();
            return $post;
        }
        return false;
    }

    public static function SearchPosts($searchText)
    {
        $search = '%' . $searchText . '%';
        $stmt = self::$connection->prepare('SELECT * FROM Posts WHERE title LIKE ?');
        $stmt->bind_param('s', $search);

        $posts = [];
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                var_dump($row);
                $post = new Post($row['id'], $row['user_id'], $row['title'], $row['post_text'], $row['post_date']);
                $posts[] = $post;
            }
            $stmt->close();
        }
        return $posts;
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

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getPostText()
    {
        return $this->postText;
    }

    public function getPostDate()
    {
        return $this->postDate;
    }

    public function getAllComments()
    {
        $comments = [];
        $sql = "SELECT * FROM Comments WHERE post_id = $this->id ORDER BY comment_date DESC";
        $result = self::$connection->query($sql);

        if ($result != false && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $comment = new Comment($row['id'], $row['post_id'], $row['user_id'], $row['comment_text'], $row['comment_date']);
                $comments[] = $comment;
            }
        }
        return $comments;
    }

    public function removePost()
    {
        $sql = "DELETE FROM Posts WHERE id = $this->id";
        $result = self::$connection->query($sql);

        if ($result == true) {
            return true;
        }
        return false;
    }

    public function updatePost($title, $postText)
    {
        $stmt = self::$connection->prepare("UPDATE Posts SET post_text = ?, title = ? WHERE id = $this->id");
        $stmt->bind_param('ss', $postText, $title);

        if ($stmt->execute() != false) {
            $this->setPostText($postText);
            $this->setTitle($title);
            $stmt->close();
            return true;
        } else {
            return false;
        }
    }
}