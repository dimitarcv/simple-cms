<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('pages');
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

}