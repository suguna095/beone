<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class CouponManagement extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
    }
public function new_coupon()
{
$this->load->view('couponmanagement/new_coupon');
}
public function valid_coupon()
{
$this->load->view('couponmanagement/valid_coupon');
}
public function expire_coupon()
{
$this->load->view('couponmanagement/expire_coupon');
}
}