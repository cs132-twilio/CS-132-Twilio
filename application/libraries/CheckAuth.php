<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class CheckAuth extends Tank_Auth {
  public function __construct(){
    $this->_ci =& get_instance();
  }
  public function check($url = ''){
    if ($url === '') $url = $_SERVER['REQUEST_URI'] . '?' . $_SERVER['QUERY_STRING'];
    $uid = $this->_ci->tank_auth->get_user_id();
    if (!$uid){
      redirect('/auth/login?u=' . $url);
      return;
    }
  }
}
?>