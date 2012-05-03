<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class cList extends CI_Controller{
  function __construct(){
    parent::__construct();
  }

  function index($c){
    $this->checkauth->check();
    if (!(intval($c) > 0)){
      echo "Invalid class id";
      return;
    }
    $this->session->sess_update();
    $data['class_id'] = $c;
    $r = $this->db->query('SELECT m.student_id, s.id, s.name, s.number FROM classmap m, students s WHERE m.student_id = s.id AND class_id=?', array($c));
    $data['students'] = $r->result_array();
    $this->load->view('modules/list.php', $data);
  }

  function delete($cid, $sid){
    header('Content-type: application/json');
    $uid = $this->tank_auth->get_user_id();
    if (!$uid){
      return array('success' => 0, 'message' => 'Your session has been timed out. Please refresh the page');
    }
    try{
      $this->db->query('DELETE FROM classmap WHERE EXISTS (SELECT classmap.student_id FROM classlist l WHERE l.id = classmap.class_id AND classmap.class_id = ? AND classmap.student_id = ? AND l.owner_id = ?)', array($cid, $sid, $uid));
    } catch(PDOException $e) {
      echo json_encode(array('success' => 0, 'message' => 'An error occured: ' . $e->getMessage()));
      return;
    }
    echo json_encode(array('success' => 1));
    return;
  }
}