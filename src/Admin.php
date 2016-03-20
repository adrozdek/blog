<?php

class Admin
{
    private $id;
    private $email;
    private static $connection = null;

    public function __construct($id, $email)
    {
        $this->id = intval($id);
        $this->email = $email;
    }

    public static function SetConnection(mysqli $connection)
    {
        Admin::$connection = $connection;
    }

    public static function RegisterAdmin($email, $password1, $password2)
    {
        if ($password1 !== $password2) {
            return false;
        }

        $options = [
            'cost' => 11,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
        ];
        $hashedPassword = password_hash($password1, PASSWORD_BCRYPT, $options);

        $stmt = self::$connection->prepare('INSERT INTO Admins(email, password) VALUES (?,?)');

        $stmt->bind_param('ss', $email, $hashedPassword);

        if ($stmt->execute()) {
            $admin = new Admin(self::$connection->insert_id, $email);
            $stmt->close();
            return $admin;
        }
        return false;
    }

    public static function LogInAdmin($email, $password)
    {
        $stmt = self::$connection->prepare('SELECT * FROM Admins WHERE email LIKE ?');
        $stmt->bind_param('s', $email);

        if ($stmt->execute() != false) {
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $isPasswordOK = password_verify($password, $row['password']);

                if ($isPasswordOK == true) {
                    $admin = new Admin($row['id'], $row['email']);
                    $stmt->close();
                    return $admin;
                }
                $stmt->close();
            }
        }
        return false;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getId()
    {
        return $this->id;
    }



}


