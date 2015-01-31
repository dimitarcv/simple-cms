<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('loggedin');
    if(!loggedin()) redirect('admin/login', 'refresh');

    $this->load->model('admin/pages_management');
  }

  public function index()
  {
    $this->load->library('table');
    $data['pages']            = $this->pages_management->get_all_pages();
    $data['title']            = "Pages list";
    $data['error']['state']   = $this->session->flashdata('state');
    $data['error']['message'] = $this->session->flashdata('message');

    $this->load->view('admin/templates/header', $data);
    $this->load->view('admin/templates/messages', $data);
    $this->load->view('admin/templates/sidebar');
    $this->load->view('admin/pages-list', $data);
    $this->load->view('admin/templates/footer');
  }

  public function add($action = null)
  {
    $this->load->library('form_validation');
    $data['title']             = "Add page";
    $data['edit']              = NULL;
    $data['page_id']           = NULL;
    $data['page_name']         = $this->input->post('page_name');
    $data['page_title']        = $this->input->post('page_title');
    $data['page_description']  = $this->input->post('page_description');
    $data['page_keywords']     = $this->input->post('page_keywords');
    $data['content_area']      = $this->input->post('content_area');
    $data['content_area_id']   = $this->input->post('content_area_id');

    if(isset($_POST['add_content']))
    {
      $data['content_area'][]    = NULL;
      $data['content_area_id'][] = NULL;
    }
    elseif(isset($_POST['delete_content']))
    {
      $content_area_num = $this->input->post('delete_content');
      unset($data['content_area'][$content_area_num]);
      unset($data['content_area_id'][$content_area_num]);
    }
    else
    {
      $this->_verify($data);
    }

    $this->load->view('admin/templates/header', $data);
    $this->load->view('admin/templates/messages', $data);
    $this->load->view('admin/templates/sidebar');
    $this->load->view('admin/add-page', $data);
    $this->load->view('admin/templates/footer');
  }

  public function edit($page_id = NULL)
  {
    $data['error']['state']   = $this->session->flashdata('state');
    $data['error']['message'] = $this->session->flashdata('message');

    if(is_numeric($page_id))
    {
      $this->load->library('form_validation');
      $data['title']             = "Edit page";
      $data['edit']              = true;
      $data['page_id']           = $page_id;
      $data['page_name']         = $this->input->post('page_name');
      $data['page_title']        = $this->input->post('page_title');
      $data['page_description']  = $this->input->post('page_description');
      $data['page_keywords']     = $this->input->post('page_keywords');
      $data['content_area']      = $this->input->post('content_area');
      $data['content_area_id']   = $this->input->post('content_area_id');

      if($this->input->post('page_id'))
      {
        if(isset($_POST['add_content']))
        {
          $data['content_area'][]    = NULL;
          $data['content_area_id'][] = NULL;
        }
        elseif(isset($_POST['delete_content']))
        {
          $content_area_num = $this->input->post('delete_content');
          if($data['content_area_id'][$content_area_num])
          {
            $this->pages_management->delete_content_area($data['content_area_id'][$content_area_num]);
          }
          unset($data['content_area'][$content_area_num]);
          unset($data['content_area_id'][$content_area_num]);
        }
        else
        {
          $this->_verify($data);
        }
      }
      else
      {
        $result = $this->pages_management->get_page($page_id);
        $data['page_id']          = $result['id'];
        $data['page_name']        = $result['page_name'];
        $data['page_title']       = $result['page_title'];
        $data['page_description'] = $result['page_description'];
        $data['page_keywords']    = $result['page_keywords'];

        $result = $this->pages_management->get_page_content($page_id);
        foreach ($result as $row) {
          $data['content_area_id'][] = $row['id'];
          $data['content_area'][]    = $row['content'];
        }
      }

      $this->load->view('admin/templates/header', $data);
      $this->load->view('admin/templates/messages', $data);
      $this->load->view('admin/templates/sidebar');
      $this->load->view('admin/add-page', $data);
      $this->load->view('admin/templates/footer');
    }
    else
    {
      show_404();
    } 
  }

  private function _verify(&$data)
  {
    $data['page_id'] = intval($this->input->post('page_id'));

    if($data['page_id'])
    {
      $this->form_validation->set_rules('page_name', 'Page name', 'trim|required|max_length[50]|xss_clean|callback_unique[pages.page_name.'.$data['page_id'].']');
    }
    else
    {
      $this->form_validation->set_rules('page_name', 'Page name', 'trim|required|max_length[50]|xss_clean|is_unique[pages.page_name]');
    }
    $this->form_validation->set_rules('page_title', 'Page title', 'trim|required|max_length[100]|xss_clean');
    $this->form_validation->set_rules('page_description', 'Page description', 'trim|max_length[255]|xss_clean');
    $this->form_validation->set_rules('page_keywords', 'Page keywords', 'trim|max_length[255]|xss_clean');
    $this->form_validation->set_rules('content_area[]', 'Content area', 'trim');

    if($this->form_validation->run() == true)
    {
      $page_id          = $data['page_id'];
      $page_name        = url_title(strip_tags($this->input->post('page_name',true)));
      $page_title       = $this->input->post('page_title',true);
      $page_description = $this->input->post('page_description',true);
      $page_keywords    = $this->input->post('page_keywords',true);
      $content_area     = $this->input->post('content_area');
      $content_area_id  = $this->input->post('content_area_id');

      $page = $this->pages_management->add_page($page_id, $page_name, $page_title, $page_description, $page_keywords, $content_area, $content_area_id);
      if($page)
      {
        $this->session->set_flashdata('state', 'success');
        $this->session->set_flashdata('message', 'The operation was successful');
        redirect('admin/pages/edit/'.$page, 'refresh');
      }
      $data['error']['state']   = 'error';
      $data['error']['message'] = 'The error appears when inserting';
    }

    $data['page_name']        = set_value('page_name');
    $data['page_title']       = set_value('page_title');
    $data['page_description'] = set_value('page_description');
    $data['page_keywords']    = set_value('page_keywords');
    $data['content_area']     = $this->input->post('content_area');
    $data['content_area_id']  = $this->input->post('content_area_id');
  }

  public function delete($page_id = null)
  {
    if(is_numeric($page_id))
    {
      if($this->pages_management->delete_page($page_id))
      {
        $this->session->set_flashdata('state', 'success');
        $this->session->set_flashdata('message', 'Deleted');
        redirect('admin/pages/', 'refresh');
      }
      $this->session->set_flashdata('state', 'error');
      $this->session->set_flashdata('message', 'The page was not deleted');
      redirect('admin/pages/', 'refresh');
    }
    show_404();
  }

  public function unique($str, $field)
  {
      list($table, $field, $id) = explode('.', $field);
      $result = $this->pages_management->is_unique($str, $table, $field, $id);
      return $result;
  }

}