<?php
class ZoneManagement_model extends CI_Model
{
	
	function __construct()  
	{
		parent::__construct();
		
	
	}  
		
	public function getshowZonelist($searchfield=null,$page_no)
	{ 
		$page_no;
          $limit = 100;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        }    
		 $this->db->select('*');
         $this->db->from('zone_list');
		 $this->db->where('deleted','N'); 
        // $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		 if(!empty($searchfield))
		 {
			$this->db->where("name LIKE '%$searchfield%' or uniqueid LIKE '%$searchfield%' or phone LIKE '%$searchfield%' or email LIKE '%$searchfield%'");
			
		 }
		 //$this->db->where('status','Y');
		 $this->db->where('deleted','N');
         $query = $this->db->get();
          ////return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getgetshowZonelistCount($searchfield,$page_no);  
			return $data;
		}
	}
	
	public function getgetshowZonelistCount($searchfield,$page_no)
	{
		 if(!empty($searchfield))
		 {
			$this->db->where('name','uniqueid','phone','email',$searchfield); 
		 }
		   
			//$this->db->where('status','Y');
		    $this->db->where('deleted','N');
			$this->db->select('COUNT(id) as sh_count');
			$this->db->from('zone_list');
			$this->db->where('deleted','N'); 
			$this->db->where('name!=','');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array();  
				return $data[0]['sh_count'];    
				}
				return 0;
	}
	
	public function insertZone($data=array()) 
		{
			return $this->db->insert('zone_list',$data);   
		}
	
    public function Getzoneedit($id=null)
		{
		 $this->db->select('*');
         $this->db->from('zone_list'); 
		 //$this->db->where('status','Y');
         //$this->db->where('deleted', 'N'); 
		 $this->db->where('id', $id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		}
		
		public function EditZoneUpdate($data=array(),$id=null)  
		{
			return $this->db->update('zone_list',$data,array('id'=>$id));
			//$this->db->last_query(); die(); 
		}
	
	    public function getzonedelete($data=array(),$id=null)
	{
		return $this->db->update('zone_list',$data,array('id'=>$id));

	}
	
		public function CityZone($searchfield=null,$page_no,$alphabetic=null)
	{ 
		$page_no;
          $limit = 100;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        }    
		
		 if(!empty($searchfield))  
		 {
			$this->db->where("city LIKE '%$searchfield%'");
			
		 } 
		 
		  if(!empty($alphabetic))  
		 {
			$this->db->where("city LIKE '$alphabetic%'");
			
		 } 
		 $this->db->select('*');
         $this->db->from('country');
		 $this->db->where('city!=','');
     
		
		
         $query = $this->db->get();
         //return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->CityZoneCount($searchfield,$page_no,$alphabetic);   
			return $data;
		}
	}

	public function CityZoneCount($searchfield=null,$page_no,$alphabetic=null)
	{
		  if(!empty($searchfield))  
		 {
			$this->db->where("city LIKE '%$searchfield%'");
			
		 } 
		 
		  if(!empty($alphabetic))  
		 {
			$this->db->where("city LIKE '$alphabetic%'");
			
		 } 
		 
			$this->db->select('COUNT(id) as sh_count');  
			$this->db->from('country');
			$this->db->where('city!=','');
			//$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
			
				if($query->num_rows()>0){
				$data= $query->result_array();  
				return $data[0]['sh_count'];    
				}
				return 0; 
	}
	
	 public function showZoneDropData() 
		{
			
		 $this->db->select('name,id'); 
         $this->db->from('zone_list'); 
		 $this->db->where('deleted','N'); 
		 $this->db->where('status','Y'); 
		// $this->db->where('main_status','16');
		
		 
		// $this->db->order by('sub_status','ASC') 
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();  
		}
		}
	
	
	 public function showcountryZoneDropData() 
		{
			
		 $this->db->select('name,id'); 
         $this->db->from('zone_list'); 
		$this->db->where('type','W');
		$this->db->where('deleted','N');
		$this->db->where('status','Y');
		
		 
		// $this->db->order by('sub_status','ASC') 
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();  
		}
		}
		
		
	 public function showCityDropData() 
		{
			
		$this->db->select('id,city,country_zone_id'); 
        $this->db->from('country'); 
		$this->db->where('country','Saudi Arabia');
		$this->db->where('id IN(29661,29675,29663)');
		$this->db->where('status','Y');
		$this->db->where('deleted','N');
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();  
		}
		}
		
	public function GetZoneactivestatus($data=array(),$id=null) 
	{
		return $this->db->update('zone_list',$data,array('id'=>$id));  
	}
	
	
	public function GetUpdateZoneID($data=array(),$id=null) 
	{
		return $this->db->update('country',$data,array('id'=>$id));  
	}
	
	
	public function GetZoneDetails($id=null)  
		{
		 $this->db->select('*');
         $this->db->from('zone_list'); 
         $this->db->where('status','Y');
		 $this->db->where('deleted','N'); 
		 $this->db->where('name', $id);
		
         $query = $this->db->get(); 
         // return $this->db->last_query(); die; 
		
			return $query->num_rows();
		
		}
		
	
	public function CountryZone($searchfield=null,$page_no,$alphabetic=null)
	{ 
		$page_no;
          $limit = 100;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        }    
		
		 if(!empty($searchfield))  
		 {
			$this->db->where("country LIKE '%$searchfield%'");
			
		 } 
		 
		  if(!empty($alphabetic))  
		 {
			$this->db->where("country LIKE '$alphabetic%'");
			
		 } 
		 $this->db->select('*');
         $this->db->from('country');
		 $this->db->where('country','Saudi Arabia');
		  $this->db->where('city','');
		 $this->db->where('state','');
		 $this->db->where('deleted','N');
		
		
         $query = $this->db->get();
         //return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->CountryZoneCount($searchfield,$page_no,$alphabetic);   
			return $data;
		}
	}

	public function CountryZoneCount($searchfield=null,$page_no,$alphabetic=null)
	{
		  if(!empty($searchfield))  
		 {
			$this->db->where("country LIKE '%$searchfield%'");
			
		 } 
		 
		  if(!empty($alphabetic))  
		 {
			$this->db->where("country LIKE '$alphabetic%'");
			
		 } 
		 
			$this->db->select('COUNT(id) as sh_count');  
			 $this->db->from('country');
		 $this->db->where('country','Saudi Arabia');
		  $this->db->where('city','');
		 $this->db->where('state','');
		 $this->db->where('deleted','N');
			//$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
			
				if($query->num_rows()>0){
				$data= $query->result_array();  
				return $data[0]['sh_count'];    
				}
				return 0; 
	}
}
?>