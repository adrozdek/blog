<?php

require_once("./src/connections.php");

if (isset($_SESSION['userId'])) {
    header("Location: default.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = Security::IsValid(Security::SanitizeString($_POST['email']));
    $password = Security::IsValid(Security::SanitizeString($_POST['password']));

    if ($email && $password) {
        if ($user = User::LogInUser($email, $password)) {
            if ($user != false) {
                $_SESSION['userId'] = $user->getId();
                $url = Param::url(false);
                header("Location: $url");
            } else {
                echo("Wrong email or password.");
            }
        } elseif ($admin = Admin::LogInAdmin($email, $password)) {
            if ($admin != false) {
                $_SESSION['adminId'] = $admin->getId();
                $url = Param::url(false, ['action' => 'bloggers']);
                header("Location: $url");
            } else {
                echo("Wrong email or password");
            }
        } else {
            echo('Email or password are invalid');
        }
    }
}

require_once("src/nav.php");

$form_action = 'login.php';
$register = 'register.php';

require_once './Template/login_form.php';




