<?php
class DeliveryRunSheet_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		
	
	public function getDrsData($data=array())
	{
		$page_no;
          $limit = 20; 
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        }    
		if(!empty($data['searchfield']))
		 {
			 $searchfield=$data['searchfield'];
			$this->db->where("drs_unique_id LIKE '%$searchfield%' or routecode LIKE '%$searchfield%' or city_id LIKE '%$searchfield%' or messanger_id LIKE '%$searchfield%' or shipment_id LIKE '%$searchfield%'");
			
		 }
		if(!empty($data['start_date']))
		 {
			
			$this->db->where("DATE(drs_date)", $data["start_date"]); 
				
		 }
		 if(!empty($data['end_date']))
		 {
			
			$this->db->where("DATE(drs_date)", $data["end_date"]); 
				
		 }
		 $this->db->select('*');
         $this->db->from('drs');
         $this->db->where('deleted', 'N');
		  $this->db->where('shipment_id!=','');
		 $this->db->group_by("drs_unique_id");
		 $this->db->order_by("id", 'DESC');
		 $this->db->limit($limit, $start);
		 
		
		
         $query = $this->db->get();
           //return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getDrsDataCount($data); 
			return $data;  
		}
	}
	
	public function getDrsDataCount($data=array())
		{
			
			if(!empty($data['searchfield']))
		 {
			 $searchfield=$data['searchfield'];
			$this->db->where("drs_unique_id LIKE '%$searchfield%' or routecode LIKE '%$searchfield%' or city_id LIKE '%$searchfield%' or messanger_id LIKE '%$searchfield%' or shipment_id LIKE '%$searchfield%'");
			
		 }
		if(!empty($data['start_date']))
		 {
			
			$this->db->where("DATE(drs_date)", $data["start_date"]); 
				
		 }
		 if(!empty($data['end_date']))
		 {
			
			$this->db->where("DATE(drs_date)", $data["end_date"]); 
				
		 }
		 
		 $this->db->select('count(*) as sh_count');
         $this->db->from('drs');
         $this->db->where('deleted', 'N');
		 $this->db->where('shipment_id!=','');
		 $this->db->group_by("drs_unique_id");
		 $this->db->order_by("id", 'DESC');
	
		
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array();
				return $data[0]['sh_count'];    
				}
				return 0;
			
	  }
	  
	  
	  public function getDrsDetailData($id=null)
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
		
	  public function getnotdeliveredDetailData($id=null)
		{
		 $this->db->select('shipment.slip_no,shipment.code,shipment.d_attempt,shipment.schedule_date,shipment.nrd,shipment.cust_id,shipment.reciever_address,shipment.messanger_id,drs.*');
         $this->db->from('drs'); 
		 $this->db->join('shipment', 'shipment.slip_no = drs.shipment_id');
		 $this->db->where('drs.deleted', 'N');
		 $this->db->where('drs.shipment_id!=', '');
		 $this->db->where('drs.delivery_status', 'N');
		  $this->db->where('shipment.delivered!=', '11');
		 $this->db->where('drs.drs_unique_id', $id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
			return $data;
			
		}
		}
		
		 public function getdeliveredDetailData($id=null)
		{
		 $this->db->select('shipment.slip_no,shipment.code,shipment.d_attempt,shipment.schedule_date,shipment.nrd,shipment.cust_id,shipment.reciever_address,shipment.messanger_id,drs.*');
         $this->db->from('drs'); 
		 $this->db->join('shipment', 'shipment.slip_no = drs.shipment_id');
		 $this->db->where('drs.deleted', 'N');
		 $this->db->where('drs.shipment_id!=', '');
		 $this->db->where('shipment.delivered', '1');
		 $this->db->where('drs.drs_unique_id', $id);
		
		
         $query = $this->db->get();

 //return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
			return $data;
			
		}
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
		
	  	public function getDrsDetailData1($data=array()) 
	{ 
		   
		
		 $this->db->select('*');
         $this->db->from('drs');
         $this->db->where('deleted', 'N');
		 $this->db->where('shipment_id!=','');
		 if(!empty($data))
		 $this->db->where($data);
		 $this->db->order_by("id", 'DESC');
		
		 
		
		
         $query = $this->db->get();
           //return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$dataresult['result']=$query->result_array();
            $dataresult['count']=$this->getDrsDetailDataCount($data); 
			return $dataresult;
		}
	}
	  
	  public function getDrsDetailDataCount($data1=array())  
		{
			 $this->db->select('count(id) as sh_count');
         $this->db->from('drs');
          $this->db->where('deleted', 'N');
		 $this->db->where('shipment_id!=','');
		 if(!empty($data1))
		 $this->db->where($data1);
		 $this->db->order_by("id", 'DESC');
		
		
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array();
				return $data[0]['sh_count'];    
				}
				return 0;
			
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
		
			public function GetalldrsPritqry($drs_unique_id=null)
	{
		$query=$this->db->query("select shipment.*,drs . *,courier_staff . * from drs left join shipment on drs.shipment_id=shipment.slip_no left join courier_staff on drs.messanger_id=courier_staff.cor_id where drs.drs_unique_id='".$drs_unique_id."' and shipment.status='Y' and shipment.deleted='N' and drs.deleted='N' GROUP by drs.shipment_id order by drs.id");
		return $data= $query->result_array();
	}
	

}
?>