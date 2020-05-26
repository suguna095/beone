<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class CouriersManagement extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
        $this->load->model("CouriersManagement_model");
		$this->load->helpers('utility_helper');
    }

public function show_couriers()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->CouriersManagement_model->getviewcourier($_POST['searchfield'],$_POST['page_no']); 
		$maniarray=$returnArray['result'];
		$dataArray['pdata']=$_POST ;
        
		foreach($maniarray as $key=>$val)
		{
		$maniarray[$key]['supplier']=getsupplierbyid($maniarray[$key]['supplier']);	 
		$maniarray[$key]['city_id']=getcitybyid($maniarray[$key]['city']); 	
		}	
		
			

        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count'];
		echo json_encode($dataArray);
    }

public function ShowEditcourier()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['courierid'];  
		
		$courierArray=$this->CouriersManagement_model->Getcourier_edit($table_id);
		$courierArray['cityname']=getdestinationfieldshow($courierArray['city'],'city'); 
		$courierArray['supplier']=getsupplierbyid($courierArray['supplier']);  
		echo json_encode($courierArray);
	}
	
	public function Showodometer() 
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['courierid'];
		
		$courierArray=$this->CouriersManagement_model->Getodometer_edit($table_id);
		 foreach($courierArray as $key=>$val)
		{
			$courierArray[$key]['messenger_name']=getDriverNameByid($courierArray[$key]['cor_id']);	 
		} 
		//$dataArray=$courierArray;  
		echo json_encode($courierArray);
	}

public function ShowAssignRoot()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['courierid'];
		
		$cityAray=$this->CouriersManagement_model->GetCityId($table_id);
		$totalofdAray=$this->CouriersManagement_model->GetAssignRoot($cityAray['city']);
		$returnArray=$totalofdAray['result'];
	 foreach($returnArray as $key=>$value) 
		{
	
		$returnArray[$key]['routeid']=checkRoutAssigned($table_id,$returnArray[$key]['id']); 
		} 
	
		
		 $returnArrayR['result']=$returnArray;
		echo json_encode($returnArrayR);
 
	}
	
public function get_delete_courier()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('deleted'=>'Y'); 
		 $ReturnData=$this->CouriersManagement_model->getcourierdelete($array,$_POST['cor_id']);   
		 echo json_encode($ReturnData);  
	}
	


	public function AddCourier()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);	
		$dataArray=$_POST['add_couriers'];
		$password=Md5($dataArray['password']);
		$email=$dataArray['email'];
		 $city=$dataArray['city'];  
		 $city_id= getidsByNameshow($city);  
		 if(!empty($dataArray['iqama_id']))
			{
			//==========================imageupload===========//
		    $base64string = $dataArray['iqama_id'];
            $d1='iqama_id'.mktime(date(h),date(i),date(s),date(m),date(d),date(y)); 
            $save_Path='assets/images/'.$d1.'';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$iqama_id =  $save_Path.time().'';
            file_put_contents($iqama_id, $image_base64);
			
		    
			$return= true;
			}
			else
			{
			$img_path="";
			$return= false;
			}
			
			 if(!empty($dataArray['license']))
			{
			//==========================imageupload===========//
		    $base64string = $dataArray['license'];
            $d1='license'.mktime(date(h),date(i),date(s),date(m),date(d),date(y)); 
            $save_Path='assets/images/'.$d1.'';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$license =  $save_Path.time().'';
            file_put_contents($license, $image_base64);
			
		    
			$return= true;
			}
			else
			{
			$img_path="";
			$return= false;
			}
			
			 if(!empty($dataArray['messanger_image']))
			{
			//==========================imageupload===========//
		    $base64string = $dataArray['messanger_image'];
            $save_Path='assets/images/';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$imgpath2 =  $save_Path.time().'3'. '.png';
            file_put_contents($imgpath2, $image_base64);
			
		    
			$return= true;
			}
			else
			{
			$img_path="";
			$return= false;
			}
		            if($email!=""){
					$returnArray=$this->CouriersManagement_model->CheckEmailExist($email);
				    if($returnArray==0){
					
					$courierArray=array('messenger_name'=>$dataArray['messenger_name'],'country_id'=>$dataArray['country_id'],'city'=>$city_id,'messenger_code'=>$dataArray['messenger_code'],'mobile'=>$dataArray['mobile'],'email'=>$dataArray['email'],'iqama'=>$dataArray['iqama'],'typVehicle'=>$dataArray['typVehicle'],
					'supplier'=>$dataArray['supplier'],'joinDate'=>$dataArray['joinDate'],'password'=>$password,'vehicle_number'=>$dataArray['vehicle_number'],'iqama_id'=>$iqama_id,'license'=>$license,'messanger_image'=>$imgpath2);
					
					//print_r($courierArray); die();
		            $res_data=$this->CouriersManagement_model->insertcourier($courierArray); 
						
			        $return= true;   
					}else{
							$res_data=false;
						$return= 'email';  
					}
					}
					else{
						$res_data=false;
						$return=false;
					}
					
		 echo json_encode($return);
	}
	
	public function AddEditCourier()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);	
		$dataArray=$_POST['edit_couriers'];
		$courierid = $dataArray['courierid'];
		 $city=$dataArray['city'];  
		 $city_id= getidsByNameshow($city);  
		if($dataArray['uploadFiles']==true)	
		{
		 if(!empty($dataArray['iqama_id']))
			{
			//==========================imageupload===========//
		    $base64string = $dataArray['iqama_id'];
            $d1='iqama_id'.mktime(date(h),date(i),date(s),date(m),date(d),date(y)); 
            $save_Path='assets/images/'.$d1.'';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$iqama_id =  $save_Path.time().'';
            file_put_contents($iqama_id, $image_base64);
			
		    
			$return= true;
			}
			else
			{
			$img_path="";
			$return= false;
			}
			
			 if(!empty($dataArray['license']))
			{
			//==========================imageupload===========//
		    $base64string = $dataArray['license'];
            $d2='license'.mktime(date(h),date(i),date(s),date(m),date(d),date(y)); 
            $save_Path='assets/images/'.$d2.'';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$license =  $save_Path.time().'';
            file_put_contents($license, $image_base64);
			
		    
			$return= true;
			}
			else
			{
			$img_path="";
			$return= false;
			}
			
			 if(!empty($dataArray['messanger_image']))
			{
			//==========================imageupload===========//
		    $base64string = $dataArray['messanger_image'];
            $save_Path='assets/images/';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$imgpath2 =  $save_Path.time().'3'. '.png';
            file_put_contents($imgpath2, $image_base64);
			
		    
			$return= true;
			}
			else
			{
			$img_path="";
			$return= false;
			}
		
			if($dataArray['password1']==''){
					
					$editcourierArray=array('messenger_name'=>$dataArray['messenger_name'],'country_id'=>$dataArray['country_id'],'city'=>$city_id,'messenger_code'=>$dataArray['messenger_code'],'mobile'=>$dataArray['mobile'],'iqama'=>$dataArray['iqama'],'typVehicle'=>$dataArray['typVehicle'],
					'supplier'=>$dataArray['supplier'],'joinDate'=>$dataArray['joinDate'],'vehicle_number'=>$dataArray['vehicle_number'],'iqama_id'=>$iqama_id,'license'=>$license,'messanger_image'=>$imgpath2);
		            
				}else{
					$editcourierArray=array('messenger_name'=>$dataArray['messenger_name'],'country_id'=>$dataArray['country_id'],'city'=>$city_id,'messenger_code'=>$dataArray['messenger_code'],'mobile'=>$dataArray['mobile'],'iqama'=>$dataArray['iqama'],'typVehicle'=>$dataArray['typVehicle'],
					'supplier'=>$dataArray['supplier'],'joinDate'=>$dataArray['joinDate'],'password'=>Md5($dataArray['password1']),'vehicle_number'=>$dataArray['vehicle_number'],'iqama_id'=>$iqama_id,'license'=>$license,'messanger_image'=>$imgpath2);
		            
				  }   
		}else{
			if($dataArray['password1']==''){
					
				$editcourierArray=array('messenger_name'=>$dataArray['messenger_name'],'country_id'=>$dataArray['country_id'],'city'=>$city_id,'messenger_code'=>$dataArray['messenger_code'],'mobile'=>$dataArray['mobile'],'iqama'=>$dataArray['iqama'],'typVehicle'=>$dataArray['typVehicle'],
				'supplier'=>$dataArray['supplier'],'joinDate'=>$dataArray['joinDate'],'vehicle_number'=>$dataArray['vehicle_number']);  
				
			}else{
				$editcourierArray=array('messenger_name'=>$dataArray['messenger_name'],'country_id'=>$dataArray['country_id'],'city'=>$city_id,'messenger_code'=>$dataArray['messenger_code'],'mobile'=>$dataArray['mobile'],'iqama'=>$dataArray['iqama'],'typVehicle'=>$dataArray['typVehicle'],
				'supplier'=>$dataArray['supplier'],'joinDate'=>$dataArray['joinDate'],'password'=>Md5($dataArray['password1']));
				
			  } 
		}  
			  
			  $res_data=$this->CouriersManagement_model->courierUpdate($editcourierArray,$courierid);  	 
			  $return= true; 
		 echo json_encode($return);
	}
	
	public function show_Odo()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->CouriersManagement_model->getOdoData($_POST);
        $maniarray=$returnArray['result'];
		$dataArray['pdata']=$_POST ;
        
		foreach($maniarray as $key=>$val)
		{
		$maniarray[$key]['messenger_name']=getDriverNameByid($maniarray[$key]['cor_id']);	 
			
		}	
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count'];
		echo json_encode($dataArray);		
		
    }
	
	public function ShowEditOdo()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['odoid'];
		
		$returnArray=$this->CouriersManagement_model->Getodo_edit($table_id);
	     
		 echo json_encode($returnArray);  
	}
   
   
   public function AddEditodo()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);	
		$dataArray=$_POST['edit_odo'];
		$odoid = $dataArray['odoid'];
		
		
			 if(!empty($dataArray['s_img']))
			{
			//==========================imageupload===========//
		    $base64string = $dataArray['s_img'];
            $save_Path='assets/images/';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$s_img =  $save_Path.time().'1'. '.png';
            file_put_contents($s_img, $image_base64);
			
		    
			$return= true;
			}
			else
			{
			$img_path="";
			$return= false;
			}
			
			
			 if(!empty($dataArray['e_img']))
			{
			//==========================imageupload===========//
		    $base64string = $dataArray['e_img'];
            $save_Path='assets/images/';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$e_img =  $save_Path.time().'2'. '.png';
            file_put_contents($e_img, $image_base64);
			
		    
			$return= true;
			}
			else
			{
			$img_path="";
			$return= false;
			}
					
					$editodoArray=array('start_km'=>$dataArray['start_km'],'end_km'=>$dataArray['end_km'],'s_time'=>$dataArray['s_time'],'e_time'=>$dataArray['e_time'],'pre_e_ltr'=>$dataArray['pre_e_ltr'],
					's_img'=>$s_img,'e_img'=>$e_img);
		            $res_data=$this->CouriersManagement_model->odoUpdate($editodoArray,$odoid);  
			        $return= true;  
		 
					
		 echo json_encode($return);
	}
	
	public function GetCountryDropshowShow()
	{
		$returnArray=GetcountryDropData();     
		echo json_encode($returnArray);
	}
	public function Getcitydropdatashow()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=getAllDestination($_POST['country_id']);     
		echo json_encode($returnArray);
	}
	
	
	public function CourierCityDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->CouriersManagement_model->GetCityCourierDrop();     
		echo json_encode($returnArray);
	}
	
	public function CourierVehicleDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->CouriersManagement_model->GetVehicleCourierDrop();     
		echo json_encode($returnArray);
	}
	
	public function CourierSupplierDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->CouriersManagement_model->GetSupplierCourierDrop();     
		echo json_encode($returnArray);
	}
	
	public function GetCourtatusUpdate() 
	{
		//echo $status; die;
		$_POST = json_decode(file_get_contents('php://input'), true);
		//$status = $this->db->query("select status from customer  where id = $_POST['id']")->row()->status;
        $array=array('online_offline_status'=>$_POST['online_offline_status']);  
		
		 $returnArray=$this->CouriersManagement_model->GetCoractivestatus($array, $_POST['cor_id']);
		 echo json_encode($_POST);
	}
	
	
	public function courierImport()
	{
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $path = $_FILES["file"]["tmp_name"];
		 if(!empty($path))
		 {
         $this->load->library("excel");
         $object = PHPExcel_IOFactory::load($path);
		   foreach($object->getWorksheetIterator() as $worksheet)
		   {
			$highestRow = $worksheet->getHighestRow();
			$highestColumn = $worksheet->getHighestColumn();
		
			$returnArr=array();
				for($row=2; $row<=$highestRow; $row++)
			    {	
				
				 
				 $old_email = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
				 $city = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
				  
				 $emailData=$this->CouriersManagement_model->checkEmailExitsQry($old_email);
				 $cityData=$this->CouriersManagement_model->getCityIdQry($city);
					  if($emailData==0)
						{
							
							$messenger_name =	$worksheet->getCellByColumnAndRow(0, $row)->getValue();
							$messenger_code 		=	$worksheet->getCellByColumnAndRow(1, $row)->getValue();
							$branch 		=	$worksheet->getCellByColumnAndRow(2, $row)->getValue();
							$city 		=	$worksheet->getCellByColumnAndRow(3, $row)->getValue();
							$mobile 		=	$worksheet->getCellByColumnAndRow(4, $row)->getValue();
							$email 		=	$worksheet->getCellByColumnAndRow(5, $row)->getValue();
							$iqama 		=	$worksheet->getCellByColumnAndRow(6, $row)->getValue();
							$iqama_id 		=	$worksheet->getCellByColumnAndRow(7, $row)->getValue();
							$typVehicle 		=	$worksheet->getCellByColumnAndRow(8, $row)->getValue();
							$supplier 		=	$worksheet->getCellByColumnAndRow(9, $row)->getValue();
							$joinDate 		=	$worksheet->getCellByColumnAndRow(10, $row)->getValue();
							$password 		=	$worksheet->getCellByColumnAndRow(11, $row)->getValue();
							$vehicle_number 		=	$worksheet->getCellByColumnAndRow(12, $row)->getValue();
							
								
						
							$update_status_r="INSERT INTO courier_staff (messenger_name, messenger_code, branch, city, mobile, email, iqama, iqama_id, typVehicle, supplier, joinDate, password, vehicle_number)
							VALUES ('".$messenger_name."', '".$messenger_code."', '".$branch."', '".$cityData."', '".$mobile."', '".$email."', '".$iqama."', '".$iqama_id."', '".$typVehicle."', '".$supplier."', '".$joinDate."', '".Md5($password)."', '".$vehicle_number."')";
							
							//print_r($update_status_r); die();
							
							$this->CouriersManagement_model->dataUpdateAddedQry($update_status_r);
							$returnArr['validrows'][]="added Successfully ";
						}
							else
							$returnArr['invalidrpows'][]="Aleady Email ID Exists ".$old_email."<br>";
				}
			}
		   }
        
	   else
	   $returnArr['fileemtpy'];
	   
  echo json_encode($returnArr);
		
	}
	
	
	public function setAssignRoot()
	{
		
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $postArray=$_POST;
		$courierid=$postArray['courierid'];
		$root_id=$postArray['root_id'];
		$onoff_true_false=$postArray['onoff_true_false'];
		
		if($onoff_true_false=="true"){
		$data=array('cor_id'=>$courierid,'rout'=>$root_id);
		$result=$this->CouriersManagement_model->InsertAssignRoot($data);
		}else{
			$result=$this->CouriersManagement_model->DeleteAssignroot($courierid,$root_id);
		}
		
		echo json_encode($result); 
		
		
		
	}
	
}