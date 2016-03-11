<?php

require_once("./src/connections.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user = User::RegisterUser(trim($_POST['name']), trim($_POST['email']), trim($_POST['password1']), trim($_POST['password2']), trim($_POST['description']));

    if ($user !== FALSE) {
        $_SESSION['userId'] = $user->getId();
        echo("Registered. You can start blogging.");
    } else {
        echo("Wrong registration");
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