<?php
class GeneralSetting_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		
	public function getuploadapp()
	{
		
		 $this->db->select('*');
         $this->db->from('upload_app');
         $this->db->where('status', '0');
		 $this->db->where('del', '0');
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
	}
	
	
		public function upload_app($data=array())
		{
			return $this->db->insert('upload_app',$data);
			 //return $this->db->last_query();
			
		}
		
			public function generalsetting($id=null)
		{
		 $this->db->select('*');
         $this->db->from('site_config'); 
         $query = $this->db->get();  
         // return $this->db->last_query(); die; 
		
			return $query->result_array();
		
		}
    
    	public function GetUserdetails($id=null)
		{
		 $this->db->select('*');
         $this->db->from('user'); 
         $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N'); 
		 $this->db->where('username', $id);
		
         $query = $this->db->get();  
         // return $this->db->last_query(); die; 
		
			return $query->num_rows();
		
		}
		
    	public function UsernameData($id=null)
		{
		 $this->db->select('username,id');
         $this->db->from('user'); 
         $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N'); 
		 $this->db->where('id', $id);
		
         $query = $this->db->get();  
         // return $this->db->last_query(); die; 
		
			return $query->result_array();
		
		}
		
		
		
		public function social_detail($data=array())
		{
			return $this->db->insert('generalsetting',$data);
			
		}
		
		public function payment_setting($data=array())
		{
			return $this->db->insert('generalsetting',$data);
			
		}
	
	public function admin($data=array(),$id)
		{
			return $this->db->update('user',$data,$id);
			
		}
		public function getcompany($data=array(),$id=null)
		{
			return $this->db->update('site_config',$data,array('id'=>$id));  
			    
		}
		  
		public function getaddfeed($data=array())
		{
			return $this->db->insert('feedback',$data);
			
		}
		
		public function getsmtp($data=array())
		{
			return $this->db->insert('smtp_configuration',$data);
			
		}
		
		public function gettestimonial()
	{
		
		 $this->db->select('*');
         $this->db->from('feedback');
         $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		 $this->db->where('approved', 'N');
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
	}
		
		public function getabout()
	{
		
		 $this->db->select('*');
         $this->db->from('about_us');
         $this->db->where('status', '0');
		 $this->db->where('del', '0');
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
	}
	
	public function getappdelete($data=array(),$id=null)
	{
		return $this->db->update('upload_app',$data,array('id'=>$id));

	} 
	
	public function getaboutus($id=null)
		{
		 $this->db->select('*');
         $this->db->from('about_us');
         $this->db->where('status', '0');
		 $this->db->where('del', '0');
		 $this->db->where('id', $id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		}
		
		public function abtUpdate($data=array(),$id=null)
		{
			return $this->db->update('about_us',$data,array('id'=>$id));
		}
		
		public function getabtsdelete($data=array(),$id=null)
	{
		return $this->db->update('about_us',$data,array('id'=>$id));

	} 
	
	public function gettestdelete($data=array(),$id=null)
	{
		return $this->db->update('feedback',$data,array('id'=>$id));

	} 

}
?>