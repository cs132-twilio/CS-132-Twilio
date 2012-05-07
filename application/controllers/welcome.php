<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
  function __construct(){
    parent::__construct();

    $this->load->library('tank_auth');
    $this->load->library('session');
    $this->load->helper('form');
    $this->load->helper('url');
  }
  function _checkauth($data = array()){
    if ($this->tank_auth->is_logged_in()){
      $data['user_id'] = $this->tank_auth->get_user_id();
      $data['username'] = $this->tank_auth->get_username();
    }
    return $data;
  }
  
  function ajax($view){
    $this->load->view($view, $data);
  }
  function modules($view){
    $this->load->view('modules/' . $view, $data);
  }
  function render($view, $data = array()){
    $data = $this->_checkauth($data);
    $data['page'] = $view;
    $temp = ($this->db->query("SELECT phone_number FROM user_profiles WHERE user_id=?", array($data['user_id']))->result_array());
    $data['phone'] = $temp[0];
    $this->load->view('header', $data);
    $this->load->view($view, $data);
    $this->load->view('footer', $data);
  }
  function render_secure($view, $data=array(), $redirect = '/auth/login'){
    $this->session->sess_update();
    if ($this->tank_auth->is_logged_in()) $this->render($view, $data);
    else redirect($redirect);
  }
  
  function index(){
    $this->render('home');
  }

  function dashboard(){
    $data = $this->_checkauth($data);
    if ($data['user_id']){
      $data['classlist'] = $this->db->query('SELECT id, name FROM classlist WHERE owner_id = ?', array($data['user_id']))->result_array();
      $this->render_secure('dashboard', $data);
    }
    else redirect('/auth/login');
  }


  function profile(){
    $data = $this->_checkauth($data);
    if ($data['user_id']){    
	//get the phone
	$temp = ($this->db->query("SELECT phone_number FROM user_profiles WHERE user_id=?", array($data['user_id']))->result_array());	
	$data['phone'] = $temp[0];
	//get the email and the username
        $temp['users'] = $this->db->query('SELECT username, email FROM users WHERE id = ?', array($data['user_id']))->result_array();
	$data['username'] = htmlspecialchars($temp['users'][0]['username']);   
	$data['email'] = htmlspecialchars($temp['users'][0]['email']); 
      	$this->render_secure('profile', $data);
   }
    else redirect('/auth/login');
  }

}
