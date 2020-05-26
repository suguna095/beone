<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class BulkInvoiceManagement extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	   
	   $this->load->model("BulkInvoiceManagement_model");
    }

   public function showCodInvoiceData()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->BulkInvoiceManagement_model->getviewcod($_POST); 
		$maniarray=$returnArray['result'];
		foreach($maniarray as $key=>$val)
		{
			$maniarray[$key]['cod_paid_by']=Get_user_name($val['cod_paid_by'],'user');
			$maniarray[$key]['invoice_created_by']=Get_user_name($val['invoice_created_by'],'user');
			$invocieCountArray=invoiceCountnew($val['invoice_no']);
			$InvocieDetailsArray=invoiceDetailnew($val['invoice_no']);
			$maniarray[$key]['invoiceCount']=$invocieCountArray['total_numCount'];
			$maniarray[$key]['monthly_invoice_no']=$monthly_invoice_no['total_numCount'];
			$maniarray[$key]['cod_charge_sum']=$InvocieDetailsArray['cod_charge_sum'];
			$maniarray[$key]['return_charge_sum']=$InvocieDetailsArray['return_charge_sum'];
			$maniarray[$key]['service_charge_sum']=$InvocieDetailsArray['service_charge_sum'];
			$maniarray[$key]['vat_sum']=$InvocieDetailsArray['vat_sum'];
			$maniarray[$key]['cod_amount_sum']=$InvocieDetailsArray['cod_amount_sum'];
			
		
		}
        $dataArray['pdata']=$_POST ; 
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count']; 
		echo json_encode($dataArray); 
    }

    public function showPayableInvoiceData()
    {
    $_POST = json_decode(file_get_contents('php://input'), true);
      $returnArray=$this->BulkInvoiceManagement_model->getviewPayableInvoice($_POST); 
    $maniarray=$returnArray['result'];
	foreach($maniarray as $key=>$val)
		{
			$maniarray[$key]['cod_paid_by1']=Get_user_name($val['cod_paid_by'],'user');
			$maniarray[$key]['invoice_created_by']=Get_user_name($val['invoice_created_by'],'user');
			$maniarray[$key]['receivable_paid_by']=Get_user_name($val['receivable_paid_by'],'user');
			$maniarray[$key]['cod_paid_by']=Get_user_name($val['cod_paid_by'],'user');
			
			
			$invocieCountArray=invoiceCountnew($val['invoice_no']);
			$InvocieDetailsArray=invoiceDetailnew($val['invoice_no']);
			
			$maniarray[$key]['invoiceCount']=$invocieCountArray['total_numCount'];
			$maniarray[$key]['monthly_invoice_no']=$monthly_invoice_no['total_numCount'];
			$maniarray[$key]['cod_charge_sum']=$InvocieDetailsArray['cod_charge_sum'];
			$maniarray[$key]['return_charge_sum']=$InvocieDetailsArray['return_charge_sum'];
			$maniarray[$key]['service_charge_sum']=$InvocieDetailsArray['service_charge_sum'];
			$maniarray[$key]['vat_sum']=$InvocieDetailsArray['vat_sum'];
			$maniarray[$key]['cod_amount_sum']=$InvocieDetailsArray['cod_amount_sum'];
			
		
		}
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count']; 
    echo json_encode($dataArray); 
    }

    public function showPayableData()
    {
    $_POST = json_decode(file_get_contents('php://input'), true);
      $returnArray=$this->BulkInvoiceManagement_model->getviewPayable($_POST); 
    $maniarray=$returnArray['result'];
	foreach($maniarray as $key=>$val)
		{
			$maniarray[$key]['cod_paid_by1']=Get_user_name($val['cod_paid_by'],'user');
			$maniarray[$key]['invoice_created_by']=Get_user_name($val['invoice_created_by'],'user');
			$maniarray[$key]['receivable_paid_by']=Get_user_name($val['receivable_paid_by'],'user');
			
			
			$invocieCountArray=invoiceCountnew($val['invoice_no']);
			$InvocieDetailsArray=invoiceDetailnew($val['invoice_no']);
			
			$maniarray[$key]['invoiceCount']=$invocieCountArray['total_numCount'];
			$maniarray[$key]['monthly_invoice_no']=$monthly_invoice_no['total_numCount'];
			$maniarray[$key]['cod_charge_sum']=$InvocieDetailsArray['cod_charge_sum'];
			$maniarray[$key]['return_charge_sum']=$InvocieDetailsArray['return_charge_sum'];
			$maniarray[$key]['service_charge_sum']=$InvocieDetailsArray['service_charge_sum'];
			$maniarray[$key]['vat_sum']=$InvocieDetailsArray['vat_sum'];
			$maniarray[$key]['cod_amount_sum']=$InvocieDetailsArray['cod_amount_sum'];
			
		
		}
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count']; 
    echo json_encode($dataArray); 
    }

    public function ShowEditpay()
    {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $table_id=$_POST['id'];
        
        $returnArray=$this->BulkInvoiceManagement_model->Getpay_edit($table_id);
    
         echo json_encode($returnArray);
    }

    public function ShowInvoice()
    {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $table_id=$_POST['pid'];
        
        $returnArray=$this->BulkInvoiceManagement_model->Getinvoice($table_id);
		$newreturnArray=$returnArray;
		$total_cod_amount=0;
		$total_collect_add=0;
		$total_service_add=0;
		$returnCharges=0;
		foreach($newreturnArray as $key=>$val)
		{
			$newreturnArray[$key]['cityname']=Get_name_country_by_id('city',$val['city']);
			$newreturnArray[$key]['country']=Get_name_country_by_id('country',$val['city']);
			$newreturnArray[$key]['company_name']=site_configTable('company_name');
			$newreturnArray[$key]['company_address']=site_configTable('company_address');
			$newreturnArray[$key]['site_vat']=site_configTable('vat');
			$newreturnArray[$key]['logo']=site_configTable('logo');
			
			 $total_cod_amount+=$val['cod_amount'];
	         $total_collect_add+=$val['cod_charge'];
	         $total_service_add+=$data1['service_charge'];
             $returnCharges+=$data1['return_charge'];
			
			
			
		}
    
	    $return['allarray']=$newreturnArray;
		$return['total_cod_amount']=$total_cod_amount;
		$return['total_collect_add']=$total_collect_add;
		$return['total_service_add']=$total_service_add;
		$return['returnCharges']=$returnCharges;
         echo json_encode($return);
    }

    public function Showpayableinvoice()
    {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $table_id=$_POST['pid'];
        
        $returnArray=$this->BulkInvoiceManagement_model->Getpayableinvoice($table_id);
    
         echo json_encode($returnArray);
    }

     public function ShowpayableCODinvoice()
    {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $table_id=$_POST['pid'];
        
        $returnArray=$this->BulkInvoiceManagement_model->GetpayableCODinvoice($table_id);
    
         echo json_encode($returnArray);
    }


    
	
	public function GetcustomerShowdata()
	{
		$return=GetcustomerDropdata();
		 echo json_encode($return);
	}
	
	public function GetCreateBultINvoiceData()
	{
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $postArrar=$_POST;
		$returnStatus=false;
		if(!empty($postArrar['awb_no'])){
	
	    $uid=$postArrar['user_name'];

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
			
			$shipment_Array = array_unique($slipData);
			foreach($shipment_Array as $key1=>$val1)
			{
				
				$insertData=0;
				
				$shipments=$this->BulkInvoiceManagement_model->GetcreateinvocieShipmentData(trim($shipment_Array[$key1]));
				
				if(!empty($shipments)){
					
				$code=$shipments[0]['code'];
				$delivered=$shipments[0]['delivered'];
				$mode=$shipments[0]['mode'];
				$cust_id=$shipments[0]['cust_id'];
				$slipno=trim($shipments[0]['slip_no']);
				if($cust_id!=$uid)
				{
				 array_push($not_belong,$shipment_Array[$key1]);
				 $returnArray['not_belong']=$not_belong;
			
				
				}
				else
				{
				if($delivered=="11" || $delivered=="6" )
				{
					
					if($postArrar['inv_type']=='COD')
				{
					
					if($mode=='COD' && $delivered=="11" )
					$insertData=1;	
						else
				{	
					if($mode=='CC')
					{
						array_push($cc_awb,$shipment_Array[$key1]);
               			$returnArray['cc_awb']=$cc_awb;
						
					}
					if($delivered=='6')
					{
						array_push($cod_return_awb,$shipment_Array[$key1]);
               			$returnArray['cod_return_awb']=$cod_return_awb;
						
					}
				
						
						}
						
				}
				else if($postArrar['inv_type']=='CC')	
				{
					
					if(($delivered=="6") || ($mode=='CC' && $delivered=="11") )
					$insertData=1;	 
					else
					{
						if(($mode=='COD' && $delivered=="11"))
						{
						array_push($cod_deliver_awb,$shipment_Array[$key1]);
               			$returnArray['cod_deliver_awb']=$cod_deliver_awb;
						}
						
					}
				}
					else if($postArrar['inv_type']=='All')
					{
						
						$insertData=1;	
					}
					
					if($insertData==1)
					{
						
                    $present_in_invoice=$this->BulkInvoiceManagement_model->GetpaybaleInvocieQry(trim($shipment_Array[$key1]));
				
					
					if(empty($present_in_invoice))
					{
             
				      $t=strtotime($CURRENT_TIME);
						$invoiceNumberMonthy='C'.$postArrar['user_name'].$CURRENT_YEAR.$CURRENT_MONTH.$t;
						$receivble_invoice='R'.$postArrar['user_name'].$CURRENT_YEAR.$CURRENT_MONTH.$t;
						
						if($shipments[0]['delivered']==6)//if shipment is return
						{
							
							$return_charge=return_charge($uid); 
							$cod_fees=0;
							$service_charge=0;
							$vat=$return_charge*5/100;
							$total_cod_amount=0;
							$pissue=0;
						}
						else
						{//if shipment is delivered

						$return_charge=	0; 
				
					
		  $finalCalulate=calculatePriceJolly($shipments[0]['service_id'],'KVAIMI',$shipments[0]['weight'],$shipments[0]['origin'],$shipments[0]['destination'],$shipments[0]['cust_id']);
					
							if($mode=='CC')
							{
								$cod_fees=0;
							}
							else
						   {
								$cod_fees=$finalCalulate['cod_fees'];
							}
						 
						// echo "//";
						 $service_charge=$finalCalulate['price'];
						// exit("comes in service charge 0");
					if($service_charge==0)
					{
						//echo "sssssss";
					//exit();	
					array_push($price_issue,$shipment_Array[$key1]);	
					$returnArray['price_issue']=$price_issue;	
					$pissue=1;	
					}
					else
					$pissue=0;
							
					$vat=($service_charge+$cod_fees)*5/100;
					$total_cod_amount=$shipments[0]['total_cod_amt'];
				       }
					$time=strtotime($shipments[0]['delever_date']);
					$month=date("m",$time);
					$year=date("Y",$time);	
					$CURRENT_DATE=date('Y-m-d H:i:s');
					// $week=$functions->weekOfMonth($time);
						if($pissue==0)
						{
							
			           $insert_values.="('".$invoiceNumberMonthy."','".$receivble_invoice."','".$shipments[0]['entrydate']."','".$shipments[0]['delever_date']."','".$shipments[0]['cust_id']."','".mysql_real_escape_string($shipments[0]['reciever_name'])."','".Get_name_country_by_id('city',$shipments[0]['origin'])."','".Get_name_country_by_id('city',$shipments[0]['destination'])."','".$shipments[0]['slip_no']."','".$shipments[0]['booking_id']."','".$shipments[0]['pieces']."','".$shipments[0]['weight']."','".$shipments[0]['mode']."','".getStatus($shipments[0]['delivered'])."','".$return_charge."','".$service_charge."','".$cod_fees."','".$total_cod_amount."','".$vat."','".date('Y-m-d')."','".$week."','".$CURRENT_MONTH."','".$CURRENT_YEAR."','".$this->session->userdata('useridadmin')."','".$CURRENT_DATE."','".$shipments[0]['d_attempt']."'),";
					   array_push($success_update,$shipment_Array[$key1]);
			          $returnArray['success_update']=$success_update;
					  $returnStatus=true;
					  $this->BulkInvoiceManagement_model->GetinvoiceUpdatedata($invoiceNumberMonthy,$receivble_invoice,$shipments[0]['slip_no']);
						}	
						}//end of the
						
				else
					{
						array_push($invoice_present,$shipment_Array[$key1]);
						 $returnArray['invoice_present']=$invoice_present;
                    }//end else slip_no is present in invoice table

               }

		     else
               {
               array_push($status_not_delivered,$shipment_Array[$key1]);
			  
				$returnArray['status_not_delivered']=$status_not_delivered;
				 $status_not_delivered.="";
               }//end else if code is not delivered or Return

				}
					}
			}
			else{array_push($wrong_awb,$shipment_Array[$key1]);
               $returnArray['wrong_awb']=$wrong_awb;
			}//end for loop
				$insertDataqry=rtrim($insert_values,',');
			if(!empty($insertDataqry))
			{
				//echo $insertDataqry; die;
				$returnStatus=true;
			$this->BulkInvoiceManagement_model->GetinvocieInsertData($insertDataqry);	
		
			
			}
		//redirect($site_url."system145.php?c=bulk_invoice&f=add_bulk_invoice");
		}
	}
	
	$reurn=array('status'=>$returnStatus,'returnArr'=>$returnArray);
 echo json_encode($reurn);
	}


public function GetstaffDropData()
{
	$return=getstaff_multycreated();
	echo json_encode($return);
}

public function PaymentConfirmUpdaye()
{
	$_POST = json_decode(file_get_contents('php://input'), true);
	$dataArray=$_POST;
	
		if(!empty($dataArray['image']))
			{
			//==========================imageupload===========//
		    $base64string = $dataArray['image'];
            $save_Path='assets/invoice_copy/';
			$image_parts = explode(";base64,", $base64string);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];
			$image_base64 = base64_decode($image_parts[1]);
			$imgpath = $save_Path.time(). '.png';
			file_put_contents($imgpath, $image_base64);
			}
			if(!empty($imgpath))
			{
				$CURRENT_DATE=date("Y-m-d H:i:s");
				$updateinvoiceAarray=array('cod_pay_status'=>'Y','cod_paid_by'=>$this->session->userdata('useridadmin'),'cod_paid_date'=>$CURRENT_DATE,'pay_voucher'=>$imgpath);
				$updateinvoiceAarrayW=array('invoice_no'=>$dataArray['invoice_no'],'cust_id'=>$dataArray['cust_id']);
				
				$return1=$this->BulkInvoiceManagement_model->GetupdateFinalInvocie($updateinvoiceAarray,$updateinvoiceAarrayW);	
	
			}
			else
			$return=false;
                   
                   
			echo json_encode($return1);
}


public function payableInvoice_update()
    {
            $_POST = json_decode(file_get_contents('php://input'), true);
            $dataArray=$_POST;
            $invoice_no = $dataArray['invoice_no'];
		$CURRENT_DATE=date("Y-m-d H:i:s");
			 $updateinvoiceAarrayW=array('invoice_no'=>$dataArray['invoice_no'],'cust_id'=>$dataArray['cust_id']);
			$updateinvoiceAarray=array('receivable_pay_status'=>'Y','receivable_paid_by'=>$this->session->userdata('useridadmin'),'receivable_paid_date'=>$CURRENT_DATE,'rec_voucher'=>$dataArray['rec_voucher']);
           $res_data=$this->BulkInvoiceManagement_model->addInvoiceUpdate($updateinvoiceAarray,$updateinvoiceAarrayW);
            
            //===============================================//
        
         
         echo json_encode($res_data);
    }
	
	
	public function bulkPrintPayableView($invoice_no=null)
	{
		$result=$this->BulkInvoiceManagement_model->bulkPrintPayableQry($invoice_no);
		$view['invoiceData']=$result;
	
		$this->load->view('bulkinvoicemanagement/print_payable_invocie',$view);
	}
	public function bulkInvoiceNumber($invoice_no=null)
	{
		$result=$this->BulkInvoiceManagement_model->bulkPrintPayable_cod_Qry($invoice_no);
		$view['invoiceData']=$result;
	
		$this->load->view('bulkinvoicemanagement/print_cod_invocie',$view);
	}
	public function codreceivablePrint($invoice_no=null)
	{
		$result=$this->BulkInvoiceManagement_model->codreceivablePrintQry($invoice_no);
		$view['invoiceData']=$result;
	
		$this->load->view('bulkinvoicemanagement/bulkallinvoice',$view);
	}




}

