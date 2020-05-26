<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class BannerManagement extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	   $this->load->model('BannerManagement_model');
    }
public function showBannerlist()
    {
		 $_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->BannerManagement_model->getShowbanner(); 
		$maniarray=$returnArray['result'];
       $dataArray['result']=$maniarray;   
         $dataArray['count']=$returnArray['count'];
		 echo json_encode($returnArray);
    }
	
	 public function add_bannerList()
	{
		    $_POST = json_decode(file_get_contents('php://input'), true);
		    $dataArray=$_POST['add_banner'];
			//alert($dataArray1);
			if(!empty($dataArray['image']))
			{
			//==========================imageupload===========//
		    $base64string = $dataArray1['image'];
            $save_Path='assets/images/';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$imgpath = $save_Path.time(). '.png';
			file_put_contents($imgpath, $image_base64);
			$bannerArray=array('title'=>$dataArray['title'],'url'=>$dataArray['url'],'description'=>$dataArray['description'],'image_path'=>$imgpath);
		    $res_data=$this->BannerManagement_model->insertbanner($bannerArray);
			$return= true;
			}
			else
			{
			$img_path="";
			$return= false;
			}
			
			
			//===============================================//
		
		 
		 echo json_encode($res_data);
	}
	
	public function Banner_update()
	{
		    $_POST = json_decode(file_get_contents('php://input'), true);
		    $dataArray=$_POST['edit_banner'];
			$image_path = $dataArray['image_path'];
			$banid = $dataArray['banid'];
			if(!empty($dataArray['image']))
			{
			//==========================imageupload===========//
		    $base64string = $dataArray['image']; 
			
            $save_Path='assets/images/';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$imgpath = $save_Path.time(). '.png';
			file_put_contents($imgpath, $image_base64); 
			
			$return= true;
			}
			else
			{
			$imgpath=$image_path;
			$return= false;
			}
			$editbannerArray=array('title'=>$dataArray['title'],'url'=>$dataArray['url'],'description'=>$dataArray['description'],'image_path'=>$imgpath);
		   $res_data=$this->BannerManagement_model->editBannerUpdate($editbannerArray,$banid);
			
			//===============================================//
		
		 
		 echo json_encode($res_data);
	}
	
	public function geteditbannerData()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['banid'];
		
		$returnArray=$this->BannerManagement_model->Getbannerlist_edit($table_id); 
	
		 echo json_encode($returnArray);
	}
}