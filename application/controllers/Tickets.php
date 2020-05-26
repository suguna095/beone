<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Tickets extends CI_Controller {
 function __construct() {
        parent::__construct();
       error_reporting(0);
        $this->load->model("Tickets_model");
    }

public function show_ticket()
{
	$_POST = json_decode(file_get_contents('php://input'), true);
	  $returnArray=$this->Tickets_model->getviewticket($_POST['searchfield'],$_POST['page_no']);
      $maniarray1=$returnArray['result'];
      $dataArray['pdata']=$_POST ;  
      $dataArray['result']=$maniarray1;   
      $dataArray['count']=$returnArray['count'];
	 echo json_encode($dataArray); 	


}

public function get_delete_ticket()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$array=array('deleted'=>'Y'); 
		 $ReturnData=$this->Tickets_model->getticketdelete($array,$_POST['id']);   
		 echo json_encode($ReturnData);  
	}
	
public function ShowSendMailData()
{
	$_POST = json_decode(file_get_contents('php://input'), true);
	$table_id=$_POST['id'];
	$returnArray=$this->Tickets_model->GetSendMail_edit($table_id);
	echo json_encode($returnArray);
}

public function ShowTicketdMailData()
{
	$_POST = json_decode(file_get_contents('php://input'), true);
	$table_id=$_POST['id'];
	$returnArray=$this->Tickets_model->GetTicketPopupdata($table_id);
	echo json_encode($returnArray);
}

public function ShowReplyMsg()
	{
		$_POST = json_decode(file_get_contents('php://input'), true);
		$table_id=$_POST['id'];
		
		$returnArray=$this->Tickets_model->GetReplyMsg($table_id); 
	
		 echo json_encode($returnArray);
	}


public function TicketstatusUpdate()
	{
		//echo $ticket_status; die;
		$_POST = json_decode(file_get_contents('php://input'), true);
		//$status = $this->db->query("select status from customer  where id = $_POST['id']")->row()->status;
		$table_id=$_POST['id'];
        $array=array('ticket_status'=>$_POST['ticket_status']);  
		
		 $returnArray=$this->Tickets_model->GetTicketstatus($array, $table_id);
		 echo json_encode($returnArray); 
	}
	public function TicketDetailsDataShowPage()
	{
		//echo $ticket_status; die;
		$_POST = json_decode(file_get_contents('php://input'), true);
		//$status = $this->db->query("select status from customer  where id = $_POST['id']")->row()->status;
		$ticketno=$_POST['ticketno'];
       
		
		 $returnArray=$this->Tickets_model->TicketDetailsDataShowPageQry($ticketno);
		 echo json_encode($returnArray); 
	}
	
	public function UpdateReply()
	{
		$_POST = json_decode(file_get_contents('php://input'), true); 
		
		$dataArray=$_POST['ReplyDataArray'];
		
		//$ReplyDataArray=array('r_id'=>$this->session->userdata('useridadmin'),'q_type'=>'R','reply_comment'=>$dataArray['reply_comment'],'entry_date'=>date("Y-m-d H:i:s"));
		$returnArray=$this->Tickets_model->UpdateReplyData($dataArray);  
		echo json_encode($returnArray);
	}
}