<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class ScheduleManagement extends CI_Controller {
 function __construct() {
        parent::__construct();
       ///error_reporting(0);
	   $this->load->model('ScheduleManagement_model');
    }
	public function ReasonDrop()
	{
		//$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->ScheduleManagement_model->NotScheduleDrop();     
		echo json_encode($returnArray); exit;
	}


	public function getRootData()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		//$searchText=$_POST['searchText'];
		$returnArray=$this->ScheduleManagement_model->getRootname();     
		echo json_encode($returnArray);
	}


 
    public function NotSchedule1()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);    
		/* $dataArray=$_POST['slip_no']; 
		 $slip_no = $dataArray['slip_no'];
		  $entry_date = date("Y-m-d H:i:s");;
		  
		 
		 $notschedArray=array('sub_category'=>$dataArray['sub_category'],'status_comment'=>$dataArray['status_comment'],'slip_no'=>$dataArray['slip_no']);
		 $notschedArray1=array('code'=>$dataArray['sub_category'],'comment'=>$dataArray['status_comment'],'slip_no'=>$dataArray['slip_no'],'entry_date'=>$entry_date,'Details'=>'Shipment Reschedule','user_id'=>'1','user_type'=>'user');
		 
         $res_data=$this->ScheduleManagement_model->updateNotSched($notschedArray,$slip_no); 
         $res_data=$this->ScheduleManagement_model->insertSched($notschedArray1); 	 	 
		  			   
		 echo json_encode($res_data);  
	 }
	 */
	}
	 	public function NotSchedule()   
	 {
		$_POST = json_decode(file_get_contents('php://input'), true);
		$dataArray=$_POST['notschedArray'];  
		 $upstatus=false;
		 if(!empty($dataArray['slip_no']))
	      {
			  //echo "exit1"; die();
				$CURRENT_TIME=date('H:i:s');
				$CURRENT_DATE=date('Y-m-d H:i:s');
				$success_update=array();
				$wrong_awb=array();
				if($dataArray['slip_no']!='')	
				{
					//echo "exit2"; die();
				  $slipData = preg_split('/\s+/', trim($dataArray['slip_no']));
				 $slipData =array_unique($slipData);
				  if(!empty($slipData))
				  {
					//echo "exit3"; die();
					$awbData=array();
					$wrong_awb=array();
					$onholdArray=array();

					$code=$dataArray['sub_category']; 
					if($code=='NR')
				{
				$temp_id='1';
				$logfieldstatus="not_response";
				}
				if($code=='CMC')
				{
				$temp_id='1';
				$logfieldstatus="mobile_closed";
				}
				if($code=='MOS')
				{
				$temp_id='1';
				$logfieldstatus="mobile_out_services";   
				}
				if($code=='MBT')   
				{
				$temp_id='1';
				$logfieldstatus="mobile_closeds";
				}   
				if($code=='CCL')
				{
				$temp_id='19';
				$logfieldstatus="cust_call_later";
				}
				if($code=='MU')
				{
				$temp_id='1';
				$logfieldstatus="mobile_unreachable";
				}
				if($code=='CT')
				{
				$temp_id='1';
				$logfieldstatus="customer_travling";
				}
				if($code=='CCO' || $code=='RF')
				{
				$temp_id='9';
				$logfieldstatus="cust_cancel_order";
				}
				if($code=='CDAO')
				{
				$temp_id='1';
				$logfieldstatus="cust_don_any_order";
				}
				if($code=='WN')
				{
				$temp_id='1';
				$logfieldstatus="wrong_number";
				}
				if($code=='CSL')
				{
				$temp_id='21';
				$logfieldstatus="cust_share_location_whatsup";
				}


				$sendMessage="select templates from msg_template where id='".$temp_id."'";
				$template=$this->ScheduleManagement_model->dataUpdateAddedQry($sendMessage);

				$counter=0;

					foreach($slipData as $awb)
					{
						//echo "exit4"; die();
						$logcount=$counter+1;
						$call_attempt=0;		
						$refuse=" ";

				
							$FetchSlip=$this->ScheduleManagement_model->shipmentDataByslip($awb);
						//print_r($FetchSlip);exit;
					  if(!empty($FetchSlip))	
					  {		
						//echo "exit5"; die();
					     if($FetchSlip[0]['refused']=='YES')
					      {
							//echo "exit6"; die();
						    array_push($onholdArray,$awb); 
							 $retunArr['onholdArray']=$onholdArray;
						   }
						 else
						 {	
							//echo "exit7"; die();
				    $activity=getActivity($code); 
						  $upstatus=true;;			
							array_push($awbData,"'".trim($awb)."'"); 
							$time = date('Y-m-d');
							$CURRENT_DATE=date("Y-m-d");
							$CURRENT_TIME=date("H:i");

							$req_delevery_time= $FetchSlip[0]['req_delevery_time'];
							if($req_delevery_time!=$CURRENT_DATE)
							{

								$call_attempt=	$FetchSlip[0]['call_attempt']+1;
							}
								
							else
								$call_attempt=	$FetchSlip[0]['call_attempt'];	

                         //echo "exit18"; die();
								if($call_attempt>=3 || $code=='WN' || $code=='CDAO'|| $code=='CCO'   || $code=='MOS'|| $code=='CCR' )
								{
									//echo "exit19"; die();
									if($call_attempt>=3)
									{
										$onholdReason=' On hold Due to call attempt exceed';
									}
										if($code=='WN')
									{
										$onholdReason=' On hold Due to wrong number';
										$logfield="wrong_number";
									}
											if($code=='CDAO')
									{
										$onholdReason=' On hold Due to Customer dont aware any delivery';
										$logfield="cust_don_any_order";
									}
											if($code=='CCO')
									{
										$onholdReason=' On hold Due to Customer cancel the order';
										$logfield="cust_cancel_order";
									}
										if($code=='MOS')
									{
										$onholdReason=' On hold Due to Mobile out of service';
										$logfield="mobile_out_service";
									}
										if($code=='CCR')
									{
										$onholdReason=' Cancelled As per Client Request';
										$logfield="cancelled_client_request";
									}
									
									$entrydate=date("Y-m-d H:i:s");
									$refuse=" , refused='YES',onHold_Reason='".$onholdReason."'";
								

								
									
									$shipmentstatusArray=array('new_location'=>$this->session->userdata('adminbranchlocation'),'new_status'=>$FetchSlip[0]['delivered'],'slip_no'=>trim($awb),'pickup_time'=>$CURRENT_TIME,'pickup_date'=>$CURRENT_DATE,'Activites'=>'On Hold','Details'=>$onholdReason,'comment'=>'','entry_date'=>$CURRENT_DATE,'user_id'=>$this->session->userdata('useridadmin'),'user_type'=>'user','code'=>'OH'); 
					 
									$res_data=$this->ScheduleManagement_model->insertSched($shipmentstatusArray);  

				
									$shipment_up="update shipment set onHold_Date='".$CURRENT_DATE."' $refuse  where  slip_no ='".trim($awb)."'"; 
									$update_status=$this->ScheduleManagement_model->dataUpdateAddedQry($shipment_up);
									
									//print_r($update_status); exit;

								}
								//echo "exit20"; die();
					if($code=='OCA'){
					$refuse=" , refused='YES'";
				}
				if($code=='OCA'){
					$refuse=" , refused='YES'";
				}
				if($code!='OCA'){
					
			//	$destination=Get_city_name($FetchSlip[0]['destination']);
				$number=$FetchSlip[0]['reciever_phone'];
				//$link=$site_url."gml/".encrypt($FetchSlip[0]['id'].'/'.mktime());
				
			 	//$feedbacklink=$site_url."feedback/".encrypt($FetchSlip[0]['id'].'/'.mktime()); 
				
				// $dataVal=str_replace('booking_id',$awb,$template['templates']);
				// $dataVal=str_replace('Link',$link,$dataVal);
				// $dataVal=str_replace('Location',$destination,$dataVal);
				// $dataVal=str_replace('number','920003464',$dataVal);
				// $dataVal=str_replace('driver_name',$driver_name,$dataVal);
				// $dataVal=str_replace('sender',$FetchSlip[0]['reciever_name'],$dataVal);
				// $dataVal=str_replace('shipper',$FetchSlip[0]['sender_name'],$dataVal);
				// $dataVal=str_replace('New_feedback_link',$feedbacklink,$dataVal);  
				// 	$dataVal; 	
		
					//echo "exit22"; die();
		
				$CURRENT_DATE=date("Y-m-d H:i:s");
				$entrydate=date("Y-m-d H:i:s");
				$status_details_up="SMS Sent To Customer sucessfully. Mobile No: ".$FetchSlip[0]['reciever_phone'];;
				$update_status="insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,code,comment) values ('".$FetchSlip[0]['slip_no']."','".$this->session->userdata['adminbranchlocation']."','".$FetchSlip[0]['delivered']."','".$data['CURRENT_TIME']."','".$entrydate."','SMS to receiver','$status_details_up','".$entrydate."','".$this->session->userdata['useridadmin']."','user','SMS','".mysql_real_escape_string($dataVal)."')";

				$update_status_cus=$this->ScheduleManagement_model->dataUpdateAddedQry($update_status);
					//print_r($update_status_cus); echo '22'; exit; 
				//$custid=$functions->Getuser_id($FetchSlip[0]['slip_no']);
				//$functions->GetAllclientLogUpdates_stutusCat(1,'out_cove_area',$custid);
                //$functions->GetAllclientLogUpdates($logcount,'hold_for_pickup',$custid);

			//SEND_SMS($number,$dataVal);
				}
				else{}

				  $update_data="update shipment set schedule_status='N',schedule_type='',req_delevery_time='".date('Y-m-d')."',call_attempt='".$call_attempt."'  , req_delevery_time='".$CURRENT_DATE."'  ".$refuse." where  (slip_no ='".trim($awb)."' or booking_id='".$awb."')"; 
			  $update_data1=$this->ScheduleManagement_model->dataUpdateAddedQry($update_data);

			
			   $update_status="insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,comment,code) values ('".$FetchSlip[0]['slip_no']."','".$this->session->userdata['adminbranchlocation']."','16','".$CURRENT_TIME."','".$CURRENT_DATE."','".$activity."','Shipment Not  Scheduled By CSA','".$CURRENT_DATE."','".$this->session->userdata['useridadmin']."','user','".$dataArray['comment']."','".$code."')"; 
			 
				$update_status1=$this->ScheduleManagement_model->dataUpdateAddedQry($update_status);


				//$custid=Getuser_id($FetchSlip[0]['slip_no']);
				//$functions->GetAllclientLogUpdates_stutusCat(1,$logfieldstatus,$custid);			
		   	$update_data = "update assigning_shipment set reason='".$code."',comment='".$dataArray['comment']."',schedule_status='N' where  slip_no ='" . trim($awb) . "' and deleted='N'";
				$update_data1=$this->ScheduleManagement_model->dataUpdateAddedQry($update_data);

				     array_push($success_update,trim($awb));
					 $retunArr['success_update']=$success_update;
						}
					 
					
		
					}
					 else
					{
						array_push($wrong_awb,trim($awb));
						$retunArr['wrong_awb']=$wrong_awb;  
					}
			      }
						
				
			}
		}
	
					
		}			
		$return=array('status'=>$upstatus,'retunArr'=>$retunArr);
				
				
				//$res_data=$this->ManifestManagement_model->updateawb($update_dateArray);
	
				echo json_encode($return);        
	 }  

	
	 public function ScheduleUpdate()   
	 { 
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataArray=$_POST['scheduledArray'];
		//print_r($_POST);exit();
		 /*$driverData=explode('/',$dataArray['nrd']);
		 $driver_rout	=	$driverData[0];
		 $driver_name	=	$driverData[1];
		 $driver_id      =   $driverData[2];*/
     
		 $upstatus=false;
		 if(!empty($dataArray['slip_no']))
	      {
				$CURRENT_TIME=date('H:i:s');
				$CURRENT_DATE=date('Y-m-d H:i:s');
				$success_update=array();
				$wrong_awb=array();
				if($dataArray['slip_no']!='')	
				{
				  $slipData = preg_split('/\s+/', trim($dataArray['slip_no']));
				 $slipData =array_unique($slipData);
				  if(!empty($slipData))
				  {
					$awbData=array();
					$wrong_awb=array();
					$onholdArray=array();
					foreach($slipData as $awb)
					{
					  $FetchSlip=$this->ScheduleManagement_model->ShipmetupdateQryData($awb);	
					// print_r($FetchSlip);
					  if(!empty($FetchSlip))	
					  {		
						if($FetchSlip[0]['delivered']!=11)
					    {
					 
					     if($FetchSlip[0]['refused']=='YES')
					      {
						    array_push($onholdArray,$awb); 
							 $retunArr['onholdArray']=$onholdArray;
						   }
						 else
						 {	
						  $upstatus=true;;			
							array_push($awbData,"'".trim($awb)."'"); 
							$time = strtotime($dataArray['schedule_date']);

							$req_delevery_time=$FetchSlip[0]['req_delevery_time'];
							$call_attempt=0;
							
							if($req_delevery_time!=date('Y-m-d'))
							$call_attempt=	$FetchSlip[0]['call_attempt']+1;
							else
							$call_attempt=	$FetchSlip[0]['call_attempt'];	
							if($call_attempt>=3)
							$refuse=" , refused='YES'";
							else
							$refuse='';
							$newformat = date('Y-m-d',$time); 

							

							if($dataArray['schedule_type']=='CSA')
							{
								$lat_lang=explode(',',$dataArray['dest_lng']);
								
								$lng		=	 $lat_lang[1]; 
								$lat		=	 $lat_lang[0]; 
								
								//echo $selectRout="SELECT id FROM `root` WHERE `route` LIKE '%".($dataArray['area'])."%'"; exit;
								//echo 'here10'; 
								 $RoutData=$this->ScheduleManagement_model->checkRoute($dataArray['area']); //die();
								// exit('here9');
								if(!empty($RoutData))
								{
								//exit('here8');
									$corides=$this->ScheduleManagement_model->selectCourier($RoutData[0]['id']);	

									if(count($corides)>0)  
									{
										foreach($corides as $ids=>$val)
										$allCor_ids.=$corides[$ids]['cor_id'].',';
										$allCor_ids=trim($allCor_ids,',');
								
									$messangerData=$this->ScheduleManagement_model->getMessangerName($allCor_ids);
									} 

								//print_r($messangerData); die();
								$messanger_id= $messangerData['cor_id']; 
								if(!empty($messanger_id)) 
								$driver_id=$messanger_id;
								}
								else
								$driver_id=0;	

								
												
										$area_street=$dataArray['area_street'];
										$area=$dataArray['area'];
										$code='CSS';
										//echo 'here0';exit;	
							}

							//echo 'here1';exit;
							$customerdataArray=array('time_slot'=>$dataArray['time_slot'],'schedule_status'=>'Y','schedule_type'=>$dataArray['schedule_type'],'call_attempt'=>$call_attempt,'messanger_id'=>$driver_id,'schedule_date'=>date('Y-m-d',strtotime($dataArray['schedule_date'])),'area_street'=>$dataArray['area'],'dest_lng'=>$lng,'dest_lat'=>$lat,'code'=>"CSA");


					
							 $updatestatus=$this->ScheduleManagement_model->updateShip($customerdataArray,$FetchSlip[0]['slip_no']);
							$CURRENT_DATE=date("Y-m-d H:i:s");   
							$CURRENT_TIME=date("H:i");

							$activity="Shipment  Scheduled By ". $this->session->userdata('user_name');
							$update_status=array('slip_no'=>$FetchSlip[0]['slip_no'],'new_location'=>$this->session->userdata('adminbranchlocation'),'new_status'=>'Scheduled','pickup_time'=>$CURRENT_TIME,'pickup_date'=>$CURRENT_DATE,'Activites'=>"Delivery Location:$area",'Details'=>$activity,'entry_date'=>$CURRENT_DATE,'user_id'=>$this->session->userdata('useridadmin'),'comment'=>'','code'=>$code);
//print_r($this->session);
							$this->ScheduleManagement_model->insertSched($update_status);  
					
							

							$maintainHistory=array('awb_no'=>$FetchSlip[0]['slip_no'],'lat'=>$lat,'lang'=>$lng,'update_date'=>date('Y-m-d',strtotime($dataArray['schedule_date'])),'update_time'=>$dataArray['time_slot'],'area_street'=>$area_street,'area'=>$area,'schedule_type'=>$code,'type'=>'user','user_id'=>$this->session->userdata('useridadmin'));

						 	$this->ScheduleManagement_model->insertHistory($maintainHistory); 



							array_push($success_update,trim($awb));
							$retunArr['success_update']=$success_update;
											
							}

							  
							if($dataArray['schedule_type']=='CSA')
							{
								$lat_lang=explode(',',$dataArray['dest_lng']);
								$lng		=	 $lat_lang[1]; 
								$lat		=	 $lat_lang[0];  

								$update_data=array('messanger_id'=>$driver_id,'schedule_date'=>$dataArray['schedule_date'],'area_street'=>$dataArray['area_street'],'area'=>$dataArray['area'],'dest_lng'=>$lng,'dest_lat'=>$lat,'comment'=>"CSA");


					
							$this->ScheduleManagement_model->updateAssignShip($update_data,$FetchSlip[0]['slip_no']);


							
							}
							
						}
						else
							{
								array_push($Already_delvrd_return,trim($awb));
								$retunArr['Already_delvrd_return']=$Already_delvrd_return;
							}

						}
				
					 else
					{
						array_push($wrong_awb,trim($awb));  
						$retunArr['wrong_awb']=$wrong_awb;
					}
			      }
						
				
			}
		}  
	
					
	}
	
	$return=array('status'=>$upstatus,'retunArr'=>$retunArr);
		 
		 
         //$res_data=$this->ManifestManagement_model->updateawb($update_dateArray);
		 
		 echo json_encode($return);
	 }
	 


	 public function UploadEcelArea()
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
			   
			   
					$old_awb_number = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$shipmentData=$this->ScheduleManagement_model->GetratesImportShipDataQry($old_awb_number);
						 if(!empty($shipmentData))
						   {
							   
							   $area 	=	$worksheet->getCellByColumnAndRow(1, $row)->getValue(); 
							   $channel 	=	$worksheet->getCellByColumnAndRow(2, $row)->getValue(); 
						   
							   if(empty($channel)){ 
								$returnArr['validrows'][]="Channel Is Empty";

							   }else
							   {
								   if(!empty($channel) && ($channel=='CSA' ||$channel=='BLIND' || $channel=='BULK'))
								   {
									$channelcond=" , schedule_type='".$channel."'";
								   }

								   $GetareaDataQry="SELECT id FROM `root` WHERE `route` LIKE '%".mysql_real_escape_string($area)."%'" ;
			
											$RoutData=$this->ScheduleManagement_model->dataUpdateAddedQry($GetareaDataQry);

									   
								   if(!empty($RoutData))
									{
										$selectDriverRouting="SELECT `cor_id` FROM `courier_routing` WHERE rout='".$RoutData['id']."' " ;
			
											$corides=$this->ScheduleManagement_model->dataUpdateAddedQry($selectDriverRouting);


										if(count($corides)>0)  
										{
											foreach($corides as $ids=>$val)
											$allCor_ids.=$corides[$ids]['cor_id'].',';  
											$allCor_ids=trim($allCor_ids,',');
											

											$messangerQry="select cor_id,messenger_name from courier_staff where status='Y' and deleted='N' and cor_id IN (".$allCor_ids.") ORDER BY cor_id asc LIMIT 1" ;
			
											$messangerData=$this->ScheduleManagement_model->dataUpdateAddedQry($messangerQry);

									
										} 
									
									//print_r($messangerData);
									$messanger_id= $messangerData['cor_id']; 
									if(!empty($messanger_id)) 
									$driver_id=$messanger_id;
									} 

									$updatelocation="update shipment set area='".$area."' , messanger_id='".$driver_id."'  where slip_no='".$old_awb_number."' and deleted='N'" ;
			
									$this->ScheduleManagement_model->dataUpdateAddedQry($updatelocation);

									$maintainHistory="update `receiver_location_history` set area='".mysql_real_escape_string($area)."' where awb_no='".$awb."' and area='' ";    
									

									//print_r($messangerData); die();


									$this->ScheduleManagement_model->dataUpdateAddedQry($maintainHistory);         


							   }  
							   
							   
							  
							   $returnArr['validrows'][]="added  awb no ".$old_awb_number."<br>";
						   }
						   else
						   $returnArr['invalidrpows'][]="invalid  awb no ".$old_awb_number."<br>";   
				
		   }
		  }
	   }
	  else
	  $returnArr['fileemtpy'];
	
		
          echo json_encode($returnArr);   
		
		}
   
	 
	 
	public function ScheduleUpdate22()
	 {
		 
		 $_POST = json_decode(file_get_contents('php://input'), true);   
		  $dataArray=$_POST['slip_no'];  
		  $slip_no = $dataArray['slip_no']; 
		  $schedule_type=$dataArray['schedule_type'];    
		  if($schedule_type=="CSA"){
			 $scheduleArray=array('schedule_type'=>$schedule_type,'time_slot'=>$dataArray['time_slot'],'dest_lng'=>$dataArray['dest_lng']
			 ,'area'=>$dataArray['area'],'area_street'=>$dataArray['area_street'],'schedule_date'=>$dataArray['schedule_date'],'slip_no'=>$dataArray['slip_no']); 
		  }else if($schedule_type=="BULK"){
			   $scheduleArray=array('schedule_type'=>$schedule_type,'time_slot'=>$dataArray['time_slot'],'nrd'=>$dataArray['nrd'],'schedule_date'=>$dataArray['schedule_date'],'slip_no'=>$dataArray['slip_no']); 
		  }else{
			   $scheduleArray=array('schedule_type'=>$schedule_type,'time_slot'=>$dataArray['time_slot'],'schedule_date'=>$dataArray['schedule_date'],'slip_no'=>$dataArray['slip_no']); 
		  }

			 
		
		   $res_data=$this->ScheduleManagement_model->updateSched($scheduleArray,$slip_no);   
		 
		 
		 echo json_encode($res_data);
	 }
	 
	 public function BlindSchedule()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->ScheduleManagement_model->BlindScheduleData($_POST['searchfield'],$_POST['page_no']); 
		
		$maniarray=$returnArray['result'];
		
		foreach($maniarray as $key=>$val)
		{
		$maniarray[$key]['destination']=getcityidbyid($maniarray[$key]['destination']); 
		}	
	
		$dataArray['pdata']=$_POST ;  
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count'];
		echo json_encode($dataArray);
    }
	
	public function BlindResheduleUpdate()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
         $dataArray=$_POST['filterData'];
		 $area = $dataArray['area']; 
		 $timeslot = $dataArray['timeslot']; 
		 $schedule_date = $dataArray['schedule_date']; 
		 $slip_no = $dataArray['slip_no'];
		 $address = $dataArray['address'];

		 $address = str_replace(" ", "+", $address);

    $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&key=AIzaSyD5KwJjv1xXU_pmMxonzYdJf_87CLPCfzQ");
    $json = json_decode($json);

    $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
    $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

	
		$bulkArray=array('area'=>$dataArray['area']);
		 
		/* $selectRout="SELECT id FROM `root` WHERE `route` LIKE '%".mysql_real_escape_string($area)."%'";
		 $RoutData= $this->ScheduleManagement_model->AddmanifestData($selectRout);

 if(!empty($RoutData))
 {
	$selectDriverRouting="SELECT `cor_id` FROM `courier_routing` WHERE rout='".$RoutData['id']."'";
	$corides= $this->ScheduleManagement_model->AddmanifestData($selectDriverRouting);
	if(count($corides)>0)
	{
		foreach($corides as $ids=>$val)
		$allCor_ids.=$corides[$ids]['cor_id'].',';
		$allCor_ids=trim($allCor_ids,',');
	$messangerQry="select cor_id,messenger_name from courier_staff where status='Y' and deleted='N' and cor_id IN (".$allCor_ids.") ORDER BY cor_id ASC
LIMIT 1";
$messangerData= $this->ScheduleManagement_model->AddmanifestData($messangerQry);
	} 
 
 //print_r($messangerData);
  $messanger_id= $messangerData['cor_id']; 
 if(!empty($messanger_id)) 
 $driver_id=$messanger_id;
 } 
				$messCond=" , messanger_id='".$driver_id."' ,schedule_date='".$schedule_date."',area_street='".mysql_real_escape_string($area_street)."',area='".mysql_real_escape_string($area)."',dest_lng='".$lng."' , dest_lat='".$lat."'	";		
		
			$updater="Operational Team";	
		//	$area_street='N/A';
			$code='BLI';
			
			
				
			
			 $update_data="update shipment set time_slot='".$timeslot."',schedule_status='Y',schedule_type='BLI'  ".$messCond.$refuse." where  slip_no ='".trim($slip_no)."'"; 
			 $dbh->Query($update_data);
			 $CURRENT_DATE=date("Y-m-d H:i:s");
    		 $CURRENT_TIME=date("H:i");
			   $update_status="insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,comment,code) values ('".$slip_no."','".$this->session->userdata('adminbranchlocation')."','Scheduled','".$CURRENT_TIME."','".$CURRENT_DATE."','Delivery Location:".mysql_real_escape_string($area)."','Shipment  Scheduled By ".$updater."','".$CURRENT_DATE."','".$this->session->userdata('useridadmin')."','user','','".$code."')"; 
			 
		$dbh->Query($update_status); 
		
		$maintainHistory="INSERT INTO `receiver_location_history`( `awb_no`, `lat`, `lang`, `update_date`, `update_time`,area_street,area,schedule_type,type,user_id) VALUES ('".$slip_no."','".$lat."','".$long."','".$schedule_date."','".$timeslot."','".mysql_real_escape_string($area_street)."','".mysql_real_escape_string($area)."','".$code."','user','".$this->session->userdata('useridadmin')."')";   
   
		 $this->ScheduleManagement_model->AddmanifestData($maintainHistory)
 		$return true;*/
        $res_data=$this->ScheduleManagement_model->getscheduleremove($bulkArray,$slip_no); 	
         echo json_encode($res_data);	  	 
	 } 
	 

	
	public function BulkRemove()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataArray=$_POST['removeArray'];
		 $upstatus=false;
		 if(!empty($dataArray['slip_no']))
	      {
				$CURRENT_TIME=date('H:i:s');
				$CURRENT_DATE=date('Y-m-d H:i:s');
				$success_update=array();
				$wrong_awb=array();
				if($dataArray['slip_no']!='')	
				{
				  $slipData = preg_split('/\s+/', trim($dataArray['slip_no']));
				 $slipData =array_unique($slipData);
				  if(!empty($slipData))
				  {
					$awbData=array();
					$wrong_awb=array();
					$onholdArray=array();
					$Already_delvrd_return=array();
					
					foreach($slipData as $awb)
					{
					  $FetchSlip=$this->ScheduleManagement_model->ShipmetupdateQryData($awb);	
					  if(!empty($FetchSlip))	
					  {		
						if($FetchSlip[0]['delivered']!=11)
					    {
					 
					     if($FetchSlip[0]['refused']=='YES')
					      {
						    array_push($onholdArray,$awb); 
							 $retunArr['onholdArray']=$onholdArray; 
						   }
						 else
						 {	
						  $upstatus=true;;			
							array_push($awbData,"'".trim($awb)."'"); 
							$time = date('Y-m-d');
					 $update_data="update shipment set schedule_status='N' ,schedule_type='' where slip_no ='".trim($awb)."'"; 
					 
					 $shipmentstatusArray=array('new_location'=>$this->session->userdata('adminbranchlocation'),'new_status'=>'16','slip_no'=>trim($awb),'pickup_time'=>$CURRENT_TIME,'pickup_date'=>$CURRENT_DATE,'Activites'=>'Not Schedule By CSA','Details'=>'Shipment Not Scheduled by CSA','comment'=>$dataArray['comment'],'entry_date'=>$CURRENT_DATE,'user_id'=>$this->session->userdata('useridadmin'),'user_type'=>'user');
					 
					 
					 $this->ScheduleManagement_model->AddmanifestData($update_data);
					$this->ScheduleManagement_model->insertSched($shipmentstatusArray);  
 
				     array_push($success_update,trim($awb));
					 $retunArr['success_update']=$success_update;
						}
					  }
					  else
					  {
						array_push($Already_delvrd_return,trim($awb));
						$retunArr['Already_delvrd_return']=$Already_delvrd_return;
					  }
					
		
					}
					 else
					{
						array_push($wrong_awb,trim($awb));
						$retunArr['wrong_awb']=$wrong_awb;
					}
			      }
						
				
			}
		}
	
					
	}
	
	$return=array('status'=>$upstatus,'retunArr'=>$retunArr);
		 
		 
         //$res_data=$this->ManifestManagement_model->updateawb($update_dateArray);
		 
		 echo json_encode($return);
	 }
	 
	 
	public function BulkResheduleUpdate()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataArray=$_POST['bulkArray'];
		$schedule_date= $dataArray['schedule_date'];
		 $upstatus=false;
		 if(!empty($dataArray['slip_no']))
	      {
				$CURRENT_TIME=date('H:i:s');
				$CURRENT_DATE=date('Y-m-d H:i:s');
				$success_update=array();
				$wrong_awb=array();
				if($dataArray['slip_no']!='')	
				{
				  $slipData = preg_split('/\s+/', trim($dataArray['slip_no']));
				 $slipData =array_unique($slipData);
				  if(!empty($slipData))
				  {
					$awbData=array();
					$wrong_awb=array();
					$Already_delvrd_return=array();
					$onholdArray=array();
					foreach($slipData as $awb)
					{
					  $FetchSlip=$this->ScheduleManagement_model->ShipmetupdateQryData($awb);	 
					  if(!empty($FetchSlip))	
					  {		
						if($FetchSlip[0]['delivered']!=11)
					    {
					 
					     if($FetchSlip[0]['refused']=='YES')
					      {
						    array_push($onholdArray,$awb); 
							 $retunArr['onholdArray']=$onholdArray; 
						   }
						 else
						 {	
						  $upstatus=true;;			
							array_push($awbData,"'".trim($awb)."'"); 
							$time = date('Y-m-d'); 
					 $update_data="update shipment set schedule_date='".$schedule_date."'  where slip_no ='".trim($awb)."'"; 
					 
					$shipmentstatusArray=array('new_location'=>$this->session->userdata('adminbranchlocation'),'new_status'=>'16','slip_no'=>trim($awb),'pickup_time'=>$CURRENT_TIME,'pickup_date'=>$CURRENT_DATE,'Activites'=>'Recheduled','Details'=>'Shipment rescheduled By','comment'=>'','entry_date'=>$CURRENT_DATE,'user_id'=>$this->session->userdata('useridadmin'),'user_type'=>'user');
					 
					 
					 //print_r($shipmentstatusArray); die();
					 
					 
						$this->ScheduleManagement_model->AddmanifestData($update_data);
						$this->ScheduleManagement_model->insertSched($shipmentstatusArray);  
					
					
					$FetchReceiverHistory=$this->ScheduleManagement_model->receiverLocData($awb);	
					
					 $updateReceiverHistroy="INSERT INTO `receiver_location_history`( `awb_no`, `lat`, `lang`, `update_date`, `update_time`,area_street,area,schedule_type,type,user_id) VALUES ('".$FetchSlip[0]['slip_no']."','".$FetchReceiverHistory['lat']."','".$FetchReceiverHistory['lang']."','".$schedule_date."','".$FetchReceiverHistory['update_time']."','".mysql_real_escape_string($FetchReceiverHistory['area_street'])."','".mysql_real_escape_string($FetchReceiverHistory['area'])."','".$FetchReceiverHistory['schedule_type']."','user','".$this->session->userdata('useridadmin')."')";
					 
					 $this->ScheduleManagement_model->AddReceiverHistory($updateReceiverHistroy);
					 
					 
				     array_push($success_update,trim($awb));
					 $retunArr['success_update']=$success_update;
						}
					  }  
					  else
					  {
						array_push($Already_delvrd_return,trim($awb));
						$retunArr['Already_delvrd_return']=$Already_delvrd_return;
					  }
					
		
					}
					 else
					{
						array_push($wrong_awb,trim($awb));
						$retunArr['wrong_awb']=$wrong_awb;
					}
			      }
						
				
			}
		}
	
					
	}
	$return=array('status'=>$upstatus,'retunArr'=>$retunArr);
		 
		 
         //$res_data=$this->ManifestManagement_model->updateawb($update_dateArray);
		 
		 echo json_encode($return);  
	 }
	 
}