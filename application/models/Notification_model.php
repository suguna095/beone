<?php
class Notification_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		
	
	public function getNotification()
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
         $this->db->from('notification'); 
         $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		 //$this->db->where('status','Y');
		 $this->db->where('deleted','N');
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getNotificationCount($data);  
			return $data;
		}
	}
	
	public function getNotificationCount()
	{
		   
			//$this->db->where('status','Y');
		    $this->db->where('deleted','N');
			$this->db->select('COUNT(id) as sh_count');
			$this->db->from('notification');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}
	
	
	public function insertnotification($data=array()) 
		{
			return $this->db->insert('notification',$data); 
		}
	
	public function getnotifydelete($data=array(),$id=null) 
	{
		return $this->db->update('notification',$data,array('id'=>$id));

	} 
	
	
	public function GetNotify_edit($id=null)
		{
		 $this->db->select('*');
         $this->db->from('notification'); 
        // $this->db->where('status', 'Y');
		// $this->db->where('deleted', 'N');
		 $this->db->where('id', $id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		}
		
		public function notifyUpdate($data=array(),$id=null) 
		{
			return $this->db->update('notification',$data,array('id'=>$id));
			//$this->db->last_query(); die(); 
		}
}
?>