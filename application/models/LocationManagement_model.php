<?php
class LocationManagement_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		
    public function InsertCityList($data=array())
		{
			return $this->db->insert('country',$data);
		}
		
		public function InsertStateList($data=array())
		{
			return $this->db->insert('country',$data);
		}
	
	public function InsertCountryList($data=array())
		{
			return $this->db->insert('country',$data);
		}
	
	 public function GetCountryListData($searchfield=null,$page_no)
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
		//$this->db->distinct('country');
		 $this->db->select('*');
         $this->db->from('country');
		 $this->db->where('city', '');
		 $this->db->where('state', '');
		 $this->db->where('country!=', '');
		 $this->db->group_by('country');
          $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		 $this->db->order_by('country','DESC'); 
		 $this->db->limit($limit, $start); 
		 if(!empty($searchfield))
		 {
			$this->db->where("country LIKE '%$searchfield%'");
			
		 }
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->GetCountryListDataCount($searchfield,$page_no);  
			return $data;
		}
	}
	
	public function GetCountryListDataCount($searchfield,$page_no)
	{
		   if(!empty($searchfield))
		 {
			$this->db->where('country',$searchfield);   
		 }
		   //$this->db->distinct();
			$this->db->where('status', 'Y');
			$this->db->where('deleted', 'N');
			$this->db->select('*');  
			 $this->db->from('country');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0; 
	}
		
	
		
		public function GetCountryAllData($country=null)
		{
		 
		 $this->db->select('*');
         $this->db->from('country'); 
        // $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		  $this->db->where('city!=', '');
		   //$this->db->where('state!=', '');
		 $this->db->where('country', $country);
		
		
         $query = $this->db->get();
        //return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		}
		
		public function GetCityCourierDrop() 
		{
		$this->db->select('*');
         $this->db->from('country');
		 $this->db->where('city', '');
		 $this->db->where('state', '');
		 $this->db->where('country!=', '');
		 $this->db->group_by('country');
          $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		 $this->db->order_by('country','DESC'); 
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();  
		}
		}
		
		
		public function getcountrydelete($data=array(),$id=null)
	{
		
		 $this->db->update('country',$data,array('id'=>$id));
         //return $this->db->last_query(); die; 
	} 
	
	public function getcountryAlldelete($data=array(),$id=null)
	{
		
		return $this->db->update('country',$data,array('id'=>$id)); 
         //return $this->db->last_query(); die; 
	} 
	
	
	public function GetCountry_edit($id=null)
		{
		 $this->db->select('*');
         $this->db->from('country'); 
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
		
		 public function CountryUpdateData($data=array(),$id=null) 
		{
			 $this->db->update('country',$data,array('id'=>$id));   
			//return $this->db->last_query(); die; 
		}
		
		 public function UpdateCityList($data=array(),$id=null) 
		{
			 $this->db->update('country',$data,array('id'=>$id));   
			//return $this->db->last_query(); die; 
		}
		

	
	public function dataUpdateAddedQry($data){
			$this->db->query($data);
		}
}
?>