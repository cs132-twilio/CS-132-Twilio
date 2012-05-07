<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inbox extends CI_Controller {
  function __construct(){
    parent::__construct();
    $this->load->helper('form');
  }

  function index($id = 0){
    $this->messages($id);
  }
  function messages($id = 0){
    $this->checkauth->check();
    $uid = $this->tank_auth->get_user_id();
    if (!$uid){
      echo 'Your session has been timed out. Please refresh the page';
      return;
    }
    $data['messages'] = $this->db->query('SELECT i.id as id, s.name as `from`, message, timestamp, `read` FROM inbox i, students s WHERE `to` = ? AND s.id = i.`from`' . ($id?' AND i.id = ?':'') . ' ORDER BY timestamp DESC', array($uid, $id))->result_array();
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