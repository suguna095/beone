<?php
class OfdReport_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		public function getOfdData($data=array())
	{
		$page_no;
          $limit = 20;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
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
            $data['count']=$this->getOfdDataCount($data); 
			return $data;
		}
	}
	
	public function getOfdDataCount($data=array())
		{
			 $this->db->select('count(id) as sh_count');
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
	  
	  
	  public function alllistData($data=array())
	{ 
		$page_no;
          $limit = 100;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        } 
		
 		 if(!empty($data['messanger_id']))
		 {
			$messanger_id=$data['messanger_id']; 
			$this->db->where("drs.messanger_id", $messanger_id); 
						
		 }
		 
		  if(!empty($data['origin']))
		 {
			$origin=$data['origin']; 
			$this->db->where("drs.city_id in (select id from country where city='$origin')");  
						
		 }
		   if(!empty($data['supplier']))
		 {
			$supplier=$data['supplier']; 
			$this->db->where("courier_staff.supplier", $supplier); 
						
		 }
		 
		 if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			$this->db->where('drs.drs_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 } else{
			 $this->db->where("DATE(drs.drs_date)='".date('Y-m-d')."'");
		 } 
		$this->db->distinct();
		$this->db->select('drs.drs_unique_id,drs.messanger_id,courier_staff.messenger_name,courier_staff.messenger_code,courier_staff.supplier,drs.city_id,drs.drs_date');
        $this->db->from('drs');
		$this->db->join('courier_staff', 'courier_staff.cor_id = drs.messanger_id');
		$this->db->where("drs.deleted", 'N'); 
		$this->db->group_by('drs.messanger_id');
		$this->db->limit($limit, $start); 
        $query = $this->db->get();
      
	//echo $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
			$data['count']=$this->getOfdlistCount($data);   
			return $data;
		}
	}


	public function alllistData1($data=array())
	{ 
		$page_no;
          $limit = 100;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        } 
		
 		 if(!empty($data['messanger_id']))
		 {
			$messanger_id=$data['messanger_id']; 
			$this->db->where("drs.messanger_id", $messanger_id); 
						
		 }
		 
		  if(!empty($data['origin']))
		 {
			$origin=$data['origin']; 
			$this->db->where("drs.city_id", $origin); 
						
		 }
		   if(!empty($data['supplier']))
		 {
			$supplier=$data['supplier']; 
			$this->db->where("courier_staff.supplier", $supplier); 
						
		 }
		 
		 
			$this->db->where('drs.drs_date', date('Y-m-d'));
				
		 /* else{
			 $this->db->where('drs.drs_date BETWEEN "'. date('Y-m-d'). '" and "'. date('Y-m-d').'"');
		 } */
		$this->db->distinct();
		$this->db->select('drs.drs_unique_id,drs.messanger_id,courier_staff.messenger_name,courier_staff.messenger_code,courier_staff.supplier,drs.city_id,drs.drs_date');
        $this->db->from('drs');
		$this->db->join('courier_staff', 'courier_staff.cor_id = drs.messanger_id');
		$this->db->where("drs.deleted", 'N'); 
		//$this->db->limit($limit, $start); 
        $query = $this->db->get();
      
	//echo $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
			return $data;
		}
	}
	
	public function GetCheckDrsStatusQry($drs_unique_id=null,$field=null,$data=array(),$messanger_id=null)
	{
		$this->db->select('count(id) as totaldelivered');
		$this->db->from('drs');
		if($field=='delivered')
		{
		$this->db->where("delivered", 'Y'); 
		$this->db->where("delivery_status", 'N'); 
		}
		 if($field=='delivery_status')
		{
		$this->db->where("delivered", 'Y'); 
		$this->db->where("delivery_status", 'Y'); 
		}
		 if($field=='running')
		{
		$this->db->where("delivered", 'N'); 
		$this->db->where("delivery_status", 'N'); 
		}
		
		//$messanger_id=$data['messanger_id']; 
			$this->db->where("drs.messanger_id", $messanger_id); 
		
		
		if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			$this->db->where('drs.drs_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 } else{
			 $this->db->where("DATE(drs.drs_date)='".date('Y-m-d')."'");
		 } 
		
		//$query="select count(id) as total_shipment from drs where messanger_id='".$cor_id."' and DATE(drs_date) between '".$from."' and '".$to."' and deleted='N'";
		//$this->db->where('drs_unique_id',$drs_unique_id);
		$this->db->where('deleted','N');
		  $query = $this->db->get();
		// echo $this->db->last_query();
		  $result=$query->result_array();
		  return $result[0]['totaldelivered'];
	}
	
	public function GetCheckDrsStatusQry_dash($drs_unique_id=null,$field=null,$messanger_id)
	{
		$this->db->select('count(id) as totaldelivered');
		$this->db->from('drs');
		if($field=='delivered')
		{
		$this->db->where("delivered", 'Y'); 
		$this->db->where("delivery_status", 'Y'); 
		}
		 if($field=='delivery_status')
		{
		$this->db->where("delivered", 'Y'); 
		$this->db->where("delivery_status", 'Y'); 
		}
		 if($field=='running')
		{
		$this->db->where("delivered", 'N'); 
		$this->db->where("delivery_status", 'N'); 
		}
		
		//$messanger_id=$data['messanger_id']; 
			$this->db->where("drs.messanger_id", $messanger_id); 
		
		
		if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			$this->db->where('drs.drs_date BETWEEN "'. date('Y-m-d'). '" and "'. date('Y-m-d').'"');
				
		 } else{
			 $this->db->where("DATE(drs.drs_date)='".date('Y-m-d')."'");
		 } 
		
		//$query="select count(id) as total_shipment from drs where messanger_id='".$cor_id."' and DATE(drs_date) between '".$from."' and '".$to."' and deleted='N'";
		//$this->db->where('drs_unique_id',$drs_unique_id);
		$this->db->where('deleted','N');
		  $query = $this->db->get();
		// echo $this->db->last_query();
		  $result=$query->result_array();
		  return $result[0]['totaldelivered'];
	}
	 
	public function getOfdlistCount($data=null)
	{
		
 		 	$messanger_id=$data['messanger_id']; 
			$this->db->where("drs.messanger_id", $messanger_id); 
			
		 
		  if(!empty($data['origin']))
		 {
			$origin=$data['origin']; 
			$this->db->where("drs.city_id", $origin); 
						
		 }
		   if(!empty($data['supplier']))
		 {
			$supplier=$data['supplier']; 
			$this->db->where("courier_staff.supplier", $supplier); 
						
		 }
		 
		$this->db->group_by('drs.messanger_id');
			if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 {
			$this->db->where('drs.drs_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 } else{
			 $this->db->where("DATE(drs.drs_date)='".date('Y-m-d')."'");
		 } 
		
		
		 $this->db->select('drs.messanger_id,courier_staff.messenger_name,courier_staff.messenger_code,courier_staff.supplier,drs.city_id,drs.drs_date');
        $this->db->from('drs');
		$this->db->join('courier_staff', 'courier_staff.cor_id = drs.messanger_id');
		$this->db->where("drs.deleted", 'N'); 
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				
				}
				return 0;
	}
	
	
	public function getSupplierDropData() 
	{
		
	$this->db->select('*'); 
	$this->db->from('supplier'); 
	$this->db->where('status','Y'); 
	$this->db->where('deleted','N');
	
	 $query = $this->db->get();	  
	if($query->num_rows()>0) 
	{
		return $query->result_array();  
	}
	}


		public function GetOFDList($data=array()) 
	{ 
		
	
	  if(!empty($data['origin']))
		 {
			$origin=$data['origin']; 
			$this->db->where("city_id", $origin); 
						
		 }
		 if(!empty($data['start_date']))
		 {
			$this->db->where('drs_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }
		 
	$this->db->select('count(id) as totalcompletedrs');  
	$this->db->from('drs'); 
	$this->db->where('deleted','N');
	$query = $this->db->get();	  	
   // return $this->db->last_query(); die;
	if($query->num_rows()>0) 
	{
		 $data= $query->result_array();
		return $data[0]['totalcompletedrs'];			 
	}
	}
	
	
		public function GetDeliveredList($data=null) 
	{ 
		
	 if(!empty($data['origin']))
		 {
			$origin=$data['origin']; 
			$this->db->where("city_id", $origin); 
						
		 }
		 if(!empty($data['start_date']))
		 {
			$this->db->where('drs_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }
	$this->db->select('count(id) as totaldelivered'); 
	$this->db->from('drs'); 
	$this->db->where('deleted','N');
	$this->db->where('delivery_status','Y');
	$query = $this->db->get();	  	
	if($query->num_rows()>0) 
	{
		  $data= $query->result_array();
		return $data[0]['totaldelivered'];		 
	}
	}
	
		public function GetNotDeliveredList($data=null) 
	{ 
	if(!empty($data['origin']))
		 {
			$origin=$data['origin']; 
			$this->db->where("city_id", $origin); 
						
		 }
		 if(!empty($data['start_date']))
		 {
			$this->db->where('drs_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }	
	$this->db->select('count(id) as totalnotdeliverd'); 
	$this->db->from('drs'); 

	$this->db->where('deleted','N');
	$this->db->where('delivery_status','N');
	$this->db->where('delivered','Y');
	$query = $this->db->get();	  	
	if($query->num_rows()>0) 
	{
		 $data= $query->result_array(); 
		return $data[0]['totalnotdeliverd'];	 
	}
	}
	
	
		public function GetRunningList($data=null) 
	{ 
	if(!empty($data['origin']))
		 {
			$origin=$data['origin']; 
			$this->db->where("city_id", $origin); 
						
		 }
		 if(!empty($data['start_date']))
		 {
			$this->db->where('drs_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }		
	$this->db->select('count(id) as totalrunning'); 
	$this->db->from('drs'); 
	$this->db->where('deleted','N');
	$this->db->where('delivery_status','N');
	$this->db->where('delivered','N');
	$query = $this->db->get();	  	
	if($query->num_rows()>0) 
	{
		 $data=  $query->result_array(); 
	return $data[0]['totalrunning'];			 
	}
	}
	
	
	
		public function GetOFD($messanger_id=null,$drs_date=null,$city_id=null) 
	{ 
		
	
	  if(!empty($messanger_id))
		 {
		
			$this->db->where("messanger_id", $messanger_id); 
						
		 }
		 
		 if(!empty($city_id))
		 {
			$this->db->where("city_id", $city_id); 
		 }	
		 if(!empty($drs_date))
		 {
			$this->db->where('drs_date', date('Y-m-d', strtotime($drs_date)));
				
		 } 
		 
	$this->db->select('count(id) as totaldrs'); 
	$this->db->from('drs'); 
	$this->db->where('deleted','N');
	$query = $this->db->get();	  	
 // return $this->db->last_query(); die;
	if($query->num_rows()>0) 
	{
		 $data= $query->result_array();
		return $data[0]['totaldrs'];			 
	}
	}
	
	
		public function GetDelivered($messanger_id=null,$drs_date=null,$city_id=null) 
	{ 
		
	 if(!empty($messanger_id))
		 {
		
			$this->db->where("messanger_id", $messanger_id); 
						
		 }
		 if(!empty($city_id))
		 {
		
			$this->db->where("city_id", $city_id); 
						
		 }
		 if(!empty($drs_date))
		 {
			$this->db->where('drs_date', date('Y-m-d', strtotime($drs_date)));
				
		 } 
	$this->db->select('count(id) as delivered'); 
	$this->db->from('drs'); 
	$this->db->where('deleted','N');
	$this->db->where('delivery_status','Y');
	$query = $this->db->get();	  	
	if($query->num_rows()>0) 
	{
		  $data= $query->result_array();
		return $data[0]['delivered'];		 
	}
	}
	
		public function GetNotDelivered($messanger_id=null,$drs_date=null,$city_id=null) 
	{ 
	if(!empty($messanger_id))
		 {
		
			$this->db->where("messanger_id", $messanger_id); 
						
		 }
		 if(!empty($city_id))
		 {
		
			$this->db->where("city_id", $city_id); 
						
		 }
		 if(!empty($drs_date))
		 {
			$this->db->where('drs_date', date('Y-m-d', strtotime($drs_date)));
				
		 }	
	$this->db->select('count(id) as notdeliverd'); 
	$this->db->from('drs'); 

	$this->db->where('deleted','N');
	$this->db->where('delivery_status','N');
	$this->db->where('delivered','Y');
	$query = $this->db->get();	  	
	if($query->num_rows()>0) 
	{
		 $data= $query->result_array(); 
		return $data[0]['notdeliverd'];	 
	}
	}
	
	
		public function GetRunning($messanger_id=null,$drs_date=null,$city_id=null) 
	{ 
	if(!empty($messanger_id))
		 {
		
			$this->db->where("messanger_id", $messanger_id); 
						
		 }
		 if(!empty($city_id))
		 {
		
			$this->db->where("city_id", $city_id); 
						
		 }
		 if(!empty($drs_date))
		 {
			$this->db->where('drs_date', date('Y-m-d', strtotime($drs_date)));
				
		 }	
	$this->db->select('count(id) as running'); 
	$this->db->from('drs'); 
	$this->db->where('deleted','N');
	$this->db->where('delivery_status','N');
	$this->db->where('delivered','N');

	$query = $this->db->get();	
//	return $this->db->last_query(); die;  	
	if($query->num_rows()>0) 
	{
		 $data=  $query->result_array(); 
		return $data[0]['running'];			 
	}
	}
	
	
	  public function gettotalofsData($data=array())
	{ 
		$page_no;
          $limit = 100;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        } 
		//print_r($data);
 		 if(!empty($data['messanger_id']))
		 {
			$messanger_id=$data['messanger_id']; 
			$this->db->where("drs.messanger_id", $messanger_id); 
						
		 }
		
		 //if(!empty($data['drs_date']) && !empty($data['drs_date2']))
		 //{
			 
			$this->db->where("drs.drs_date BETWEEN '".date('Y-m-d')."' AND '".date('Y-m-d')."'");
				
		// }
		 
		  if($data['ofdstatus']==0)
		 {
				
		 }else if($data['ofdstatus']==1)
		 {
			$this->db->where("drs.delivery_status", 'Y');	
		 }else if($data['ofdstatus']==2)
		 {
			$this->db->where("drs.delivered", 'N');	
		 }else if($data['ofdstatus']==5)
		 {
			$this->db->where("drs.delivery_status", 'N');	
			$this->db->where("drs.delivered", 'Y');	
		 }
		 
		//$this->db->distinct();
		$this->db->select('shipment.*, shipment.id as sh_id, drs.*');
        $this->db->from('drs');
		$this->db->join('shipment', 'shipment.slip_no = drs.shipment_id');
		$this->db->where("drs.deleted", 'N'); 
		$this->db->where("shipment.status", 'Y'); 
		$this->db->where("shipment.deleted", 'N'); 
		$this->db->limit($limit, $start); 
        $query = $this->db->get();
      
	//echo $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
			return $data;
		}
	}
	
	  public function gettotalofdlistData($data=array())
	{ 
		$page_no;
          $limit = 100;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        } 
		
 		
		// if((!empty($data['start_date'])) && (!empty($data['end_date'])))
		 //{
			$this->db->where('drs_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		// }
		 
		 
		  if($data['ofdstatus']==0)
		 {
				
		 }else if($data['ofdstatus']==1)
		 {
			$this->db->where("drs.delivery_status", 'Y');	
		 }else if($data['ofdstatus']==2)
		 {
			$this->db->where("drs.delivered", 'N');	
		 }else if($data['ofdstatus']==5)
		 {
			$this->db->where("drs.delivery_status", 'N');	
			$this->db->where("drs.delivered", 'Y');	
		 }
		 
		//$this->db->distinct();
		$this->db->select('shipment.*, shipment.id as sh_id, drs.*');
        $this->db->from('drs');
		$this->db->join('shipment', 'shipment.slip_no = drs.shipment_id');
		$this->db->where("drs.deleted", 'N'); 
		$this->db->where("shipment.status", 'Y'); 
		$this->db->where("shipment.deleted", 'N'); 
		$this->db->limit($limit, $start); 
        $query = $this->db->get();
      
	// echo $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
			return $data;
		}
	}
	
}
?>