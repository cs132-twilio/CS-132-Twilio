<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
  function __construct(){
    parent::__construct();

    $this->load->helper('url');
    $this->load->library('tank_auth');
    $this->load->helper('form');
  }
  function _checkauth(){
    if ($this->tank_auth->is_logged_in()){
      $data['user_id'] = $this->tank_auth->get_user_id();
      $data['username'] = $this->tank_auth->get_username();
    }
    return $data;
  }
  
  function ajax($view){
    $this->load->view($view, $data);
  }
  function render($view){
    $data = $this->_checkauth();
    $data['page'] = $view;
    $this->load->view('header', $data);
    $this->load->view($view, $data);
    $this->load->view('footer', $data);
  }
  function index(){
    $this->render('home');
  }
}