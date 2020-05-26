<?php
class BannerManagement_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		
	public function getShowbanner()
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
         $this->db->from('gallery_management');
         $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getShowbannerCount($data);  
			return $data;
		}
	}
	
	public function getShowbannerCount()
	{
		   
			
			$this->db->select('COUNT(id) as sh_count');
			 $this->db->from('gallery_management');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}
	
	public function insertbanner($data=array())
		{
			return $this->db->insert('gallery_management',$data);
		}
	
	public function editBannerUpdate($data=array(),$id=null)
		{
			return $this->db->update('gallery_management',$data,array('id'=>$id));
		}
		
		public function Getbannerlist_edit($id=null)
		{
		 $this->db->select('*');
         $this->db->from('gallery_management');
         
		 $this->db->where('id', $id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->row_array(); 
		}
		}
		
	
}
?>