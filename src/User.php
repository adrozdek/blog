<?php

require_once('Security.php');

class User
{
    static private $connection = null;

    static public function SetConnection(mysqli $connection)
    {
        User::$connection = $connection;
    }

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

        $stmt = self::$connection->prepare('INSERT INTO Users(name, email, password, description) VALUES (?,?,?,?)');

        $stmt->bind_param('ssss', $name, $email, $hashedPassword, $description);

        if ($stmt->execute()) {
            $newUser = new User(self::$connection->insert_id, $name, $email, $description);
            $stmt->close();
            return $newUser;
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
        $stmt = self::$connection->prepare('SELECT * FROM Users WHERE id = ?');
        $stmt->bind_param('i', $id);

        if ($stmt->execute() != false) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $user = new User($row['id'], $row['name'], $row['email'], $row['description']);
                $stmt->close();
                return $user;
            }
        }
        return false;
    }

    static public function GetAllUsers()
    {
        $sql = "SELECT * FROM Users";
        $result = self::$connection->query($sql);

        if ($result != false && $result->num_rows > 0) {
            $users = [];
            while ($row = $result->fetch_assoc()) {
                $user = new User($row['id'], $row['name'], $row['email'], $row['description']);
                $users[] = $user;
            }
            return $users;
        }
        return false;
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
        $sql = "SELECT * FROM Posts WHERE user_id = $this->id";
        $result = self::$connection->query($sql);

        if($result == true && $result->num_rows > 0) {
            $posts = [];
            while($row = $result->fetch_assoc()) {
                $post = new Post($row['id'], $row['user_id'], $row['post_text'], $row['post_date']);
                $posts[] = $post;
            }
            return $posts;
        }
        return false;

    }

    public function loadAllSentMessages()
    {

    }

    public function loadAllReceivedMessages()
    {

    }


}