<?php
class EmailTemplates_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		
	public function getmails()
	{
		
		$this->db->select('*');
        $this->db->from('mails');
       $this->db->where('deleted', 'N');
        $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
	}
	
	
	public function Getmaillist_edit($id=null)
		{
		 $this->db->select('*');
         $this->db->from('mails');
         $this->db->where('deleted', 'N');
		 $this->db->where('id', $id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		}
	 public function mailUpdate($data=array(),$id=null)
		{
			return $this->db->update('mails',$data,array('id'=>$id));   
			//return $this->db->last_query(); die; 
		}
}
?>