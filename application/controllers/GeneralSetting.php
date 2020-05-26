<?php

defined('BASEPATH') OR exit('No direct script access allowed');
Class GeneralSetting extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	   $this->load->model("GeneralSetting_model");
    }
    public function showUploadAppData()
    {
	    $return_array=$this->GeneralSetting_model->getuploadapp();
	   
	    echo json_encode($return_array);
    }
   
  
  public function upload_app()
	{
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataArray=$_POST['upload_app'];
		 if(!empty($dataArray['image']))
			{
			//==========================imageupload===========//
		    $base64string = $dataArray['image'];
            $save_Path='assets/images/';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$imgpath =  $save_Path.time(). '.png';
            file_put_contents($imgpath, $image_base64);
			
		    
			$return= true;
			}
			else
			{
			$img_path="";
			$return= false;
			}
			if(!empty($dataArray['image1']))
			{
			//==========================imageupload===========//
		    $base64string = $dataArray['image1'];
            $save_Path='assets/images/'; 
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image1/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$imgpath1 = time(). '.png';
            file_put_contents($imgpath1, $image_base64);
			$return= true;
			}
			else
			{
			$img_path="";
			$return= false;
			}
		    
			$upload_appArray=array("upload_path"=>$dataArray['upload_path'],'description'=>$dataArray['description'],'uplaod_app'=>$imgpath,'screen_shot'=>$imgpath1,'email'=>$dataArray['email']);
		    $res_data=$this->GeneralSetting_model->upload_app($upload_appArray);
		
			 echo json_encode($res_data);
	}
	
	
	 public function social_detail()
	{
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataArray=$_POST['social_detail'];
         $socialArray=array('facebook'=>$dataArray['facebook'],'twitter'=>$dataArray['twitter'],'youtube'=>$dataArray['youtube'],
		 'istagram'=>$dataArray['istagram'],'facebook_status'=>$dataArray['facebook_status'],'twitter_status'=>$dataArray['twitter_status'],
		 'youtube_status'=>$dataArray['youtube_status'],'istagram_status'=>$dataArray['istagram_status']);
		 $res_data=$this->GeneralSetting_model->social_detail($socialArray);
		 
		 echo json_encode($res_data);
	}
	
	
	 public function payment_setting()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataArray=$_POST['payment_setting'];
		 $payment_settingArray=array('paypalemail'=>$dataArray['paypalemail']);
		 
         $res_data=$this->GeneralSetting_model->payment_setting($payment_settingArray);
		 
		 echo json_encode($res_data);
	 }
	 
	  public function admin()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataArray=$_POST['admin'];
		 $username=$dataArray['user'];
		 $returnArray=$this->GeneralSetting_model->GetUserdetails($username);
		if($returnArray==0){
						
				
			if($dataArray['password']=='')
			{
				$adminArray=array('username'=>$dataArray['username']); 
			}else{
				$adminArray=array('username'=>$dataArray['username'],'password'=>md5($dataArray['password']));
			}
	
		 
         $res_data=$this->GeneralSetting_model->admin($adminArray,$dataArray['id']);
		}else{
			 $res_data=false;
		}
		 echo json_encode($res_data);
	 }
	
     public function company()  
	{
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataArray=$_POST['company'];
	
		if($dataArray['uploadFiles']==true)	
		{
		
			//==========================imageupload===========//

		    $base64string = $dataArray['logo'];
            $save_Path='assets/logo/';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$imgpath2 = $save_Path.time(). '.png';
            file_put_contents($imgpath2, $image_base64);  
				$return= true;
				
				
				$companyArray=array('company_name'=>$dataArray['company_name'],'company_address'=>$dataArray['company_address'],'phone'=>$dataArray['phone'],'email'=>$dataArray['email'],'support_email'=>$dataArray['support_email'],'webmaster_email'=>$dataArray['webmaster_email'],'logo'=>$imgpath2,'vat'=>$dataArray['vat']);
			} 
			else{			
				$companyArray=array('company_name'=>$dataArray['company_name'],'company_address'=>$dataArray['company_address'],'phone'=>$dataArray['phone'],'email'=>$dataArray['email'],'support_email'=>$dataArray['support_email'],'webmaster_email'=>$dataArray['webmaster_email'],'vat'=>$dataArray['vat']);
	//	print_r($companyArray); die();
			}
			$res_data=$this->GeneralSetting_model->getcompany($companyArray,'1');     
			$return= true;
			
		
		    echo json_encode($return); 
	}
	     public function smtp()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataArray=$_POST['smtp'];
		 $smtp_password1=$dataArray['smtp_password'];
		 $smtpArray=array('smtp_port'=>$dataArray['smtp_port'],'smtp_secure'=>$dataArray['smtp_secure'],'smtp_host'=>$dataArray['smtp_host'],'smtp_user_name'=>$dataArray['smtp_user_name'],
		 'smtp_password'=>md5($smtp_password1),'smtp_onoff'=>$dataArray['smtp_onoff']);  
		 
         $res_data=$this->GeneralSetting_model->getsmtp($smtpArray);
		 
		 echo json_encode($res_data);
	 }
	 
	 public function get_delete_app()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('del'=>'0'); 
		$ReturnData=$this->GeneralSetting_model->getappdelete($array,$_POST['id']);    
		echo json_encode($ReturnData);  
	}
	 
	  public function showtestimonial()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $return_array=$this->GeneralSetting_model->gettestimonial();
	   
	    echo json_encode($return_array);
    }
	
	  public function showabout()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $return_array=$this->GeneralSetting_model->getabout();
	   
	    echo json_encode($return_array);
    }

	 public function addfeed()
	{
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataArray=$_POST['feed'];
		 $CURRENTDATE=date('Y-m-d');
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
			$img_path="";
			$return= false;
			}
			$fedArray=array("name"=>$dataArray['name'],'email'=>$dataArray['email'],'message'=>$dataArray['message'],
           'image'=>$imgpath,'date'=>$CURRENTDATE);
		    $res_data=$this->GeneralSetting_model->getaddfeed($fedArray);
		    echo json_encode($res_data);
	}
	   
	   
	   public function geteditaboutData()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['rid'];
		
		$returnArray=$this->GeneralSetting_model->getaboutus($table_id);
	
		 echo json_encode($returnArray);
	}
	
	public function Abtusupdate()
	{
		    $_POST = json_decode(file_get_contents('php://input'), true);
		    $dataArray=$_POST['abtus'];
			$image = $dataArray['image'];
			$rid = $dataArray['rid'];
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
			$imgpath=$image;
			$return= false;
			}
			$abtArray=array('heading_ar'=>$dataArray['heading_ar'],'heading_en'=>$dataArray['heading_en'],'description_en'=>$dataArray['description_en'],'description_ar'=>$dataArray['description_ar'],'image'=>$imgpath);
		   $res_data=$this->GeneralSetting_model->abtUpdate($abtArray,$rid);
			
			//===============================================//
		
		 
		 echo json_encode($res_data);
	}
	
	 public function get_delete_abts()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('del'=>'1'); 
		$ReturnData=$this->GeneralSetting_model->getabtsdelete($array,$_POST['id']);    
		echo json_encode($ReturnData);  
	}
	
	
	public function get_delete_test()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('deleted'=>'Y'); 
		$ReturnData=$this->GeneralSetting_model->gettestdelete($array,$_POST['id']);    
		echo json_encode($ReturnData);  
	}
    
    public function showCompanyDetails()
	{
		
		$ReturnData=$this->GeneralSetting_model->generalsetting(); 
        $return['company']=$ReturnData;
         $return['user']=$this->GeneralSetting_model->UsernameData(1);;
        
		echo json_encode($return);  
	}
	

}