<?php

header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age:86400');
         header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token,  Accept, Authorization, X-Requested-With');
defined('BASEPATH') OR exit('No direct script access allowed');
Class News extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	   $this->load->model("News_model");
    }
/*public function add_news()
{
$this->load->view('news/add_news');
}*/
/*public function show_news()
{
$this->load->view('news/show_news');
}*/


    public function add_news()
	{
		    $_POST = json_decode(file_get_contents('php://input'), true);
		    $dataArray=$_POST['news'];
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
			$addArray=array('heading'=>$dataArray['heading'],'heading_ar'=>$dataArray['heading_ar'],'content'=>$dataArray['content_e'],'content_ar'=>$dataArray['content_ar'],'image_con'=>$imgpath);
		    $res_data=$this->News_model->add($addArray);
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
	public function Addform_update()
	{
		    $_POST = json_decode(file_get_contents('php://input'), true);
		    $dataArray=$_POST['news'];
			$image_con = $dataArray['image_con'];
			$editid = $dataArray['editid'];
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
			$imgpath=$image_con;
			$return= false;
			}
			$addArray=array('heading'=>$dataArray['heading'],'heading_ar'=>$dataArray['heading_ar'],'content'=>$dataArray['content'],'content_ar'=>$dataArray['content_ar'],'image_con'=>$imgpath);
		   $res_data=$this->News_model->addUpdate($addArray,$editid);
			
			//===============================================//
		
		 
		 echo json_encode($res_data);
	}
	
	
	public function Getlist()
	{
        $_POST = json_decode(file_get_contents('php://input'), true);
        
        $heading=$_POST['heading'];
        $content=$_POST['content'];
		
		 $returnArray=$this->News_model->Gettablelist($heading,$content);
		  echo json_encode($returnArray);
	}
	
	public function geteditshowData()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['editid'];
		
		$returnArray=$this->News_model->Gettablelist_edit($table_id);
	
		 echo json_encode($returnArray);
	}
}