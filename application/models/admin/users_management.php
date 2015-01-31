<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users_management extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }

  public function check_user($username, $password)
  {
    $this->db->select('id, username');
    $this->db->from('users');
    $this->db->where('username', $username);
    $this->db->where('password', sha1($password));
    $this->db->limit(1);

    $query = $this->db->get();
    if($query->num_rows() == 1)
    {
      return $query->row_array();
    }
    return false;
  }

  public function get_users()
  {
    $this->db->select('id, username');
    $this->db->from('users');
    $this->db->order_by("id", "asc"); 
    $query = $this->db->get();

    if($query->num_rows() > 0)
    {
      return $query->result_array();
    }
    return false;
  }

  public function add_user($username, $password)
  {
    $data = array(
     'username' => $username,
     'password' => sha1($password)
    );

    return $this->db->insert('users', $data); 
  }

  public function delete_user($user_id)
  {
    return $this->db->delete('users', array('id' => $user_id)); 
  }

}