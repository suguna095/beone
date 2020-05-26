<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	function __construct() {
        parent::__construct(); 
		  if ($this->session->userdata('A_ID')== null || $this->session->userdata('A_ID')< 1) {
            // Prevent infinite loop by checking that this isn't the login controller               
            if ($this->router->class != 'Login') 
            {                        
              //  redirect(base_url());
            }
        }   
      
    }
	public function index()
	{
		$this->load->view('dashboard');   
	}
}
