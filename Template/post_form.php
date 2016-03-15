<div class='container'>
    <h3>New post:</h3>
    <form action='<?php echo $form_action; //można też <?=$form_action ?>' method='post'>
        <p>
            <label>Title:
                <input type="text" name="title">
            </label>
        </p>
        <label>
            <textarea name='postText' rows='30' cols='100'></textarea>
        </label>
        <input type='submit'>
    </form>
</div>

