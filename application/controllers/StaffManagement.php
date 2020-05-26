<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class StaffManagement extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	   $this->load->model('StaffManagement_model');
    }

 public function showStafflist()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->StaffManagement_model->getShowstaff($_POST['searchstaff'],$_POST['page_no']); 
		$maniarray=$returnArray['result'];
		foreach($maniarray as $key=>$val)
			{
				$maniarray[$key]['branch_location']=Get_name_country_by_id('city',$val['branch_location']);
			}
			$shiparray=$maniarray;
		 $dataArray['result']=$shiparray;
		$dataArray['adata']=$_POST ;
        $dataArray['count']=$returnArray['count'];
		echo json_encode($dataArray); 
    }
	

	public function getShelveData()   
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		//$searchText=$_POST['searchText'];
		$returnArray=$this->ShipmentManagement_model->getshelvename();     
		echo json_encode($returnArray);
	}



	public function get_delete_staff()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('deleted'=>'Y');
		 $ReturnData=$this->StaffManagement_model->getstaffdelete($array,$_POST['id']);  
		 echo json_encode($ReturnData);  
	}
	 
	public function add_staff()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataArray=$_POST['add_staff'];
		 $password=Md5($dataArray['password']);
		 
		 $branch=$dataArray['branch_location'];
		 $branch_location= getidsByNameshow($branch);
        $email=$dataArray['email'];		 
		 if($email!=""){
					$returnArray=$this->StaffManagement_model->CheckEmailExist($email);
				    if($returnArray==0){
		 $staffArray=array('name'=>$dataArray['name'],'username'=>$dataArray['name'],'address'=>$dataArray['address'],'phone'=>$dataArray['phone'],'email'=>$dataArray['email']
		 ,'password'=>$password,'country_id'=>$dataArray['country_id'],'branch_location'=>$branch_location,'privilege'=>$dataArray['privilege']);
		// print_r($staffArray); die();
         $res_data=$this->StaffManagement_model->InserStaff($staffArray);
		 $return= true;   
					}else{
							$res_data=false;
						$return= 'email';  
					}
					
					}else{
                    	$res_data=false;
						$return= false;  
					}
		 echo json_encode($return);
	 }
	 
	  public function geteditstaffData()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['staffid'];
		
		$returnArray=$this->StaffManagement_model->Getstafflist_edit($table_id);
		$returnArray['cityname']=getdestinationfieldshow($returnArray['branch_location'],'city'); 
		/*foreach($returnArray as $key=>$val)
			{
				$returnArray[$key]['branch_location']=Get_name_country_by_id('state',$val['branch_location']);
			}
			//$shiparray=$returnArray;    */ 
	
		/*foreach($mainArray as $key=>$value)
		{
			$mainArray[$key]['branch_location']=Get_name_country_by_id('state',$value['branch_location']);
	
		}
		*/
		 echo json_encode($returnArray);

	} 
	
	 public function edit_staffform()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
         $dataArray=$_POST['edit_staff'];
		 $staffid = $dataArray['id'];   
		  $password=Md5($dataArray['password1']);
		  $branch=$dataArray['branch_location'];
		  $branch_location= getidsByNameshow($branch);            
         $editstaffArray=array('name'=>$dataArray['name'],'username'=>$dataArray['name'],'address'=>$dataArray['address'],'phone'=>$dataArray['phone'],'email'=>$dataArray['email']
		 ,'password'=>$password,'branch_location'=>$branch_location,'privilege'=>$dataArray['privilege']);
         $res_data=$this->StaffManagement_model->staffUpdate($editstaffArray,$staffid); 	
          echo json_encode($res_data);	  	 
	 } 
	 public function GetstaffstatusUpdate()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
        $array=array('onlinestatus'=>$_POST['status']);  
		
		 $returnArray=$this->StaffManagement_model->Getupdateactivestatus($array, $_POST['id']);
		 echo json_encode($_POST);
	}
	
	
}