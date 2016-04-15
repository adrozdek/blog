<?php

namespace Agata\Models;

class Comment
{
    private $id;
    private $postId;
    private $userId;
    private $commentText;
    private $commentDate;
    private static $connection = null;

    public function __construct($id, $postId, $userId, $commentText, $commentDate)
    {
        $this->setCommentText($commentText);
        $this->commentDate = $commentDate;
        $this->id = intval($id);
        $this->postId = $postId;
        $this->userId = $userId;
    }

    public static function SetConnection(mysqli $connection)
    {
        Comment::$connection = $connection;
    }

    public static function CreateComment($postId, $commentText)
    {
        $userId = $_SESSION['userId'];
        $commentDate = date('Y-m-d H:i:s T', time());
        $stmt = self::$connection->prepare('INSERT INTO Comments (post_id, user_id, comment_text, comment_date) VALUES (?,?,?,?)');
        $stmt->bind_param('iiss', $postId, $userId, $commentText, $commentDate);

        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        return false;
    }

    public static function LoadCommentById($id)
    {
        $sql = "SELECT * FROM Comments WHERE id = $id";
        $result = self::$connection->query($sql);

        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $comment = new Comment($row['id'], $row['post_id'], $row['user_id'], $row['comment_text'], $row['comment_date']);
            return $comment;
        }
        return false;
    }

    public function getCommentDate()
    {
        return $this->commentDate;
    }

    public function getCommentText()
    {
        return $this->commentText;
    }

    public function setCommentText($commentText)
    {
        $this->commentText = $commentText;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPostId()
    {
        return $this->postId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function removeComment()
    {
        $sql = "DELETE FROM Comments WHERE id = $this->id";
        $result = self::$connection->query($sql);

        if ($result == true) {
            return true;
        }
        return false;
    }

    public function updateComment($commentText)
    {
        $stmt = self::$connection->prepare("UPDATE Comments SET comment_text = ? WHERE id = $this->id");
        $stmt->bind_param('s', $commentText);

        if ($stmt->execute() != false) {
            $this->setCommentText($commentText);
            $stmt->close();
            return true;
        } else {
            return false;
        }
    }
}