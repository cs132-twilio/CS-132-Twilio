<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stream extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
    $this->load->library('twilio');
    $this->load->library('tank_auth');
    $this->load->helper('url');
	}

	function index($c, $s = null)
	{
    $this->checkauth->check('/modules/stream/index/' . $c . ($s?'/'.$s:''));
    $this->session->sess_update();
    $uid = $this->tank_auth->get_user_id();
    $data['sel'] = $s;
    $data['stream'] = $this->db->query('SELECT str.id as id, str.name as name FROM classlist l, streams str WHERE class_id = ? AND l.id = class_id AND l.owner_id = ?', array($c, $uid))->result_array();
		$this->load->view('/modules/stream.php', $data);
	}

  function post(){
    if ($_SERVER['REQUEST_METHOD'] != 'GET' || !$_GET['Body'] || !$_GET['From'] || !$_GET['To']){
      $this->load->view('twiml.php', array('message' => 'Invalid request!'));
      return;
    }
    $message = preg_split('/[\s]+/', $_GET['Body'], 3);
    if (count($message) != 3){
      $this->load->view('twiml.php', array('message' => 'Invalid request!'));
      return;
    }
    $id = intval($message[1]);
    if ($id <= 0 || $message[2] === '' || $message[2] === null || $message[2] === false){
      $this->load->view('twiml.php', array('message' => 'Invalid thread!'));
      return;
    }
    $this->db->query('INSERT INTO stream_posts (thread, student_id, message, `timestamp`)
                      SELECT ? as thread, s.id as student_id, ? as message,
                      NOW() as `timestamp` FROM streams str, classmap m, students s
                      WHERE number = ? AND str.class_id = m.class_id AND
                      s.id = m.student_id AND ? = str.id',
                      array($id, $message[2], $_GET['From'], $id));
  }
  
  function poll($thread){
    header('Content-type: application/json');
    if (!$this->tank_auth->is_logged_in()){
      exit(
        json_encode(
          array(
            'success' => 0,
            'username' => '<span class="stream_error_title">Twexter System Message</span>',
            'message' => 'You must be <a onclick="Twexter.ajax_load(\'/auth/login?u=/dashboard%23c=\' + Twexter.dashboard.getClass() + \'%26m=stream%26m_args=/' . $thread . '\', \'moduleContent\');">logged in</a> to read messages!',
            'execute' => 'clearInterval(Twexter.modules.Stream.loop); Twexter.modules.Stream.loop = null;'
          )
        )
      );
    }
    $r = $this->db->query('SELECT student_id, name, message, unix_timestamp(timestamp)
                           AS timestamp FROM stream_posts, students s WHERE s.id = student_id
                           AND thread = ? AND unix_timestamp(timestamp) > ?',
                           array($thread, $_SERVER['QUERY_STRING']))->result_array();
    foreach($r as &$s){
      $s['name'] = htmlentities($s['name']);
      $s['message'] = htmlentities($s['message']);
    }
    echo json_encode($r);
  }
}