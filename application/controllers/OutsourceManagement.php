<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class OutsourceManagement extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	   $this->load->model('OutsourceManagement_model'); 
    }
   public function showSupplierlist()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->OutsourceManagement_model->getShowsupplier($_POST['searchfield'],$_POST['page_no']); 
		$maniarray=$returnArray['result'];
		 
         foreach($maniarray as $key=>$val)
		{
			$maniarray[$key]['city']=getcitybyid($maniarray[$key]['city']);
        }
$dataArray['pdata']=$_POST ;		
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count'];
		echo json_encode($dataArray);


    }
	
	public function get_delete_supplier()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('deleted'=>'Y');
		 $ReturnData=$this->OutsourceManagement_model->getsupplierdelete($array,$_POST['id']);  
		 echo json_encode($ReturnData);  
	}
	
	public function AddSupplier()
	{
	    $_POST = json_decode(file_get_contents('php://input'), true);
        $supplierArray=$_POST['add_supplier'];	 
                if(!empty($supplierArray['upload_cr']))
			{
			//==========================imageupload===========//
		    $base64string = $supplierArray['upload_cr'];
			$d1='upload_cr'.mktime(date(h),date(i),date(s),date(m),date(d),date(y)); 
            $save_Path='assets/images/'.$d1.'.pdf';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);  
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$upload_cr =  $save_Path.time(). '.pdf';
            file_put_contents($upload_cr, $image_base64);
			
		    
			$return= true;
			}
			else
			{
			$upload_cr="";
			$return= false;
			}
			
			if(!empty($supplierArray['upload_id']))
			{
			//==========================imageupload===========//
		    $base64string = $supplierArray['upload_id'];
			$d2='upload_id'.mktime(date(h),date(i),date(s),date(m),date(d),date(y)); 
            $save_Path='assets/images/'.$d2.'.pdf';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$upload_id =  $save_Path.time(). '.pdf';
            file_put_contents($upload_id, $image_base64);
			
		    
			$return= true;
			}
			else
			{
			$upload_id="";
			$return= false;
			}	
			
			if(!empty($supplierArray['upload_contact']))
			{
			//==========================imageupload===========//
		    $base64string = $supplierArray['upload_contact'];
			$d3='upload_contact'.mktime(date(h),date(i),date(s),date(m),date(d),date(y)); 
            $save_Path='assets/images/'.$d3.'.pdf';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$upload_contact =  $save_Path.time(). '.pdf';
            file_put_contents($upload_contact, $image_base64);
			
			
			$return= true;
			}
			else
			{
			$upload_contact="";
			$return= false; 
			}
					
					$supplierArray=array('name'=>$supplierArray['name'],'mobile'=>$supplierArray['mobile'],
					'city'=>$supplierArray['city'],'vat_no'=>$supplierArray['vat_no'],'rate'=>$supplierArray['rate'],'entry_date'=>$supplierArray['entry_date'],
					'upload_cr'=>$upload_cr,'upload_id'=>$upload_id,'upload_contact'=>$upload_contact);
					//print_r($supplierArray); die();
		            $res_data=$this->OutsourceManagement_model->insertsupplier($supplierArray);
					
			        $return= true;
		               
					   
		 echo json_encode($res_data);  
	}

	public function ShowEditsupplier()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['supid'];
		
		$returnArray=$this->OutsourceManagement_model->Getsupplier_edit($table_id);
	
		 echo json_encode($returnArray);
	}
	
	public function ShowPaymentDetail()
	{
	  $_POST = json_decode(file_get_contents('php://input'), true);
      $table_id=$_POST['id'];
	  
	  $paymentArray1=$this->OutsourceManagement_model->GetPaymentDetails($_POST,$_POST['searchfield']); 
	  $supplierArray=getsupplierbyid($table_id);
	   $paymentArray= $paymentArray1['result'];
	  foreach($paymentArray as $key=>$value)
		{
		//$paymentArray[$key]['rate']=$this->OutsourceManagement_model->GetPaymentDetails($paymentArray[$key]['id']);
		$paymentArray[$key]['supplier']=getsupplierbyid($paymentArray[$key]['supplier_id']);	
		//$paymentArray=$this->OutsourceManagement_model->GetPaymentData($table_id);
		}
		
		$returnArrayR['result']=$paymentArray;
	    $returnArrayR['supplier']=$supplierArray;
      echo json_encode($returnArrayR); 	  
	}

	public function Updateeditsupplier()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);	
		$editsupplierArray=$_POST['edit_supplier'];
		$supid = $editsupplierArray['supid'];
		
		 if(!empty($editsupplierArray['upload_cr']))
			{
			//==========================imageupload===========//
		    $base64string = $editsupplierArray['upload_cr'];
			$d1='upload_cr'.mktime(date(h),date(i),date(s),date(m),date(d),date(y)); 
            $save_Path='assets/images/'.$d1.'.pdf';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);  
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$upload_cr =  $save_Path.time(). '.pdf';
            file_put_contents($upload_cr, $image_base64);
			
		    
			$return= true;
			}
			else
			{
			$upload_cr="";
			$return= false;
			}
			
			if(!empty($editsupplierArray['upload_id']))
			{
			//==========================imageupload===========//
		    $base64string = $editsupplierArray['upload_id'];
			$d2='upload_id'.mktime(date(h),date(i),date(s),date(m),date(d),date(y)); 
            $save_Path='assets/images/'.$d2.'.pdf';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$upload_id =  $save_Path.time(). '.pdf';
            file_put_contents($upload_id, $image_base64);
			
		    
			$return= true;
			}
			else
			{
			$upload_id="";
			$return= false;
			}	
			
			if(!empty($editsupplierArray['upload_contact']))
			{
			//==========================imageupload===========//
		    $base64string = $editsupplierArray['upload_contact'];
			$d3='upload_contact'.mktime(date(h),date(i),date(s),date(m),date(d),date(y)); 
            $save_Path='assets/featured_partner/'.$d3.'.pdf';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$upload_contact =  $save_Path.time(). '.pdf';
            file_put_contents($upload_contact, $image_base64);
			
			
			$return= true;
			}
			else
			{
			$upload_contact="";
			$return= false;
			}
		
					$editsupplierArray=array('name'=>$editsupplierArray['name'],'mobile'=>$editsupplierArray['mobile'],
					'city'=>$editsupplierArray['city'],'vat_no'=>$editsupplierArray['vat_no'],'rate'=>$editsupplierArray['rate'],'entry_date'=>$editsupplierArray['entry_date'],
					'upload_cr'=>$upload_cr,'upload_id'=>$upload_id,'upload_contact'=>$upload_contact);
					//print_r($supplierArray); die();
		            $res_data=$this->OutsourceManagement_model->supplierUpdate($editsupplierArray,$supid);   
			        $return= true;
					
		
		 echo json_encode($res_data);
	}
	
	public function OutCityDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->OutsourceManagement_model->GetCityOutDrop();     
		echo json_encode($returnArray);
	}
	
	public function InvoiceSuppDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->OutsourceManagement_model->GetIvoiceSuppDrop();     
		echo json_encode($returnArray);
	}
	
	
	public function getconfirmPayment()
	{
		
		$_POST = json_decode(file_get_contents('php://input'), true); 
	
		$invoice_no = $_POST['invoice_no']; 
		
		
		$UpdateArray=array('service_pay_status'=> 'Y','services_updated_by'=>$this->session->userdata('user_name'));
		 $res_data=$this->OutsourceManagement_model->UpdateSupplierInvoice($UpdateArray,$invoice_no); 
		
	
		echo json_encode($res_data);
	}
	  
	  
	  
	public function genetate_invoice_supplier()
	{
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 
		 $postArrar=$_POST;
		 $returnStatus=false;   
		if(!empty($_POST['awb_no']))
		{
			// echo"ssss"; die();
			 $uid=$_POST['supplier'];  
			 $supplierdata=$this->OutsourceManagement_model->GetSuppMessage($uid); 
			//print_r($supplierdata); die(); 
			
			 $supplier_rate=$supplierdata['rate'];   
			 $supplier_id=$supplierdata['id'];
			// print_r($supplier_id); die(); 


			 $courierStaffdata=$this->OutsourceManagement_model->GetCouriData($uid);
			//  print_r($courierStaffdata); die(); 
			 $messanger_id=array();
			foreach($courierStaffdata as $key1=>$val1)
			{
			//echo $courierStaffdata[$key1]['cor_id']; exit();
			array_push($messanger_id,$val1);	
			}
			
			$a=trim(' ',$postArrar['awb_no']);

				if($a!='')
				{
				if (strpos($a,PHP_EOL)!== '') {
				$slipData = explode(PHP_EOL,$postArrar['awb_no']);
				}
				else if (strpos($a,',') !== '') {
				$slipData = explode(",",$postArrar['awb_no']);
				}
				}					
				$invoice_present=array();
				$not_belong=array();
				$price_issue=array();
				$success_update=array();
				$code_issue=array();
				$wrong_awb=array();  
				$cod_return_awb=array();
				$cod_deliver_awb=array();
				$cc_awb=array();
				$CURRENT_MONTH=date('n');
				$CURRENT_YEAR=date('Y');
				$CURRENT_TIME=date('H:i:s');
				$insert_values="";
				$shipment_Array = array_unique($slipData);

				//print_r($shipment_Array); die();
				foreach($shipment_Array as $key1=>$val1)
				{
				$insertData=0;
				
				        $shipments=$this->OutsourceManagement_model->fetch_shipments(trim($shipment_Array[$key1]));
					
						//print_r($shipments[0]['messanger_id']); die(); 


				if(!empty($shipments)){  
						$code=$shipments[0]['code'];
						$delivered=$shipments[0]['delivered'];
						$mode=$shipments[0]['mode'];
						$messanger_id1=$shipments[0]['messanger_id']; 
						$slipno=trim($shipments[0]['slip_no']);

						//print_r($messanger_id1);
						//print_r($messanger_id);
						if(!in_array($messanger_id1,$messanger_id))
						{
						  array_push($not_belong,$shipment_Array[$key1]);

						//  echo "HI1";exit(); $returnArray['not_belong']=$not_belong;	
						}
						
						else
    					{
							if( $delivered=="11")
							{
								//echo "HI2";exit();
								$returnStatus=true;    
								$present_in_invoice=$this->OutsourceManagement_model->check_in_invoice(trim($shipment_Array[$key1]));
								
								if(empty($present_in_invoice))
									{
									$t=strtotime($CURRENT_TIME);
											
										$service_charge=$supplier_rate;
									

										$vat=($service_charge)*5/100;
										
										$time=strtotime($shipments[0]['delever_date']);
										$month=date("m",$time);
										$year=date("Y",$time);	
										$CURRENT_DATE=date('Y-m-d H:i:s');
										$receivble_invoice='SUP'.$_REQUEST['supplier'].$month.$year.$t;     

									
										//$insert_values=array('supplier_id'=>$supplier_id,'cor_id'=>$shipments[0]['messanger_id'],'entry_date'=>$shipments[0]['entrydate']); 
		   
										$insert_values="INSERT INTO supplier_invoice(`supplier_id`, `cor_id`, `entry_date`, `close_date`, `awb_no`, `invoice_created_by`, `invoice_created_date`,  `invoice_month`, `invoice_year`,`invoice_no`,charge_val,vat,invoice_date)Values
											('".$supplier_id."','".$shipments[0]['messanger_id']."','".$shipments[0]['entrydate']."','".$shipments[0]['delever_date']."','".$shipments[0]['slip_no']."','".$this->session->userdata('useridadmin')."','".$CURRENT_DATE."','".$month."','".$year."','".$receivble_invoice."','".$service_charge."','".$vat."','".$CURRENT_DATE."')";  

											//print_r($insert_values); die();   


										 $this->OutsourceManagement_model->AddmanifestData($insert_values); 
										array_push($success_update,$shipment_Array[$key1]);
										$returnArray['success_update']=$success_update;
										
									}

									else
									{
										//echo "HI3";exit();
										array_push($invoice_present,$shipment_Array[$key1]); 
										$returnArray['invoice_present']=$invoice_present;
									}

							}
							else
							{
								//echo "HI4";exit();
								array_push($Already_delvrd_return,trim($awb));
								$returnArray['Already_delvrd_return']=$Already_delvrd_return;
							}	
						}
					}
					else{  
						//echo "HI5";exit();
						array_push($wrong_awb,$shipment_Array[$key1]); 
						$returnArray['wrong_awb']=$wrong_awb;
					} 

				/*	if(!empty($insert_values))
					{
							$db_host = 'tamcodb.ctikm53hr4st.us-east-1.rds.amazonaws.com';   //Database Host Name
							$db_user = 'ajoulMaster'; //Database User Name
							$db_password = "Ajouldb118";  //Database password 9WQ086!^)*()_oPH
							$db_name = 'beone_db'; //Database Name
					// Create connection
					$conn = new mysqli($db_host, $db_user, $db_password, $db_name);
					// Check connection
					if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
					} 


					if ($conn->multi_query($insert_values) === TRUE) {
						
						
					
						//echo "New records created successfully";
					} else {
						echo "Error: " . $sql . "<br>" . $conn->error;
						$conn->close();    
					}

					$conn->close();   
						
					}*/
				}
				$return=array('status'=>$returnStatus,'resultarr'=>$returnArray);   
			} 
		 
		else{
			$return=array('status'=>$returnStatus,'resultarr'=>$returnArray);   
			}
		  echo json_encode($return);       
}




}