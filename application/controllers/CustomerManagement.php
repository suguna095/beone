<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class CustomerManagement extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	   $this->load->model('CustomerManagement_model');
	   $this->load->helper('utility_helper'); 
    }
    
	public function showCustomerlist()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->CustomerManagement_model->getShowCustomer($_POST['searchfield'],$_POST['page_no']); 
		$maniarray=$returnArray['result'];
		$dataArray['adata']=$_POST ;  
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count'];
		echo json_encode($dataArray);
    }
	
	public function ShowExcelDatalist()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->CustomerManagement_model->GetExcelCustomer($_POST); 
		
		echo json_encode($returnArray);
    }
	
	
	public function GetBookingDetaillist()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
		//$_POST['cusid']=50;page_no
	    $returnArray=$this->CustomerManagement_model->GetBookingDetailQuery($_POST['cusid'],$_POST['page_no']);
		$newreturnArray= $returnArray;
		
		
        foreach($newreturnArray as $key=>$value)
		{
			
		$newreturnArray[$key]['total_collection']=total_collection($value); 
		$newreturnArray[$key]['delivered']=$this->CustomerManagement_model->DeliverdStatus($value['delivered'],$value['code']); 
		
		}
		
		 
		// print_r($returnArrayR); die();  
		echo json_encode($newreturnArray);
    }
	
	/*public function ShowBookingIdDetails()
	{
		$_POST = json_decode(file_get_contents('php://input'), true); 
		$totalofdAray=$this->CustomerManagement_model->gettotalShipmentData($_POST);      
		$returnArray=$totalofdAray['result'];
	foreach($returnArray as $key=>$value) 
		{
	
		$returnArray[$key]['destination']=getdestinationfieldshow($returnArray[$key]['origin'],'city');
		$returnArray[$key]['origin']=getdestinationfieldshow($returnArray[$key]['destination'],'destination');
		$returnArray[$key]['citydata']=status_main_cat($returnArray[$key]['delivered']);
		$returnArray[$key]['totaldata']=$returnArray[$key]['total_cod_amt']+$returnArray[$key]['cod_fees']+$returnArray[$key]['service_charge'];
		}
	
		
		 $returnArrayR['result']=$returnArray;
	echo json_encode($returnArrayR);
	}*/
	
	public function AddCustomer()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);	
		$customerArray=$_POST['customerArray'];
		$city=$customerArray['city'];
		  $branch_location= getidsByNameshow($city);
		$email=$customerArray['email'];
		
			 if(!empty($customerArray['upload_cr']))
			{
			//==========================imageupload===========//
		    $base64string = $customerArray['upload_cr'];
			$d1='upload_cr'.mktime(date(h),date(i),date(s),date(m),date(d),date(y)); 
            $save_Path='assets/pdf_uploads/'.$d1.'';
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
			
			
			if(!empty($customerArray['upload_id']))
			{
			//==========================imageupload===========//
		    $base64string = $customerArray['upload_id'];
			$d2='upload_id'.mktime(date(h),date(i),date(s),date(m),date(d),date(y)); 
            $save_Path='assets/pdf_uploads/'.$d2.'';
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

			if(!empty($customerArray['upload_contact']))
			{
			//==========================imageupload===========//
		    $base64string = $customerArray['upload_contact'];
			$d3='upload_contact'.mktime(date(h),date(i),date(s),date(m),date(d),date(y)); 
            $save_Path='assets/pdf_uploads/'.$d3.'';   
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
			
			  if(!empty($customerArray['cmp_image']))
			{
			//==========================imageupload===========//
		    $base64string = $customerArray['cmp_image'];
            $save_Path='assets/images/';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$cmp_image =  $save_Path.time().'1'. '.png';
            file_put_contents($cmp_image, $image_base64);   
			
		    
			$return= true;
			}
			else
			{
			$cmp_image="";
			$return= false;
			}
			$uniqid=GetUseraccounTiD(); 
			 if($email!=""){
					$returnArray=$this->CustomerManagement_model->CheckEmailExist($email);
				    if($returnArray==0){
				$customerdataArray=array('uniqueid'=>$uniqid,'name'=>$customerArray['name'],'company'=>$customerArray['company'],'address'=>$customerArray['address'],'phone'=>$customerArray['phone'],'bank_name'=>$customerArray['bank_name'],'city'=>$branch_location,'bank_fees'=>$customerArray['bank_fees'],
					'account_number'=>$customerArray['account_number'],'account_manager'=>$customerArray['account_manager'],'managerEmail'=>$customerArray['managerEmail'],'OnHold_Period'=>$customerArray['OnHold_Period'], 
					'managerMobileNo'=>$customerArray['managerMobileNo'],'iban_number'=>$customerArray['iban_number'],'vat_no'=>$customerArray['vat_no'],'entrydate'=>$customerArray['entrydate'],
					'email'=>$customerArray['email'],'password'=>Md5($customerArray['password']),'upload_cr'=>$upload_cr
					,'upload_id'=>$upload_id,'upload_contact'=>$upload_contact,'cmp_image'=>$cmp_image,'VIP_user'=>'Y'); 
					//print_r($customerdataArray);	die(); 
					$res_data=$this->CustomerManagement_model->insertcustomer($customerdataArray);     
			        					
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
	
	
	public function get_delete_customer()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('deleted'=>'Y'); 
		 $ReturnData=$this->CustomerManagement_model->getcustomerdelete($array,$_POST['id']);   
		 echo json_encode($ReturnData);  
	}
	
	public function ShowEditcustomer()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['cusid'];
		
		$returnArray=$this->CustomerManagement_model->Getcustomer_edit($table_id); 
		
		 $returnArray['cityname']=getdestinationfieldshow($returnArray['city'],'city'); 
		 echo json_encode($returnArray);
	
		// echo json_encode($returnArray); 
	}
	
	
	public function ShowPaymentInfo()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['cusid'];
		//$table_id=$_POST['cusid'];
		$returnArray=$this->CustomerManagement_model->Getcustomer_edit($table_id);
		$paymentArray=$this->CustomerManagement_model->GetPaymentDetails($_POST);
		foreach($paymentArray as $key=>$value)
		{
		$paymentArray[$key]['totalshipment']=$this->CustomerManagement_model->GetTotalShipment($paymentArray[$key]['user_id'],$paymentArray[$key]['invoice_month_year']);
		$paymentArray[$key]['totalcodamount']=$this->CustomerManagement_model->GetTotalCodAmount($paymentArray[$key]['user_id'],$paymentArray[$key]['invoice_month_year']);
		}
		 $returnArrayR=$paymentArray;
		 echo json_encode($returnArrayR);
	}
	
	
	public function ShowCustomerPaymentInfo()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$user_id=$_POST['cusid'];
		$invoice_month_year=$_POST['invoice_month_year'];
		$customerpaymentArray=$this->CustomerManagement_model->GetCustomerPaymentDetails($_POST);
		$newcustomerpaymentArray=$customerpaymentArray;
		foreach($newcustomerpaymentArray as $key=>$value)
		{
			$newcustomerpaymentArray[$key]['sender_city']=Get_name_country_by_id('city',$value['sender_city']);
			$newcustomerpaymentArray[$key]['reciever_city']=Get_name_country_by_id('city',$value['reciever_city']);
			$newcustomerpaymentArray[$key]['delivered']=getStatus($value['delivered']); 
			
			
			
		}
		
		 echo json_encode($newcustomerpaymentArray);
	}
	 
	
	public function ShowSendMailData()
{
	$_POST = json_decode(file_get_contents('php://input'), true);
	$table_id=$_POST['invoice_id'];
	$returnArray=$this->CustomerManagement_model->GetSendMail_edit($table_id);
	echo json_encode($returnArray);
}


	public function UpdateEditCustomer()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);	
		$editcustomerArray=$_POST['edit_customer'];
		$cusid = $editcustomerArray['cusid']; 
		$city=$editcustomerArray['city'];
		  $branch_location= getidsByNameshow($city);
		if($editcustomerArray['uploadFiles']==true)	
		{
			 if(!empty($editcustomerArray['upload_cr'])) 
			{
			//==========================imageupload===========//
		    $base64string = $editcustomerArray['upload_cr'];
			$d1='upload_cr';
            $save_Path='assets/pdf_uploads/';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);  
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$upload_cr =  $save_Path.time().$d1.".pdf";
            file_put_contents($upload_cr, $image_base64);
			
		    
			$return= true;
			}
			else
			{
			$upload_cr="";
			$return= false;
			}
			
			
			if(!empty($editcustomerArray['upload_id']))
			{
			//==========================imageupload===========//
		    $base64string = $editcustomerArray['upload_id'];
			$d2='upload_id'; 
            $save_Path='assets/pdf_uploads/';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$upload_id =  $save_Path.time().$d2.".pdf";
            file_put_contents($upload_id, $image_base64);
			
		    
			$return= true;
			}
			else
			{
			$upload_id="";
			$return= false;
			}	

			if(!empty($editcustomerArray['upload_contact']))
			{
			//==========================imageupload===========//
		    $base64string = $editcustomerArray['upload_contact'];
			$d3='upload_contact';
            $save_Path='assets/pdf_uploads/';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$upload_contact =  $save_Path.time().$d3.".pdf";
            file_put_contents($upload_contact, $image_base64);
			
			
			$return= true;
			}
			else
			{
			$upload_contact="";
			$return= false;
			}	
			
			  if(!empty($editcustomerArray['cmp_image']))
			{
			//==========================imageupload===========//
		    $base64string = $editcustomerArray['cmp_image'];
            $save_Path='assets/images/';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$cmp_image =  $save_Path.time().'1'. '.png';
            file_put_contents($cmp_image, $image_base64);  
			
		    
			$return= true;
			}
			else
			{
			$cmp_image="";
			$return= false;
			}

				$editcustomerArray['upload_cr']=$upload_cr;
                $editcustomerArray['upload_id']=$upload_id;
                $editcustomerArray['upload_contact']=$upload_contact;
				$editcustomerArray['cmp_image']=$cmp_image;
				
				if($editcustomerArray['password1']=='' && $editcustomerArray['conf_password']==''){  
					$editcustomerArray=array('name'=>$editcustomerArray['name'],'company'=>$editcustomerArray['company'],'address'=>$editcustomerArray['address'],'phone'=>$editcustomerArray['phone'],'bank_name'=>$editcustomerArray['bank_name']
                     ,'city'=>$branch_location,
						'account_number'=>$editcustomerArray['account_number'],'account_manager'=>$editcustomerArray['account_manager'],'managerEmail'=>$editcustomerArray['managerEmail'],'OnHold_Period'=>$editcustomerArray['OnHold_Period'],
						'managerMobileNo'=>$editcustomerArray['managerMobileNo'],'iban_number'=>$editcustomerArray['iban_number'],'vat_no'=>$editcustomerArray['vat_no'],'entrydate'=>$editcustomerArray['entrydate'],'bank_fees'=>$editcustomerArray['bank_fees'],
						'type'=>$editcustomerArray['type'],'upload_cr'=>$upload_cr,'upload_id'=>$upload_id,'upload_contact'=>$upload_contact,'cmp_image'=>$cmp_image);
	
				  }else{
					$editcustomerArray=array('name'=>$editcustomerArray['name'],'company'=>$editcustomerArray['company'],'address'=>$editcustomerArray['address'],'phone'=>$editcustomerArray['phone'],'bank_name'=>$editcustomerArray['bank_name'],'city'=>$branch_location,
					'account_number'=>$editcustomerArray['account_number'],'account_manager'=>$editcustomerArray['account_manager'],'managerEmail'=>$editcustomerArray['managerEmail'],'bank_fees'=>$editcustomerArray['bank_fees'],
					'managerMobileNo'=>$editcustomerArray['managerMobileNo'],'iban_number'=>$editcustomerArray['iban_number'],'vat_no'=>$editcustomerArray['vat_no'],'entrydate'=>$editcustomerArray['entrydate'],'OnHold_Period'=>$editcustomerArray['OnHold_Period'],'password'=>Md5($editcustomerArray['password1']),'type'=>$editcustomerArray['type'],'upload_cr'=>$upload_cr,'upload_id'=>$upload_id,'upload_contact'=>$upload_contact,'cmp_image'=>$cmp_image);
				  }   
		}else{
			  if($editcustomerArray['password1']=='' && $editcustomerArray['conf_password']==''){  
				$editcustomerArray=array('name'=>$editcustomerArray['name'],'company'=>$editcustomerArray['company'],'address'=>$editcustomerArray['address'],'phone'=>$editcustomerArray['phone'],'bank_name'=>$editcustomerArray['bank_name'],'city'=>$branch_location,'bank_fees'=>$editcustomerArray['bank_fees'],
					'account_number'=>$editcustomerArray['account_number'],'account_manager'=>$editcustomerArray['account_manager'],'managerEmail'=>$editcustomerArray['managerEmail'],'OnHold_Period'=>$editcustomerArray['OnHold_Period'],
					'managerMobileNo'=>$editcustomerArray['managerMobileNo'],'iban_number'=>$editcustomerArray['iban_number'],'vat_no'=>$editcustomerArray['vat_no'],'entrydate'=>$editcustomerArray['entrydate'],
					'type'=>$editcustomerArray['type']);

			  }else{
				$editcustomerArray=array('name'=>$editcustomerArray['name'],'company'=>$editcustomerArray['company'],'address'=>$editcustomerArray['address'],'phone'=>$editcustomerArray['phone'],'bank_name'=>$editcustomerArray['bank_name'],'city'=>$branch_location,
				'account_number'=>$editcustomerArray['account_number'],'account_manager'=>$editcustomerArray['account_manager'],'managerEmail'=>$editcustomerArray['managerEmail'],'OnHold_Period'=>$editcustomerArray['OnHold_Period'],'bank_fees'=>$editcustomerArray['bank_fees'],   
				'managerMobileNo'=>$editcustomerArray['managerMobileNo'],'iban_number'=>$editcustomerArray['iban_number'],'vat_no'=>$editcustomerArray['vat_no'],'entrydate'=>$editcustomerArray['entrydate'],
				'password'=>Md5($editcustomerArray['password1']),'type'=>$editcustomerArray['type']);
			  }
		}		
				//print_r($editcustomerArray);	die();
					$res_data=$this->CustomerManagement_model->customerUpdate($editcustomerArray,$cusid);   
			        					
		           $return= true;   
					
		        echo json_encode($res_data); 
	      }
	
	public function addTemplate()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);	
		$dataArray=$_POST['add_template'];
		$id = $dataArray['id'];  
		$tempArray=array('template_id'=>$dataArray['template_id']);
		$res_data=$this->CustomerManagement_model->templateUpdate($tempArray,$id);
		$return= true;
        echo json_encode($res_data);
	}
	
	
	public function ShowAccount()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->CustomerManagement_model->GetAccount($_POST['searchfield'],$_POST['page_no']); 
		$maniarray=$returnArray['result'];
		foreach($maniarray as $key=>$val)
			{
				$maniarray[$key]['city']=Get_name_country_by_id('city',$val['city']);
			}
			$shiparray=$maniarray;
		

		$dataArray['pdata']=$_POST ;  
        $dataArray['result']=$shiparray;   
        $dataArray['count']=$returnArray['count']; 
		echo json_encode($dataArray);
    }
	
	public function GetstaffstatusUpdate()
	{
		//echo $status; die;
		$_POST = json_decode(file_get_contents('php://input'), true);
		//$status = $this->db->query("select status from customer  where id = $_POST['id']")->row()->status;
        $array=array('status'=>$_POST['status']);  
		
		 $returnArray=$this->CustomerManagement_model->Getupdateactivestatus($array, $_POST['id']);
		 echo json_encode($_POST);
	}
	
	public function GetrecivedPaymentUpdate()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		// echo json_encode($_POST);
	//print_r($_POST); die;
	$_POST['year_month']=$_POST['year_month_group'];
	$_POST['update_user_id']=$_POST['cust_id'];
	$_POST['user_id']=$_POST['cust_id'];
				
				  $query="insert into shipment_paid_amount_details(user_id,invoice_id,paid_amount,payment_mode,payment_comment,paid_date)values('".$_POST['update_user_id']."','".$_POST['update_invoice_id']."','".$_POST['paid_amount']."','".$_POST['payment_mode']."','".$_POST['comment']."','".date("Y-m-d H:i:s")."')";
				$this->CustomerManagement_model->dataUpdateAddedQry($query);
				
				
				$query_data=$this->CustomerManagement_model->invoiceDetailsQryData($_POST['update_invoice_id']);
				$invoice_total_amout=$query_data[0]['total_payment'];
				$invoice_paid_amout=$query_data[0]['paid_amount']+$_POST['paid_amount'];
				$invoice_due_amout=$query_data[0]['total_payment']-$invoice_paid_amout; 
				if($invoice_total_amout==$invoice_paid_amout)
					$update_status="PAID";	
				else
					$update_status="UN PAID";
					
				$return=true;
			
			$update_invoice_query="update shipment_invoice_details set total_payment='".$invoice_total_amout."',paid_amount='".$invoice_paid_amout."',due_amout='".$invoice_due_amout."',invoice_status='".$update_status."' where invoice_id='".$_POST['update_invoice_id']."'";  
				
				$this->CustomerManagement_model->dataUpdateAddedQry($update_invoice_query);
					///=============================================/////
					//echo $_POST['user_id']; die;
				$fetchdata=$this->CustomerManagement_model->ShipdatainvociePay($_POST['year_month'],$_POST['user_id']);
			    if(!empty($fetchdata))
				{
				 $paid_amount=abs($_POST['paid_amount']);
				// print_r($fetchdata); die;
				 foreach($fetchdata as $key=>$val)
				 {
					
					 if($_POST['paid_amount']!=0)
					 {
						
						if($fetchdata[$key]['mode']=='CASH')
						{
							$paid_amount=$paid_amount-$fetchdata[$key]['total_amt'];
							
							if($paid_amount>=0)
							{
					            $updatedata="update shipment set amount_collected='Y'  where id='".$fetchdata[$key]['id']."'";  
								$this->CustomerManagement_model->dataUpdateAddedQry($updatedata);
								
							}
						}
						else
						{
							
							if($fetchdata[$key]['delivered']=='6')
							{
								$paid_amount=$paid_amount-$fetchdata[$key]['cod_fees'];
								
								
								if($_POST['paid_amount']>=0)
							{
								$updatedata1="update shipment set amount_collected='Y'  where id='".$fetchdata[$key]['id']."' ";
								$this->CustomerManagement_model->dataUpdateAddedQry($updaupdatedata1tedata);
							}
							
							}
							else
							{
								
								$paid_amount=$paid_amount-($fetchdata[$key]['total_amt']-$fetchdata[$key]['service_charge']-$fetchdata[$key]['cod_fees']);
								
								
								if($paid_amount>=0)
							{
								$updatedata2="update shipment set amount_collected='Y'  where id='".$fetchdata[$key]['id']."' "; 
								$this->CustomerManagement_model->dataUpdateAddedQry($updatedata2);
							}
							
							}
						}
						 
					 }
				 }
						$AWB_NO=$fetchdata[0]['slip_no'];
						$user_id=$_POST['user_id'];
						$year_month=$_POST['year_month'];
						$link='<a href="$site_url/print.php?c=shipment&f=generateInvoiceNumber&user_id='.$user_id.'&year_month='.$year_month.'"';
						$Info=Email_Info(14);
						$Subject=$Info[0]['subject'];
						$msgBody=$Info[0]['msg'];
						$msgBody=stripslashes($msgBody);
						$msgBody=str_replace("\"", "'", $msgBody);
						eval("\$msgBody = \"$msgBody\";");	
						$msgBody=stripslashes($msgBody);
						$msgBody1='<html><body><table><tr><td>'.$msgBody.'</td></tr></table></body></html>';
							
						Send_mail(site_configTable('email'),site_configTable('company_name'),site_configTable('email'),$Subject,$msgBody1);
						Send_mail(site_configTable('email'),site_configTable('company_name'),$fetchdata[0]['reciever_email'],$Subject,$msgBody1);
						Send_mail(site_configTable('email'),site_configTable('company_name'),$fetchdata[0]['sender_email'],$Subject,$msgBody1);
						$return=true;
				}
				else
				$return=true;
				
				
				    
			
			 echo json_encode($return);
	}
	
	public function customerImportsrates()
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
				     $shipmentData=$this->CustomerManagement_model->GetratesImportShipDataQry($old_awb_number);
				          if(!empty($shipmentData))
							{
								
								$service_charge 	=	$worksheet->getCellByColumnAndRow(1, $row)->getValue(); 
								if($shipmentData[0]['delivered'] == 10){
									$cod_fees 		=	$worksheet->getCellByColumnAndRow(3, $row)->getValue(); //return_fees
								}else{
									$cod_fees 			=	$worksheet->getCellByColumnAndRow(2, $row)->getValue();// Original COD Fees
								}
								if($shipmentData[0]['pod'] == 'Y'){ 
									$pod_fees 		=	' ,pod_fees='.$worksheet->getCellByColumnAndRow(4, $row)->getValue();
								} 
							
								
								$update_status_r="update shipment set cod_fees='".$cod_fees."',service_charge='".$service_charge."',total_amt='".$service_charge."' $pod_fees  where deleted='N' and slip_no='".$old_awb_number."' ";
								$this->CustomerManagement_model->dataUpdateAddedQry($update_status_r);
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
	
	public function GetweightRangeDetailsPage()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArr=$this->CustomerManagement_model->GetweightRangeDetailsPageQry($_POST);
		 echo json_encode($returnArr);
	}
	public function weightrangeUpdateData()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$newUpdateArr=$_POST;
		$cust_id=$newUpdateArr[0]['cust_id'];
		$GENERATE_UNQUICE_ID=procut_categoryUniqueID();
		foreach($_POST as $key=>$val)
		{
			$newUpdateArr[$key]['unique_id']=$GENERATE_UNQUICE_ID;
			$newUpdateArr[$key]['cust_id']=$val['cust_id'];
			
		}
		$return=$this->CustomerManagement_model->GetupdateWeightRangeQry($newUpdateArr,$cust_id);
		 echo json_encode($return);
	}
	
	public function showZoneDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->CustomerManagement_model->showZoneDrop();     
		echo json_encode($returnArray);
	}
	public function showserviceDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->CustomerManagement_model->showserviceDrop();     
		echo json_encode($returnArray);
	}
	public function ShowproductTypeDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->CustomerManagement_model->ShowproductTypeDrop();     
		echo json_encode($returnArray);
	}
	public function Getzone_price_setData()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		//$_POST['zone_id_form']=2;
		//$_POST['sel_service_id']=4;
		//$_POST['product_type']="KVAIMI";
		//$_POST['cust_id']=44;
		// zone_id_form: "2", sel_service_id: "3", product_type: "KVAIMI", cust_id: "36"
		
		$arrayFieldSet=array();
		$zone_list2=$this->CustomerManagement_model->showZoneDrop(); 
	
		$PriceArry=$this->CustomerManagement_model->Getzone_price_setDataQry($_POST);
		//print_r($PriceArry);
    if(!empty($PriceArry))
	{
	   $weight_details=$this->CustomerManagement_model->GetshowWeightRangeCustomerQry($_POST);   
	//print_r($weight_details);
	
	   if(!empty($weight_details))
		{
			$arrayFieldSet['WeightRange']=$weight_details;
		    foreach($weight_details as $key=>$val)
			{
				$zone_list=$this->CustomerManagement_model->showZoneDrop();     
			   //print_r($zone_list);
			    foreach($zone_list as $key1=>$val1)
				{
					//echo $zone_list[$key1]['id'];
				$zone_data=$this->CustomerManagement_model->Getzone_price_setDataQry_new($_POST,$zone_list[$key1]['id'],$val['start_range'],$val['end_range']);
				//print_r($zone_data);
				//$arrayFieldSet['zone_list'][$zone_list[$key1]['id']]['id']='id'=>$zone_list[$key1]['id'],
				$arrayFieldSet['zone_list'][$weight_details[$key]['id']][$key1]['id']=$zone_list[$key1]['id'];
				$arrayFieldSet['zone_list'][$weight_details[$key]['id']][$key1]['start_range']=remove_decimal($weight_details[$key]['start_range']);
				$arrayFieldSet['zone_list'][$weight_details[$key]['id']][$key1]['end_range']=remove_decimal($weight_details[$key]['end_range']);
				$arrayFieldSet['zone_list'][$weight_details[$key]['id']][$key1]['price']=$zone_data[0]['price'];
				}
			} 	
			
		   foreach($zone_list as $key2=>$val2)
			{
				
				
			$zone_data=$this->CustomerManagement_model->Getzone_price_setDataQry_new2($_POST,$zone_list[$key2]['id'],$weight_details[$key]['start_range'],$weight_details[$key]['end_range']);
			//print_r($zone_data);
			///echo "sssssss".$zone_data[0]['cod_fees'];
			$arrayFieldSet['zone_list2'][$key2]=array('id'=>$zone_list[$key2]['id'],'start_range'=>remove_decimal($weight_details[$key]['start_range']),'end_range'=>remove_decimal($weight_details[$key]['end_range']),'cod_fees'=>$zone_data[0]['cod_fees']);
			}
		
		
		   foreach($zone_list as $key3=>$val3)
			{
			$zone_data=$this->CustomerManagement_model->Getzone_price_setDataQry_new2($_POST,$zone_list[$key3]['id'],$weight_details[$key]['start_range'],$weight_details[$key]['end_range']);
			$arrayFieldSet['zone_list3'][$key3]=array('id'=>$zone_list[$key3]['id'],'start_range'=>remove_decimal($weight_details[$key]['start_range']),'end_range'=>remove_decimal($weight_details[$key]['end_range']),'return_fees'=>$zone_data[0]['return_fees']);
			}
		
		} 
	
    }
        else
		{
		    $weight_details=$this->CustomerManagement_model->GetshowWeightRangeCustomerQry($_POST);   
			$arrayFieldSet['WeightRange']=$weight_details;
		    if(!empty($weight_details))
			{
			    foreach($weight_details as $key=>$val)
				{
				
				$zone_list=$this->CustomerManagement_model->showZoneDrop(); 
				 foreach($zone_list as $key1=>$val1)
					{
					$zone_data=$this->CustomerManagement_model->Getzone_price_setDataQry_new($_POST,$zone_list[$key1]['id'],$val['start_range'],$val['end_range']);
					$arrayFieldSet['zone_list'][$weight_details[$key]['id']][$key1]['id']=$zone_list[$key1]['id'];
					$arrayFieldSet['zone_list'][$weight_details[$key]['id']][$key1]['start_range']=remove_decimal($weight_details[$key]['start_range']);
				    $arrayFieldSet['zone_list'][$weight_details[$key]['id']][$key1]['end_range']=remove_decimal($weight_details[$key]['end_range']);
				    $arrayFieldSet['zone_list'][$weight_details[$key]['id']][$key1]['price']=$zone_data[0]['price'];
					}
				}
			
			   
			    foreach($zone_list as $key2=>$val2)
				{
				$zone_data=$this->CustomerManagement_model->Getzone_price_setDataQry_new($_POST,$zone_list[$key2]['id'],$weight_details[$key]['start_range'],$weight_details[$key]['end_range']);
				$arrayFieldSet['zone_list2'][]=array('id'=>$zone_list[$key2]['id'],'start_range'=>remove_decimal($weight_details[$key]['start_range']),'end_range'=>remove_decimal($weight_details[$key]['end_range']),'cod_fees'=>$zone_data[0]['cod_fees']);
				
				}
			    
			    foreach($zone_list as $key3=>$val3)
				{
				$zone_data=$this->CustomerManagement_model->Getzone_price_setDataQry_new($_POST,$zone_list[$key3]['id'],$weight_details[$key]['start_range'],$weight_details[$key]['end_range']);
				$arrayFieldSet['zone_list3'][]=array('id'=>$zone_list[$key3]['id'],'start_range'=>remove_decimal($weight_details[$key]['start_range']),'end_range'=>remove_decimal($weight_details[$key]['end_range']),'return_fees'=>$zone_data[0]['return_fees']);
				}
			
			}
         } 
		
	 //echo '<pre>';
		// print_r($arrayFieldSet);
		 ///$return=array('resultArr'=>$form_dezine,'OtherArr'=>$arrayFieldSet);
		echo json_encode($arrayFieldSet);
	}
	

	public function getOriginDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->CustomerManagement_model->getOriginDropData();      
		echo json_encode($returnArray);
	}
	 
	 
	 
	 
	 public function GetUpdateCustomerRateByZones()
	 {
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 if($_POST['field']=='price')
		 $returnArray=$this->CustomerManagement_model->GetUpdateCustomerRateByZonesQry($_POST);
		 if($_POST['field']=='cod_fees')
		 $returnArray=$this->CustomerManagement_model->GetUpdateCustomerRateByZonesQry_COD($_POST);
		 if($_POST['field']=='return_fees')
		 $returnArray=$this->CustomerManagement_model->GetUpdateCustomerRateByZonesQry_returnCharge($_POST);   
		 
		 echo json_encode($returnArray);
	 }
	
	
	
	 
	
}