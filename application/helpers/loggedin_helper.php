<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('loggedin'))
{
  function loggedin()
  {
    if(session_id() == '')
    {
      session_start();
    }
    if(isset($_SESSION['user_id']) && isset($_SESSION['username']))
    {
      return true;
    }
    return false;
  }
}
