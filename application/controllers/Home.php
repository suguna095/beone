<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if(empty($this->session->userdata('localSession')['A_ID']))
		{
			//  redirect('/account/login', 'refresh');
			if($this->uri->segment(1)!='')
			redirect(base_url(), 'refresh');
			
		}
		else
		{
			if($this->uri->segment(1)=='')
			redirect(base_url().'dashboard', 'refresh');
		}
		//print_r($this->session->userdata());
		$this->load->view('dashboard');
	}
}
