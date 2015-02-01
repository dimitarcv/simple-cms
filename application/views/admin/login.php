<div id="login-form">
  <?php echo validation_errors('<div class="error-mes">', '</div>'); ?>

  <?php echo form_open(current_url(), array('class'=>'basic-form')); ?>

    <label for="username">Username</label>
    <input id="username" type="text" name="username" value="" maxlength="50" required>
    <br>
    <label for="password">Password</label>
    <input id="password" type="password" name="password" value="" maxlength="50" required>
    <br>
    <input type="submit" name="submit" value="Login">

  <?php echo form_close(); ?>
</div>