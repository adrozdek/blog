<?php

require_once("src/connections.php");

if (isset($_SESSION['adminId']) != true) {
    header("Location: login.php");
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = Security::IsValid(Security::SanitizeString($_POST['email']));
    $password1 = Security::IsValid(Security::SanitizeString($_POST['password1']));
    $password2 = Security::IsValid(Security::SanitizeString($_POST['password2']));

    if ($email && $password1 && $password2) {
        $admin = Admin::RegisterAdmin($email, $password1, $password2);

        if ($admin != false) {
            $_SESSION['adminId'] = $admin->getId();
            echo("Registered. You can start admin things.");
        } else {
            echo("Wrong registration");
        }
    }
}

require_once("src/nav.php");
?>

<h2>Registration admin</h2>
<div class="center">
    <form action="admin.php" method="post">
        <p>
            <label>
                Email:
                <input type="email" name="email">
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
            <input type="submit" value="Register">
        </p>
    </form>
