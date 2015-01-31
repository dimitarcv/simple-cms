<section id="main-content">
  <h1><?php echo $title; ?></h1>
  
  <?php
  $tmpl = array ('table_open' => '<table>');
  $this->table->set_template($tmpl); 
  $this->table->set_heading('ID', 'Page', 'Action');

  if($pages){
    foreach ($pages as $page) {
      $link_edit = '<a href="'.base_url().'admin/pages/edit/'.$page['id'].'">Edit page</a>';
      $link_delete = '<a href="'.base_url().'admin/pages/delete/'.$page['id'].'">Delete</a>';
      $this->table->add_row(array($page['id'], $page['page_name'], $link_edit.' '.$link_delete));
    }
  }
  else
  {
    echo "No pages!";
  }

  echo $this->table->generate();
  ?>

  <a href="<?php echo base_url(); ?>admin/pages/add">Add page</a>

</section><!--#main-content-admin-->