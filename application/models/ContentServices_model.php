<?php
class ContentServices_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		
	public function getContentservicesData($data=array())
	{
		$page_no;
          $limit = 20;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        }    
		
		 $this->db->select('*');
         $this->db->from('service_detail');
         $this->db->where('deleted', 'N');
		 //$this->db->where('shipment_id!=','');
		// $this->db->group_by("drs_unique_id"); 
		 $this->db->order_by("id", 'DESC');
		 $this->db->limit($limit, $start);
		 
		
		
         $query = $this->db->get();
           //return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getContentservicesDataCount($data); 
			return $data;
		}
	}
	
	public function getContentservicesDataCount($data=array())
		{
			 $this->db->select('count(id) as sh_count');
         $this->db->from('service_detail');
         $this->db->where('deleted', 'N');
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
	
	public function insertContent($data=array()) 
		{
			return $this->db->insert('service_detail',$data); 
		}
	
	public function getcontentdelete($data=array(),$id=null)
	{
		return $this->db->update('service_detail',$data,array('id'=>$id));

	}
	
	public function Getservices_edit($id=null)
		{
		 $this->db->select('*');
         $this->db->from('service_detail'); 
         $this->db->where('deleted', 'N'); 
		 $this->db->where('id', $id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		}
		
		public function ConServiceUpdate($data=array(),$id=null)  
		{
			return $this->db->update('service_detail',$data,array('id'=>$id));
			//$this->db->last_query(); die(); 
		}
		
	
	
	
}
?>