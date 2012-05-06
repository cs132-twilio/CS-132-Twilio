<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Classes extends CI_Controller
{
	function __construct(){
		parent::__construct();
		$this->load->library('tank_auth');
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('url');
	}

  function index(){
    $this->checkauth->check();
    $this->session->sess_update();
    $data['user_id'] = $this->tank_auth->get_user_id();;
    if ($data['user_id']){
      $data['classlist'] = $this->db->query('SELECT id, name FROM classlist WHERE owner_id = ?', array($data['user_id']))->result_array();
      $this->load->view('header', $data);
      $this->load->view('/classes.php', $data);
      $this->load->view('footer', $data);
    }
    else redirect('/auth/login');
  }
  
//add class  
  
  function add(){
   header('Content-type: application/json');
    if ($_SERVER['REQUEST_METHOD'] != 'POST') exit(json_encode(array('success' => 0, 'message' => 'Invalid Request!')));
    $owner_id = $this->tank_auth->get_user_id();
    if (!$owner_id){
      echo array('success' => 0, 'message' => 'Your session has been timed out. Please refresh the page');		//check if user logged in
      return;
    }
    //$this->form_validation->set_rules('new-class', 'trim|required|xss_clean');
    $class_name = $_POST['new-class'];
    //if ($this->form_validation->run() == FALSE){
     // echo json_encode(array('success' => 0, 'message' => 'Invalid Request!'));
    //}
    //else{
	try{
	  $this->db->query("INSERT INTO classlist (name, owner_id) VALUES (?, ?)", array( $class_name , $owner_id) );
	  $class_id = $this->db->insert_id();
	} catch(PDOException $e) {
	  echo json_encode(array('success' => 0, 'message' => 'An error occured: ' . $e->getMessage()));
	  return;
	}
	echo json_encode(array('success' => 1, 'class_id' => $class_id, 'name' => $class_name));
   // }
  }


// Delete a class from database

function delete(){
   header('Content-type: application/json');
    if ($_SERVER['REQUEST_METHOD'] != 'POST') exit(json_encode(array('success' => 0, 'message' => 'Invalid Request!')));
    $owner_id = $this->tank_auth->get_user_id();
    if (!$owner_id){
      echo array('success' => 0, 'message' => 'Your session has been timed out. Please refresh the page');		//check if user logged in
      return;
    }
    foreach ( $_POST as $key => $value )										//get all classes to be deleted into the post array
    {
	$classes[$this->input->post($key)] = $this->input->post($key);
    }
    foreach($classes as $class_id){
	try{
	  $this->db->query("DELETE FROM classmap WHERE classmap.class_id = ? AND classmap.class_id IN (SELECT classlist.id FROM classlist WHERE classlist.owner_id = ?)", array($class_id, $owner_id));
	  $this->db->query("DELETE FROM classlist WHERE owner_id = ? AND id = ?", array($owner_id, $class_id));
	} catch(PDOException $e) {
	  echo json_encode(array('success' => 0, 'message' => 'An error occured: ' . $e->getMessage()));
	  return;
	}
    }
    $post['success'] = 1;
    $post = array('success' => 1, $classes);
    echo json_encode($post);
  }
}