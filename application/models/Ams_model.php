<?php
class Ams_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		
	
		 public function getAMSdata()
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
         $this->db->from('address_management');
        $this->db->where('deleted', 'N'); 
		
		 $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getAMSdataCount($data);  
			return $data;
		}
	}
	
	public function getAMSdataCount() 
	{
		   
			$this->db->where('deleted', 'N');
            $this->db->select('COUNT(id) as sh_count');
			$this->db->from('address_management');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}	
	
	
	
		public function InsertAms($data=array())
	{
		return $this->db->insert('address_management',$data);
		 
		 // $this->db->last_query(); die;
		
	}
	
}
?>