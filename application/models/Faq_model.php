<?php
class Faq_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		
	public function getfaq()
	{
		
		 $this->db->select('*');
         $this->db->from('faq');
         $this->db->where('status', '0');
		 
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
	}
	
	
	public function getfaqdelete($data=array(),$id=null)
	{
		return $this->db->update('faq',$data,array('id'=>$id));

	} 
	public function updateFaq($data=array())
	{
		return $this->db->insert('faq',$data);
}
    public function getEditfaq($id=null)
	{
		
		 $this->db->select('*');
         $this->db->from('faq');
         $this->db->where('status', '0');
		 $this->db->where('id', $id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
	}
	public function faqUpdate($data=array(),$id=null)
		{
			return $this->db->update('faq',$data,array('id'=>$id));   
			//return $this->db->last_query(); die; 
		}
}
?>