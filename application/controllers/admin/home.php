<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('admin/users_management');
  }

  public function index()
  {
    $this->load->helper('loggedin');
    if(!loggedin()) redirect('admin/home/login', 'refresh');

    $data['title'] = "Home";

    $this->load->view('admin/templates/header', $data);
    $this->load->view('admin/templates/sidebar');
    $this->load->view('admin/home');
    $this->load->view('admin/templates/footer');
  }

  public function login()
  {
    $this->load->helper('loggedin');
    if(loggedin()) redirect('admin/home/', 'refresh');

    $this->load->helper('form');
    $this->load->library('form_validation');

    $data['title'] = "Log in";
    $this->_verify();

    $this->load->view('admin/templates/header', $data);
    $this->load->view('admin/login');
    $this->load->view('admin/templates/footer');
  }
  public function logout()
  {
    session_unset();
    session_destroy();

    redirect('admin/home/login', 'refresh');
  }

  private function _verify()
  {
    $this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[50]|xss_clean');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[50]|xss_clean|callback_check_login');

    if($this->form_validation->run() == true)
    {
      redirect('admin/home/', 'refresh');
    }
  }

  public function check_login($password)
  {
    $username = $this->input->post('username');
    $result   = $this->users_management->check_user($username, $password);
    
    if($result)
    {
      $_SESSION['user_id'] = $result['id'];
      $_SESSION['username'] = $result['username'];
      return true;
    }
    else
    {
      $this->form_validation->set_message('check_login', 'Invalid username or password');
      return false;
    }
  }

}