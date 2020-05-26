<?php
class News_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		
		
		
		public function add($data=array())
		{
			return $this->db->insert('news',$data);
		}
		public function addUpdate($data=array(),$id=null)
		{
			return $this->db->update('news',$data,array('id'=>$id));
		}
		
		
		
		public function Gettablelist($heading=NULL,$content=NULL)
		{
		 $this->db->select('*');
         $this->db->from('news');
        
            if(!empty($heading))
        $this->db->where('heading like', '%'.$heading.'%');
            
             if(!empty($content))
        $this->db->where('content like', '%'.$content.'%');
         $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		}
		public function Gettablelist_edit($id=null)
		{
		 $this->db->select('*');
         $this->db->from('news');
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
		
	
	
	
	
	
}
?>