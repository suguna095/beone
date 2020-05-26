<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Notification extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
	   $this->load->model('Notification_model');
    }
    
	 public function showNotificationlist()
    {
		$_POST = json_decode(file_get_contents('php://input'), true);
	    $returnArray=$this->Notification_model->getNotification(); 
		$maniarray=$returnArray['result'];
        $dataArray['result']=$maniarray;   
        $dataArray['count']=$returnArray['count'];
		echo json_encode($returnArray);
    }
	
	public function AddNotification()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$dataArray=$_POST['add_notification']; 
		$notificationArray=array('title'=>$dataArray['title'],'notification_desc'=>$dataArray['notification_desc'],'entry_date'=>$dataArray['entry_date'],'expiry_date'=>$dataArray['expiry_date']);
        $res_data=$this->Notification_model->insertnotification($notificationArray);
        echo json_encode($res_data);
	}
	
	public function get_delete_notify()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('deleted'=>'Y');
		$ReturnData=$this->Notification_model->getnotifydelete($array,$_POST['id']);  
		echo json_encode($ReturnData);  
	}
	
	public function GetActivestatusUpdate()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
        $array=array('status'=>$_POST['status']);  
		
		 $returnArray=$this->Notification_model->getnotifydelete($array, $_POST['id']); 
		 echo json_encode($_POST);
	}
	
	
	 public function geteditNotifyData()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['notifyid'];
        $returnArray=$this->Notification_model->GetNotify_edit($table_id);
        echo json_encode($returnArray);
	}
	
	 public function edit_notifyform()
	 {
		$_POST = json_decode(file_get_contents('php://input'), true);
        $dataArray=$_POST['edit_notification'];
		$notifyid = $dataArray['notifyid'];   
        $editnotificationArray=array('title'=>$dataArray['title'],'notification_desc'=>$dataArray['notification_desc'],'entry_date'=>$dataArray['entry_date'],'expiry_date'=>$dataArray['expiry_date']);		 
		$res_data=$this->Notification_model->notifyUpdate($editnotificationArray,$notifyid);   	
        echo json_encode($res_data);
     }		
}