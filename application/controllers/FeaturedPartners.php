<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class FeaturedPartners extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
    }
public function featured_partners()
{
$this->load->view('featuredpartners/featured_partners');
}
}