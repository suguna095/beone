<?php
class ShowRating_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
	public function getShowratingData($data=array())  
	{
		$page_no;
          $limit = 20;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        }    
		  
		if(!empty($data['awb_no'])){
            $this->db->where('awb_no',$data['awb_no']);
        }
		if(!empty($data['driver_id'])){
            $this->db->where('driver_id',$data['driver_id']);
        }
		if(!empty($data['rating'])){
            $this->db->where('rating',$data['rating']);
        }
		 $this->db->select('*');
         $this->db->from('rating');
      
		 $this->db->order_by("id", 'DESC');
		 $this->db->limit($limit, $start);
		 
		
		
         $query = $this->db->get();
           //return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getShowratingDataCount($data); 
			return $data;
		}
	}
	
	public function getShowratingDataCount($data=array())
		{
			if(!empty($data['awb_no'])){
            $this->db->where('awb_no',$data['awb_no']);
        }
		if(!empty($data['driver_id'])){
            $this->db->where('driver_id',$data['driver_id']);
        }
		if(!empty($data['rating'])){
            $this->db->where('rating',$data['rating']);
        }
			 $this->db->select('count(id) as sh_count');
         $this->db->from('rating');
         //$this->db->where('deleted', 'N');
		 //$this->db->where('shipment_id!=','');
		 //$this->db->group_by("drs_unique_id");
		 $this->db->order_by("id", 'DESC');
		
		
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array();
				return $data[0]['sh_count'];    
				}
				return 0;
			
	  }
	
	
	public function GetDriverDropData($id=null)
		{
		 $this->db->select('*');
         $this->db->from('courier_staff'); 
         $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		 //$this->db->where('id', $id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		}
		
	
	
	
	
	
}
?>