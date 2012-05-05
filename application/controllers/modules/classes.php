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
      $this->load->view('modules/classes.php', $data);
    }
    else redirect('/auth/login');
  }
  
  
  
  function add(){
    header('Content-type: application/json');
    if (!$this->tank_auth->is_logged_in()) exit(json_encode(array('success' => 0, 'message' => 'You must be logged in to edit your classes!')));
    if ($_SERVER['REQUEST_METHOD'] != 'POST') exit(json_encode(array('success' => 0, 'message' => 'Invalid Request!')));
    //if (!$_POST['n'] || !$_POST['m']) exit(json_encode(array('success' => 0, 'messsage' => 'You must fill in all fields')));
    if ($this->tank_auth->is_logged_in()){
      $uid = $this->tank_auth->get_user_id();
    }
    if (!$uid){
      return array('success' => 0, 'message' => 'Your session has been timed out. Please refresh the page');
    }
    $targets = explode(',', $_POST['n']);
    $r = array();
    foreach ($targets as $t){
//       $t = strtolower(trim($t));
//       if ($t[0] == 'c' && substr($t, 1)){
//         $list = $this->db->query('SELECT DISTINCT number FROM classlist l, classmap m, students s WHERE m.class_id = ? AND m.student_id = s.id AND owner_id = ? AND m.class_id = l.id', array(substr($t, 1), $uid))->result_array();
//         foreach ($list as $l){
//           $r[] = $this->_send($l['number'], $_POST['m']);
//         }
//       } else {
//         $r[] = $this->_send($t, $_POST['m']);
//       }
//     }
//     echo json_encode($r);
  }
}

function delete($cid){
   header('Content-type: application/json');
   $uid = $this->tank_auth->get_user_id();
    if (!$uid){
      echo array('success' => 0, 'message' => 'Your session has been timed out. Please refresh the page');
      return;
    }
    try{
      $this->db->query('DELETE FROM classmap WHERE EXISTS (SELECT classmap.student_id FROM classlist l WHERE l.id = classmap.class_id AND classmap.class_id = ? AND classmap.student_id = ? AND l.owner_id = ?)', array($cid, $sid, $uid));
    } catch(PDOException $e) {
      echo json_encode(array('success' => 0, 'message' => 'An error occured: ' . $e->getMessage()));
      return;
    }
    echo json_encode(array('success' => 1));
  }

}