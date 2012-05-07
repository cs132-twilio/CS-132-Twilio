<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inbox extends CI_Controller {
  function __construct(){
    parent::__construct();
    $this->load->library('twilio');
    $this->load->helper('form');
  }

  function index($id = 0){
    $this->messages($id);
  }
  function count(){
    $uid = $this->tank_auth->get_user_id();
    if (!$uid) return;
    $r = $this->db->query('SELECT count(*) as n FROM inbox WHERE `to` = ? AND `read` = 0', array($uid))->result_array();
    echo $r[0]['n'];
  }
  function reply(){
    header('Content-type: application/json');
    if (!$this->tank_auth->is_logged_in()) exit(json_encode(array('success' => 0, 'message' => 'You must be logged in to send messages!')));
    if ($_SERVER['REQUEST_METHOD'] != 'POST') exit(json_encode(array('success' => 0, 'message' => 'Invalid Request!')));
    if (!$_POST['to'] || !$_POST['m']) exit(json_encode(array(array('success' => 0, 'message' => 'You must fill in all fields'))));
    if ($this->tank_auth->is_logged_in()){
      $uid = $this->tank_auth->get_user_id();
    }
    if (!$uid){
      exit(json_encode(array('success' => 0, 'message' => 'Your session has been timed out. Please refresh the page')));
    }
    $to = $this->db->query('SELECT number FROM classlist l, classmap m, students s WHERE s.id = ? AND m.student_id = s.id AND m.class_id = l.id AND l.owner_id = ?', array($_POST['to'], $uid))->result_array();
    $response = $this->twilio->sms('0000000000', $to[0]['number'], $_POST['m']);
    if($response->IsError){
      exit(json_encode(array('success' => 0, 'message' => $to . ': ' . $response->ErrorMessage)));
    } else {
      exit(json_encode(array('success' => 1, 'message' => 'Message succesfully sent to ' . $to[0]['number'])));
    }
  }
  function messages($id = 0){
    $this->checkauth->check();
    $uid = $this->tank_auth->get_user_id();
    if (!$uid){
      echo 'Your session has been timed out. Please refresh the page';
      return;
    }
    $data['messages'] = $this->db->query('SELECT i.id as id, s.name as `from`, i.`from` as fromid, message, timestamp, `read` FROM inbox i, students s WHERE `to` = ? AND s.id = i.`from`' . ($id?' AND i.id = ?':'') . ($_GET['unread']?' AND `read` = 0':'') . ' ORDER BY timestamp DESC', array($uid, $id))->result_array();
    if ($id){
      $this->db->query('UPDATE inbox SET `read` = 1 WHERE id = ?', array($id));
      $this->load->view('inbox/message.php', $data);
    }
    else $this->load->view('inbox/inbox.php', $data);
  }
  
  function send(){
    if ($_SERVER['REQUEST_METHOD'] != 'GET' || !$_GET['Body'] || !$_GET['From'] || !$_GET['To']){
      $this->load->view('twiml.php', array('message' => 'Invalid request!'));
      return;
    }
    $message = preg_split('/[\s]+/', $_GET['Body'], 2);
    if (count($message) != 2){
      $this->load->view('twiml.php', array('message' => 'Invalid request!'));
      return;
    }
    $this->db->query('INSERT INTO inbox (`from`, `to`, message, timestamp)
                     SELECT s.id as `from`, u.id as `to`, ? as message, NOW() as timestamp
                     FROM students s, users u, user_profiles p
                     WHERE s.number = ? AND u.id = p.user_id AND p.phone_number = ?',
                     array($message[1], $_GET['From'], $_GET['To']));
  }
}