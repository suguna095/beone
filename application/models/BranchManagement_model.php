<?php
class BranchManagement_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		
	
	 public function getShowBranch()
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
         $this->db->from('branch');
        //  $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		 $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getShowBranchCount($data);  
			return $data;
		}
	}
	
	public function getShowBranchCount()
	{
		   
			$this->db->where('status', 'Y');
			$this->db->where('deleted', 'N');
			$this->db->select('COUNT(id) as sh_count');
			 $this->db->from('branch');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}
	
	public function getbranchdelete($data=array(),$id=null)
	{
		return $this->db->update('branch',$data,array('id'=>$id));

	} 
	
	
		public function updateBranch($data=array())
	{
		return $this->db->insert('branch',$data);
		 
		 // $this->db->last_query(); die;
		
	}
	
	public function Getbranchlist_edit($id=null)
		{
		 $this->db->select('*');
         $this->db->from('branch');
         //$this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		 $this->db->where('id', $id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		}
		
		public function branchFetch($data=array(),$id=null)
		{
			return $this->db->update('branch',$data,array('id'=>$id));   
			//$this->db->last_query(); die(); 
		}
		public function Getupdateactivestatus($data=array(),$id=null) 
	{
		return $this->db->update('branch',$data,array('id'=>$id));  
	}
	
	public function GetCityBranchDrop() 
		{
			
		 $this->db->select('*'); 
         $this->db->from('country'); 
		 //$this->db->where('main_status','16');
		
		 
		// $this->db->order by('sub_status','ASC') 
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();  
		}
		}
}
?>