<?php
class StaffManagement_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
	
   public function getShowstaff($searchstaff=null,$page_no)
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
         $this->db->from('user');
          $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		 $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		if(!empty($searchstaff))
		 {
			$this->db->where("name LIKE '%$searchstaff%' or phone LIKE '%$searchstaff%' or email LIKE '%$searchstaff%'");
			
		 }
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getShowstaffCount($searchstaff,$page_no);  
			return $data;
		}
	}
	
	public function getShowstaffCount($searchstaff,$page_no)
	{
		    if(!empty($searchstaff))
		 {
			$this->db->where('name','phone','email',$searchstaff);
		 }
			$this->db->where('status', 'Y');
			$this->db->where('deleted', 'N');
			$this->db->select('COUNT(id) as sh_count');
			 $this->db->from('user');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}
		
	
	public function CheckEmailExist($id=null)
		{
		 $this->db->select('*');
         $this->db->from('user'); 
         $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N'); 
		 $this->db->where('email', $id);
		
		
         $query = $this->db->get(); 
     //echo $this->db->last_query(); die; 
		
			return $query->num_rows();
		
		}
	

		public function getshelvename($searchText=null)
		{
		 $this->db->select('*');
         $this->db->from('warehous_shelve_no'); 
         $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		// $this->db->where("messenger_code like '%".$searchText."%'");  
		
		   
         $query = $this->db->get();
         //return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		}

		
	public function getstaffdelete($data=array(),$id=null)
	{
		return $this->db->update('user',$data,array('id'=>$id));

	} 
	
	
		public function InserStaff($data=array())
	{
		return $this->db->insert('user',$data);
		 
		 // $this->db->last_query(); die;
		
	}
	
	public function Getstafflist_edit($id=null)
		{
		 $this->db->select('*');
         $this->db->from('user');
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
		
		public function staffUpdate($data=array(),$id=null)
		{
			return $this->db->update('user',$data,array('id'=>$id));   
			//return $this->db->last_query(); die; 
		}
		
		public function Getupdateactivestatus($data=array(),$id=null) 
	{
		return $this->db->update('user',$data,array('id'=>$id));  
	}
}
?>