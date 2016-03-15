
<h2>Login:</h2>
<form action="<?=$form_action; ?>" method="post">
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
    <a href='<?= $register; ?>' name='register'>Register now</a>

</p>