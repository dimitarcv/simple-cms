<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session_php extends CI_Hooks{

  public function start_session_php()
  {
    if(session_id() == '')
    {
      session_start();
    }
  }
}