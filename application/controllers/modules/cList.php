<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class cList extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function index($c)
	{
    if (!(intval($c) > 0)){
      echo "Invalid class id";
      return;
    }
    $data['class_id'] = $c;
		$r = $this->db->query('SELECT m.student_id, s.id, s.name, s.number FROM classmap m, students s WHERE m.student_id = s.id AND class_id=?', array($c));
    $data['students'] = $r->result_array();
    $this->load->view('modules/list.php', $data);
	}
}