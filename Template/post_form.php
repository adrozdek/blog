<?php if (isset($headline)): ?>
    <h3><?= $headline; ?></h3>
<?php endif; ?>

<form action='<?php echo $form_action; //można też <?=$form_action ?>' method='post'>
    <p>
        <label>Title:
            <input type="text" name="title" value='<?= (isset($title)) ? $title : ""; ?>'>
        </label>
    </p>
    <label>
        <textarea name='postText' rows='30' cols='100'><?= (isset($postText)) ? $postText : ""; ?></textarea>
    </label>
    <input type='submit'>
</form>


