<?php
class PickupLocation_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  

	public function getShowPickuplist($searchfield=null,$page_no)
	{ 
		$page_no;
          $limit = 100;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        }    
		 $this->db->select('*');
         $this->db->from('pickup_loaction');
         $this->db->order_by('id','ASC'); 
		 $this->db->limit($limit, $start); 
		 if(!empty($searchfield))
		 {
			$this->db->where("location_number LIKE '%$searchfield%'");
			
		 }
		 $this->db->where('deleted', 'N');			
         $query = $this->db->get();
          ////return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getShowPickuplistCount($searchfield,$page_no);  
			return $data;
		}
	}


public function getShowPickuplistCount($searchfield,$page_no)
	{
		 if(!empty($searchfield))
		 {
			$this->db->where('location_number',$searchfield);
		 }
		   
			$this->db->select('COUNT(id) as sh_count');
			$this->db->from('pickup_loaction');
			$this->db->order_by('id','ASC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}
	
		
	
	
	
	
	
}
?>