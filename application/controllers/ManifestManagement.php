<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class ManifestManagement extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	   $this->load->model("ManifestManagement_model");
	   $this->load->helper("utility");
    }
	public function showmanifest()
    {
		 $_POST = json_decode(file_get_contents('php://input'), true);
	    $showmanifest=$this->ManifestManagement_model->getmanifest($_POST);
		$maniarray=$showmanifest['result'];
		 foreach($maniarray as $key=>$value)
	   {
		$base64 = 'data:image/' . $type . ';base64,' . barcodeRuntime($maniarray[$key]['uniqueid']); 
		$maniarray[$key]['barcodeImage']=$base64; 
		if(getLinehoul($maniarray[$key]['line_hule'])!='')
		 $maniarray[$key]['line_hule']=getLinehoul($maniarray[$key]['line_hule']);
		 else
		 $maniarray[$key]['line_hule']="N/A";
		$maniarray[$key]['mfrom']=Get_name_country_by_id('city',$maniarray[$key]['mfrom']);
		$maniarray[$key]['mto']=Get_name_country_by_id('city',$maniarray[$key]['mto']);
		
		$maniarray[$key]['mtotal_Yes']=getTotal_menifest($maniarray[$key]['uniqueid'],'Y');
		$maniarray[$key]['mtotal_NO']=getTotal_menifest($maniarray[$key]['uniqueid'],'N');
		}
	  
        $dataArray['result']=$maniarray;  
         $dataArray['count']=$showmanifest['count']; 
		 
	    echo json_encode($dataArray);
	}
	
	public function getOriginDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$citydrop=$this->ManifestManagement_model->getOriginDropData();
		$returnArray['type']=$this->session->userdata('adminusertype');     
		$returnArray['citydrop']=$citydrop;
		echo json_encode($returnArray);   
	}
	
	 
	public function GetCityDrop()
	  {
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->ManifestManagement_model->DataCityDrop($_POST);
        echo json_encode($returnArray);	 	
	  }
	 public function get_delete_manifest()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('deleted'=>'Y');  
		 $ReturnData=$this->ManifestManagement_model->getmanifestupdate($array,$_POST['uniqueid']);   
		 echo json_encode($ReturnData); 
	}
	
	public function returnmanifest()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $retuenArray=$this->ManifestManagement_model->getreturnmanifest($_POST);
		$newretuenArray=$retuenArray['result'];
		foreach($newretuenArray as $key=>$value)
		{
			$newretuenArray[$key]['sender_city']=Get_name_country_by_id('city',$newretuenArray[$key]['sender_city']); 
		    $newretuenArray[$key]['reciever_city']=Get_name_country_by_id('city',$newretuenArray[$key]['reciever_city']);
		}
		$dataArray['CustomerDrop']=GetcustomerDropdata();
		$dataArray['CityDrop']=getAllDestination();
		 
	     $dataArray['result']=$newretuenArray; 
         $dataArray['count']=$retuenArray['count'];  
		echo json_encode($dataArray);     
    }
	
	public function GetCUstomerDropShow()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$return=GetcustomerDropdata();
		echo json_encode($return);  
	}
	
	public function GetbulkManifestUpdate()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		
		
		if(empty($_POST['awb_no']))
		{
			$returnArr['abw_no']="awb no is required";
		
		        echo json_encode($returnArr); die; 
		}
		
		if($_POST['return']=='N')
		{
			if(empty($_POST['mfrom']))
			{
					$returnArr['mfrom']="from ciy is required";
		
		        echo json_encode($returnArr); die; 
			}
			if(empty($_POST['mto']))
			{
					$returnArr['mto']="To ciy is required";
		
		        echo json_encode($returnArr); die;
			}
		}
		else
		{
			if(empty($_POST['user_name']))
			{
					$returnArr['user_name']="customer name is required";
		
		        echo json_encode($returnArr); die; 
			}
		}
		
			$slipData = preg_split('/\s+/', trim($_POST['awb_no']));
			//print_r($parts);exit;
			$awbData=array();
            $deliverd_awb=array();
             $wrong_cust=array();
			 $returnArr=array();
			foreach($slipData as $sliploop)
					{
					array_push($awbData,"'".trim($sliploop)."'"); 
					}
           $awbData=implode(",",$awbData);
		   
		   //echo $_POST['mfrom'];
		   if(!empty($_POST['mfrom']))
		   {
			   $orig=$_POST['mfrom'];
		   }
		   else{
			$orig=$this->session->userdata('adminbranchlocation');
		   }
		 
		  // print_r($this->session->userdata('adminbranchlocation'));
			if(!empty($awbData))
			{   $condition='';
				if(!empty($_POST['user_name'])){
					//$condition.=" and cust_id='".$_REQUEST['user_name']."' and refused='YES' ";
				}else{
					 $condition.=" and origin='".$orig."' and destination='".$_POST['mto']."'";
				}
				 $listingQry="select delivered,sender_email,refused,cust_id,sender_phone,slip_no,sender_city,destination,pieces,weight,total_amt,id,messanger_id,booking_id,cust_id,code from shipment where deleted='N' ".$condition." and slip_no In (".$awbData.")"; 
				 $shipmentdata=$this->ManifestManagement_model->GetselectQry($listingQry);
				
			
			// print_r($_REQUEST).'<br>';exit;
				$unique_code=get_unique_code();
		
				//echo 'fasfas';exit;
				$num=count($_POST['menifest_id']);
				
				
				$CURRENT_DATE=date("Y-m-d H:i:s");
				$CURRENT_TIME=date("H:i");
			
			
				if(!empty($shipmentdata))
				{	
                       $shipmentdata=$shipmentdata;
						$filename = $_POST['driver_name'].'-'.date('His').'-'.$_FILES["uploadedfile"]["name"];
	  
						move_uploaded_file($_FILES["uploadedfile"]["tmp_name"], "iquama_copy/" . $filename);
					foreach($shipmentdata as $check=>$val)
					{ 
                         if($shipmentdata[$check]['code']=='SH' || $shipmentdata[$check]['code']=='RI')
                        {
                            
						if($_POST['return']=='N')
					  {
									
							$add_menifest="insert into menifest (uniqueid, mfrom, mto,mdate, shipper,  awbillno, destination, pcs, weight, amount, shipment_id,messanger_id,line_hule,driver_name,plate_number,iquma_copy,driver_mobile) values ('".$unique_code."', ".$orig.", '".$_POST['mto']."', '".$CURRENT_DATE."', '".$shipmentdata[$check]['sender_name']."', '".$shipmentdata[$check]['slip_no']."', '".$shipmentdata[$check]['destination']."','".$shipmentdata[$check]['pieces']."','".$shipmentdata[$check]['weight']."','".$shipmentdata[$check]['total_amt']."', '".$shipmentdata[$check]['id']."','".$_POST['messanger_id']."','".$_POST['line_hule']."','".$_POST['driver_name']."','".$_POST['plate_number']."','".$filename."','".$_POST['driver_mobile']."')"; 
						$this->ManifestManagement_model->GetUpdateQry($add_menifest);
							
							$shipupdate="update shipment set in_meni='Y',delivered='8',code='DTH',menifest_location='".$_POST['line_hule']."' where id='".$shipmentdata[$check]['id']."'";
							$this->ManifestManagement_model->GetUpdateQry($shipupdate);
							$Activites="Dispatch to Hub";
						$Detail="Shipment Dispatch to ".getcitybyid(mysql_real_escape_string($_POST['mto']))." under manifest#".$unique_code;	
						$message="Shipment Dispatch to Hub under manifest #".$unique_code;	
					
							
							
							 $update_status="insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,code) values ('".$shipmentdata[$check]['slip_no']."','".$this->session->userdata('adminbranchlocation')."','8','".$CURRENT_TIME."','".$CURRENT_DATE."','".$Activites."','".$Detail."','".$CURRENT_DATE."','".$this->session->userdata('useridadmin')."','user','FTH')";
							$this->ManifestManagement_model->GetUpdateQry($update_status);
                            $details=$Detail;
				            $code='FTH';
							
					}
                        else{
                            
                           if($shipmentdata[$check]['cust_id']!=$_POST['user_name']) 
                           {
                              ///array_push($wrong_cust,trim($shipmentdata[$check]['slip_no']));
							  $returnArr['wrong_cust'][]=	trim($shipmentdata[$check]['slip_no']); 
                           }
                            elseif($shipmentdata[$check]['refused']!="YES") 
                           {
                             // array_push($refused_awb,trim($shipmentdata[$check]['slip_no']));
							  $returnArr['refused_awb'][]=	trim($shipmentdata[$check]['slip_no']); 	 
                           }
                            else
                            {
                                
						$add_menifest="insert into menifest (uniqueid, mfrom, mto,mdate, shipper,  awbillno, destination, pcs, weight, amount, shipment_id,messanger_id,line_hule,driver_name,plate_number,iquma_copy,driver_mobile,return_menifest) values ('".$unique_code."', ".$orig.", '".$shipmentdata[$check]['sender_city']."', '".$CURRENT_DATE."', '".$shipmentdata[$check]['sender_name']."', '".$shipmentdata[$check]['slip_no']."', '".$shipmentdata[$check]['destination']."','".$shipmentdata[$check]['pieces']."','".$shipmentdata[$check]['weight']."','".$shipmentdata[$check]['total_amt']."', '".$shipmentdata[$check]['id']."','".$_POST['messanger_id']."','".$_POST['line_hule']."','".$_POST['driver_name']."','".$_POST['plate_number']."','".$filename."','".$_POST['driver_mobile']."','Y')"; 
						$this->ManifestManagement_model->GetUpdateQry($add_menifest);
							
							$shipupdate="update shipment set in_meni='Y',delivered='8',code='FTH',menifest_location='".$_POST['line_hule']."' where id='".$shipmentdata[$check]['id']."'";
							$this->ManifestManagement_model->GetUpdateQry($shipupdate);
						
					
							
							//$Activites="Shipment Dispatch";
                            $Activites="Ready to return to shipper";							
							$Detail	="Shipment ready to return under manifest #".$unique_code;
						    $message="Shipment ready to return under manifest #".$unique_code;	
					
							 $update_status="insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,code) values ('".$shipmentdata[$check]['slip_no']."','".$this->session->userdata('adminbranchlocation')."','8','".$CURRENT_TIME."','".$CURRENT_DATE."','".$Activites."','".$Detail."','".$CURRENT_DATE."','".$this->session->userdata('useridadmin')."','user','FTH')";
							$this->ManifestManagement_model->GetUpdateQry($update_status);
                            $details=$Detail;
				            $code='FTH';
                           }
					}
				
				
			      	$booking_id=$shipmentdata[$check]['booking_id'];


					// array_push($menifest_awbs,trim($shipmentdata[$check]['slip_no']));	
					 $returnArr['menifest_awbs'][]=	trim($shipmentdata[$check]['slip_no']);	
						} else
                        {
                       // array_push($deliverd_awb,trim($shipmentdata[$check]['slip_no']));	
						$returnArr['deliverd_awb'][]=	trim($shipmentdata[$check]['slip_no']);	            

                        }
                    }
               
					
					
					
				}
				else
				{
				$returnArr['abw_no']="please enter valid awb no.";	
				}
			}
			else
			$returnArr['abw_no']="awb no is required";
		
		echo json_encode($returnArr);  
	}
	
	public function GetupdatemanifestChekData()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$shipmentIDS=$_POST;
			$unique_code=get_unique_code();
		    $num=count($shipmentIDS);
			if($num>0)
			{
				$CURRENT_DATE=date("Y-m-d H:i:s");
				$CURRENT_TIME=date("H:i");
				foreach($shipmentIDS as $shipID)
				{
					
					$shipmentdata=$this->ManifestManagement_model->Getallshipmentdataaddmanifest($shipID);
					
					
				  $add_menifest="insert into menifest (uniqueid, mfrom, mto,mdate, shipper,  awbillno, destination, pcs, weight, amount, shipment_id,messanger_id,return_menifest) values ('".$unique_code."', '".$shipmentdata[0]['destination']."', '".$shipmentdata[0]['origin']."', '".$CURRENT_DATE."', '".$shipmentdata[0]['sender_name']."', '".$shipmentdata[0]['slip_no']."', '".$shipmentdata[0]['destination']."','".$shipmentdata[0]['pieces']."','".$shipmentdata[0]['weight']."','".$shipmentdata[0]['total_amt']."', '".$shipmentdata[0]['id']."','".$_REQUEST['messanger_id']."','Y')";
				$this->ManifestManagement_model->AddmanifestData($add_menifest);
					
					 $shipupdate="update shipment set in_meni='Y',schedule_status='N',schedule_type='',delivered='8',code='DTC', menifest_location='".$shipmentdata[0]['destination']."' where id='".$shipmentdata[0]['id']."'";
					 $this->ManifestManagement_model->updateAddmanifestTime($shipupdate);
					
						$Activites="Dispatch to client";
						
						$detail	="Shipment Dispatch to client under manifest #".$unique_code;
						$message="Shipment Dispatch to client under manifest #".$unique_code;	
					
					 $update_status="insert into status(slip_no,new_location,new_status,pickup_time,pickup_date,Activites,Details,entry_date,user_id,user_type,code) values ('".$shipmentdata[0]['slip_no']."','".$this->session->userdata('adminbranchlocation')."','8','".$CURRENT_TIME."','".$CURRENT_DATE."','".$Activites."','".$detail."','".$CURRENT_DATE."','".$this->session->userdata('useridadmin')."','user','DTC')"; 
					
					 $custid=$shipmentdata[0]['cust_id'];
                    GetAllclientLogUpdates(1,'in_transit',$custid);
					
					GetAllclientLogUpdates_stutusCat(1,'dispatch_client',$custid);
					
					 $this->ManifestManagement_model->AddManifestStatusdata($update_status);
					
					$details=$message;
					$code='DTC';
				    $booking_id=$shipmentdata[0]['booking_id'];
							$cust_id=$shipmentdata[0]['cust_id'];
							$origin=$shipmentdata[0]['origin'];
							$destination=$shipmentdata[0]['destination'];
							$from_zone=Get_name_country_by_id('zone_id',$shipmentdata[0]['origin']);	
						 	$to_zone=Get_name_country_by_id('zone_id',$shipmentdata[0]['destination']);	
						
						   {
						
							$select_destination=$default_country;
							$select_origin=$default_country;
							$ratesdata= $this->ManifestManagement_model->ZonesratesDataqry($from_zone,$to_zone,$cust_id);	
							$ratescount1=count($ratesdata);
							if(!empty($ratesdata))
							{
							
							$count=($ratescount1)-1;	
							
							if($ratesdata[0]['price']<=0)
							{
							unset($ratesdata);
							$ratesdata= $this->ManifestManagement_model->ZonesratesDataqry($from_zone,$to_zone,0);	
							$count=(count($ratesdata))-1;	
							
							}
						
							}
							else
							{
							$ratesdata= $this->ManifestManagement_model->ZonesratesDataqry($from_zone,$to_zone,0);	
							$count=(count($ratesdata))-1;	
							}
						}
			
			
			
			
			$update_status_r="update shipment set delivered='8',code='FTH', refused='NO',schedule_status='N',schedule_type='',cod_fees='".$ratesdata[0]['return_fees']."' where slip_no='".$shipmentdata[0]['slip_no']."'"; 
			$this->ManifestManagement_model->AddmanifestData($update_status_r);	 							
				
				}
				$return= true;
				     $auto_bar_id=$unique_code;
				
						$d1=mktime(date(h),date(i),date(s),date(m),date(d),date(Y));
						$path="assets/128barcode_image/".$d1.'.jpeg';
						$genreate_barcode_image=Bar_code_genreter($auto_bar_id,$path);	
						move_uploaded_file( $genreate_barcode_image,$path);
						$uploaded_file=$d1.'.jpeg';
						$update_bar_code="update menifest set manfist_bar_img='".$uploaded_file."',manfist_bar_code='".$auto_bar_id."' where uniqueid='".$unique_code."'";	
						$this->ManifestManagement_model->AddmanifestData($update_bar_code);	 		
				
			}
			else
			$return= false;
				
				
				
				
			
				
		
		echo json_encode($return);
	}
	public function update_date()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataArray=$_POST['update_date'];
		 $upstatus=false;
		 if(!empty($dataArray['awb_no']))
	      {
				$CURRENT_TIME=date('H:i:s');
				$CURRENT_DATE=date('Y-m-d H:i:s');
				$success_update=array();
				$wrong_awb=array();
				if($dataArray['awb_no']!='')	
				{
				  $slipData = preg_split('/\s+/', trim($dataArray['awb_no']));
				 $slipData =array_unique($slipData);
				  if(!empty($slipData))
				  {
					$awbData=array();
					$wrong_awb=array();
					$onholdArray=array();
					foreach($slipData as $awb)
					{
					  $FetchSlip=$this->ManifestManagement_model->ShipmetupdateQryData($awb);	
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
					 $update_data="update shipment set req_delevery_time='".$time."'  where  slip_no ='".trim($awb)."'"; 
					 $this->ManifestManagement_model->AddmanifestData($update_data);	
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
	 
	 public function add_com()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataArray=$_POST['add_com'];
		 
		 $add_comArray=array('name'=>$dataArray['comp_name']);
		 
         $res_data=$this->ManifestManagement_model->update_com($add_comArray);
		 
		 echo json_encode($res_data);
	 }
	 
	 public function get_comp()
    {
	    $_POST = json_decode(file_get_contents('php://input'), true);
	    $retuenArray=$this->ManifestManagement_model->get_com();
		echo json_encode($retuenArray);
    }
	
	public function get_edit_com_1()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		 $ReturnData=$this->ManifestManagement_model->geteditDataQuery($_POST);  
		 echo json_encode($ReturnData); 
	} 
	 
	 public function get_delete_update()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('deleted'=>'Y');
		 $ReturnData=$this->ManifestManagement_model->getupdatedelete($array,$_POST['id']);  
		 echo json_encode($ReturnData); 
	}
	
	 public function edit_comform()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
         $dataArray=$_POST['comp_name'];
		 $editid = $dataArray['id']; 
         $edit_compidArray=array('name'=>$dataArray['name']); 
         $res_data=$this->ManifestManagement_model->comUpdate($edit_compidArray,$editid); 	
          echo json_encode($res_data);	  	 
	 }
	 
	 public function getTransitTime()
	 {
		 
		$_POST = json_decode(file_get_contents('php://input'), true);
         $ReturnData=$this->ManifestManagement_model->gettransit($_POST);  	
		 echo json_encode($ReturnData); 
	 }
	 
	 
	 public function getTransitTime_update()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $updateArray=array($_POST['field']=>$_POST['val']);
		 $return=$this->ManifestManagement_model->getTransitTime_updateQry($updateArray,$_POST['id']);  	
		  echo json_encode($return); 
	 }
	 //==========Line Haul Popup Data=========/// 
	 public function get_uniqueid()
	 {
		 
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['uniqueid'];
		$ReturnData=$this->ManifestManagement_model->getuniqueidData($table_id);
		$ReturnData['line_hule']=getLinehoul($ReturnData['line_hule']);
		$return['detailsArr']=$ReturnData;
		$return['lineHaleDrop']=line_hule();
        echo json_encode($return);		
	 }
	 
	 public function GetUpdateshowlineDataProcess()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataArray=$_POST;
		 
		// print_r($dataArray); die;
		 if(!empty($dataArray['image']))
			{
			//==========================imageupload===========//
		    $base64string = $dataArray['image'];
            $save_Path='assets/iquama_copy/';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$imgpath = $save_Path.time(). '.png';
			file_put_contents($imgpath, $image_base64);
			
			}
			
			if(!empty($imgpath))
			{
             $mData= $this->ManifestManagement_model->GetupdatelineManifestData($dataArray['uniqueid']);  
           
            $mfrom=Get_name_country_by_id('zone_id',$mData['mfrom']); 
            $mTo=Get_name_country_by_id('zone_id',$mData['mto']); 
              
            $Param['zone_to']=  $mTo;
            $Param['zone_from']=  $mfrom;        
            $Param['lid']=  $dataArray['line_hule'];
            //print_r( $Param);
               $rData= transist_time($Param);
                $ThatTime =$rData['cutoff'];
               // echo $imgpath; die;
                if(strtotime($ThatTime)>=time()) {
               $days=$rData['day'];    
                $expactedDate=date('Y-m-d', strtotime('+'.$days.' days'));
                }
                else
                {
                $days=$rData['day']+1;    
                $expactedDate=date('Y-m-d', strtotime('+'.$days.' days'));
                }
			  $return=$this->ManifestManagement_model->GetupdateManifestShipmentQry($dataArray,$imgpath,$expactedDate); 
		
			}
			else
			$return= false;
			
		  echo json_encode($return);	
	 }
	 
	 public function view_manifest() 
	 {
		$_POST = json_decode(file_get_contents('php://input'), true);
        $ReturnData=$this->ManifestManagement_model->getViewData($_POST);
		$newReturnData=$ReturnData;
		foreach($newReturnData as $key=>$value)
		{
			$newReturnData[$key]['origin']=Get_name_country_by_id('city',$value['origin']);
			$newReturnData[$key]['destination']=Get_name_country_by_id('city',$value['destination']);
			if($value['arrived']=='Y')
			$newReturnData[$key]['arrived']='Yes';
			else
			$newReturnData[$key]['arrived']='No';
		}
		echo json_encode($newReturnData);
	 }
	 
	  public function not_found() 
	 {
		$_POST = json_decode(file_get_contents('php://input'), true);
        $ReturnData=$this->ManifestManagement_model->getNotfoundData($_POST);
		$newReturnData=$ReturnData;
		foreach($newReturnData as $key=>$value)
		{
			$newReturnData[$key]['origin']=Get_name_country_by_id('city',$value['origin']);
			$newReturnData[$key]['destination']=Get_name_country_by_id('city',$value['destination']);
			if($value['arrived']=='Y')
			$newReturnData[$key]['arrived']='Yes';
			else
			$newReturnData[$key]['arrived']='No';
		}
		echo json_encode($newReturnData);
	 }
	 
	 public function ShipmentListForManifest()
	 {
		$_POST = json_decode(file_get_contents('php://input'), true);
		// echo json_encode($_POST); die;
	    $slipArray=array_unique($_POST['slip_array']);	
	    $countAray=count($slipArray);	
		$uniqueid=$_POST['uniqueid']; 
		$staus_id=$_POST['staus_id']; 
		$success=false;   
		
		  $citydata=$this->ManifestManagement_model->GetshipmentrowCount($_POST);
		//print_r($citydata); die();   
		   $count_rows=count($citydata);
			if($countAray==$count_rows){
				$success=true; 
		         $this->ManifestManagement_model->active_menifestUpdate($_POST);   
					
					$CURRENT_DATE=date("Y-m-d");
					$CURRENT_TIME=date("H:i");       
					$CURRENT_DATE_TIME=date("Y-m-d H:i:s");   
					$shipment_data=$this->ManifestManagement_model->shipment_data_Qry($_POST);	
					
						foreach($shipment_data as $key=>$val)
						{
							$custid=Getuser_id($shipment_data[$key]['awbillno']);
							if($_POST['return']=='Y')
							{
									$Activites="Return To Shipper ";
									$message="Return To Shipper   #".$uniqueid;
									$status='6';
									$location=$shipment_data[$key]['mfrom'];
									$code='RTC  ';
									$Deliver_date=",delever_date='".$CURRENT_DATE_TIME."'";
									
                                 GetAllclientLogUpdates(1,'returned',$custid);
							}
							else
							{
								GetAllclientLogUpdates(1,'in_transit',$custid);
								$Activites="Arrival To  Delivery Station"; //." at ".$functions->get_city_namee($shipment_data[$key]['mto'])." "
								$message="your shipment is Forward / Arrival at  ".getcitybyid($shipment_data[$key]['mto'])."  ";
								$status='8';
								$location=$shipment_data[$key]['mto'];
								$code='ADS';
			                   $number=$fetchData[0]['reciever_phone'];
							   $result=$this->ManifestManagement_model->reciever_phoneQry($_POST['single_slip_no']);
							   $r_phone=$result['reciever_phone'];
							   $message = $_POST['single_slip_no'];
							   SEND_SMS($r_phone,$message);
							}
							$query_data_dateArr=array('slip_no'=>$shipment_data[$key]['awbillno'],'new_location'=>$this->session->userdata('adminbranchlocation'),'new_status'=>$status,'pickup_time'=>$CURRENT_TIME,'pickup_date'=>date('Y-m-d H:i:s'),'Activites'=>$Activites,'Details'=>$message,'entry_date'=>date('Y-m-d H:i:s'),'user_id'=>$this->session->userdata('useridadmin'),'user_type'=>'user','code'=>$code);
							
						$booking_id=$shipment_data[$key]['booking_id'];
						$details=$message;

						}
						$this->ManifestManagement_model->ShipmentUpdateQry($code,$status,$Deliver_date,$_POST['single_slip_no']);
						Getupdate_status($query_data_dateArr);
						/*foreach($shipment_data as $key1=>$val1)
						{
						$functions->trackPush(trim($shipment_data[$key1]['awbillno']));
						}*/
			}
			if($count_rows>0)
			{
				
				foreach($citydata as $key=>$val)
				{
					$retrun_valueArr[$key]['slip_no']=$citydata[$key]['slip_no'];
					$retrun_valueArr[$key]['sender_name']=$citydata[$key]['sender_name'];
					$retrun_valueArr[$key]['origin']=getdestinationfieldshow($citydata[$key]['origin'],'city');
					$retrun_valueArr[$key]['destination']=getdestinationfieldshow($citydata[$key]['destination'],'city');
					$retrun_valueArr[$key]['receive']=$citydata[$key]['arrived'];
					
					
					
				}
			}   
			
			
			$return=array('status'=>$success,'retrun_value'=>$retrun_valueArr);
			
			
			   
			
			
	
		 echo json_encode($return);
	 }
	 
	 public function ManifestActive()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $return=$this->ManifestManagement_model->manifestStatusActiveUpdate($_POST);
		 
		 
		 echo json_encode($return);
	 }
	 
	 public function printmanifestView($uniqueid=null)
	 {
		$view['uniqueid']=$uniqueid;
		 $view['data1']=$this->ManifestManagement_model->GetManifestPrntData($uniqueid);
		// $view['totalscaned']=$this->ManifestManagement_model->GetManifestPrntCountData($uniqueid);
		      
		 $this->load->view('printmanifest',$view);  
	 }
	 

}