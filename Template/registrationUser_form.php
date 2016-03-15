<h2>Registration</h2>

<form action="<?= $form_action ?>" method="post">

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

