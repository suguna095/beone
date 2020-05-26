<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 include_once APPPATH.'/third_party/phpqrcode/qrlib.php';
class QrcodeView {

	
	public function GetshowQrcode($slip_no)
	{
		  // outputs image directly into browser, as PNG stream 
         QRcode::png($slip_no);
	}
}	