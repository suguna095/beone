<?php
class CMS_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
 public function getviewCMS($searchfield=null,$page_no)
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
        $this->db->from('service_detail');
        $this->db->where('status', 'Y');
		$this->db->where('deleted', 'N');  
		
		$this->db->order_by('id','ASC'); 
		$this->db->limit($limit, $start); 
		
	
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getviewCMSCount($searchfield,$page_no);  
			return $data;
		}
	}
	
	public function getviewCMSCount($searchfield,$page_no)  
	{

	
		   
			$this->db->where('status', 'Y');
		    $this->db->where('deleted', 'N'); 
            $this->db->select('COUNT(id) as sh_count'); 
			$this->db->from('service_detail');
			$this->db->order_by('id','ASC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];     
				}
				return 0;
	}	
 

	public function GetCMS_edit($id=null)
		{
		 $this->db->select('*');
         $this->db->from('service_detail'); 
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
	

public function addUpdate($data=array(),$id=null)
		{
			return $this->db->update('service_detail',$data,array('id'=>$id));
		}
		
	
	
}
?>