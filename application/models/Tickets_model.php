<?php
class Tickets_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
 public function getviewticket($searchfield=null,$page_no)
	{ 
		$page_no;
          $limit = 20;
        if(empty($page_no))
		{
            $start = 0;
        }
		else
		{
         $start = ($page_no-1)*$limit; 
		}
		$this->db->select('*');
        $this->db->from('contactus');
        $this->db->where('status', 'Y');
		$this->db->where('deleted', 'N');  
		$this->db->where('q_type', 'Q');  
		$this->db->group_by('ticket_no');  
		
		$this->db->order_by('id','DESC'); 
		$this->db->limit($limit, $start); 
		
		if(!empty($searchfield))
		 {
			$this->db->where("awb_no LIKE '%$searchfield%' OR ticket_no LIKE '%$searchfield%'");
			
		 }
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getviewticketCount($searchfield,$page_no);  
			return $data;
		}
	}
	
	public function getviewticketCount($searchfield,$page_no)  
	{

		 if(!empty($searchfield))
		 {
			$this->db->where('awb_no','ticket_no',$searchfield);
		 }
		   
			$this->db->where('status', 'Y');
		    $this->db->where('deleted', 'N'); 
            $this->db->select('COUNT(id) as sh_count'); 
			$this->db->from('contactus');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];     
				}
				return 0;
	}	
 

		public function getticketdelete($data=array(),$id=null)
	{
		return $this->db->update('contactus',$data,array('id'=>$id));

	} 
	
  public function GetSendMail_edit($id=null)
		{
		 $this->db->select('*');
         $this->db->from('contactus'); 
         $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		 $this->db->where('id', $id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		}
	
	 public function GetTicketPopupdata($id=null)
		{
		 $this->db->select('*');
         $this->db->from('contactus'); 
         $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		 $this->db->where('id', $id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		}
	
	 public function GetReplyMsg($id=null)
		{
		 $this->db->select('*');
         $this->db->from('contactus'); 
         $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		 $this->db->where('id', $id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		}
		 public function TicketDetailsDataShowPageQry($ticket_no=null)
		{
		 $this->db->select('*');
         $this->db->from('contactus'); 
         $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		 $this->db->where('ticket_no', $ticket_no);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		}
		
		public function GetTicketstatus($data=array(),$id=null) 
	{
		
		return $this->db->update('contactus',$data,array('id'=>$id)); 
        //return $this->db->last_query(); die;		
	}
	
	public function UpdateReplyData($template=array())
	{
		
		       $date=date("Y-m-d H:i:s");
				 $add_contactus="insert into contactus (name,email,entry_date,subject,mobile, awb_no, user_id,ticket_no,message,priority,q_type,r_id) values ('".$template['name']."', '".$template['email']."', '".$date."','".$template['subject']."','".$template['mobile']."','".$template['awb_no']."','".$template['user_id']."','".$template['ticket_no']."','".$template['sendmess']."','".$template['priority']."','R','".$this->session->userdata('useridadmin')."')";
				return $this->db->query($add_contactus);
        //return $this->db->last_query(); die;
	} 
	
	
}
?>