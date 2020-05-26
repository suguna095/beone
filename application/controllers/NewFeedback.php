<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class NewFeedback extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
       $this->load->model('NewFeedback_model');
    }

	public function showFeedbacklist()
	    {
			$_POST = json_decode(file_get_contents('php://input'), true);
		    $returnArray=$this->NewFeedback_model->getShowFeedbacklist($_POST); 
			$maniarray=$returnArray['result'];
			 $dataArray['pdata']=$_POST ;  
	        $dataArray['result']=$maniarray;   
	        $dataArray['count']=$returnArray['count'];
			echo json_encode($dataArray);
	    }
}