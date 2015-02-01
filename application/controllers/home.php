<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('pages');
    $this->load->library('form_validation');
  }

  public function index($page = NULL)
  {
    $result = $this->pages->get_all_pages();
    
    if($result)
    {
      $data['pages'] = $result;
    }

    if($page)
    {
      $result = $this->pages->get_page($page);  
    }
    else
    {
      $result = $this->pages->get_first();
    }
    if($result)
    {
      $data['page_title'] = $result['page_title'];
      $data['page_description'] = $result['page_description'];
      $data['page_keywords'] = $result['page_keywords'];
      $data['content'] = $result['content'];
    }
    else
    {
      show_404();
    }

    $this->load->view('front/templates/header', $data);
    $this->load->view('front/pages', $data);
    $this->load->view('front/templates/footer', $data);
  }

  public function search()
  {
    $search = $_REQUEST['search'];
    if($search)
    {
      $this->load->helper('text');

      $result = $this->pages->get_all_pages();
    
      if($result)
      {
        $data['pages'] = $result;
      }
      
      $data['page_title'] = 'Search';
      $data['page_description'] = 'Search';
      $data['page_keywords'] = 'Search';
      $data['search'] = $search;
      $data['search_results'] = $this->pages->find_page($search);

      $this->load->view('front/templates/header', $data);
      $this->load->view('front/search-result', $data);
      $this->load->view('front/templates/footer', $data);
    }
    else
    {
      show_404();
    }
  }

}