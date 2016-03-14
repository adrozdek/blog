<?php

require_once("./src/connections.php");

if (isset($_SESSION['userId'])) {
    header("Location: blog.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = Security::IsValid(Security::SanitizeString($_POST['email']));
    $password = Security::IsValid(Security::SanitizeString($_POST['password']));

    if ($email && $password) {
        $user = User::LogInUser($email, $password);

        if ($user != false) {
            $_SESSION['userId'] = $user->getId();
            header("Location: blog.php");
        } else {
            echo("Wrong email or password.");
        }
    } else {
        echo('Email or password are invalid');
    }
}

require_once("src/nav.php");
?>

<div class="container">

    <h2>Login:</h2>
    <form action="login.php" method="post">
        <p>
            <label>
                Email:
                <input type="email" name="email">
            </label>
        </p>
        <p>
            <label>
                Password:
                <input type="password" name="password">
            </label>
        </p>
        <p>
            <input type="submit" value="Log In">
        </p>
    </form>


    <p>
        Don't have an account?
        <a href='register.php' name='register'>Register now</a>


    </p>
</div>
