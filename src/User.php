<?php

require_once('Security.php');
require_once('Database.php');

class User
{
    static public function RegisterUser($name, $email, $password1, $password2, $description)
    {
        if ($password1 !== $password2) {
            return false;
        }

        $options = [
            'cost' => 11,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
        ];
        $hashedPassword = password_hash($password1, PASSWORD_BCRYPT, $options);

        $db = Database::getInstance();
        $params =  [$name, $email, $hashedPassword, $description];
        $result = $db->queryParams('INSERT INTO Users(name, email, password, description) VALUES (?,?,?,?)', 'ssss', $params);

        if ($result != false) {
            $user = new User(1, $name, $email, $description);
            return $user;
        }
        return false;
    }

    static public function LogInUser($email, $password)
    {
        $stmt = self::$connection->prepare('SELECT * FROM Users WHERE email LIKE ?');
        $stmt->bind_param('s', $email);

        if ($stmt->execute() != false) {
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $isPasswordOK = password_verify($password, $row['password']);

                if ($isPasswordOK == true) {
                    $user = new User($row['id'], $row['name'], $row['email'], $row['description']);
                    $stmt->close();
                    return $user;
                }
                $stmt->close();
            }
        }
        return false;
    }

    static public function GetUserById($id)
    {
        $db = Database::getInstance();
        $result = $db->queryParams('SELECT * FROM Users WHERE id = ?', $id, 'i');

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $user = new User($row['id'], $row['name'], $row['email'], $row['description']);

            return $user;
        }

        return false;
    }

    static public function GetAllUsers()
    {
        $users = [];
        $db = Database::getInstance();
        $result = $db->queryParams('SELECT * FROM Users ORDER BY name ASC');

        if ($result != false && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $user = new User($row['id'], $row['name'], $row['email'], $row['description']);
                $users[] = $user;
            }

        }
        return $users;
    }

    private $id;
    private $name;
    private $email;
    private $description;

    public function __construct($id, $name, $email, $description)
    {
        $this->id = intval($id);
        $this->email = $email;
        $this->name = $name;
        $this->setDescription($description);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($newDescription)
    {
        if (strlen($newDescription) > 0) {
            return ($this->description = $newDescription);
        }
        return false;
    }

    public function changeDescription($newDescription)
    {
        $this->setDescription($newDescription);

        $sql = "UPDATE Users SET description ='$this->description' WHERE id= $this->id";
        $result = self::$connection->query($sql);

        if ($result == true) {
            return true;
        }
        return false;
    }

    public function loadAllUserPosts()
    {
        $posts = [];
        $sql = "SELECT * FROM Posts WHERE user_id = $this->id ORDER BY post_date DESC";
        $result = self::$connection->query($sql);

        if ($result == true && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $post = new Post($row['id'], $row['user_id'], $row['title'], $row['post_text'], $row['post_date']);
                $posts[] = $post;
            }

        }
        return $posts;

    }


}