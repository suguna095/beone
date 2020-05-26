<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Reports extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	    $this->load->model('Reports_model');
    }
public function supplier_report()
{
$this->load->view('reports/supplier_report');
}
public function getSupplierDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->Reports_model->getSupplierDropData();      
		echo json_encode($returnArray);
	}
	public function getOriginDrop() 
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->Reports_model->getOriginDropData();      
		echo json_encode($returnArray);
	}

public function allTransactionReport()
	{
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataAray=$this->Reports_model->allTransactionReportData($_POST);
		$maniarray=$dataAray['result'];
			foreach($maniarray as $key=>$value)
		{
			$maniarray[$key]['origin']=Get_name_country_by_id('city',$value['origin']);
			$maniarray[$key]['reciever_city']=Get_name_country_by_id('city',$value['reciever_city']);
			$maniarray[$key]['company']=Get_cust_name($value['cust_id']);
			$maniarray[$key]['total_attempted']=get_total_attempted($value['slip_no']);
			$maniarray[$key]['Details']=get_report_status($value['slip_no'],$value['delivery_status']);
			$maniarray[$key]['comment']=get_report_status($value['slip_no'],$value['delivery_status']);
			$maniarray[$key]['messenger_name']=getDriverNameByid($value['messanger_id']);
			$maniarray[$key]['uniqueid']=Get_cust_uid($value['cust_id']);
			
			$maniarray[$key]['total_count']=($value['total_cod_amt']+$value['cod_fees']+$value['service_charge']);
			
			
			
		}
		
			
			 $dataArray['pdata']=$_POST ;  
	        $dataArray['result']=$maniarray;   
	        $dataArray['count']=$dataAray['count'];
			echo json_encode($dataArray);
		
	}	
	
		
		
		public function allTransactionReportExcel()
	{
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataAray=$this->Reports_model->allTransactionReportDataExcel($_POST);
		$maniarray=$dataAray['result'];
			foreach($maniarray as $key=>$value)
		{
			$maniarray[$key]['origin']=Get_name_country_by_id('city',$value['origin']);
			$maniarray[$key]['reciever_city']=Get_name_country_by_id('city',$value['reciever_city']);
			$maniarray[$key]['company']=Get_cust_name($value['cust_id']);
			$maniarray[$key]['total_attempted']=get_total_attempted($value['slip_no']);
			$maniarray[$key]['Details']=get_report_status($value['slip_no'],$value['delivery_status']);
			$maniarray[$key]['comment']=get_report_status($value['slip_no'],$value['delivery_status']);
			$maniarray[$key]['messenger_name']=getDriverNameByid($value['messanger_id']);
			$maniarray[$key]['uniqueid']=Get_cust_uid($value['cust_id']);
			
			$maniarray[$key]['total_count']=($value['total_cod_amt']+$value['cod_fees']+$value['service_charge']);
			
			
			
		}
		
			echo json_encode($maniarray);
		
	}	
	
	public function allOnHoldReport()
	{
		 $_POST = json_decode(file_get_contents('php://input'), true);
		 $dataAray=$this->Reports_model->allOnHoldReportData($_POST);
		$maniarray=$dataAray['result'];
			foreach($maniarray as $key=>$value)
		{
			$maniarray[$key]['origin']=Get_name_country_by_id('city',$value['origin']);
			$maniarray[$key]['reciever_city']=Get_name_country_by_id('city',$value['reciever_city']);
			$maniarray[$key]['company']=Get_cust_name($value['cust_id']);
			$maniarray[$key]['total_attempted']=get_total_attempted($value['slip_no']);
			$maniarray[$key]['messenger_name']=getDriverNameByid($value['messanger_id']);
			$maniarray[$key]['username']=Get_user_name($value['u_id'],$value['u_type']);
			$maniarray[$key]['new_status']=status_main_cat($value['new_status']);
			$maniarray[$key]['uniqueid']=Get_cust_uid($value['cust_id']);
			
			$maniarray[$key]['total_count']=($value['total_cod_amt']+$value['cod_fees']+$value['service_charge']);
			
			
			
		}
	
			$dataArray['pdata']=$_POST ;  
	        $dataArray['result']=$maniarray; 
	        $dataArray['count']=$dataAray['count'];
			echo json_encode($dataArray);
		
	}
	
	public function ShowCustomerDetails()
	{
	$_POST = json_decode(file_get_contents('php://input'), true);
	$table_id=$_POST['company'];
	// print_r($table_id); die();  
	$returnArray=$this->Reports_model->GetCustomerDetails($table_id);
	echo json_encode($returnArray); 
	}
	
	
	public function ShowPaymentDetails()
	{
	$_POST = json_decode(file_get_contents('php://input'), true);
	//print_r($_POST); die();
	$returnArray=$this->Reports_model->GetPaymentReportDetails($_POST);
	$shiparray=$returnArray['result'];
	$dataArray['result']=$shiparray;
	echo json_encode($dataArray); 
	}
	
	
	
	
	public function ShowCustDrop()
	{
		$return=GetcustomerDropdata();
		 echo json_encode($return);
	}
	
	public function ShowPaymentReport()
	{
	$_POST = json_decode(file_get_contents('php://input'), true);
	$table_id=$_POST['company'];
	// print_r($table_id); die();  
	$returnArray=$this->Reports_model->GetPaymentReportDetails($table_id);
	echo json_encode($returnArray); 
	}
	
	
	public function report_download()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
			//echo json_encode($_POST); die;
		$post=$_POST['listdata'];
		$_POST=$_POST['filterdata'];
			//echo json_encode($_POST); die;
		$condition.='';
		
			if(!empty($_POST['main_status1']))
			{
				
				if($_POST['main_status1']==11 )
					{
						$condition.=" and delivered='".$_POST['main_status1']."'";
				if(!empty($_POST['date_from']) && !empty($_POST['date_to']) )
			{
				$date_from = $_POST['date_from'];
					
				$condition.=" and DATE(delever_date) BETWEEN '".$date_from."' AND '".$_POST['date_to']."' ";
				
			}
						}
					else
					{
						
			if(!empty($_POST['main_status1']))
			{
				if($_POST['shipmentStatusBy']=='LAST')
				$condition.=" and delivered In (".$_POST['main_status1'].") ";
				else
				{
					
					
			 	$awbDatas=	getAwb_betweendateStatus_multy($_POST['date_from'],$_POST['date_to'],$_POST['main_status1']);
					if(!empty($awbDatas))
					{
						$condition.=	" and slip_no IN (".$awbDatas.")";			
						}
				
					
					}
					if($_POST['shipmentStatus']=='O')
					{
						$condition.=" and  code NOT IN ('POD','RTS')";	
						}
						elseif($_POST['shipmentStatus']=='OFD')
						
						{
						$condition.=" ";	
						}
						else
						{
						$condition.=" and  code IN ('POD','RTS')";	
						if(!empty($_POST['date_from']) && !empty($_POST['date_to']) )
						{
							$date_from = $_POST['date_from'];
							$condition.=" and DATE(delever_date) BETWEEN '".$date_from."' AND '".$_POST['date_to']."' ";

						}
						}
			}			
						
			elseif(!empty($_POST['date_from']) && !empty($_POST['date_to']) )
			{
				$date_from = $_POST['date_from'];
				$condition.=" and DATE(entrydate) BETWEEN '".$date_from."' AND '".$_POST['date_to']."' ";
				
			}
			
					
					
				
				
				
			}
			}
			
		elseif(!empty($_POST['date_from']) && !empty($_POST['date_to']) )
			{
				
				$date_from = $_POST['date_from'];
				$condition.=" and DATE(entrydate) BETWEEN '".$date_from."' AND '".$_POST['date_to']."' ";
				
			}
				
			//print_r($_POST['cust_id']);	
			 if(!empty($_POST['cust_id']))
			{
				//$cus_data="'" . implode ( "', '", $_REQUEST['cust_id'] ) . "'";
				$condition.=" and cust_id IN (".implode(',',$_POST['cust_id']).") ";
				
			}
			
	
			if(!empty($_POST['fwd_th']))
			{
				  $condition.=" and frwd_throw ='".$_POST['fwd_th']."' ";
			}		
		if(!empty($_POST['hubsearch']))
			{
				$hubCity=getHubCity_multy($_POST['hubsearch']);
				if(!empty($hubCity)) 
				 $condition.=" and destination IN  (".$hubCity.") ";  
			}
		
		if(!empty($_REQUEST['onhold']))
			{
				$onhold = $_POST['onhold'];
				$condition.=" and refused = '".$onhold."' ";
				
			}
		if(!empty($_POST['mode']))
			{
				$mode = $_POST['mode'];
				$condition.=" and mode = '".$mode."' ";
				
			}	
		if(!empty($_POST['schedule']))
			{
				$schedule = $_POST['schedule'];
				$condition.=" and schedule_status = '".$schedule."' ";
				
			}		
			if(!empty($_POST['origin']))
			{
				
				$str_org = $_POST['origin'];

				$arr_val = explode(",",$str_org);
				//print_r($arr_val);exit;
				$origin_data="'" . implode ( "', '", $arr_val ) . "'";
				$condition.=" and origin IN (".$origin_data.") ";
				//print_r($origin_data);exit;
			}
			if(!empty($_POST['destination']))
			{
				$str_des = $_POST['destination'];

				$arr_val1 = explode(",",$str_des);

				$destination_data="'" . implode ( "', '", $arr_val1 ) . "'";
				$condition.=" and destination IN (".$destination_data.") ";
			} 
			if(!empty($_POST['shipmentStatus']))
			{
			if($_POST['shipmentStatus']=='O')
					{
						//$condition.=" and  code NOT IN ('POD','RTS')";	
						}
						elseif($_POST['shipmentStatus']=='OFD')
						
						{
						$condition.=" ";	
						}
						else
						{
						//$condition.=" and  code IN ('POD','RTS')";	
						}	
			}
			
	
		     $countDataQry="select count(id)as toltalCout from shipment where status='Y' and deleted='N' ".$condition_customer.$condition.$location_condition.$BETWEEN_Date; 
		    $query=$this->db->query($countDataQry); 
			$shipmentdata2=$query->row_array();
		 
		   $tolalShip=$shipmentdata2['toltalCout']; 
		  // $option="";
		
		foreach($post as $key=>$val)
		{
			
			//echo '<br>'. $key.'//'.$val;
			$param.='<input type="hidden" name="'.$key.'" value="'.$val.'">';
			
		}
		  	$downlaoadData=100;
		   $j=0;
		   for ($i=0;$i<=$tolalShip;)
		   { 
		   
		  $i=$i+$downlaoadData;
		  if($tolalShip>$i)
		  {
		   $option.=' <div class="col-md-2"><form method="post" target="_blank" action="'.$site_url.'/system145.php?c=report&f=report_download_final" >'.$param.'<button class="btn btn-info" name="download" value="'.$i.'">'.$j.'-'.$i.' <i class="fa fa-file-excel-o"></i></button></form></div>';
		  }
			   else
			   {
				   
				    $option.='<div class="col-md-2"><form method="post" target="_blank" action="'.$site_url.'/system145.php?c=report&f=report_download_final" >'.$param.'<button class="btn btn-info" name="download" value="'.$tolalShip.'">'.$j.'-'.$tolalShip.' <i class="fa fa-file-excel-o"></i></button></form></div>';
			   }
			$j=$i;   
			   }
			
		 
		 
		  
		//echo $option; 
		
		   $return['count']=$tolalShip;
		   $return['showarry']=$option;
		   echo json_encode($return); die;
		//print_r($datatest);
	
	
		//print_r($option);exit;
	
	}
}