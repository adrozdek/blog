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

?>

<h2>Registration</h2>
<div class="center">
    <form action="register.php" method="post">

        <p>
            <label>
                Email:
                <input type="email" name="email">
            </label>
        </p>
        <p>
            <label>
                Name:
                <input type="text" name="name">
            </label>
        </p>
        <p>
            <label>
                Password:
                <input type="password" name="password1">
            </label>
        </p>
        <p>
            <label>
                Repeat password:
                <input type="password" name="password2">
            </label>
        </p>
        <p>
            <label>
                Description:
                <input type="text" name="description">
            </label>
        </p>
        <p>
            <input type="submit" value="Register">
        </p>
    </form>

</div>