<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('loggedin');
    if(!loggedin()) redirect('admin/login', 'refresh');

    $this->load->model('admin/users_management');
  }

  public function index()
  {
    $this->load->library('table');
    $data['users']            = $this->users_management->get_users();
    $data['title']            = "Users list";
    $data['error']['state']   = $this->session->flashdata('state');
    $data['error']['message'] = $this->session->flashdata('message');

    $this->load->view('admin/templates/header', $data);
    $this->load->view('admin/templates/messages', $data);
    $this->load->view('admin/templates/sidebar');
    $this->load->view('admin/users-list', $data);
    $this->load->view('admin/templates/footer');
  }

  public function add(){
    $this->load->library('form_validation');
    $data['title'] = "Add user";

    $this->_verify($data);

    $this->load->view('admin/templates/header', $data);
    $this->load->view('admin/templates/messages', $data);
    $this->load->view('admin/templates/sidebar');
    $this->load->view('admin/add-user', $data);
    $this->load->view('admin/templates/footer');
  }

  private function _verify(&$data)
  {
    $this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[50]|xss_clean|is_unique[users.username]');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[50]|xss_clean');
    $this->form_validation->set_rules('reppassword', 'Repeated password', 'trim|required|max_length[50]|xss_clean|matches[password]');

    if($this->form_validation->run() == true)
    {
      $username = $this->input->post('username',true);
      $password = $this->input->post('password');
      if($this->users_management->add_user($username, $password))
      {
        $this->session->set_flashdata('state', 'success');
        $this->session->set_flashdata('message', 'Inserted');
        redirect('admin/users/', 'refresh');
      }
      $data['error']['state']   = 'error';
      $data['error']['message'] = 'The error appears when inserting';
    }
  }

  public function delete($user_id = null)
  {
    if(is_numeric($user_id))
    {
      if($user_id != $_SESSION['user_id'] && $this->users_management->delete_user($user_id))
      {
        $this->session->set_flashdata('state', 'success');
        $this->session->set_flashdata('message', 'Deleted');
        redirect('admin/users/', 'refresh');
      }
      $this->session->set_flashdata('state', 'error');
      $this->session->set_flashdata('message', 'The user was not deleted');
      redirect('admin/users/', 'refresh');
    }
    show_404();
  }

}