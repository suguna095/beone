<?php
class WarehouseManagement_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		
	
	public function getShowinventorylist($data = array())
	{ 
		page_no;
        $limit = 50;
        if (empty($data['page_no'])) {
            $start = 0;
        } else {
            $start = ($data['page_no'] - 1) * $limit;
        }
        if((!empty($data['from_date'])) && (!empty($data['to_date'])))
		 {
			$this->db->where('shedule_date BETWEEN "'. date('Y-m-d', strtotime($data['from_date'])). '" and "'. date('Y-m-d', strtotime($data['to_date'])).'"');
				
		 }
         if(!empty($data['schedule_status'])){
			 $this->db->where('schedule_status',$data['schedule_status']); 
		 }	
         if(!empty($data['origin']))
		 {
			$city_id=$data['origin']; 
			$this->db->where("origin in (select id from country where city='$city_id')"); 
						
		 }	
         if(!empty($data['destination']))
		 {
			$destination=$data['destination']; 
			$this->db->where("destination in (select id from country where city='$destination')"); 
						
		 }	 	 
		 $this->db->select('*');
         $this->db->from('inventory_report');
         $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
					
         $query = $this->db->get();
          ////return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getShowinventorylistCount($data);  
			return $data;
		}
	}


public function getShowinventorylistCount($data)  
	{
		
		    
			$this->db->select('COUNT(id) as sh_count');
	        $this->db->from('inventory_report'); 
		     $this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}

 
			public function GetAWBNO($searchfield=null,$page_no)
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
			$this->db->where("shelv_no LIKE '%$searchfield%' ");
			
		 
		 }
	
		
         $query = $this->db->get();
          ////return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->GetAccountCount($searchfield,$page_no);  
			return $data;
		}
	}
	
	
		
		
	public function GetAccountCount($searchfield,$page_no) 
	{
		 if(!empty($searchfield))
		 {
			$this->db->where('shelv_no',$searchfield);  
		 }
	
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
	
public function	DataCityDrop()
	{
		$this->db->select('*');
		$this->db->from('country');
		$this->db->where('status','Y');
		$this->db->where('deleted','N');
		 $query = $this->db->get();
          //echo $this->db->last_query(); die;
		 	  
		if($query->num_rows()>0)
		{
			return $query->result_array();  
		}
	
	}
		
	public function	DataHubDrop() 
	{
		
		$this->db->select('*');
		$this->db->from('country');
       $this->db->where('status','Y');
		$this->db->where('deleted','N');
		 $query = $this->db->get();
          //echo $this->db->last_query(); die;
		 	  
		if($query->num_rows()>0)
		{
			return $query->result_array();  
		}
	
	}	
		public function getShowScanShipmentlist($searchfield=null,$page_no)
	{ 
		$page_no;
          $limit = 100;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        }    
		 $this->db->select('*');
         $this->db->from('status');
         $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
					
         $query = $this->db->get();
          ////return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getShowScanShipmentlistCount($searchfield,$page_no);  
			return $data;
		}
	}
	


public function getShowScanShipmentlistCount($searchfield,$page_no)
	{
		 if(!empty($searchfield))
		 {
			$this->db->where('name',$searchfield);
		 }
		   
			$this->db->select('COUNT(id) as sh_count');
			$this->db->from('status');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}
	
	
	
			
	
		
			public function getShowHoldShipmentlist($slip_no=null,$page_no)
	{ 
		$page_no;
          $limit = 20;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        }    
		 $this->db->select('*');
         $this->db->from('status');
         $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		 if(!empty($slip_no))
		 {
			$this->db->where("slip_no LIKE '%$slip_no%' ");
			
		 
		 }else{
			  $this->db->where('deleted','Y'); 
		 }
	
		
         $query = $this->db->get();
          ////return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getShowHoldShipmentlistCount($slip_no,$page_no);  
			return $data;
		}
	}
	   
		
	public function getShowHoldShipmentlistCount($slip_no,$page_no) 
	{
		 if(!empty($slip_no))
		 {
			$this->db->where('slip_no',$slip_no);  
		 }else{
			  $this->db->where('deleted','Y'); 
		 }
	
			$this->db->select('COUNT(id) as sh_count'); 
			$this->db->from('status');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}
	
	
	
	
	public function getshowBoundShipmentlist($slip_no=null,$page_no)
	{ 
		$page_no;
          $limit = 20;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        }    
		 $this->db->select('*');
         $this->db->from('status');
         $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		 if(!empty($slip_no))
		 {
			$this->db->where("slip_no LIKE '%$slip_no%' ");
			
		 
		 }else{
			  $this->db->where('deleted','Y'); 
		 }
	
		
         $query = $this->db->get();
          ////return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getshowBoundShipmentlistCount($slip_no,$page_no);  
			return $data;
		}
	}
	   
		
	public function getshowBoundShipmentlistCount($slip_no,$page_no) 
	{
		 if(!empty($slip_no))
		 {
			$this->db->where('slip_no',$slip_no);  
		 }
	
			$this->db->select('COUNT(id) as sh_count'); 
			$this->db->from('status');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}
	
	
	
		public function getshowScheduleShipmentlist($slip_no=null,$page_no)
	{ 
		$page_no;
          $limit = 20;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        }    
		 $this->db->select('*');
         $this->db->from('status');
         $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		 if(!empty($slip_no))
		 {
			$this->db->where("slip_no LIKE '%$slip_no%' ");
			
		 
		 }else{
			  $this->db->where('deleted','Y'); 
		 }
	
		
         $query = $this->db->get();
          ////return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getshowScheduleShipmentlistCount($slip_no,$page_no);  
			return $data;
		}
	}
	   
		
	public function getshowScheduleShipmentlistCount($slip_no,$page_no) 
	{
		 if(!empty($slip_no))
		 {
			$this->db->where('slip_no',$slip_no);  
		 }
	
			$this->db->select('COUNT(id) as sh_count'); 
			$this->db->from('status');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}
	
	
	
	
	public function insertcustomer($data=array()) 
		{
			return $this->db->insert('status',$data); 
		}
		
		public function ScanShipmentDataQry($slip_no=null)
		{
			$query=$this->db->query("select id,slip_no,onHold_Confirm,shelv_no,refused,schedule_status,onHold_Confirm,schedule_type,schedule_date,time_slot,code,messanger_id,booking_id,delivered,reciever_name,reciever_address,area,destination,origin,code from shipment where deleted ='N' and (slip_no='".$slip_no."' or booking_id='".$slip_no."' )  and delivered NOT in (6,11,12,19)");
			return $data= $query->row_array(); 
		}
		public function ReportShipemtDataQry($slip_no=null)
		{
			$query=$this->db->query("select slip_no,origin,destination,schedule_status,shedule_type,shedule_date,refused,messenger_code from shipment where deleted='N' and (slip_no='".$slip_no."' || booking_id='".trim($slip_no)."'  ) and delivered NOT in (6,11,12,19)");
			return $data= $query->row_array(); 
		}
		public function scanInboundShipmentQry($slip_no=null)
		{
			$query=$this->db->query("select id,slip_no,onHold_Confirm,shelv_no,refused,schedule_status,schedule_type,schedule_date,time_slot,code,messanger_id,booking_id,delivered,reciever_name,reciever_address,area,destination,origin,code from shipment where deleted ='N'  and (slip_no='".trim($slip_no)."' || booking_id='".trim($slip_no)."'  ) and code IN ('PUC','FTH','FTB')   and delivered NOT in (6,11,12,19)  ");
			return $data= $query->row_array(); 
		}
		
		
		public function scanScheduleDataQry($slip_no=null,$from=null,$to=null)
		{
			$query=$this->db->query( "select id,slip_no,onHold_Confirm,shelv_no,refused,schedule_status,schedule_type,schedule_date,time_slot,code,messanger_id,booking_id,delivered,reciever_name,reciever_address,area,destination,origin,code from shipment where deleted ='N' and schedule_status='Y' and (slip_no='".trim($slip_no)."' or booking_id='".trim($slip_no)."')  and DATE(schedule_date) between '".$from."' and  '".$to."'  and delivered NOT in (6,11,12,19) ");
			return $data= $query->row_array(); 
		}
		
		
		public function OnholdShipemtDataQry($slip_no=null,$from=null,$to=null)
		{
			$query=$this->db->query("select id,slip_no,onHold_Confirm,shelv_no,refused,onHold_Confirm,schedule_status,schedule_type,schedule_date,time_slot,code,messanger_id,booking_id,delivered,reciever_name,reciever_address,area,destination,origin,code from shipment where deleted ='N' and (slip_no='".$slip_no."' or booking_id='".$slip_no."') and refused='YES'  and DATE(entrydate) between '".$from."' and  '".$to."'  and delivered NOT in (6,11,12,19) ");
			return $data= $query->row_array(); 
		}
		public function securityCheckDataShipmetDataQry($slip_no=null)
		{
			$query=$this->db->query("select slip_no from shipment where (slip_no='".$slip_no."' or booking_id='".$slip_no."') and deleted='N'");
			return $data= $query->row_array(); 
		}
		public function securityCheckDataDrsDataQry($drs_id=null,$slip_no=null)
		{
			$query=$this->db->query("select id from drs where shipment_id='".trim($slip_no)."' and drs_unique_id='".trim($drs_id)."' and deleted ='N'");
			return $data= $query->row_array(); 
		}
		public function securityCheckShipDataQry($slip_no=null)
		{
			$query=$this->db->query("select id,slip_no,shelv_no,refused,schedule_status,schedule_type,schedule_date,time_slot,code,messanger_id,booking_id,delivered,reciever_name,reciever_address,area,destination,origin,code,pieces from shipment where deleted ='N' and (slip_no='".$slip_no."' ) ");
			return $data= $query->row_array(); 
		}
		
		
		public function InserAndUpdateQry($data)
		{
			$this->db->query($data);
		}
		
		public function VerifyManifestshipDataQry($slip_no=null)
		{
			$query=$this->db->query("select slip_no,reciever_phone,messanger_id from shipment where deleted='N' and slip_no='".trim($slip_no)."' ");
			return $data= $query->row_array(); 
		}
	
	
}
	
	
	
	

?>