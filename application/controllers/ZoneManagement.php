<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class ZoneManagement extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	   $this->load->model('ZoneManagement_model');
    }
    
	public function showZonelist()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->ZoneManagement_model->getshowZonelist($_POST['searchfield'],$_POST['page_no']); 
		$maniarray=$returnArray['result'];
		$dataArray['adata']=$_POST ;  
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count'];    
		echo json_encode($dataArray);
    }
	
	 public function AddZone()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);	
		$dataArray=$_POST['add_zone']; 
		$name=$dataArray['name'];
		
		
				if($name!=""){
				$returnArray=$this->ZoneManagement_model->GetZoneDetails($name);

					if($returnArray==0){
				
					$zoneArray=array('name'=>$dataArray['name']);
		             $res_data=$this->ZoneManagement_model->insertZone($zoneArray);   
  					$return= true; 
					}}else{
						 $res_data=false;
						$return= false; 
					}
		
        echo json_encode($return);
	}
	
	public function ShowEditZones() 
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['zid'];
		
		$returnArray=$this->ZoneManagement_model->Getzoneedit($table_id);
	
		 echo json_encode($returnArray);
	}


   public function EditZone()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);	
		$dataArray=$_POST['add_zone'];
		$zid = $dataArray['zid'];
		$zoneArray=array('name'=>$dataArray['name']);
	    $res_data=$this->ZoneManagement_model->EditZoneUpdate($zoneArray,$zid );  
	    $return= true;  
        echo json_encode($res_data);
	}
	
	 public function get_delete_zone()    
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('deleted'=>'Y'); 
		 $ReturnData=$this->ZoneManagement_model->getzonedelete($array,$_POST['id']);   
		 echo json_encode($ReturnData);  
	}
	
	public function GetCityZone() 
    {
		$_POST = json_decode(file_get_contents('php://input'), true); 
	    $returnArray=$this->ZoneManagement_model->CityZone($_POST['searchfield'],$_POST['page_no'],$_POST['alphabetic']);  
		$maniarray=$returnArray['result'];
		$dataArray['adata']=$_POST ;  
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count'];    
		echo json_encode($dataArray);
    }
	
	public function GetCountryZone() 
    {
		$_POST = json_decode(file_get_contents('php://input'), true); 
	    $returnArray=$this->ZoneManagement_model->CountryZone($_POST['searchfield'],$_POST['page_no'],$_POST['alphabetic']);  
		$maniarray=$returnArray['result'];
		$dataArray['adata']=$_POST ;  
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count'];    
		echo json_encode($dataArray);
    }
	
	 public function showZoneDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->ZoneManagement_model->showZoneDropData();     
		echo json_encode($returnArray);
	}
	
	
	 public function showCountryZoneDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->ZoneManagement_model->showcountryZoneDropData();     
		echo json_encode($returnArray);
	}
	
	
	 public function showCityDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->ZoneManagement_model->showCityDropData();     
		echo json_encode($returnArray);
	}
	
	public function GetZonestatusUpdate() 
	{
		//echo $status; die;
		$_POST = json_decode(file_get_contents('php://input'), true);
		//$status = $this->db->query("select status from customer  where id = $_POST['id']")->row()->status;
        $array=array('status'=>$_POST['status']);  
		
		 $returnArray=$this->ZoneManagement_model->GetZoneactivestatus($array, $_POST['id']);
		 echo json_encode($_POST);
	}
	
	public function GetZoneIDUpdate() 
	{
		//echo $status; die;
		$_POST = json_decode(file_get_contents('php://input'), true);
        $array=array('zone_id'=>$_POST['zone_id']);  
		
		 $returnArray=$this->ZoneManagement_model->GetUpdateZoneID($array, $_POST['id']);
		 echo json_encode($_POST);
	}
	
	public function GetCountryZoneIDUpdate() 
	{
		//echo $status; die;
		$_POST = json_decode(file_get_contents('php://input'), true);
        $array=array('country_zone_id'=>$_POST['country_zone_id']);  
		
		 $returnArray=$this->ZoneManagement_model->GetUpdateZoneID($array, $_POST['id']);
		 echo json_encode($_POST);
	}
	
}