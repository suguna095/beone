<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class WarehouseManagement extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
       $this->load->model('WarehouseManagement_model');
	   $this->load->helper('utility');
    }


 public function warehouse_manage()
	{
     
	 $SQL_QUERY4=" SELECT shelv_no FROM warehous_shelve_no WHERE deleted='N' and status='Y'";
	 $query=$this->db->query($SQL_QUERY4);
	 $selvevalue= $query->result_array(); 
	 $selveArray=array();
	 foreach($selvevalue as $key=>$val)
	 array_push($selveArray,$selvevalue[$key]['shelv_no']);
	 
	 echo json_encode($selveArray);
	}
	public function showinventorylist()
	    {
			$_POST = json_decode(file_get_contents('php://input'), true);
		    $returnArray=$this->WarehouseManagement_model->getShowinventorylist($_POST); 
			$maniarray=$returnArray['result'];
			foreach($maniarray as $key=>$value)
			{
				$maniarray[$key]['origin']=Get_name_country_by_id('city',$value['origin']);
				$maniarray[$key]['username']=getuserbyid($value['user_id']);  
				$maniarray[$key]['destination']=Get_name_country_by_id('city',$value['destination']);
				if($value['schedule_date']>0)
				$maniarray[$key]['schedule_date']=date('D d M Y',strtotime($value['schedule_date']));
				else
				$maniarray[$key]['schedule_date']='---'; 
			}
			 //$dataArray['pdata']=$_POST ;  
	        $dataArray['result']=$maniarray;   
	        $dataArray['count']=$returnArray['count'];
			echo json_encode($dataArray); 
	    }

        		
			public function Showawbno()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->WarehouseManagement_model->GetAWBNO($_POST['searchfield'],$_POST['page_no']); 
		$maniarray=$returnArray['result'];
		
		foreach($maniarray as $key=>$val)
		{
				if($val['schedule_date']>0)
				$maniarray[$key]['schedule_date']=date('D d M Y',strtotime($val['schedule_date']));
				else
				$maniarray[$key]['schedule_date']='---';
		}
		$dataArray['pdata']=$_POST ;  
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count']; 
		echo json_encode($dataArray);
    }

      public function GetCityDrop()
	  {
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->WarehouseManagement_model->DataCityDrop($_POST);
        echo json_encode($returnArray);	 	
	  }
	  
	   public function GetHbstateDrop()
	  {
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->WarehouseManagement_model->DataHubDrop($_POST);
        echo json_encode($returnArray);	  	
	  }
	  
	    public function showScanShipmentlist()
	    {
			$_POST = json_decode(file_get_contents('php://input'), true);
		    $returnArray=$this->WarehouseManagement_model->getShowScanShipmentlist($_POST['searchfield'],$_POST['page_no']); 
			$maniarray=$returnArray['result'];
			foreach($maniarray as $key=>$val)
		   {
				if($val['schedule_date']>0)
				$maniarray[$key]['schedule_date']=date('D d M Y',strtotime($val['schedule_date']));
				else
				$maniarray[$key]['schedule_date']='---';
		  }
			 $dataArray['pdata']=$_POST ;  
	        $dataArray['result']=$maniarray;   
	        $dataArray['count']=$returnArray['count'];
			echo json_encode($dataArray);
	    }
		
		  public function showHoldShipmentlist()
	    {
			$_POST = json_decode(file_get_contents('php://input'), true);
		    $returnArray=$this->WarehouseManagement_model->getShowHoldShipmentlist($_POST['slip_no'],$_POST['page_no']); 
			$maniarray=$returnArray['result'];
			 $dataArray['pdata']=$_POST ;  
	        $dataArray['result']=$maniarray;   
	        $dataArray['count']=$returnArray['count'];
			echo json_encode($dataArray);
	    }
		
		  public function showBoundShipmentlist()
	    {
			$_POST = json_decode(file_get_contents('php://input'), true);
		    $returnArray=$this->WarehouseManagement_model->getshowBoundShipmentlist($_POST['slip_no'],$_POST['page_no']); 
			$maniarray=$returnArray['result'];
			 $dataArray['pdata']=$_POST ;  
	        $dataArray['result']=$maniarray;   
	        $dataArray['count']=$returnArray['count'];
			echo json_encode($dataArray);
	    }
		
		
		  public function showScheduleShipmentlist()
	    {
			$_POST = json_decode(file_get_contents('php://input'), true);
		    $returnArray=$this->WarehouseManagement_model->getshowScheduleShipmentlist($_POST['slip_no'],$_POST['page_no']); 
			$maniarray=$returnArray['result'];
			 $dataArray['pdata']=$_POST ;  
	        $dataArray['result']=$maniarray;   
	        $dataArray['count']=$returnArray['count'];
			echo json_encode($dataArray);
	    }
		
		
		

	public function AddCustomer()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);	
		$dataArray=$_POST['filterData'];
		$pickup_date=date('Y-m-d H:i:s');
		
		$Details="Shelve using warehouse management"."".$dataArray['searchfield'];
		
		
		if(!empty($dataArray))	
		{
			
					$customerArray=array('user_id'=>'1','user_type'=>'user','new_status'=>'7','code'=>'SH',
					'pickup_date'=>$pickup_date,'Activites'=>'Shelve','Details'=>$Details,'entry_date'=>$pickup_date,
					'slip_no'=>$dataArray['slip_no'],'comment'=>$dataArray['searchfield']);
		            $res_data=$this->WarehouseManagement_model->insertcustomer($customerArray);  
			        $return= true;
					
		}
		else
					{
					
					$return= false; 
					}
		 echo json_encode($res_data);
	}
	
	public function GetshipmentScanData()
	{
	$_POST = json_decode(file_get_contents('php://input'), true);		
	$shelv_no=$_POST['shelve'];
	$data=$this->WarehouseManagement_model->ScanShipmentDataQry(trim($_POST['slip_no'])); 
	
   if(!empty($data))
   {
	$data['print_url']=encrypt($data['slip_no']);
	$data['lastofd']=lastOfd($data['slip_no']);
	$data['destination']=Get_name_country_by_id('city',$data['destination']);
	$data['origin']=Get_name_country_by_id('city',$data['origin']);
	$data['shelv_no']=$shelv_no;
	if($data['schedule_date']>0)
	$data['schedule_date']=date('Y-m-d',strtotime($data['schedule_date']));
	else
	$data['schedule_date']="--";
	
	
	$CURRENT_TIME=date('H:i:s');
	$CURRENT_DATE=date('Y-m-d H:i:s');
	if(!empty($data['messanger_id']))
	{
	$messData=messangerData($data['messanger_id']);
	//print_r($messData);
	$data['messanger_name']=$messData[0]['messenger_name'];
	$data['supplier']=$messData[0]['supplier'];
	$data['messanger_code']=$messData[0]['messenger_code'];
	$data['mobile']=$messData[0]['mobile'];
	$driver_id=$messData[0]['cor_id'];
	
	}
	
	if($data['schedule_status']=='Y' &&  $data['refused']!='YES')
	{
	$drs_unique_code=checkTempDrsToday($driver_id);  	
	$data['schedule_status']='Yes';
	
	  $timestamp=date('Y-m-d', strtotime($data['schedule_date']));
		    $currentTimeStamp=date('Y-m-d', strtotime(' +1 day')); 
			
			$date_a = new DateTime($timestamp);
			$date_b = new DateTime($currentTimeStamp);
			$interval = date_diff($date_a,$date_b);
			//print_r($interval);
			 $day= $interval->format('%d');
			 $year= $interval->format('%y');
			 $month= $interval->format('%m');
			 $hour= $interval->format('%h');
			if( $day==0 && $year==0 && $month==0)
			{
				$data['schedule_status_for_tommorow']='Yes';
				
				$destZone=Get_name_country_by_id('zone_id',$data['destination']);
				$staffZone= Get_name_country_by_id('zone_id',$this->session->userdata('adminbranchlocation'));  
				if($destZone==$staffZone)
				{
				$ThatTime='16:00';
				if(strtotime($ThatTime)>=time())
				$expactedDate=date('Y-m-d');   
				else
				$expactedDate=date('Y-m-d', strtotime('+1 days'));    
				$cond.=" ,req_delevery_time='".$expactedDate."' "; 
				
				}
				else
				{
				$cond.="";
				}
                     
					$edit_drs_temp="insert into temp_drs (routecode, shipment_id, city_id,drs_date, messanger_id,drs_unique_id,drs_bar_image,drs_bar_code) values ('".$data['messanger_code']."', '".trim($data['slip_no'])."', '".$data['destination']."','".$CURRENT_DATE."','".$data['messanger_id']."','".$drs_unique_code."','".$uploaded_file."','".$auto_bar_id."')";
					$this->WarehouseManagement_model->InserAndUpdateQry($edit_drs_temp); 
					
					$Activites=getStatus(14);
					$details=$Activites.' using warehouse management ';
					$update_status="insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,comment,code) values ('".preg_replace('/\s+/', '',trim($data['slip_no']))."','".$this->session->userdata('adminbranchlocation')."','14','".$CURRENT_TIME."','".$CURRENT_DATE."','".$Activites."','".$details."','".$CURRENT_DATE."','".$this->session->userdata('useridadmin')."','user','".$_REQUEST['comment']."','RFDE')"; 
					$this->WarehouseManagement_model->InserAndUpdateQry($update_status);
					
					$update_status_r="update shipment set delivered='14',shelv_no='".$shelv_no."'  , code='RFDE' ".$cond." where  slip_no='".trim($data['slip_no'])."' ";  
					$this->WarehouseManagement_model->InserAndUpdateQry($update_status_r);
						//$functions->trackPush(trim($data['slip_no']));	
				
			  }
				else
				{
				 $destZone=Get_name_country_by_id('zone_id',$data['destination']);
				 $staffZone=Get_name_country_by_id('zone_id',$this->session->userdata('adminbranchlocation'));  
				if($destZone==$staffZone)
				{
				$ThatTime='16:00';
				if(strtotime($ThatTime)>=time())
				$expactedDate=date('Y-m-d');   
				else
				$expactedDate=date('Y-m-d', strtotime('+1 days'));    
				$cond.=" ,req_delevery_time='".$expactedDate."' "; 
				
				}
				else
				{
				$cond.="";
				}
				
				$Activites=getStatus(7);
				$details=$Activites.' using warehouse management shelve no :'.$shelv_no;
				$data['schedule_status']='No';
				
				$update_status="insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,comment,code) values ('".preg_replace('/\s+/', '',trim($data['slip_no']))."','".$this->session->userdata('adminbranchlocation')."','7','".$CURRENT_TIME."','".$CURRENT_DATE."','".$Activites."','".$details."','".$CURRENT_DATE."','".$this->session->userdata('useridadmin')."','user','".$_REQUEST['comment']."','SH')"; 
				$this->WarehouseManagement_model->InserAndUpdateQry($update_status);
				$update_status_r="update shipment set shelv_no='".$shelv_no."', code='SH', delivered='7' ".$cond."  where  slip_no='".trim($data['slip_no'])."' ";  
				$this->WarehouseManagement_model->InserAndUpdateQry($update_status_r);
				///$functions->trackPush(trim($data['slip_no']));	
				
				}
	   } 
		else
			{
        
                  
				$destZone=Get_name_country_by_id('zone_id',$data['destination']);
				$staffZone= Get_name_country_by_id('zone_id',$this->session->userdata('adminbranchlocation'));  
				if($destZone==$staffZone)
				{
				$ThatTime='16:00';
				if(strtotime($ThatTime)>=time())
				$expactedDate=date('Y-m-d');   
				else
				$expactedDate=date('Y-m-d', strtotime('+1 days'));    
				$cond.=" ,req_delevery_time='".$expactedDate."' "; 
				
				}
				else
				{
				$cond.="";
				}
				$Activites=getStatus(7);
				$details=$Activites.' using warehouse management shelve no :'.$shelv_no;
				$update_status="insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,comment,code) values ('".preg_replace('/\s+/', '',trim($data['slip_no']))."','".$this->session->userdata('adminbranchlocation')."','7','".$CURRENT_TIME."','".$CURRENT_DATE."','".$Activites."','".$details."','".$CURRENT_DATE."','".$this->session->userdata('useridadmin')."','user','".$_REQUEST['comment']."','SH')"; 
				$this->WarehouseManagement_model->InserAndUpdateQry($update_status);
				$update_status_r="update shipment set shelv_no='".$shelv_no."', code='SH', delivered='7' ".$cond." where  slip_no='".trim($data['slip_no'])."' ";  
				$this->WarehouseManagement_model->InserAndUpdateQry($update_status_r);
				//$functions->trackPush(trim($data['slip_no']));	 
	         }
	
	if(!empty($data))
	 echo json_encode($data);  

	 }

 }
 
 public function GetOnHoldShipmentDataUpdate()
 {
	$_POST = json_decode(file_get_contents('php://input'), true);	 
	//$shelv_no=$_POST['shelve'];
		$from=date('Y-m-d', strtotime($_POST['from_date']));
		$to=date('Y-m-d', strtotime($_POST['to_date']));
       $data= $this->WarehouseManagement_model->OnholdShipemtDataQry(trim($_POST['slip_no']),$from,$to);

		if(!empty($data))
		{
			$data['destination']=Get_name_country_by_id('city',$data['destination']);
			$data['origin']=Get_name_country_by_id('city',$data['origin']);
			$CURRENT_TIME=date('H:i:s');
			
			$CURRENT_DATE=date('Y-m-d H:i:s');
			echo json_encode($data);  
		}
		else
		{
			$data['slip_no']=0;
			echo json_encode($data);  
		}

 }
 
 public function GetAddReportData()
 {
	 
	$_POST = json_decode(file_get_contents('php://input'), true);	 
	$report_type=$_POST['report_type'];
    $data=array_unique($_POST['slip_no']);
	if(!empty($data))
	{
		foreach($data as $val)
		{
			 $shipmentdata= $this->WarehouseManagement_model->ReportShipemtDataQry(trim($val));
		$insert="INSERT INTO `inventory_report`(`awb_no`, `origin`, `destination`, `schedule_status`, `shedule_type`, `shedule_date`, `refused`, `messenger_code`, `report_type`,user_id) VALUES ('".$shipmentdata['slip_no']."','".$shipmentdata['origin']."','".$shipmentdata['destination']."','".$shipmentdata['schedule_status']."','".$shipmentdata['shedule_type']."','".$shipmentdata['shedule_date']."','".$shipmentdata['refused']."','".$shipmentdata['messenger_code']."','".$report_type."','".$this->session->userdata('useridadmin')."') ";
		$this->WarehouseManagement_model->InserAndUpdateQry($insert);
		
		}
	}
	//print_r($data);

 }
 
 public function scanScheduleData()
 {
	 $_POST = json_decode(file_get_contents('php://input'), true);	
	 
	$shelv_no=$_POST['shelve'];
	$from=date('Y-m-d', strtotime($_POST['from_date']));
	$to=date('Y-m-d', strtotime($_POST['to_date']));
	 $data= $this->WarehouseManagement_model->scanScheduleDataQry(trim($_POST['slip_no']),$from,$to);
       if(!empty($data))
		{
			$data['print_url']=encrypt($data['slip_no']);
			$data['lastofd']=lastOfd($data['slip_no']);
			$data['destination']=Get_name_country_by_id('city',$data['destination']);
			$data['origin']=Get_name_country_by_id('city',$data['origin']);
			$data['schedule_date1']=date('Y-m-d',$schedule_date); 
			$CURRENT_TIME=date('H:i:s');
					
			$CURRENT_DATE=date('Y-m-d H:i:s');
			if(!empty($data['messanger_id']))
			{
			$messData=messangerData($data['messanger_id']);
			//print_r($messData);
			$data['messanger_name']=$messData['messenger_name'];
			$data['supplier']=$messData['supplier'];
			$data['messanger_code']=$messData['messenger_code'];
			$data['mobile']=$messData['mobile'];
			$driver_id=$messData[0]['cor_id'];
			}
			
			if($data['schedule_status']=='Y' &&  $data['refused']!='YES')
			{
					$drs_unique_code=checkTempDrsToday($driver_id);  	
					$data['schedule_status']='Yes';
					
					$timestamp=date('Y-m-d', strtotime($data['schedule_date']));
					$currentTimeStamp=date('Y-m-d', strtotime(' +1 day')); 
					
					$date_a = new DateTime($timestamp);
					$date_b = new DateTime($currentTimeStamp);
		
					$interval = date_diff($date_a,$date_b);
					//print_r($interval);
					 $day= $interval->format('%d');
					 $year= $interval->format('%y');
					 $month= $interval->format('%m');
					 $hour= $interval->format('%h');
			} 
			 echo json_encode($data);  
			}
	   else
	   {
		$data['slip_no']=0;
		 echo json_encode($data);  
		}
 
  }
  public function scanInboundShipment()
  {
	 $_POST = json_decode(file_get_contents('php://input'), true);	  
	$shelv_no=$_POST['shelve'];
	$from=date('Y-m-d', strtotime($_POST['from_date']));
	$to=date('Y-m-d', strtotime($_POST['to_date']));
	$data= $this->WarehouseManagement_model->scanInboundShipmentQry(trim($_POST['slip_no']));
       if(!empty($data))
		{
			//$data['print_url']=$functions->encrypt($data['slip_no']);
			//$data['lastofd']=$functions->lastOfd($data['slip_no']);
			$data['destination']=Get_name_country_by_id('city',$data['destination']);
			$data['origin']=Get_name_country_by_id('city',$data['origin']);
			$CURRENT_TIME=date('H:i:s');
					
			$CURRENT_DATE=date('Y-m-d H:i:s');
			if(!empty($data['messanger_id']))
			{
			$messData=messangerData($data['messanger_id']);
			//print_r($messData);
			$data['messanger_name']=$messData['messenger_name'];
			$data['supplier']=$messData['supplier'];
			$data['messanger_code']=$messData['messenger_code'];
			$data['mobile']=$messData['mobile'];
			$driver_id=$messData[0]['cor_id'];
			}
			
			
				$Activites=getStatus(13);
				$details=$Activites.' using warehouse management ';
				
				$update_status="insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,comment,code) values ('".preg_replace('/\s+/', '',trim($data['slip_no']))."','".$this->session->userdata('adminbranchlocation')."','13','".$CURRENT_TIME."','".$CURRENT_DATE."','".$Activites."','".$details."','".$CURRENT_DATE."','".$this->session->userdata('useridadmin')."','user','".$details."','SH')"; 
				$this->WarehouseManagement_model->InserAndUpdateQry($update_status);
				$update_status_r="update shipment set code='RI', delivered='13' where  slip_no='".trim($data['slip_no'])."' ";  
				$this->WarehouseManagement_model->InserAndUpdateQry($update_status_r);
				//$functions->trackPush(trim($data['slip_no']));
				
			 echo json_encode($data);  
			}
			else
			{
			$data['slip_no']=0;
			echo json_encode($data);  
			}

	  
  }
  
  public function securityCheckData()
  {
	 $_POST= json_decode(file_get_contents('php://input'), true);	
	   $scanned=$_POST['scanned'];
	   $shData= $this->WarehouseManagement_model->securityCheckDataShipmetDataQry(trim($_POST['slip_no']));
		if(!empty($shData))
		{
			$dataDRS= $this->WarehouseManagement_model->securityCheckDataDrsDataQry(trim($shData['slip_no']),trim($_POST['drs_id']));
			if(!empty($dataDRS))
			{
				$data= $this->WarehouseManagement_model->securityCheckShipDataQry(trim($shData['slip_no']));
					if(!empty($data))
					{
					$arry=array_count_values($scanned);
					$data['scanned']=$arry[$data['slip_no']];
					$data['print_url']=encrypt($data['slip_no']);
					$data['lastofd']=lastOfd($data['slip_no']);
					$data['destination']=Get_name_country_by_id('city',$data['destination']);
					$data['origin']=Get_name_country_by_id('city',$data['origin']);
					$data['shelv_no']=$shelv_no;
					$CURRENT_TIME=date('H:i:s');
					
					if(!empty($data))
					echo json_encode($data);  
					
					}
			}
		}

    }
	
	public function GetverifyCreateManifest()
	{
	$_POST= json_decode(file_get_contents('php://input'), true);		
	if(!empty($_POST['scanned']))	
	{
		     $CURRENT_TIME=date('H:i:s');
	         $CURRENT_DATE=date('Y-m-d H:i:s');
			foreach($_POST['scanned'] as $key=>$val)
			{
				    $citydata= $this->WarehouseManagement_model->VerifyManifestshipDataQry(trim($val['slip_no']));
					$number=$citydata['reciever_phone'];
					$driver_id=$citydata['messanger_id'];
					$driver_name	=	get_messanger_tablefield($driver_id,'messenger_name');
					//$driver_name	=	$functions->get_messanger_name($driver_id);
					$driver_mobile	=	get_messanger_tablefield($driver_id,'mobile'); 						
					$message = outOfDeliveryMessage($val['slip_no'],$driver_name,$driver_mobile);
					SEND_SMS($number,$message);	
					$activites='Secutity Check';
					$Detail='Number of shipment Verified ';				
					$statusQuery.=" ('".$val['slip_no']."','".$this->session->userdata('adminbranchlocation')."','','".$CURRENT_TIME."','".$CURRENT_DATE."','".$activites."','".$Detail."','".$CURRENT_DATE."','".$this->session->userdata('useridadmin')."','user','SCHK'),";
			
			}
			
			if(!empty($statusQuery))
			{
				$update_status="insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,code) values".rtrim($statusQuery,',');
				$this->WarehouseManagement_model->InserAndUpdateQry($update_status);
				
			}
			
			foreach($_POST['scanned'] as $key=>$val)
			{
			//$functions->trackPush(trim($val['slip_no']));
			}
			
			echo json_encode($unique_code);  
	}
	

	}
	
	

}