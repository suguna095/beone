<?php
class RoutsManagement_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		
	
	public function getShowroute($searchroute=null,$page_no)
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
         $this->db->from('root');
		 $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start);
		 if(!empty($searchroute))
		 {
			$this->db->where("route LIKE '%$searchroute%' or routecode LIKE '%$searchroute%'");
			
		 }
          $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();  
            $data['count']=$this->getShowrouteCount($searchroute,$page_no);  
			return $data;
		}
	}
	
	public function getShowrouteCount($searchroute,$page_no)
	{
		  if(!empty($searchroute))
		 {
			$this->db->where('route','routecode',$searchroute);
		 }
			$this->db->where('status', 'Y');
			$this->db->where('deleted', 'N');
			$this->db->select('COUNT(id) as sh_count');
			 $this->db->from('root');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}
	
	public function getexcelroutrtabl()
	{
		$this->db->select('*');
         $this->db->from('root');
		 $this->db->order_by('id','DESC');
       $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');		 
		 $this->db->limit($limit, $start);
		  $query = $this->db->get();
		//echo  $this->db->last_query(); die; 
		  if($query->num_rows()>0)
		{
			return $query->result_array();
		}
	}
	
	public function getroutedelete($data=array(),$id=null)
	{
		return $this->db->update('root',$data,array('id'=>$id));

	} 
	
		public function getRoute($data=array())
	{
		return $this->db->insert('root',$data);
		 
		 //echo $this->db->last_query(); die;     
		
	}
	
	public function Getroutelist_edit($id=null)
		{
		 $this->db->select('*');
         $this->db->from('root');
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
		
		public function routeUpdate($data=array(),$id=null)
		{
			return $this->db->update('root',$data,array('id'=>$id));   
			
		}
		
		
		public function GetCityRouteDrop($data=array()) 
		{
			if(!empty($data))
			$country=Get_name_country_by_id('country',$data['country_id']);
			else
			$$country="";
		$this->db->distinct();
		 $this->db->select('*'); 
         $this->db->from('country'); 
		 $this->db->where("state!=''");
		$this->db->group_by('state');
		 $this->db->where('country',$country);
		 $this->db->where('deleted','N');
		  $this->db->where('status','Y');
         $query = $this->db->get();
		//echo $this->db->last_query(); die; 
			return $query->result_array();  
		
		}
}
?>