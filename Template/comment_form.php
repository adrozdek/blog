<?php if (isset($headline)): ?>
    <h3><?= $headline; ?></h3>
<?php endif; ?>

<form action='<?php echo $form_action; ?>' method='post'>
    <label>
        <input type='text' name='commentText' value='<?= (isset($commentText)) ? $commentText : ""; ?>'>
    </label>
    <input type='submit'>
</form>



