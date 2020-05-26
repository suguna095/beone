<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class OperationFilter extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
       $this->load->model('OperationFilter_model');
    }
	public function showordernotpickedlist()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->OperationFilter_model->getShowordernotpicked($_POST['searchfield'],$_POST['page_no']); 
		$maniarray=$returnArray['result'];
		foreach($maniarray as $key=>$val)
		{
			$maniarray[$key]['origin']=getdestinationfieldshow($val['origin'],'city');
			$maniarray[$key]['destination']=getdestinationfieldshow($val['destination'],'city');
		}
		$dataArray['pdata']=$_POST ;  
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count'];
		echo json_encode($dataArray);
    }

    public function showofdissuelist()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->OperationFilter_model->getShowofdissue($_POST); 
		$maniarray=$returnArray['result'];
		foreach($maniarray as $key=>$val)
		{
			
			$maniarray[$key]['origin']=getdestinationfieldshow($val['origin'],'city');
			$maniarray[$key]['destination']=getdestinationfieldshow($val['destination'],'city');
			//$maniarray[$key]['uidshow']=Get_cust_uid($val['cust_id']);
			$maniarray[$key]['reciever_city']=getdestinationfieldshow($val['reciever_city'],'city');
			$maniarray[$key]['showStatus']=status_main_cat($val['delivered']);
			$maniarray[$key]['uidshow']=Get_cust_uid($val['cust_id']);
			if($val['schedule_date']!='0000-00-00 00:00:00')
			$maniarray[$key]['schedule_date']=date('D d M Y',strtotime($val['schedule_date']));
			else
			$maniarray[$key]['schedule_date']='--';
			
			$statusData=get_detail($val['slip_no']);
			$maniarray[$key]['details']=$statusData['Details'];
			$maniarray[$key]['comment']=$statusData['comment'];
			$maniarray[$key]['messanger_id']=getDriverNameByid($val['messanger_id']);
			$maniarray[$key]['supplier']=get_supplier_name($val['messanger_id']);
			$maniarray[$key]['username']=Get_user_name($statusData['user_id'],$statusData['user_type']);
			if($statusData['entry_date']>0)
			$maniarray[$key]['entry_date1']=date('D d M Y',strtotime($statusData['entry_date']));
			else
			$maniarray[$key]['entry_date1']='--';
		}
		 $dataArray['pdata']=$_POST ;  
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count'];
		echo json_encode($dataArray);
    }


	 public function showofdissuelistExcel()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->OperationFilter_model->getShowofdissueExcel($_POST); 
		$maniarray=$returnArray['result'];
		foreach($maniarray as $key=>$val)
		{
			
			$maniarray[$key]['origin']=getdestinationfieldshow($val['origin'],'city');
			$maniarray[$key]['destination']=getdestinationfieldshow($val['destination'],'city');
			//$maniarray[$key]['uidshow']=Get_cust_uid($val['cust_id']);
			$maniarray[$key]['reciever_city']=getdestinationfieldshow($val['reciever_city'],'city');
			$maniarray[$key]['showStatus']=status_main_cat($val['delivered']);
			$maniarray[$key]['uidshow']=Get_cust_uid($val['cust_id']);
			if($val['schedule_date']!='0000-00-00 00:00:00')
			$maniarray[$key]['schedule_date']=date('D d M Y',strtotime($val['schedule_date']));
			else
			$maniarray[$key]['schedule_date']='--';
			
			$statusData=get_detail($val['slip_no']);
			$maniarray[$key]['details']=$statusData['Details'];
			$maniarray[$key]['comment']=$statusData['comment'];
			$maniarray[$key]['messanger_id']=getDriverNameByid($val['messanger_id']);
			$maniarray[$key]['supplier']=get_supplier_name($val['messanger_id']);
			$maniarray[$key]['username']=Get_user_name($statusData['user_id'],$statusData['user_type']);
			if($statusData['entry_date']>0)
			$maniarray[$key]['entry_date1']=date('D d M Y',strtotime($statusData['entry_date']));
			else
			$maniarray[$key]['entry_date1']='--';
		}
		 //$dataArray['pdata']=$_POST ;  
        //$dataArray['result']=$maniarray;   
		echo json_encode($maniarray);
    }

    public function showgetshipmentlist()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->OperationFilter_model->getShowshipment($_POST['searchfield'],$_POST['page_no']); 
		$maniarray=$returnArray['result'];
		foreach($maniarray as $key=>$val)
		{
			$maniarray[$key]['origin']=getdestinationfieldshow($val['origin'],'city');
			$maniarray[$key]['destination']=getdestinationfieldshow($val['destination'],'city');
		}
		 $dataArray['pdata']=$_POST ;  
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count'];
		echo json_encode($dataArray);
    }

    
    public function showgetcsaschedulelist()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->OperationFilter_model->getShowcsaschedule($_POST['searchfield'],$_POST['page_no']); 
		$maniarray=$returnArray['result'];
		foreach($maniarray as $key=>$val)
		{
			$maniarray[$key]['origin']=getdestinationfieldshow($val['origin'],'city');
			$maniarray[$key]['destination']=getdestinationfieldshow($val['destination'],'city');
			//$maniarray[$key]['uidshow']=Get_cust_uid($val['cust_id']);
			$maniarray[$key]['reciever_city']=getdestinationfieldshow($val['reciever_city'],'city');
			$maniarray[$key]['showStatus']=status_main_cat($val['delivered']);
			$maniarray[$key]['uidshow']=Get_cust_uid($val['cust_id']);
			if($val['schedule_date']!='0000-00-00 00:00:00')
			$maniarray[$key]['schedule_date']=date('D d M Y',strtotime($val['schedule_date']));
			else
			$maniarray[$key]['schedule_date']='--';
			
			$statusData=get_detail($val['slip_no']);
			$maniarray[$key]['details']=$statusData['Details'];
			$maniarray[$key]['comment']=$statusData['comment'];
			$maniarray[$key]['messanger_id']=getDriverNameByid($val['messanger_id']);
			$maniarray[$key]['supplier']=get_supplier_name($val['messanger_id']);
			$maniarray[$key]['username']=Get_user_name($statusData['user_id'],$statusData['user_type']);
			if($statusData['entry_date']>0)
			$maniarray[$key]['entry_date1']=date('D d M Y',strtotime($statusData['entry_date']));
			else
			$maniarray[$key]['entry_date1']='--';
		}
		 $dataArray['pdata']=$_POST ;  
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count'];
		echo json_encode($dataArray);
    }

	public function showgetcsaschedulelistExcel()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->OperationFilter_model->getShowcsascheduleExcel($_POST); 
		$maniarray=$returnArray['result'];
		foreach($maniarray as $key=>$val)
		{
			$maniarray[$key]['origin']=getdestinationfieldshow($val['origin'],'city');
			$maniarray[$key]['destination']=getdestinationfieldshow($val['destination'],'city');
			//$maniarray[$key]['uidshow']=Get_cust_uid($val['cust_id']);
			$maniarray[$key]['reciever_city']=getdestinationfieldshow($val['reciever_city'],'city');
			$maniarray[$key]['showStatus']=status_main_cat($val['delivered']);
			$maniarray[$key]['uidshow']=Get_cust_uid($val['cust_id']);
			if($val['schedule_date']!='0000-00-00 00:00:00')
			$maniarray[$key]['schedule_date']=date('D d M Y',strtotime($val['schedule_date']));
			else
			$maniarray[$key]['schedule_date']='--';
			
			$statusData=get_detail($val['slip_no']);
			$maniarray[$key]['details']=$statusData['Details'];
			$maniarray[$key]['comment']=$statusData['comment'];
			$maniarray[$key]['messanger_id']=getDriverNameByid($val['messanger_id']);
			$maniarray[$key]['supplier']=get_supplier_name($val['messanger_id']);
			$maniarray[$key]['username']=Get_user_name($statusData['user_id'],$statusData['user_type']);
			if($statusData['entry_date']>0)
			$maniarray[$key]['entry_date1']=date('D d M Y',strtotime($statusData['entry_date']));
			else
			$maniarray[$key]['entry_date1']='--';
		}
		 //$dataArray['pdata']=$_POST ;  
        //$dataArray['result']=$maniarray;   
		echo json_encode($maniarray); 
    }


     public function showgetlocationlist()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->OperationFilter_model->getShowcsalocation($_POST); 
		$maniarray=$returnArray['result'];
		foreach($maniarray as $key=>$val)
		{
			$maniarray[$key]['origin']=getdestinationfieldshow($val['origin'],'city');
			$maniarray[$key]['destination']=getdestinationfieldshow($val['destination'],'city');
			//$maniarray[$key]['uidshow']=Get_cust_uid($val['cust_id']);
			$maniarray[$key]['reciever_city']=getdestinationfieldshow($val['reciever_city'],'city');
			$maniarray[$key]['showStatus']=status_main_cat($val['delivered']);
			$maniarray[$key]['uidshow']=Get_cust_uid($val['cust_id']);
			if($val['schedule_date']!='0000-00-00 00:00:00')
			$maniarray[$key]['schedule_date']=date('D d M Y',strtotime($val['schedule_date']));
			else
			$maniarray[$key]['schedule_date']='--';
			
			$statusData=get_detail($val['slip_no']);
			$maniarray[$key]['details']=$statusData['Details'];
			$maniarray[$key]['comment']=$statusData['comment'];
			$maniarray[$key]['messanger_id']=getDriverNameByid($val['messanger_id']);
			$maniarray[$key]['supplier']=get_supplier_name($val['messanger_id']);
			$maniarray[$key]['username']=Get_user_name($statusData['user_id'],$statusData['user_type']);
			if($statusData['entry_date']>0)
			$maniarray[$key]['entry_date1']=date('D d M Y',strtotime($statusData['entry_date']));
			else
			$maniarray[$key]['entry_date1']='--';
		}
		 $dataArray['pdata']=$_POST ;  
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count'];
		echo json_encode($dataArray);
    }

	public function showgetlocationlistExcel()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->OperationFilter_model->getShowcsalocationExcel(); 
		$maniarray=$returnArray['result'];
		foreach($maniarray as $key=>$val)
		{
			$maniarray[$key]['origin']=getdestinationfieldshow($val['origin'],'city');
			$maniarray[$key]['destination']=getdestinationfieldshow($val['destination'],'city');
			//$maniarray[$key]['uidshow']=Get_cust_uid($val['cust_id']);
			$maniarray[$key]['reciever_city']=getdestinationfieldshow($val['reciever_city'],'city');
			$maniarray[$key]['showStatus']=status_main_cat($val['delivered']);
			$maniarray[$key]['uidshow']=Get_cust_uid($val['cust_id']);
			if($val['schedule_date']!='0000-00-00 00:00:00')
			$maniarray[$key]['schedule_date']=date('D d M Y',strtotime($val['schedule_date']));
			else
			$maniarray[$key]['schedule_date']='--';
			
			$statusData=get_detail($val['slip_no']);
			$maniarray[$key]['details']=$statusData['Details'];
			$maniarray[$key]['comment']=$statusData['comment'];
			$maniarray[$key]['messanger_id']=getDriverNameByid($val['messanger_id']);
			$maniarray[$key]['supplier']=get_supplier_name($val['messanger_id']);
			$maniarray[$key]['username']=Get_user_name($statusData['user_id'],$statusData['user_type']);
			if($statusData['entry_date']>0)
			$maniarray[$key]['entry_date1']=date('D d M Y',strtotime($statusData['entry_date']));
			else
			$maniarray[$key]['entry_date1']='--';
		}
		 //$dataArray['pdata']=$_POST ;  
       // $dataArray['result']=$maniarray;   
		echo json_encode($maniarray);  
	}
	
    public function showgetdriverlist()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->OperationFilter_model->getShowdriver($_POST['search_date'],$_POST['to_date'],$_POST['page_no']); 
		$maniarray=$returnArray['result'];
		foreach($maniarray as $key=>$val)
		{
			$maniarray[$key]['origin']=getdestinationfieldshow($val['origin'],'city');
			$maniarray[$key]['destination']=getdestinationfieldshow($val['destination'],'city');
			$maniarray[$key]['reciever_city']=getdestinationfieldshow($val['reciever_city'],'city');
			$maniarray[$key]['showStatus']=status_main_cat($val['delivered']);
			$maniarray[$key]['uidshow']=Get_cust_uid($val['cust_id']);
			if($val['schedule_date']!='0000-00-00 00:00:00')
			$maniarray[$key]['schedule_date']=date('D d M Y',strtotime($val['schedule_date']));
			else
			$maniarray[$key]['schedule_date']='--';
			
			
			
		}
		 $dataArray['pdata']=$_POST ;  
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count'];
		echo json_encode($dataArray);
    }

	public function showgetDriverlistExcel()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->OperationFilter_model->getShowdriverExcel($_POST); 
		$maniarray=$returnArray['result'];
		foreach($maniarray as $key=>$val)
		{
			$maniarray[$key]['origin']=getdestinationfieldshow($val['origin'],'city');
			$maniarray[$key]['destination']=getdestinationfieldshow($val['destination'],'city');
			$maniarray[$key]['reciever_city']=getdestinationfieldshow($val['reciever_city'],'city');
			$maniarray[$key]['showStatus']=status_main_cat($val['delivered']);
			$maniarray[$key]['uidshow']=Get_cust_uid($val['cust_id']);
			if($val['schedule_date']!='0000-00-00 00:00:00')
			$maniarray[$key]['schedule_date']=date('D d M Y',strtotime($val['schedule_date']));
			else
			$maniarray[$key]['schedule_date']='--';
			
			
			
		}
		 //$dataArray['pdata']=$_POST ;  
        //$dataArray['result']=$maniarray;   
		echo json_encode($maniarray);
	}
	
     public function showgetnotdispatchlist()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->OperationFilter_model->getShownotdispatched($_POST,$_POST['page_no']); 
		$maniarray=$returnArray['result'];
		foreach($maniarray as $key=>$val)
		{
			
			$maniarray[$key]['origin']=getdestinationfieldshow($val['origin'],'city');
			$maniarray[$key]['destination']=getdestinationfieldshow($val['destination'],'city');
			$maniarray[$key]['reciever_city']=getdestinationfieldshow($val['reciever_city'],'city');
			$maniarray[$key]['showStatus']=status_main_cat($val['delivered']);
			$maniarray[$key]['uidshow']=Get_cust_uid($val['cust_id']);
			if($val['schedule_date']!='0000-00-00 00:00:00')
			$maniarray[$key]['schedule_date']=date('D d M Y',strtotime($val['schedule_date']));
			else
			$maniarray[$key]['schedule_date']='--';
			$statusData=get_detail($val['slip_no']);
			$maniarray[$key]['details']=$statusData['Details'];
			$maniarray[$key]['comment']=$statusData['comment'];
			$maniarray[$key]['messanger_id']=getDriverNameByid($val['messanger_id']);
			$maniarray[$key]['supplier']=get_supplier_name($val['messanger_id']);
			$maniarray[$key]['username']=Get_user_name($statusData['user_id'],$statusData['user_type']);
			
			
			if($statusData['entry_date']>0)
			$maniarray[$key]['entry_date1']=date('D d M Y',strtotime($statusData['entry_date']));
			else
			$maniarray[$key]['entry_date1']='--';
			//$maniarray[$key]['details']=$statusData['Details'];
			
		}
		 $dataArray['pdata']=$_POST ;  
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count'];
		echo json_encode($dataArray);
	}
	

	public function showgetnotdispatchlistExcel()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->OperationFilter_model->getShownotdispatchedExcel($_POST); 
		$maniarray=$returnArray['result'];
		foreach($maniarray as $key=>$val)
		{
			
			$maniarray[$key]['origin']=getdestinationfieldshow($val['origin'],'city');
			$maniarray[$key]['destination']=getdestinationfieldshow($val['destination'],'city');
			$maniarray[$key]['reciever_city']=getdestinationfieldshow($val['reciever_city'],'city');
			$maniarray[$key]['showStatus']=status_main_cat($val['delivered']);
			$maniarray[$key]['uidshow']=Get_cust_uid($val['cust_id']);
			if($val['schedule_date']!='0000-00-00 00:00:00')
			$maniarray[$key]['schedule_date']=date('D d M Y',strtotime($val['schedule_date']));
			else
			$maniarray[$key]['schedule_date']='--';
			$statusData=get_detail($val['slip_no']);
			$maniarray[$key]['details']=$statusData['Details'];
			$maniarray[$key]['comment']=$statusData['comment'];
			$maniarray[$key]['messanger_id']=getDriverNameByid($val['messanger_id']);
			$maniarray[$key]['supplier']=get_supplier_name($val['messanger_id']);
			$maniarray[$key]['username']=Get_user_name($statusData['user_id'],$statusData['user_type']);
			
			
			if($statusData['entry_date']>0)
			$maniarray[$key]['entry_date1']=date('D d M Y',strtotime($statusData['entry_date']));
			else
			$maniarray[$key]['entry_date1']='--';
			//$maniarray[$key]['details']=$statusData['Details'];
			
		}
		 //$dataArray['pdata']=$_POST ;  
        //$dataArray['result']=$maniarray;   
		echo json_encode($maniarray);
    }




     public function getordernotpickedlist()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->OperationFilter_model->getShowordernotpick($_POST); 
		$maniarray=$returnArray['result'];
		foreach($maniarray as $key=>$val)
		{
			$maniarray[$key]['origin']=getdestinationfieldshow($val['origin'],'city');
			$maniarray[$key]['destination']=getdestinationfieldshow($val['destination'],'city');
			$maniarray[$key]['uidshow']=Get_cust_uid($val['cust_id']);
		}
		 $dataArray['pdata']=$_POST ;  
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count'];
		echo json_encode($dataArray);
    }


	public function getordernotpickedlistExcel()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->OperationFilter_model->getShowordernotpickExcel($_POST); 
		$maniarray=$returnArray['result'];
		foreach($maniarray as $key=>$val)
		{
			$maniarray[$key]['origin']=getdestinationfieldshow($val['origin'],'city');
			$maniarray[$key]['destination']=getdestinationfieldshow($val['destination'],'city');
			$maniarray[$key]['uidshow']=Get_cust_uid($val['cust_id']);
		}
		 //$dataArray['pdata']=$_POST ;  
        //$dataArray['result']=$maniarray;   
		echo json_encode($maniarray);
	}
	

public function showgetupdatelist()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->OperationFilter_model->getShowupdate($_POST); 
		$maniarray=$returnArray['result'];
		foreach($maniarray as $key=>$val)
		{
			$maniarray[$key]['origin']=getdestinationfieldshow($val['origin'],'city');
			$maniarray[$key]['destination']=getdestinationfieldshow($val['destination'],'city');
			$maniarray[$key]['uidshow']=Get_cust_uid($val['cust_id']);
		}
		 $dataArray['pdata']=$_POST ;  
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count'];
		echo json_encode($dataArray);
    }

	public function showgetupdatelistExcel()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->OperationFilter_model->getShowupdateExcel($_POST); 
		$maniarray=$returnArray['result'];
		foreach($maniarray as $key=>$val)
		{
			$maniarray[$key]['origin']=getdestinationfieldshow($val['origin'],'city');
			$maniarray[$key]['destination']=getdestinationfieldshow($val['destination'],'city');
			$maniarray[$key]['uidshow']=Get_cust_uid($val['cust_id']);
		}
		 //$dataArray['pdata']=$_POST ;  
        //$dataArray['result']=$maniarray;   
        //$dataArray['count']=$returnArray['count'];
		echo json_encode($maniarray);
    }



}