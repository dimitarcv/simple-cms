<section id="main-content">
  <div id="users-form">
    <?php echo validation_errors('<div class="error-mes">', '</div>'); ?>

    <?php echo form_open(current_url(), array('class'=>'basic-form')); ?>

      <label for="username">Username</label>
      <input id="username" type="text" name="username" value="<?php echo set_value('username'); ?>" maxlength="50" required>
      <br>
      <label for="password">Password</label>
      <input id="password" type="password" name="password" value="" maxlength="50" required>
      <br>
      <label for="rep-password">Repeated password</label>
      <input id="rep-password" type="password" name="reppassword" value="" maxlength="50" required>
      <br>
      <input type="submit" name="submit" value="Add user">
    </form>
  </div>
</section><!--#main-content-admin-->