<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
    $this->load->library('tank_auth');
    $this->load->library('twilio');
	}

	function targets(){
    header('Content-type: application/json');
    if ($this->tank_auth->is_logged_in()){
      $uid = $this->tank_auth->get_user_id();
      echo json_encode($this->db->query(
        'SELECT CONCAT("c", id) as id, name FROM classlist WHERE owner_id = ?
        UNION SELECT number as id,
        CONCAT(s.name, " (Student in ", GROUP_CONCAT(l.name), ")") as name
        FROM classlist l, classmap m, students s WHERE m.student_id = s.id
        AND m.class_id = l.id AND owner_id = ? GROUP BY s.id',
        array($uid, $uid))->result_array()
      );
    } else {
      echo '[{name: "Your session has been timed out. Please refresh the page"}]';
    }
	}
  
  function _send($to, $m){
    $response = $this->twilio->sms('0000000000', $to, $m);
    if($response->IsError){
      return array('success' => 0, 'message' => $to . ': ' . $response->ErrorMessage);
    } else {
      return array('success' => 1, 'message' => 'Message succesfully sent to ' . $to);
    }
  }
  
  function send(){
    header('Content-type: application/json');
    if (!$this->tank_auth->is_logged_in()) exit(json_encode(array('success' => 0, 'message' => 'You must be logged in to send messages!')));
    if ($_SERVER['REQUEST_METHOD'] != 'POST') exit(json_encode(array('success' => 0, 'message' => 'Invalid Request!')));
    if (!$_POST['n'] || !$_POST['m']) exit(json_encode(array('success' => 0, 'messsage' => 'You must fill in all fields')));
    if ($this->tank_auth->is_logged_in()){
      $uid = $this->tank_auth->get_user_id();
    }
    if (!$uid){
      return array('success' => 0, 'message' => 'Your session has been timed out. Please refresh the page');
    }
    $targets = explode(',', $_POST['n']);
    $r = array();
    foreach ($targets as $t){
      $t = strtolower(trim($t));
      if ($t[0] == 'c' && substr($t, 1)){
        $list = $this->db->query('SELECT DISTINCT number FROM classlist l, classmap m, students s WHERE m.class_id = ? AND m.student_id = s.id AND owner_id = ? AND m.class_id = l.id', array(substr($t, 1), $uid))->result_array();
        foreach ($list as $l){
          $r[] = $this->_send($l['number'], $_POST['m']);
        }
      } else {
        $r[] = $this->_send($t, $_POST['m']);
      }
    }
    echo json_encode($r);
  }
}