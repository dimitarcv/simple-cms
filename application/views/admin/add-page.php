<?php
$action = "Add page";
if($edit) $action = "Edit page";
?>

<section id="main-content">
  <div id="users-form">
    <?php echo validation_errors('<div class="error-mes">', '</div>'); ?>
    <?php $hidden = array('page_id' => $page_id); ?>
    <?php echo form_open(current_url(), array('class'=>'basic-form'), $hidden); ?>

      <label for="page-name">Page name</label>
      <input id="page-name" type="text" name="page_name" value="<?php echo html_escape($page_name) ?>" maxlength="50" required>
      <br>
      <label for="title">Title</label>
      <input id="title" type="text" name="page_title" value="<?php echo html_escape($page_title); ?>" maxlength="100" required>
      <br>
      <label for="description">Description</label>
      <textarea id="description" name="page_description" rows="4" cols="50" maxlength="255"><?php echo html_escape($page_description); ?></textarea>
      <br>
      <label for="keywords">Keywords</label>
      <textarea id="keywords" name="page_keywords" rows="4" cols="50" maxlength="255"><?php echo html_escape($page_keywords); ?></textarea>
      <br>
      <?php
        $counter = 0;
        $length = count($content_area);
        do 
        {
          if(!isset($content_area[$counter])) $content_area[$counter] = NULL;
          if(!isset($content_area_id[$counter])) $content_area_id[$counter] = NULL;
      ?>
        <label for="editor<?php echo $counter; ?>">Content area</label>
        <button name="delete_content" value="<?php echo $counter; ?>" class="link-button float-right">Delete content area</button>
        <br>
        <textarea class="ckeditor" id="editor<?php echo $counter; ?>" name="content_area[]" cols="80" rows="10"><?php echo $content_area[$counter]; ?></textarea>
        <?php if($edit) { ?>
          <input type="hidden" class="hidden" name="content_area_id[]" value="<?php echo $content_area_id[$counter]; ?>">
        <?php } ?>
        <br>
      <?php
          $counter++;
        } 
        while ($counter < $length);
      ?>
      <button name="add_content" class="link-button float-right">Add content area</button>
      <br>
      <input type="submit" name="submit" value="<?php echo $action; ?>">
    <?php echo form_close(); ?>
  </div>
</section><!--#main-content-admin-->

<script src="<?php echo base_url(); ?>ckeditor/ckeditor.js"></script>