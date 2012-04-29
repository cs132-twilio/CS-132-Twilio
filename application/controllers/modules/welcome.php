<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
  function __construct(){
    parent::__construct();
    $this->load->helper('url');
  }
  function index(){
    redirect('/');
  }
}