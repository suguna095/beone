<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  include_once APPPATH.'/third_party/phpqrcode/qrlib.php';
class Pro  {

    function show_hello_world()
  {
     // outputs image directly into browser, as PNG stream 
       return  QRcode::png($slip_no);
  }
}	