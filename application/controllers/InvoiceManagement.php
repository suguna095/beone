<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class InvoiceManagement extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
    }
public function invoice_management()
{
$this->load->view('invoicemanagement/invoice_management');
}
public function cod_report()
{
$this->load->view('invoicemanagement/cod_report');
}
}