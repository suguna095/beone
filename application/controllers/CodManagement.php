<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class CodManagement extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	   $this->load->model('CodManagement_model');
	   $this->load->helpers('utility_helper');
    }

	
	public function codShipment()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $CodDetailArray=$this->CodManagement_model->getCodShipment($_POST); 
		$returnArray=$CodDetailArray['result'];
		foreach($returnArray as $key=>$val)
		{ 
			
			$base64 = 'data:image/' . $type . ';base64,' . barcodeRuntime($returnArray[$key]['drs_unique_id']); 
			$returnArray[$key]['barcodeImage']=$base64; 
			//$returnArray[$key]['supplier']=getsupplierbyid($returnArray[$key]['supplier']);		 
			$returnArray[$key]['podcollected']=$this->CodManagement_model->GetPodCollect($returnArray[$key]['shipment_id'],$returnArray[$key]['drs_unique_id']);
			$returnArray[$key]['total_ship']=$this->CodManagement_model->Getallrtoshipmenttotal($returnArray[$key]['drs_unique_id'],'all');
			$returnArray[$key]['messangerName']=get_messanger_tablefield($returnArray[$key]['courier_id'],'messenger_name');
			$returnArray[$key]['supplier']=get_supp_tablefield($returnArray[$key]['messanger_id'],'name');	 
			$returnArray[$key]['routecode']=getRoutCode($returnArray[$key]['routecode']);	

			$returnArray[$key]['Del']=$this->CodManagement_model->GetDel($returnArray[$key]['drs_unique_id']);
			$returnArray[$key]['NotDel']=$this->CodManagement_model->GetNotDel($returnArray[$key]['drs_unique_id']);
			$returnArray[$key]['allShip']=$this->CodManagement_model->GetallShip($returnArray[$key]['drs_unique_id']);
			$returnArray[$key]['NP']=$this->CodManagement_model->GetNP($returnArray[$key]['drs_unique_id']);
			$returnArray[$key]['COD_AMOUNT']=$this->CodManagement_model->GetCOD_AMOUNT($returnArray[$key]['drs_unique_id']);
			$returnArray[$key]['totalAdd']=$returnArray[$key]['Del']+$returnArray[$key]['NotDel'];
		
		}
        $returnArrayR['count']=$CodDetailArray['count'];
		 $returnArrayR['result']=$returnArray;
		/* $CodArray=$returnArray['result'];
		 foreach($CodArray as $key=>$val)
		{
			
					
			$CodArray[$key]['total_shipment']=$this->CodManagement_model->TotalShip($CodArray[$key]['podcollected'],$CodArray[$key]['slip_no']); 
		}
		 $returnArrayS['result']=$CodArray;*/
		echo json_encode($returnArrayR); 
    }
	
	
public function PendingShipment() 
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $CodPendingDetailArray=$this->CodManagement_model->getPendingShipment($_POST); 
		$returnArray=$CodPendingDetailArray['result'];
		
		foreach($returnArray as $key=>$val)
		{
			
			$base64 = 'data:image/' . $type . ';base64,' . barcodeRuntime($returnArray[$key]['drs_unique_id']); 
			$returnArray[$key]['barcodeImage']=$base64; 
			//$returnArray[$key]['supplier']=getsupplierbyid($returnArray[$key]['supplier']);	 	
			$returnArray[$key]['podcollected']=$this->CodManagement_model->GetPodCollect($returnArray[$key]['shipment_id'],$returnArray[$key]['drs_unique_id']);
			$returnArray[$key]['total_ship']=$this->CodManagement_model->Getallrtoshipmenttotal($returnArray[$key]['drs_unique_id'],'all');
			$returnArray[$key]['messangerName']=get_messanger_tablefield($returnArray[$key]['courier_id'],'messenger_name');
			$returnArray[$key]['supplier']=get_supp_tablefield($returnArray[$key]['messanger_id'],'name');	
			$returnArray[$key]['routecode']=getRoutCode($returnArray[$key]['routecode']);	 

			$returnArray[$key]['Del']=$this->CodManagement_model->GetDel($returnArray[$key]['drs_unique_id']);
			$returnArray[$key]['NotDel']=$this->CodManagement_model->GetNotDel($returnArray[$key]['drs_unique_id']);
			$returnArray[$key]['allShip']=$this->CodManagement_model->GetallShip($returnArray[$key]['drs_unique_id']);
			$returnArray[$key]['NP']=$this->CodManagement_model->GetNP($returnArray[$key]['drs_unique_id']);
			$returnArray[$key]['COD_AMOUNT']=$this->CodManagement_model->GetCOD_AMOUNT($returnArray[$key]['drs_unique_id']);
			$returnArray[$key]['totalAdd']=$returnArray[$key]['Del']+$returnArray[$key]['NotDel'];
			$returnArray[$key]['totalamtRec']=$returnArray[$key]['amount_received'];
		}
        $returnArrayR['count']=$CodPendingDetailArray['count']; 
		 $returnArrayR['result']=$returnArray;
		/* $CodArray=$returnArray['result'];
		 foreach($CodArray as $key=>$val)
		{
			
					
			$CodArray[$key]['total_shipment']=$this->CodManagement_model->TotalShip($CodArray[$key]['podcollected'],$CodArray[$key]['slip_no']); 
		}
		 $returnArrayS['result']=$CodArray;*/
		echo json_encode($returnArrayR); 
    }
	
	public function CodCityDrop()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$returnArray=$this->CodManagement_model->GetCityCodDrop();     
		echo json_encode($returnArray);
	}
	
	
	    	public function ShowtotalcodDetails()
	{
		$_POST = json_decode(file_get_contents('php://input'), true); 
		$totalofdAray=$this->CodManagement_model->gettotalcodData($_POST);      
		$returnArray=$totalofdAray['result'];
	foreach($returnArray as $key=>$value) 
		{
	
		$returnArray[$key]['messangerName']=getDriverNameByid($returnArray[$key]['messanger_id']); 
		$returnArray[$key]['city_id']=getdestinationfieldshow($returnArray[$key]['city_id'],'city');
		$returnArray[$key]['Details']=get_detail($returnArray[$key]['slip_no'],'1');
	
		//$returnArray[$key]['drivercomment']=get_detail($returnArray[$key]['slip_no'],'1');		
		$returnArray[$key]['showstatus']=status_main_cat('1');
		}
	
		
		 $returnArrayR['result']=$returnArray;
	echo json_encode($returnArrayR);
	}
	  
	 
	public function getconfirmCOD()
	{
		
		$_POST = json_decode(file_get_contents('php://input'), true); 
		$CURRENT_DATE=date("Y-m-d H:i:s");
		$CURRENT_TIME=date("H:i");
		$drs_unique_id = $_POST['drs_unique_id']; 
		$totalofdAray=$this->CodManagement_model->getConfirmcodData($_POST);      
		$returnArray=$totalofdAray['result'];
		
		$userityname=Get_name_country_by_id('city',$this->session->userdata('adminbranchlocation'));
		$update_details="COD payment Recevied By  ".$this->session->userdata('user_name')." at $userityname";
		
		$CODUpdateArray=array('amount_received'=> 'Y');
		 $res_data=$this->CodManagement_model->UpdateCOD($CODUpdateArray,$drs_unique_id); 
		
	foreach($returnArray as $key=>$value) 
		{
	
	 $CODstatusArray=array('slip_no'=>$returnArray[$key]['shipment_id'],
								 'new_location'=>$this->session->userdata('adminbranchlocation'),
								 'new_status'=>'11',
								 'pickup_time'=>$CURRENT_TIME,
								 'pickup_date'=>$CURRENT_DATE,  
								 'Activites'=>'COD Payment Recevied',
								 'Details'=>$update_details,
								 'entry_date'=>$CURRENT_TIME,
								 'user_id'=>$this->session->userdata('useridadmin'),
								 'code'=>'CLOSED');  
								
								 $res_data=$this->CodManagement_model->insertStatus($CODstatusArray);  
		}
	
		
		 $returnArrayR['result']=$returnArray;
	echo json_encode($returnArrayR);
	}
	  
	  
	 public function printCODList($start_date=null,$end_date=null)
	{
	$_POST = json_decode(file_get_contents('php://input'), true); 

	$CodPendingDetailArray=$this->CodManagement_model->GetalldrsPritqry($start_date,$end_date);
		$returnArray=$CodPendingDetailArray['result'];
		//$returnArray[$key]['totalPOD']=0;
		$totalPOD=0;
		$totalAmount=0;
		 foreach($returnArray as $key=>$val)
		{
			
		
			$returnArray[$key]['supplier']=getsupplierbyid($returnArray[$key]['supplier']);		
			$returnArray[$key]['podcollected']=$this->CodManagement_model->GetPodCollect($returnArray[$key]['shipment_id'],$returnArray[$key]['drs_unique_id']);
			$returnArray[$key]['total_ship']=$this->CodManagement_model->Getallrtoshipmenttotal($returnArray[$key]['drs_unique_id'],'all');
			$returnArray[$key]['messangerName']=get_messanger_tablefield($returnArray[$key]['messanger_id'],'messenger_name');
			$returnArray[$key]['POD']=GetallrtoshipmenttotalClass($returnArray[$key]['drs_unique_id'],'Y');
			$returnArray[$key]['total_ship']=GetallrtoshipmenttotalClass($returnArray[$key]['drs_unique_id'],'all');
			$returnArray[$key]['NP']=GetallrtoshipmenttotalClass($returnArray[$key]['drs_unique_id'],'N');
			$returnArray[$key]['totalall']=GetallrtoshipmenttotalClass($returnArray[$key]['drs_unique_id'],'NP');
			$returnArray[$key]['COD_AMOUNT']=GetalltotalamountClass($returnArray[$key]['drs_unique_id']);   
			$totalPOD+=$returnArray[$key]['POD'];
			$totalAmount+=$returnArray[$key]['COD_AMOUNT'];   
		} 
	
			$view['totalPOD']=$totalPOD;
			$view['totalAmount']=$totalAmount;
			$view['data1']=$returnArray;
			$view['start_date']=$start_date;
			$view['end_date']=$end_date;
			//redirect(base_url().'print_barcode');
			
		$this->load->view('printCOD',$view); 
	//echo json_encode($start_date,$end_date); 
		
	}


	public function GetlabelPrint4_6($pickUpId=null,$page=null)
	{
	
     
        $this->load->helper('pdf_helper');
		$this->load->library('pagination');
		
         $data['pickupId']=$pickUpId;
			
	   $menifest_data=$this->CodManagement_model->PrintawbFilterShip($pickUpId);
	   //print_r($menifest_data); die();
	   $totalCount=count($menifest_data);
	   
	   $totalPOD=0;
	   $totalAmount=0;
	   $returnArray=$menifest_data['result'];


		foreach($returnArray as $key=>$val)
	   {
		
		   $messangerName = get_messanger_tablefield($returnArray[$key]['messanger_id'],'messenger_name');;
		   $totalPOD+=$returnArray[$key]['POD'];
		   $totalAmount+=$returnArray[$key]['COD_AMOUNT'];

		   $viewdate=date('F j, Y',strtotime($returnArray[$key]['delever_date']));
	   } 
   
	   		$view['totalCount']=$totalCount;
		   $view['data1']=$returnArray;
		   $view['messangerName']=$messangerName;  
		   $view['viewdate']=$viewdate;       
  
		  //print_r($view); die();
	   
	   $this->load->view('show_fiance_cod_details',$view);   
	}  


	
	
	 public function printPendingCOD($start_date=null,$end_date=null)
	{   
		
		/* $from_date=$this->input->post('from_date');
		$to_date=$this->input->post('to_date'); */
	
	$CodPendingDetailArray=$this->CodManagement_model->GetalldrsPrintPendingqry($from_date,$end_date);
		$returnArray=$CodPendingDetailArray['result'];
		//$returnArray[$key]['totalPOD']=0;
		$totalPOD=0;
		$totalAmount=0;
		 foreach($returnArray as $key=>$val)
		{
			
		
			$returnArray[$key]['supplier']=getsupplierbyid($returnArray[$key]['supplier']);		
			$returnArray[$key]['podcollected']=$this->CodManagement_model->GetPodCollect($returnArray[$key]['shipment_id'],$returnArray[$key]['drs_unique_id']);
			$returnArray[$key]['total_ship']=$this->CodManagement_model->Getallrtoshipmenttotal($returnArray[$key]['drs_unique_id'],'all');
			$returnArray[$key]['messangerName']=get_messanger_tablefield($returnArray[$key]['messanger_id'],'messenger_name');
			$returnArray[$key]['POD']=GetallrtoshipmenttotalClass($returnArray[$key]['drs_unique_id'],'Y');
			$returnArray[$key]['total_ship']=GetallrtoshipmenttotalClass($returnArray[$key]['drs_unique_id'],'all');
			$returnArray[$key]['NP']=GetallrtoshipmenttotalClass($returnArray[$key]['drs_unique_id'],'N');
			$returnArray[$key]['totalall']=GetallrtoshipmenttotalClass($returnArray[$key]['drs_unique_id'],'NP');
			$returnArray[$key]['COD_AMOUNT']=GetalltotalamountClass($returnArray[$key]['drs_unique_id']);
			$totalPOD+=$returnArray[$key]['POD'];
			$totalAmount+=$returnArray[$key]['COD_AMOUNT'];
		} 
	
			$view['totalPOD']=$totalPOD;
			$view['totalAmount']=$totalAmount;
			$view['data1']=$returnArray;
			$view['start_date']=$start_date;  
			$view['end_date']=$end_date;     
	//echo json_encode($_POST);
		
		$this->load->view('printCOD',$view); 
		
	}
	
	
	
	
	
public function GetCODExportData() 
{
		   $_POST = json_decode(file_get_contents('php://input'), true);
		    
		   /*  $dataAray=$this->ShipmentManagement_model->alllistData($_POST);
		    $tolalShip=$dataAray['count']; 
			$shiplimit=$_POST['shiplimit']; */
			  $downlaoadData=$_POST['limit'];
			  $conditions=$_POST['cond']; 
		    $j=0;
		   for($i=0;$i<$tolalShip;)
		   {  
			  $i=$i+$downlaoadData;
			  if($i>0)
			   $expoertdropArr[]=array('j'=>$j,'i'=>$i);
			 $j=$i;   
			}
			$end1=$shiplimit;
			if($end1<=$downlaoadData) 
				$start1=0;
			else
				$start1=$end1-$downlaoadData; 
				
			$resultArr=$this->CodManagement_model->confirmexportquery($start1,$downlaoadData,$conditions); 
			$totalPOD=0;
			$totalAmount=0;
			 foreach($resultArr as $key=>$val)
			{
				
			
				$resultArr[$key]['supplier']=getsupplierbyid($resultArr[$key]['supplier']);		
				$resultArr[$key]['podcollected']=$this->CodManagement_model->GetPodCollect($resultArr[$key]['shipment_id'],$resultArr[$key]['drs_unique_id']);
				$resultArr[$key]['total_ship']=$this->CodManagement_model->Getallrtoshipmenttotal($resultArr[$key]['drs_unique_id'],'all');
				$resultArr[$key]['messangerName']=get_messanger_tablefield($resultArr[$key]['messanger_id'],'messenger_name');
				$resultArr[$key]['POD']=GetallrtoshipmenttotalClass($resultArr[$key]['drs_unique_id'],'Y');
				$resultArr[$key]['total_ship']=GetallrtoshipmenttotalClass($resultArr[$key]['drs_unique_id'],'all');
				$resultArr[$key]['NP']=GetallrtoshipmenttotalClass($resultArr[$key]['drs_unique_id'],'N');
				$resultArr[$key]['totalall']=GetallrtoshipmenttotalClass($resultArr[$key]['drs_unique_id'],'NP');
				$resultArr[$key]['COD_AMOUNT']=GetalltotalamountClass($resultArr[$key]['drs_unique_id']);
				$totalPOD+=$resultArr[$key]['POD'];
				$totalAmount+=$resultArr[$key]['COD_AMOUNT'];
			}
       
        $file_name='confirm cod shipment '.date('Ymdhis').'.xls';
    
echo json_encode($this->exportcodconfirm($resultArr,$totalPOD,$totalAmount,$file_name)) ; 
		//echo json_encode($resultArr);
	}
	
	
	 function exportcodconfirm($dataEx,$totalPOD,$totalAmount,$file_name)
   {
    $dataArray=array();
    $i=0;
    foreach($dataEx as $data)
    {
        $dataArray[$i]['drs_date']=$data['drs_date'];
		$dataArray[$i]['shipment_id']=$data['shipment_id'];
		$dataArray[$i]['messangerName']=$data['messangerName'];
		$dataArray[$i]['supplier']=$data['supplier'];
		 $dataArray[$i]['routecode']=$data['routecode'];
		$dataArray[$i]['POD']=$data['POD'];
		$dataArray[$i]['total_ship']=$data['total_ship'];
		$dataArray[$i]['NP']=$data['NP']; 
		$dataArray[$i]['totalPOD']=$data['totalall'];  
		$dataArray[$i]['totalAmount']=$data['COD_AMOUNT']; 
		
		
      
     $i++ ; 
    }
    array_unshift($dataArray,'');
    $this->load->library("excel");
    $doc = new PHPExcel();

	  $doc->getActiveSheet()->fromArray($dataArray);
	  $from = "A1"; // or any value
	  $to = "K1"; // or any value
	  $doc->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold( true ); 
	  $doc->setActiveSheetIndex(0)
				->setCellValue('A1', 'Date')
			     ->setCellValue('B1', 'COD Collected By')
				 ->setCellValue('C1', 'Driver')
				->setCellValue('D1', 'Supplier') 
				 ->setCellValue('E1', ' Driver Code') 
				->setCellValue('F1', 'POD')
				->setCellValue('G1', 'NP')
				->setCellValue('H1', 'RTW')
				->setCellValue('I1', 'Total Ship') 
				->setCellValue('J1', 'COD Amt');
				
			
	$objWriter = PHPExcel_IOFactory::createWriter($doc, 'Excel5');
	ob_start();
	$objWriter->save("php://output");
	//$objWriter->save('packexcel/'.$file_name);    
	$xlsData = ob_get_contents();
	ob_end_clean();

return $response =  array(
        'op' => 'ok',
        'file_name'=>$file_name,
        'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
    );
  } 


public function GetCODPendExportData() 
{
		   $_POST = json_decode(file_get_contents('php://input'), true);
		    
		   /*  $dataAray=$this->ShipmentManagement_model->alllistData($_POST);
		    $tolalShip=$dataAray['count']; 
			$shiplimit=$_POST['shiplimit']; */
			  $downlaoadData=$_POST['limit'];
			  $conditions=$_POST['cond']; 
		    $j=0;
		   for($i=0;$i<$tolalShip;)
		   {  
			  $i=$i+$downlaoadData;
			  if($i>0)
			   $expoertdropArr[]=array('j'=>$j,'i'=>$i);
			 $j=$i;   
			}
			$end1=$shiplimit;
			if($end1<=$downlaoadData) 
				$start1=0;
			else
				$start1=$end1-$downlaoadData;  
				
			$resultArr=$this->CodManagement_model->Pendingexportquery($start1,$downlaoadData,$conditions); 

			$totalPOD=0;
			$totalAmount=0;
			foreach($resultArr as $key=>$val)
			{
				
			
				$resultArr[$key]['supplier']=getsupplierbyid($resultArr[$key]['supplier']);		
				$resultArr[$key]['podcollected']=$this->CodManagement_model->GetPodCollect($resultArr[$key]['shipment_id'],$resultArr[$key]['drs_unique_id']);
				$resultArr[$key]['total_ship']=$this->CodManagement_model->Getallrtoshipmenttotal($resultArr[$key]['drs_unique_id'],'all');
				$resultArr[$key]['messangerName']=get_messanger_tablefield($resultArr[$key]['messanger_id'],'messenger_name');
				$resultArr[$key]['POD']=GetallrtoshipmenttotalClass($resultArr[$key]['drs_unique_id'],'Y');
				$resultArr[$key]['total_ship']=GetallrtoshipmenttotalClass($resultArr[$key]['drs_unique_id'],'all');
				$resultArr[$key]['NP']=GetallrtoshipmenttotalClass($resultArr[$key]['drs_unique_id'],'N');
				$resultArr[$key]['totalall']=GetallrtoshipmenttotalClass($resultArr[$key]['drs_unique_id'],'NP');
				$resultArr[$key]['COD_AMOUNT']=GetalltotalamountClass($resultArr[$key]['drs_unique_id']);
				$totalPOD+=$resultArr[$key]['POD'];
				$totalAmount+=$resultArr[$key]['COD_AMOUNT']; 
			}   
       
        $file_name='pending cod shipment '.date('Ymdhis').'.xls';
    
echo json_encode($this->exportcodpend($resultArr,$totalPOD,$totalAmount,$file_name)) ; 
		//echo json_encode($resultArr);
	}
	
	
	 function exportcodpend($dataEx,$totalPOD,$totalAmount,$file_name)
   {
    $dataArray=array();
    $i=0;
    foreach($dataEx as $data)
    {
        $dataArray[$i]['drs_date']=$data['drs_date'];
		$dataArray[$i]['shipment_id']=$data['shipment_id'];
		$dataArray[$i]['messangerName']=$data['messangerName'];
		$dataArray[$i]['supplier']=$data['supplier'];
		 $dataArray[$i]['routecode']=$data['routecode'];
		 $dataArray[$i]['POD']=$data['POD'];
		 $dataArray[$i]['total_ship']=$data['total_ship'];
		 $dataArray[$i]['NP']=$data['NP']; 
		 $dataArray[$i]['totalPOD']=$data['totalall'];  
		 $dataArray[$i]['totalAmount']=$data['COD_AMOUNT']; 
		
		
      
     $i++ ; 
    }
    array_unshift($dataArray,'');
    $this->load->library("excel"); 
    $doc = new PHPExcel();

	  $doc->getActiveSheet()->fromArray($dataArray);
	  $from = "A1"; // or any value
	  $to = "K1"; // or any value
	  $doc->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold( true ); 
	  $doc->setActiveSheetIndex(0)
				->setCellValue('A1', 'Date')
			     ->setCellValue('B1', 'COD Collected By')
				 ->setCellValue('C1', 'Driver')
				->setCellValue('D1', 'Supplier') 
				 ->setCellValue('E1', ' Driver Code') 
				->setCellValue('F1', 'POD')
				->setCellValue('G1', 'NP')
				->setCellValue('H1', 'RTW')
				->setCellValue('I1', 'Total Ship') 
				->setCellValue('J1', 'COD Amt');
				
			
	$objWriter = PHPExcel_IOFactory::createWriter($doc, 'Excel5');
	ob_start();
	$objWriter->save("php://output");
	//$objWriter->save('packexcel/'.$file_name);    
	$xlsData = ob_get_contents();
	ob_end_clean();

return $response =  array(
        'op' => 'ok',
        'file_name'=>$file_name,
        'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData) 
    );
  } 

}


