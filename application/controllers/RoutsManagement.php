<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class RoutsManagement extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	    $this->load->model("RoutsManagement_model");
		$this->load->helper("utility_helper"); 
    }
   public function showRoutelist()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->RoutsManagement_model->getShowroute($_POST['searchroute'],$_POST['page_no']); 
		$maniarray=$returnArray['result'];
		$dataArray['pdata']=$_POST ;
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count']; 
		echo json_encode($dataArray); 
    }
	
	 public function showRoutelistExcel()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->RoutsManagement_model->getexcelroutrtabl($_POST); 
		 
		echo json_encode($returnArray); 
    }
	
	public function get_delete_route()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('deleted'=>'Y');
		 $ReturnData=$this->RoutsManagement_model->getroutedelete($array,$_POST['id']);  
		 echo json_encode($ReturnData);  
	}
	
	 public function add_route()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataArray=$_POST['add_route']; 
		 $city=$dataArray['city_id'];  
		 $city_id= getidsByNameshow($city);   
		 
		 
		 $routeArray=array('routecode'=>$dataArray['routecode'],'route'=>$dataArray['route'],'keyword'=>$dataArray['keyword'],'country_id'=>$dataArray['country_id'],'city_id'=>$city_id); 
		  
         $res_data=$this->RoutsManagement_model->getRoute($routeArray); 
		 
		 echo json_encode($res_data);
	 }
	   
	 public function geteditrouteData()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['routeid'];
		
		$returnArray=$this->RoutsManagement_model->Getroutelist_edit($table_id);
		$returnArray['cityname']=getdestinationfieldshow($returnArray['city_id'],'city'); 
		 echo json_encode($returnArray);
	}
	
	 public function edit_Routeform()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
         $dataArray=$_POST['edit_route'];
		 $city=$dataArray['city_id'];
		 $city_id= getidsByNameshow($city);
		 $routeid = $dataArray['id']; 
         $editrouteArray=array('routecode'=>$dataArray['routecode'],'route'=>$dataArray['route'],'keyword'=>$dataArray['keyword'],'country_id'=>$dataArray['country_id'],'city_id'=>$city_id);
         $res_data=$this->RoutsManagement_model->routeUpdate($editrouteArray,$routeid); 	
          echo json_encode($res_data);	  	 
	 } 
	 
	 public function RouteCityDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->RoutsManagement_model->GetCityRouteDrop($_POST);     
		echo json_encode($returnArray);
	}
	
	public function UploadBulkUpExcel()
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
				
			      $countryName = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
				  $cityname = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				  $routecode = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
				   $route = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
				   $keyword = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
				 $city_id=Get_name_country_by_id('id',$cityname);
				 $countryName=Get_name_country_by_id('country',$city_id);
				
				 $country_id=GetCountryNameByid($countryName);
				 if($city_id>0)
				 {
				
					  $data = array(
					'country_id' => $country_id,
					'city_id'=>$city_id,
					'routecode'=>$routecode,
					'route'=>$route,
					'keyword'=>$keyword
					);

					 $this->RoutsManagement_model->getRoute($data);  

					  
					 $returnArr['valid'][]=$row;
				 } 
				else{
					$returnArr['cityiderr'][]=$row;
				}
				 
				 
			}
		   }
        }
	   else
	   $returnArr['fileemtpy'];
	   
  echo json_encode($returnArr);
		
	}	
	
}