<?php
class ScheduleManagement_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
	
	
	public function NotScheduleDrop() 
		{
			
		 $this->db->select('*'); 
         $this->db->from('status_category'); 
		 $this->db->where('main_status','16');
		
		 
		// $this->db->order by('sub_status','ASC') 
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		    
		if($query->num_rows()>0)
		{
			return $query->result_array();  
		}
		}
		
		public function getRootname($searchText=null)
		{
		 $this->db->select('*');     
         $this->db->from('root'); 
         $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		// $this->db->where("messenger_code like '%".$searchText."%'");  
		
		   
         $query = $this->db->get();
         //return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		}   


	public function updateNotSched($data=array(),$slip_no=null)
	{
		return $this->db->update('shipment',$data,array('slip_no'=>$slip_no));   

	} 

	public function updateShip($data=array(),$slip_no=null)
	{
		 $this->db->update('shipment',$data,array('slip_no'=>trim($slip_no))); 
		 return $this->db->last_query(); die;  

	} 


	
	//echo $messangerQry="select cor_id,messenger_name from courier_staff where status='Y' and deleted='N' and cor_id IN (".$allCor_ids.") ORDER BY cor_id ASC LIMIT 1";

	public function selectCourierFinal($data=array())
	{
		//SELECT `cor_id` FROM `courier_routing` WHERE rout='".$RoutData['id']."'"
		 $this->db->select('cor_id,messenger_name'); 
         $this->db->from('courier_staff'); 
		 $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		 $this->db->whereIn('cor_id', data);
		
         $query = $this->db->get();   
		 if($query->num_rows()>0)
		 {
			 return $query->result_array();  
		 }
		
		
	}


	public function selectCourier($area)
	{
		//SELECT `cor_id` FROM `courier_routing` WHERE rout='".$RoutData['id']."'"
		 $this->db->select('cor_id'); 
         $this->db->from('courier_routing'); 
		 $this->db->where('rout', $area);
		
         $query = $this->db->get();   
		 if($query->num_rows()>0)
		 {
			 return $query->result_array();  
		 }
		
		
	}


	public function getMessangerName($allCor_ids=null)
	{
		//SELECT `cor_id` FROM `courier_routing` WHERE rout='".$RoutData['id']."'"
		 $this->db->select('cor_id,messenger_name'); 
		 $this->db->from('courier_staff'); 
		 $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		 $this->db->where("cor_id IN ('.$allCor_ids.')");
		 $this->db->order_by('cor_id', 'ASC');
		 $this->db->limit('1');
		 $query = $this->db->get();   
		 
		 return $this->db->last_query(); die;


		 if($query->num_rows()>0)
		 {
			 return $query->result_array();  
		 }
		
		
	}



	public function checkRoute($area)
	{
		 $this->db->select('id'); 
         $this->db->from('root'); 
		 $this->db->like('route', $area);
		
         $query = $this->db->get();   
		 if($query->num_rows()>0)
		 {
			 return $query->result_array();  
		 }
		
		
	}
	
	public function AddReceiverHistory($data)
	{
		$this->db->query($data);
	}
	
	
	public function updateSched($data=array(),$slip_no=null)
	{
		return $this->db->update('shipment',$data,array('slip_no'=>$slip_no));   

	} 

	public function updateAssignShip($data=array(),$slip_no=null)
	{
		return $this->db->update('assigning_shipment',$data,array('slip_no'=>trim($slip_no),'deleted'=>'N'));   

	} 
	
	   public function insertSched($data=array())
	{   
		$this->db->insert('status',$data);   
		
	}
		   
	
	public function insertHistory($data=array())
	{
		 $this->db->insert('receiver_location_history',$data);   
		 return $this->db->last_query();  

	}

	public function BlindScheduleData($searchfield=null,$page_no)
	{ 
		$page_no;
          $limit = 20;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;   
        }    
		 $this->db->select('*');
         $this->db->from('shipment');
         $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		 if(!empty($searchfield))
		 {
			$this->db->where("slip_no LIKE '%$searchfield%'");
			//$this->db->where('status','Y');
		   // $this->db->where('deleted','N');
		 
		 }
		 
		 
		 else{
			 $this->db->where('id','');
		 }
		 $this->db->where('status','Y');
		    $this->db->where('deleted','N');
         $query = $this->db->get();
          ////return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->BlindCount($searchfield,$page_no);  
			return $data;
		}
	}
	
	public function BlindCount($searchfield,$page_no) 
	{
		 if(!empty($searchfield))
		 {
			$this->db->where('slip_no',$searchfield); 
		 }
		   
			$this->db->where('status','Y');
		    $this->db->where('deleted','N');
			$this->db->select('COUNT(id) as sh_count'); 
			$this->db->from('shipment');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}
	
	   public function bulkRedata($data=array(),$slip_no=null)
		{
			return $this->db->update('shipment',$data,array('slip_no'=>$slip_no));   
			//return $this->db->last_query(); die; 
		}
		
		public function getscheduleremove($data=array(),$slip_no=null)
	{
		return $this->db->update('shipment',$data,array('slip_no'=>$slip_no));  

	}

public function ShipmetupdateQryData($awb=null)
		{
			$query=$this->db->query("select slip_no,cust_id,reciever_address,reciever_city,call_attempt,req_delevery_time,refused,reciever_phone,id,destination,code,delivered ,sender_name,reciever_name from shipment where deleted='N' and (slip_no='".trim($awb)."' || booking_id='".trim($awb)."' )");
			return $query->result_array();
		}

		public function msgTemplateData($temp_id=null)
		{
			$query=$this->db->query("select templates from msg_template where id='".trim($temp_id)."' )");
			return $query->result_array();
		}

	public function receiverLocData($awb=null)
		{
			$query=$this->db->query("select lat,lang,update_time,area_street,area,schedule_type from receiver_location_history where awb_no='".trim($awb)."' order by id desc limit 1"); 
			return $query->result_array();
			//echo $this->db->last_query(); die;  
		}

		public function GetratesImportShipDataQry($old_awb_number=null)
	  {
		  $query=$this->db->query("select * from shipment where deleted='N' and slip_no='".$old_awb_number."'");
	  // $this->db->last_query(); 
		 return  $query->result_array();
	  }

	  public function GetareaDataQry($area=null)
	  {
		  $query=$this->db->query("SELECT id FROM `root` WHERE `route` LIKE '%".mysql_real_escape_string($area)."%'");
	  // $this->db->last_query(); 
		 return  $query->result_array();
	  }
	

	  public function dataUpdateAddedQry($data){
		return $this->db->query($data);  
	}
 
	public function shipmentDataByslip($awb){

		// $this->db->query("select slip_no,cust_id,reciever_address,reciever_city,call_attempt,req_delevery_time,refused,reciever_phone,id,destination,code,delivered ,sender_name,reciever_name  from shipment where (slip_no='".($awb)."' or booking_id='".($awb)."' )");
		$query=$this->db->query("select slip_no,cust_id,reciever_address,reciever_city,call_attempt,req_delevery_time,refused,reciever_phone,id,destination,code,delivered ,sender_name,reciever_name  from shipment where deleted='N' and slip_no='".$awb."'");
		//return  $this->db->last_query(); exit;
		  
		 return  $query->result_array();
	}
	
		 
}
?>