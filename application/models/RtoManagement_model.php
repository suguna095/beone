<?php
class RtoManagement_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
public function Showrto($data=array())
	{
		$page_no;
          $limit = 20; 
        if(empty($data['page_no'])){
            $start = 0;
        }else{
            $start = ($data['page_no']-1)*$limit;
        }    
		if(!empty($data['searchfield']))
		 {
			 $searchfield=$data['searchfield'];
			$this->db->where('drs.drs_unique_id', $searchfield);
			
		 }
		 if(!empty($data['city_id']))
		 {
			 $city_id=$data['city_id'];
			$this->db->where("drs.city_id in (select id from country where city='$city_id')");  
				
		 }
		if(!empty($data['start_date']))
		 {
			$this->db->where('drs.drs_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }
		 $this->db->select('drs.*');
         $this->db->from('drs');
		 $this->db->join('shipment', 'shipment.slip_no = drs.shipment_id');
         $this->db->where('drs.deleted', 'N');
		 $this->db->where('drs.rto_status', $data['rto_status']);
		 $this->db->where('drs.delivered' ,'Y');
		 $this->db->where('drs.delivery_status' ,'N');
		 
		// $this->db->where('drs.shipment_id!=','');
		 //$this->db->group_by("drs.drs_unique_id");
		// $this->db->order_by("drs.id", 'DESC');
		 $this->db->limit($limit, $start);
		 
		
		
         $query = $this->db->get();
        
		//echo $this->db->last_query(); die;  
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->ShowrtoCount($data); 
			return $data;  
		}
	}
	
	public function ShowrtoCount($data=array())
		{
			
		if(!empty($data['searchfield']))
		 {
			 $searchfield=$data['searchfield'];
			//$this->db->where("drs.drs_unique_id LIKE '$searchfield%' or drs.routecode LIKE '$searchfield%' or drs.city_id LIKE '$searchfield%' or drs.messanger_id LIKE '$searchfield%' or drs.shipment_id LIKE '$searchfield%'");
			$this->db->where('drs.drs_unique_id', $searchfield);
			
		 }
		if(!empty($data['city_id']))
		 {
			 $city_id=$data['city_id'];
			$this->db->where("drs.city_id in (select id from country where city='$city_id')");  
				
		 }
		if(!empty($data['start_date']))
		 {
			$this->db->where('drs.drs_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }
		 
		$this->db->select('count(drs.id) as sh_count');
		$this->db->from('drs');
		$this->db->join('shipment', 'shipment.slip_no = drs.shipment_id');
        $this->db->where('drs.deleted', 'N');
		$this->db->where('drs.rto_status', $data['rto_status']);
		$this->db->where('drs.delivered' ,'Y');
		$this->db->where('drs.delivery_status' ,'N');
		 
		// $this->db->where('drs.shipment_id!=','');
		 //$this->db->group_by("drs.drs_unique_id");
		// $this->db->order_by("drs.id", 'DESC');
	
		
			$query = $this->db->get();
			
			//echo $this->db->last_query(); die;
			
				if($query->num_rows()>0){
				$data= $query->result_array();
				return $data[0]['sh_count'];    
				}
				return 0;
			
	  }
	  
	  
	  public function getTotal_drs_new($id=null)
		{
		 $this->db->select('count(shipment.id) as total_shipment');
         $this->db->from('drs'); 
		 $this->db->join('shipment', 'shipment.slip_no = drs.shipment_id');
		 $this->db->where('drs.deleted', 'N');
		  $this->db->where('drs.shipment_id!=', '');
		 $this->db->where('drs.drs_unique_id', $id);
		
		
         $query = $this->db->get();
       //return $this->db->last_query(); die; 
		  
				$data= $query->result_array();
				return $data[0]['total_shipment']; 
	
		}
		
		public function getTotal_drs($id=null)
		{
		 $this->db->select('count(id) as totalshipment');
         $this->db->from('drs'); 
		 $this->db->where('deleted', 'N');
		  $this->db->where('shipment_id!=', '');
		 $this->db->where('drs_unique_id', $id);
		$query = $this->db->get();
      //return $this->db->last_query(); die; 
		  
		$data= $query->result_array();
		return $data[0]['totalshipment']; 
	
		}
		
	 public function ShowPending($searchpending=null,$page_no) 
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
		if(!empty($searchpending))
		 {
			$this->db->where("city LIKE '%$searchpending%'");
			
		 }
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->ShowPendingCount($searchpending,$page_no);  
			return $data;
		}
	}
	
	public function ShowPendingCount($searchpending,$page_no)
	{
		   
		    if(!empty($searchpending))
		 {
			$this->db->where('city',$searchpending);
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
		
	public function GetCityRtoDrop() 
		{
			
		 $this->db->select('city,id'); 
         $this->db->from('country'); 
		 $this->db->where('city!=',''); 
		 //$this->db->where('main_status','16');
		
		 
		// $this->db->order by('sub_status','ASC') 
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();  
		}
		}
	
		 public function getRtoDataDetail($id=null) 
		{
		 $this->db->select('shipment.slip_no,shipment.code,shipment.d_attempt,shipment.schedule_date,shipment.nrd,shipment.cust_id,shipment.reciever_address,shipment.messanger_id,drs.*');
         $this->db->from('drs'); 
		 $this->db->join('shipment', 'shipment.slip_no = drs.shipment_id');
		 $this->db->where('drs.deleted', 'N');
		 $this->db->where('drs.shipment_id!=', '');
		 $this->db->where('drs.drs_unique_id', $id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
			return $data;
			
		}
		}


		public function getDRSUniqueid($id=null) 
		{
		 $this->db->select('drs.*');
         $this->db->from('drs'); 
		 $this->db->join('shipment', 'shipment.slip_no = drs.shipment_id');
		 $this->db->where('drs.deleted', 'N');
		 $this->db->where('shipment.status', 'Y');
		 $this->db->where('shipment.deleted', 'N');
		 $this->db->where('drs.deleted', 'N');
		 $this->db->where('drs.delivery_status', 'N');
		 $this->db->where('drs.rto_status', 'N');
		 $this->db->where('shipment.slip_no', $id);   
		
         $query = $this->db->get();
         //echo $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
			
		}   
		}




		public function getUpdateRtoDataDetail($id=null) 
		{
		 $this->db->select('shipment.*');
         $this->db->from('drs'); 
		 $this->db->join('shipment', 'shipment.slip_no = drs.shipment_id');
		 $this->db->where('drs.deleted', 'N');
		 $this->db->where('shipment.status', 'Y');
		 $this->db->where('shipment.deleted', 'N');
		 $this->db->where('drs.deleted', 'N');
		 $this->db->where('drs.delivery_status', 'N');
		 $this->db->where('drs.rto_status', 'N');
		 $this->db->where('drs.drs_unique_id', $id);   
		
         $query = $this->db->get();
         //echo $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
			return $data;
			
		}
		}

		public function AddrtoStatusdata($data)
	{
		$this->db->query($data);
	}
	

	
		public function getdeleteDrsDetail($data=array()) 
	{ 
		   
		
		 $this->db->select('shipment_id');
         $this->db->from('drs');
         $this->db->where('deleted', 'N');
		 $this->db->where('id',$data['id']);
		
         $query = $this->db->get();  
         //  return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
		
			return $query->row_array();
		}
	}
	
	public function getadminDetails($useradmin=null) 
	{ 
		   
		
		 $this->db->select('branch_location,name');
         $this->db->from('user');
         $this->db->where('deleted', 'N');
		 $this->db->where('id',$useradmin);
		
         $query = $this->db->get();  
           //return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
	}
	
	public function getdrsdelete($data=array(),$id=null)
	{
		return $this->db->update('drs',$data,array('id'=>$id));

	} 
	
	public function getshipmentdelete($data=array(),$id=null)
	{
		return $this->db->update('shipment',$data,array('slip_no'=>$id));

	} 
	
	public function insertStatus($data=array()) 
		{
			return $this->db->insert('status',$data);  
		}
		
	
	public function getActivity()  
	{ 
		   
		
		 $this->db->select('sub_status');
         $this->db->from('status_category');
         $this->db->where('deleted', 'N');
		 $this->db->where('code','RDRS');
		
         $query = $this->db->get();  
           //return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
	}
	
	
	public function GetalldrsPritqry($drs_unique_id=null)    
	{
		$query=$this->db->query("select shipment.*,drs . *,courier_staff . * from drs left join shipment on drs.shipment_id=shipment.slip_no left join courier_staff on drs.messanger_id=courier_staff.cor_id where drs.drs_unique_id='".$drs_unique_id."' and shipment.status='Y' and shipment.deleted='N' and drs.deleted='N' GROUP by drs.shipment_id order by drs.id");
		//echo $this->db->last_query(); die();   
		return $data= $query->result_array(); 
		 
	}
	
}
?>