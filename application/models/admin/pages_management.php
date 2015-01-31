<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pages_management extends CI_Model {

  public function __construct()
  {
    $this->load->database();
  }

  public function get_all_pages()
  {
    $this->db->select('id, page_name');
    $this->db->from('pages');
    $this->db->order_by("id", "asc"); 
    $query = $this->db->get();

    if($query->num_rows() > 0)
    {
      return $query->result_array();
    }
    return false;
  }

  public function get_page($page_id = NULL)
  {
    if($page_id)
    {
      $this->db->select('pages.id, page_name, page_title, page_description, page_keywords');
      $this->db->from('pages');
      $this->db->where('pages.id', $page_id);
      $this->db->limit(1);

      $query = $this->db->get();

      if($query->num_rows() == 1)
      {
        return $query->row_array();
      }
      return false;
    }
  }

  public function get_page_content($page_id = NULL)
  {
    if($page_id)
    {
      $this->db->select('id, content');
      $this->db->from('page_content');
      $this->db->where('page_id', $page_id);
      $this->db->order_by("id", "asc"); 

      $query = $this->db->get();

      if($query->num_rows() > 0)
      {
        return $query->result_array();
      }
      return false;
    }
  }

  public function add_page($page_id, $page_name, $page_title, $page_description, $page_keywords, $page_content, $content_area_id)
  {
    $page_data = array(
      'page_name'        => $page_name,
      'page_title'       => $page_title,
      'page_description' => $page_description,
      'page_keywords'    => $page_keywords
    );
    $content_data = [];

    if($page_id)
    {
      $this->db->where('id', $page_id);
      $this->db->update('pages', $page_data);

      $counter = 0;
      foreach ($page_content as $content) {
        if($content_area_id[$counter])
        {
          $content_data = array('content' => $content);
          $this->db->where('id', intval($content_area_id[$counter]));
          $this->db->update('page_content', $content_data);
        }
        else
        {
          $content_data = array('page_id' => $page_id, 'content' => $content);
          $this->db->insert('page_content', $content_data);
        }
        $counter++;
      }
      return $page_id;
    }
    else
    {
      if($this->db->insert('pages', $page_data))
      {
        $inserted_page_id = $this->db->insert_id();
        $counter = 0;
        foreach ($page_content as $content) {
          $content_data[$counter]['page_id'] = $inserted_page_id;
          $content_data[$counter]['content'] = $content;
          $counter++;
        }
        $this->db->insert_batch('page_content', $content_data);
        return $inserted_page_id;
      }
    }
  }

  public function delete_page($page_id)
  {
    return $this->db->delete('pages', array('id' => $page_id)); 
  }

  public function delete_content_area($id)
  {
    return $this->db->delete('page_content', array('id' => $id)); 
  }

  public function is_unique($str, $table, $field, $id)
  {
    $this->db->select('id');
    $this->db->where($field, $str);
    if($id) $this->db->where('id !=', $id);
    $query = $this->db->get($table);

    return $query->num_rows() === 0;
  }
}