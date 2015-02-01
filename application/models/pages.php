<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pages extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }

  public function get_all_pages()
  {
    $this->db->select('page_name, page_title');
    $this->db->from('pages');
    $this->db->order_by("id", "asc"); 
    $query = $this->db->get();

    if($query->num_rows() > 0)
    {
      return $query->result_array();
    }
    return false;
  }

  public function get_page($page)
  {
    $this->db->select('id, page_title, page_description, page_keywords');
    $this->db->from('pages');
    $this->db->where('page_name', $page);
    $this->db->limit(1);

    $query = $this->db->get();
    if($query->num_rows() == 1)
    {
      $result = $query->row_array();
      
      $result['content'] = $this->get_content($result['id']);

      return $result;
    }
    return false;
  }

  public function get_first()
  {
    $this->db->select('id, page_title, page_description, page_keywords');
    $this->db->from('pages');
    $this->db->order_by("id", "asc"); 
    $this->db->limit(1);

    $query = $this->db->get();
    if($query->num_rows() == 1)
    {
      $result = $query->row_array();

      $result['content'] = $this->get_content($result['id']);

      return $result;
    }
    return false;
  }

  public function get_content($page)
  {
    $this->db->select('content');
    $this->db->from('page_content');
    $this->db->where('page_id', $page);
    $query = $this->db->get();
    if($query->num_rows() > 0)
    {
      $result = $query->result_array();
      foreach($result as $row)
      {
        $content[] = $row['content'];
      }
      return $content;
    }
    return false;
  }

  public function find_page($search)
  {
    $this->db->select("p.page_name, p.page_title, c.contents");
    $this->db->from('pages p');
    $this->db->join('(SELECT s.page_id, GROUP_CONCAT(s.content) AS contents FROM page_content s 
         GROUP BY s.page_id) c', 'c.page_id = p.id');
    $this->db->like('c.contents', $search);

    $query = $this->db->get();
    if($query->num_rows() > 0)
    {
      return $query->result_array();
    }
    return false;
  }

}