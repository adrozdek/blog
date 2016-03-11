<?php

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

        $sql = "INSERT INTO Users(name, email, password, description) VALUES ('$name', '$email', '$hashedPassword', '$description')";

        $result = self::$connection->query($sql);
        if ($result === TRUE) {
            $newUser = new User(self::$connection->insert_id, $name, $email, $description);
            return $newUser;
        }
        return false;
    }

    static public function LogInUser($email, $password)
    {
        $sql = "SELECT * FROM Users WHERE email LIKE '$email'";
        $result = self::$connection->query($sql);

        if ($result != false) {
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $isPasswordOK = password_verify($password, $row['password']);

                if ($isPasswordOK == true) {
                    $user = new User($row['id'], $row['name'], $row['email'], $row['description']);
                    return $user;
                }
            }
        }
        return false;
    }

    static public function GetUserById($id)
    {
        $sql = "SELECT * FROM Users WHERE id = $id";
        $result = self::$connection->query($sql);

        if ($result != false && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $user = new User($row['id'], $row['name'], $row['email'], $row['description']);
            return $user;
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


    }

    public function loadAllSentMessages()
    {

    }

    public function loadAllReceivedMessages()
    {

    }




}