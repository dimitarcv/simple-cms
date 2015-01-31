<section id="main-content">
  <h1><?php echo $title; ?></h1>

  <?php
  $tmpl = array ('table_open' => '<table>');
  $this->table->set_template($tmpl); 
  $this->table->set_heading('ID', 'Username', 'Action');

  if($users)
  {
    foreach ($users as $user) {
      $link_delete = '<a href="'.base_url().'admin/users/delete/'.$user['id'].'">Delete</a>';
      $this->table->add_row(array($user['id'], html_escape($user['username']), $link_delete));
    }
  }
  else
  {
    echo "No users";
  }

  echo $this->table->generate();
  ?>

  <a href="<?php echo base_url(); ?>admin/users/add">Add user</a>

</section><!--#main-content-admin-->