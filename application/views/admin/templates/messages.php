<?php 
  if(isset($error) && $error['state'] == 'success')
  { 
    echo '<div class="success">'.$error['message'].'</div>';
  }
  elseif(isset($error) && $error['state'] == 'error')
  {
    echo '<div class="error-mes">'.$error['message'].'</div>';
  }
?>