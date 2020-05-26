<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class LocationrManagement extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	   $this->load->model('LocationManagement_model');
    }

	 public function AddCityListr()
	{
		    $_POST = json_decode(file_get_contents('php://input'), true);
		    $dataArray=$_POST['add_cityr'];
			//alert($dataArray1);
			
			$CityrArray=array('country'=>$dataArray['country'],'city'=>$dataArray['city'],'samsa_city'=>$dataArray['samsa_city'],'city_code'=>$dataArray['city_code'],'title'=>$dataArray['title'],'descen'=>$dataArray['descen'],'keyword'=>$dataArray['keyword']);
			
			//print_r($CityrArray); die();;
		    $res_data=$this->LocationManagement_model->InsertCityList($CityrArray);
			$return= true;

		 echo json_encode($return);  
	}
	
	 public function AddStaeList()
	{
		    $_POST = json_decode(file_get_contents('php://input'), true);
		    $dataArray=$_POST['add_state'];
			//alert($dataArray1);
			
			$StateArray=array('country'=>$dataArray['country'],'state'=>$dataArray['state'],'title'=>$dataArray['title'],'descen'=>$dataArray['descen'],'keyword'=>$dataArray['keyword']);
			
			//print_r($CityrArray); die();;
		    $res_data=$this->LocationManagement_model->InsertStateList($StateArray);
			$return= true;

		 echo json_encode($return);  
	}
	
    public function showCountryList()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->LocationManagement_model->GetCountryListData($_POST['searchfield'],$_POST['page_no']); 
		$maniarray=$returnArray['result'];
		//$dataArray['adata']=$_POST ;  
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count'];  
		echo json_encode($dataArray);
    }
	
	
	
	public function showCountryAll()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['country'];
		
		$returnArray=$this->LocationManagement_model->GetCountryAllData($table_id);
	
		 echo json_encode($returnArray);
	}
	
	public function CourierCityDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->LocationManagement_model->GetCityCourierDrop();     
		echo json_encode($returnArray);
	}
	
	public function CountryDelete()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('deleted'=>'Y'); 
		$id=$_POST['id'];
		$ReturnData=$this->LocationManagement_model->getcountrydelete($array,$id);   
		echo json_encode($ReturnData);  
	}
	
	public function CountryAllDelete()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$id=$_POST['id'];
		$array=array('deleted'=>'Y','id'=>$id ); 
		
		//print_r($array); die();
		$ReturnData=$this->LocationManagement_model->getcountryAlldelete($array,$id);   
		echo json_encode($ReturnData);   
	}
	
	
	 public function AddCountryList()
	{
		    $_POST = json_decode(file_get_contents('php://input'), true);
		    $dataArray=$_POST['add_country'];
			//alert($dataArray1);
			
			 if(!empty($dataArray['country_flage']))
			{
			//==========================imageupload===========//
		    $base64string = $dataArray['country_flage'];
            $save_Path='assets/images/';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$imgpath2 =  $save_Path.time().''. '.png';
            file_put_contents($imgpath2, $image_base64);
			
		    
			$return= true;
			}
			else
			{
			$imgpath2="";
			$return= false;
			}
			
			
			$CountryArray=array('country'=>$dataArray['country'],'country_flage'=>$imgpath2,'title'=>$dataArray['title'],'descen'=>$dataArray['descen'],'keyword'=>$dataArray['keyword']);
			
			//print_r($CityrArray); die();;
		    $res_data=$this->LocationManagement_model->InsertCountryList($CountryArray);
			$return= true;

		 echo json_encode($return);  
	}
	
	public function ShowEditCountry()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['id'];
		
		$returnArray=$this->LocationManagement_model->GetCountry_edit($table_id);
	
		 echo json_encode($returnArray);
	}
	
	 public function UpdateCountryList()
	{
		    $_POST = json_decode(file_get_contents('php://input'), true);
		    $dataArray=$_POST['edit_country'];
			$id = $dataArray['id'];
			//alert($dataArray1);
			 if(!empty($dataArray['country_flage']))
			{
			//==========================imageupload===========//
		    $base64string = $dataArray['country_flage'];
            $save_Path='assets/images/';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$imgpath2 =  $save_Path.time().''. '.png';
            file_put_contents($imgpath2, $image_base64);
			
		    
			$return= true;
			}
			else
			{
			$imgpath2="";
			$return= false;
			}
			$editCountryArray=array('country'=>$dataArray['country'],'country_flage'=>$imgpath2,'title'=>$dataArray['title'],'descen'=>$dataArray['descen'],'keyword'=>$dataArray['keyword']);
			
			//print_r($CityrArray); die();;
		    $res_data=$this->LocationManagement_model->CountryUpdateData($editCountryArray,$id);
			$return= true;

		 echo json_encode($return);  
	}
	
	public function UpdateCityListr()
	{
		    $_POST = json_decode(file_get_contents('php://input'), true);
		    $dataArray=$_POST['edit_city'];
			$id = $dataArray['id'];
			//alert($dataArray1);
			
			$editCountryArray=array('country'=>$dataArray['country'],'city'=>$dataArray['city'],'samsa_city'=>$dataArray['samsa_city'],'city_code'=>$dataArray['city_code'],'title'=>$dataArray['title'],'descen'=>$dataArray['descen'],'keyword'=>$dataArray['keyword']);
			
			//print_r($CityrArray); die();;
		    $res_data=$this->LocationManagement_model->UpdateCityList($editCountryArray,$id);
			$return= true;

		 echo json_encode($return);  
	}
	
		public function GetCountrystatusUpdate()
	{
		//echo $status; die;
		$_POST = json_decode(file_get_contents('php://input'), true);
		//$status = $this->db->query("select status from customer  where id = $_POST['id']")->row()->status;
        $array=array('status'=>$_POST['cstatus']);  
		
		 $returnArray=$this->LocationManagement_model->UpdateCityList($array, $_POST['id']);
		 echo json_encode($_POST);
	}
	
	
	public function CountryImportsrates()
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
				
					$city = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
				    $samsa_city 	=	$worksheet->getCellByColumnAndRow(1, $row)->getValue(); 
					$latitute 		=	$worksheet->getCellByColumnAndRow(2, $row)->getValue(); //return_fees
					$longitute 		=	$worksheet->getCellByColumnAndRow(3, $row)->getValue();
					
					$update_status_r="INSERT INTO country (city, samsa_city, latitute, longitute)
VALUES ('".$city."', '".$samsa_city."', '".$latitute."', '".$longitute."')";
					
								$this->LocationManagement_model->dataUpdateAddedQry($update_status_r);
						
				 
			}
		   }
        }
	   else
	   $returnArr['fileemtpy'];
	   
  echo json_encode($returnArr);
		
	}
}