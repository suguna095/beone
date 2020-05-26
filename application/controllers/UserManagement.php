<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class UserManagement extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	   $this->load->model("UserManagement_model");
    }



  public function showUserListData()
  {
	   $return_array=$this->UserManagement_model->getuserlist();
	   echo json_encode($return_array);
  }
}