<?php
class CouriersManagement_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
 public function getviewcourier($searchfield=null,$page_no)
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
         $this->db->from('courier_staff');
          $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		 $this->db->order_by('cor_id','DESC'); 
		 $this->db->limit($limit, $start); 
		 if(!empty($searchfield))
		 {
			$this->db->where("messenger_name LIKE '%$searchfield%' or mobile LIKE '%$searchfield%' or email LIKE '%$searchfield%'");
			
		 }
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getviewcourierCount($searchfield,$page_no);  
			return $data;
		}
	}
	
	public function getviewcourierCount($searchfield,$page_no)
	{
		   if(!empty($searchfield))
		 {
			$this->db->where('messenger_name','mobile','email',$searchfield); 
		 }
			$this->db->where('status', 'Y');
			$this->db->where('deleted', 'N');
			$this->db->select('COUNT(cor_id) as sh_count');  
			 $this->db->from('courier_staff');
			$this->db->order_by('cor_id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}
		

		public function getcourierdelete($data=array(),$cor_id=null)
	{
		return $this->db->update('courier_staff',$data,array('cor_id'=>$cor_id));

	} 
	
	
	public function Getcourier_edit($id=null)
		{
		 $this->db->select('*');
         $this->db->from('courier_staff'); 
         $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		 $this->db->where('cor_id', $id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
		return $query->row_array();
		
		}  
		}

		public function Getodometer_edit($cor_id=null)
		{
		 $this->db->select('*');
         $this->db->from('odometer');
		 $this->db->where('cor_id', $cor_id); 
		
		
         $query = $this->db->get();
        //  echo $this->db->last_query(); die;  
		  
		if($query->num_rows()>0)
		{
		return $query->result_array(); 
		
		}
		}

		
		  public function GetAssignRoot($city=null)
	{ 
		
			$this->db->where("city_id", $city); 
		
		$this->db->select('routecode,id,route,status'); 
         $this->db->from('root'); 
		 $this->db->where('deleted', 'N'); 
		$this->db->limit($limit, $start); 
        $query = $this->db->get();
      
	 //echo $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
			return $data;
		}
	}
	
	
		public function insertcourier($data=array()) 
		{
			return $this->db->insert('courier_staff',$data); 
			//return $this->db->last_query(); die;
		}
	   
	   
			public function CheckEmailExist($cor_id=null)
		{
		 $this->db->select('*');
         $this->db->from('courier_staff'); 
         $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N'); 
		 $this->db->where('email', $cor_id);
		
		
         $query = $this->db->get(); 
     //echo $this->db->last_query(); die; 
		
			return $query->num_rows();
		
		}
	   
      public function courierUpdate($data=array(),$cor_id=null) 
		{
			 $this->db->update('courier_staff',$data,array('cor_id'=>$cor_id));   
			//return $this->db->last_query(); die; 
		}

	public function getOdoData($data=array())
	{ 
		$page_no;
          $limit = 100;
        if(empty($page_no))
		{
            $start = 0;
        }
		else
		{
         $start = ($page_no-1)*$limit;
		}
		if(!empty($data['cor_id']))
		 {
			$cor_id=$data['cor_id']; 
			$driverData=explode('/',$cor_id);
			$driver_id=$driverData[2];	 
			$this->db->where('cor_id',$driver_id); 
						
		 }
		 
		 if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			$this->db->where('odometer.entry_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }
		 $this->db->select('*');
         $this->db->from('odometer');
         
		 $this->db->order_by('cor_id','DESC'); 
		 $this->db->group_by('cor_id');
		 $this->db->limit($limit, $start); 
		
		
         $query = $this->db->get();
          //echo $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getOdoDataCount($data);  
			return $data;
		}
	}
	
	public function getOdoDataCount()
	{
		   
			if(!empty($data['cor_id']))
		 {
			$cor_id=$data['cor_id']; 
			$driverData=explode('/',$cor_id);
			$driver_id=$driverData[2];	 
			//$this->db->where('cor_id in (select cor_id from courier_staff where messenger_name="'.$driver_id.'")'); 
			$this->db->where('cor_id',$driver_id); 
						
		 }  
		 
		 if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			$this->db->where('odometer.entry_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }
			$this->db->select('COUNT(cor_id) as sh_count');  
			 $this->db->from('odometer');
			$this->db->order_by('cor_id','DESC');
			
			$query = $this->db->get();
			//return $this->db->last_query(); die; 
			
			
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}
		
     
	 public function Getodo_edit($cor_id=null)
		{
		 $this->db->select('*');
         $this->db->from('odometer'); 
        
		 $this->db->where('cor_id', $cor_id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			return $query->row_array(); 
		}
		}
		
		 public function odoUpdate($data=array(),$cor_id=null) 
		{
			return $this->db->update('odometer',$data,array('cor_id'=>$cor_id));    
			//return $this->db->last_query(); die; 
		}
		
		public function GetCityCourierDrop() 
		{
			
		 $this->db->select('*'); 
         $this->db->from('country'); 
		 $this->db->where('status','Y');
		 $this->db->where('deleted','N');
		$query = $this->db->get();
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();  
		}
		}
		
		public function GetVehicleCourierDrop() 
		{
			
		 $this->db->select('*'); 
         $this->db->from('vehicle'); 
		$query = $this->db->get();
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();  
		}
		}
		
		public function GetSupplierCourierDrop() 
		{
			
		 $this->db->select('*'); 
         $this->db->from('supplier'); 
		 $this->db->where('deleted', 'N');
		$query = $this->db->get();
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();  
		}
		}
		
		
		public function GetCoractivestatus($data=array(),$cor_id=null) 
	{
		return $this->db->update('courier_staff',$data,array('cor_id'=>$cor_id));  
	}
	
	public function checkEmailExitsQry($old_email=null)
	  {
		  $query=$this->db->query("select * from courier_staff where deleted='N' and email='".$old_email."'");
	  //echo $this->db->last_query(); die();
		 return  $query->num_rows();
	  }
	  
	public function dataUpdateAddedQry($data){
			$this->db->query($data);
		}

public function getCityIdQry($city=null) 
		{
			
		 $this->db->select('id'); 
         $this->db->from('country'); 
		 $this->db->where('city', $city);
		$query = $this->db->get();
		
		if($query->num_rows()>0){
		$data= $query->result_array(); 
		return $data[0]['id'];    
		}
		return 0;
		}
	
public function GetCityId($id=null) 
		{
			
		 $this->db->select('city'); 
         $this->db->from('courier_staff'); 
		 $this->db->where('cor_id', $id);
		$query = $this->db->get();
		
		if($query->num_rows()>0){
		$data= $query->result_array(); 
		return $data[0]['city'];    
		}
		return 0;
		}
		
	public function InsertAssignRoot($data=array()) 
		{
			return $this->db->insert('courier_routing',$data); 
			//return $this->db->last_query(); die;
		}
	
	public function DeleteAssignroot($courierid=null,$root_id=null)
	{
	 $this->db->query("delete from courier_routing where cor_id='".$courierid."' and rout='".$root_id."'");
	 return false;
	}	
}


?>