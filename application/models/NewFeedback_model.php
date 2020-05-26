<?php
class NewFeedback_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		
	public function getShowFeedbacklist($data=array())
	{ 
		$page_no;        
          $limit = 100;
        if(empty($data['page_no'])){
            $start = 0;
        }else{
            $start = ($data['page_no']-1)*$limit;
        }   
		if(!empty($data['rating']))
		 {
			$rating=$data['rating']; 
			$this->db->where("rating", $rating); 
						
		 }
		 
		  if(!empty($data['update_date']))
		 {
			$this->db->where("update_date like '".$data['update_date']."%'");  			
		 }
		 $this->db->select('*');
         $this->db->from('rating');
         $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		
		 // $this->db->where('deleted', 'N');			
         $query = $this->db->get();
          ////return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getShowFeedbacklistCount($data);  
			return $data;
		}
	}


public function getShowFeedbacklistCount($data)
	{
		if(!empty($data['rating']))
		{
		   $rating=$data['rating']; 
		   $this->db->where("rating", $rating); 
					   
		}
		
		 if(!empty($data['update_date']))
		{
			
			$this->db->where("update_date like '".$data['update_date']."%'");  	
					   
		}
			$this->db->select('COUNT(id) as sh_count');
			$this->db->from('rating');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}
	
	
	
	
}
?>