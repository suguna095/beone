<?php
class ServicesManagement_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		
	
	public function GetServicelistData()
	{ 
		
		 $this->db->select('*');
         $this->db->from('services');
		 $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start);
		 
          //$this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();  
            
			
		}
	}
	
	
	public function getserviceedelete($data=array(),$id=null)
	{
		 $this->db->update('services',$data,array('id'=>$id));

	} 
	
	public function UpdateserviceStatus($data=array(),$id=null)
	{
		 $this->db->update('services',$data,array('id'=>$id));

	} 
	
	public function ServiceUpdateData($data=array(),$id=null)
	{
		return $this->db->update('services',$data,array('id'=>$id));

	} 
	
		public function InsertService($data=array())
	{
		return $this->db->insert('services',$data);
		 
		 // $this->db->last_query(); die;   
		
	}
	
	public function GetEditData($id=null)
		{
		 $this->db->select('*');
         $this->db->from('services');
        // $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		 $this->db->where('id', $id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		}
		
	public function GetServiceDetails($services_name=null)  
		{
		 $this->db->select('*');
         $this->db->from('services'); 
         //$this->db->where('status','Y');
		 $this->db->where('deleted', 'N'); 
		 $this->db->where('services_name', $services_name);

         $query = $this->db->get(); 
         // return $this->db->last_query(); die; 
		
			return $query->num_rows();
		
		}	
		
		
}
?>