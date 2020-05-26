<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class PaymentDetails extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
    }
public function payment_details()
{
$this->load->view('paymentdetails/payment_details');
}
}