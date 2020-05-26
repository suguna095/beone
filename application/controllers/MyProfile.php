<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class MyProfile extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
    }
public function my_profile()
{
$this->load->view('my_profile');
}
}