<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class CmsPages extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
       $this->load->model("CMS_model");
    }
public function show_cmsservice()
{
	$_POST = json_decode(file_get_contents('php://input'), true);
	  $returnArray=$this->CMS_model->getviewCMS($_POST['searchfield'],$_POST['page_no']);
      $maniarray1=$returnArray['result'];
      $dataArray['pdata']=$_POST ;  
      $dataArray['result']=$maniarray1;   
      $dataArray['count']=$returnArray['count'];
	 echo json_encode($dataArray); 	


}


 public function geteditCMSData()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['id'];
		
		$returnArray=$this->CMS_model->GetCMS_edit($table_id);
	
		 echo json_encode($returnArray);
	}

	public function CMS_update()
	{
		    $_POST = json_decode(file_get_contents('php://input'), true);
		    $dataArray=$_POST['custdata'];
			$id = $dataArray['id'];
			if(!empty($dataArray['image_con']))
			{
			//==========================imageupload===========//

		    $base64string = $dataArray['image_con'];
            $save_Path='assets/images/';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$imgpath2 = $save_Path.time(). '.png';
            file_put_contents($imgpath2, $image_base64);
			
			
			
			$editcmsArray=array('heading'=>$dataArray['heading'],'heading_ar'=>$dataArray['heading_ar'],'content'=>$dataArray['content'],'content_ar'=>$dataArray['content_ar'],'image_con'=>$imgpath2);
		   $res_data=$this->CMS_model->addUpdate($editcmsArray,$id); 
			
			$return= true;
			}
		  else  
			{
			$return= false;
			}
		   // echo json_encode($return);  
		
		 
		 echo json_encode($return);
	}


	


}