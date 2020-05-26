<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Login extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	   $this->load->helper(array('form', 'url'));
    }
public function index()
{
	$this->load->model("Login_model");
     $_POST = json_decode(file_get_contents('php://input'), true);
 
      
	  $username=$_POST['username'];
	  $password=$_POST['password'];
	 
         $res_data=$this->Login_model->GetauthCheck($_POST);
		 if($res_data==false)
		 {
			 $returnarray=array('error'=>'please enter valid username or password');
		 }
		 else
		 {
			 $returnarray=array('status'=>'success','udata'=>$res_data);	
		 }
	 
		
 echo json_encode($returnarray);
 
}

  public function getsession()
  {
	 // $Array['localSession'] = array('A_USERNAME'=>"",'A_ID'=>"",'A_EMAIL'=>"");
			///$this->session->set_userdata($Array);
	
	  if(!empty($this->session->userdata('localSession')))
	  $returnarray=array('status'=>"success",'checklogin'=>$this->session->userdata('localSession'));
	  else
	   $returnarray=array('status'=>"error",'checklogin'=>"");
	  
	   echo json_encode($returnarray);
  }
  
   public function destorylogin()
  {
	  $Array['localSession'] = array('A_USERNAME'=>"",'A_ID'=>"",'A_EMAIL'=>"");
	  $this->session->set_userdata($Array);
	   $returnarray=array('status'=>"error");
	  
	   echo json_encode($returnarray);
  }
}