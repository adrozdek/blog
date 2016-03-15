<?php

require_once("./src/connections.php");
require_once("./src/nav.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = Security::IsValid(Security::SanitizeString($_POST['name']));
    $email = Security::IsValid(Security::SanitizeString($_POST['email']));
    $password1 = Security::IsValid(Security::SanitizeString($_POST['password1']));
    $password2 = Security::IsValid(Security::SanitizeString($_POST['password2']));
    $description = Security::IsValid(Security::SanitizeString($_POST['description']));

    if ($name && $email && $password1 && $password2 && $description) {

        $user = User::RegisterUser($name, $email, $password1, $password2, $description);

        if ($user != false) {
            $_SESSION['userId'] = $user->getId();
            echo("Registered. You can start blogging.");
        } else {
            echo("Wrong registration");
        }
    }
}

$form_action = 'register.php';
require_once './Template/registrationUser_form.php';

?>

