<?php
class CodManagement_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
	public function getCodShipment($data=array())
	{ 
		$page_no;
        $limit = 20; 
        if(empty($data['page_no'])){
            $start = 0;
        }else{
            $start = ($data['page_no']-1)*$limit; 
        } 
		
		if(!empty($data['city_id']))
		 {
			 $city_id=$data['city_id'];
			$this->db->where('city_id', $city_id); 
				
		 }
		 if(!empty($data['drs_unique_id']))
		 {
			 $drs_unique_id=$data['drs_unique_id'];
			$this->db->where('drs_unique_id', $drs_unique_id); 
				
		 }
		 if(!empty($data['hub']))
		 {
			 $hub=$data['hub'];
			$this->db->where('city_id', $hub); 
				
		 }
		 if(!empty($data['start_date']))
		 {
			$this->db->where('drs_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }
		 
         /* $this->db->distinct();	
		 $this->db->select('shipment.*, drs.drs_unique_id,drs.drs_date');
         $this->db->from('shipment');
		 $this->db->join('drs','drs.shipment_id= shipment.slip_no');
		 $this->db->where('shipment.status', 'Y');
		 $this->db->where('shipment.deleted','N');
		 $this->db->where('drs.deleted','N');
		 $this->db->group_by("drs_unique_id"); */
		 $this->db->distinct();	
		 $this->db->select('*, messanger_id as courier_id');
         $this->db->from('drs');
		 $this->db->where('messanger_id!=', '0');
		 $this->db->where('deleted','N');
		 $this->db->where('amount_received','Y');
		$this->db->limit($limit, $start);
        $query = $this->db->get();
      
	 //echo $this->db->last_query(); die();
		  
		if($query->num_rows()>0)  
		{
			$data['result']=$query->result_array();
			$data['count']=$this->getCodShipmentCount($data);   
			return $data;
		}
	}
	

	public function PrintawbFilterShip($pickupId){
		//print_r($pickupId);
	   $this->db->select('*');
	   $this->db->from('shipment');
	   
	   $this->db->where_in('slip_no',$pickupId);
		   
	   $this->db->order_by('shipment.id','ASC');
	  // $this->db->limit($limit, $start);
	   $query = $this->db->get();
	  //echo $this->db->last_query(); exit;
   
	  $data['result']=$query->result_array();
		return $data;
	  
	 }


	public function getCodShipmentCount($data) 
	{
		if(!empty($data['city_id']))
		 {
			 $city_id=$data['city_id'];
			$this->db->where('city_id', $city_id); 
				
		 }
		 if(!empty($data['drs_unique_id']))
		 {
			 $city_id=$data['drs_unique_id'];
			$this->db->where('drs_unique_id', $drs_unique_id); 
				
		 }
		 if(!empty($data['hub']))
		 {
			 $hub=$data['hub'];
			$this->db->where('city_id', $hub); 
				
		 }
		 if(!empty($data['start_date']))
		 {
			$this->db->where('drs_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }
		$this->db->select('count(*) as total_CODship'); 
        $this->db->from('drs');
		$this->db->where('messanger_id!=', '0');
		$this->db->where('deleted','N');
		$this->db->where('amount_received','Y');
		//$this->db->group_by("drs_unique_id");
		$query = $this->db->get();
		//echo $this->db->last_query(); die();
				if($query->num_rows()>0){
				$data=  $query->result_array(); 
				return $data[0]['total_CODship'];	 
				
				}
				return 0;
	}
		
	public function GetPodCollect($shipment_id=null,$drs_unique_id=null) 
	{ 
		
	$this->db->select('shipment_id as podcollected'); 
	$this->db->from('drs'); 
	$this->db->where('deleted','N');
	$this->db->where('drs_unique_id',$drs_unique_id);
	$this->db->where('rto_status','N');

   $query = $this->db->get();	
	//return $this->db->last_query(); die;  	
	if($query->num_rows()>0) 
	{
		 $data=  $query->result_array(); 
	return $data[0]['podcollected'];			 
	}
	}
	
	public function Getallrtoshipmenttotal($drs_unique_id=null,$type=null) 
	{ 
	if($type=="all")
	{
		$this->db->select('COUNT(id) as total_ship'); 
		$this->db->from('drs'); 
		$this->db->where('drs_unique_id',$drs_unique_id);
		$this->db->where('deleted','N');
	}		
	

   $query = $this->db->get();	
	//return $this->db->last_query(); die;  	
	if($query->num_rows()>0) 
	{
		 $data=  $query->result_array(); 
	return $data[0]['total_ship'];			 
	}
	}
	/* public function TotalShip($slip_no=null)
	 {
		 $a="'" . implode ( "', '", $data ) . "'";
		 
		 $this->db->('user_id as total_shipment');
		 $this->db->from('status');
		 $this->db->where('deleted','N'); 
		 $this->db->where("slip_no in ($a)");
		 $this->db->where('code','CLOSE');
		 $this->db->limit($limit, $start);
		 $query = $this->db->get();	
	//return $this->db->last_query(); die;  	
	if($query->num_rows()>0) 
	{
		 $data=  $query->result_array(); 
	return $data[0]['total_shipment'];	 		 
	}
	 }
	*/
	public function getPendingShipment($data=array())
	{ 
		$page_no;
        $limit = 20; 
        if(empty($data['page_no'])){
            $start = 0;
        }else{
            $start = ($data['page_no']-1)*$limit;
        } 
		
		if(!empty($data['city_id']))
		 {
			 $city_id=$data['city_id'];
			$this->db->where('city_id', $city_id); 
				
		 }
		 if(!empty($data['drs_unique_id']))
		 {
			 $drs_unique_id=$data['drs_unique_id'];
			$this->db->where('drs_unique_id', $drs_unique_id); 
				
		 }
		 if(!empty($data['hub']))
		 {
			 $hub=$data['hub'];
			$this->db->where('city_id', $hub); 
				
		 }
		 if(!empty($data['start_date']))
		 {
			$this->db->where('drs_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"');
				
		 }
		 
         /* $this->db->distinct();	
		 $this->db->select('shipment.*, drs.drs_unique_id,drs.drs_date');
         $this->db->from('shipment');
		 $this->db->join('drs','drs.shipment_id= shipment.slip_no');
		 $this->db->where('shipment.status', 'Y');
		 $this->db->where('shipment.deleted','N');
		 $this->db->where('drs.deleted','N');
		 $this->db->group_by("drs_unique_id"); */
		// $this->db->distinct();	
		 $this->db->select('*, messanger_id as courier_id');
         $this->db->from('drs');
		 $this->db->where('messanger_id!=', '0');
		 $this->db->where('deleted','N');
		 $this->db->where('amount_received','N');
		$this->db->limit($limit, $start);
        $query = $this->db->get();
      
	 //echo $this->db->last_query(); die();
		  
		if($query->num_rows()>0)  
		{
			$data['result']=$query->result_array();
			$data['count']=$this->getPendingShipmentCount($data);   
			return $data;
		}
	}
	
	public function getPendingShipmentCount($data)
	{
		if(!empty($data['city_id']))
		 {
			 $city_id=$data['city_id'];
			$this->db->where('city_id', $city_id); 
				
		 }
		 if(!empty($data['drs_unique_id']))
		 {
			 $city_id=$data['drs_unique_id'];
			$this->db->where('drs_unique_id', $drs_unique_id); 
				
		 }
		 if(!empty($data['hub']))
		 {
			 $hub=$data['hub'];
			$this->db->where('city_id', $hub); 
				
		 }
		 if(!empty($data['from_date']))
		 {
			$this->db->where('drs_date BETWEEN "'. date('Y-m-d', strtotime($data['from_date'])). '" and "'. date('Y-m-d', strtotime($data['to_date'])).'"'); 
				
		 }
		$this->db->select('count(*) as total_CODPendingship'); 
        $this->db->from('drs');
		$this->db->where('messanger_id!=', '0');
		$this->db->where('deleted','N');
		$this->db->where('amount_received','N');
		//$this->db->group_by("drs_unique_id");
		$query = $this->db->get();
		
		//echo $this->db->last_query(); die();
		
		if($query->num_rows()>0){
		$data= $query->result_array();   
		return $data[0]['total_CODPendingship'];     
		}
		return 0;
	}
		
	public function GetCityCodDrop() 
		{
			
		 $this->db->select('*'); 
         $this->db->from('country'); 
		 $this->db->where('city!=','');
		
		 
		// $this->db->order by('sub_status','ASC') 
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();  
		}
		}
	
	public function GetallShip($drs_unique_id=null) 
	{ 
		
	
	  if(!empty($drs_unique_id))
		{
			$this->db->where("drs_unique_id", $drs_unique_id); 
		}
		
		 
	$this->db->select('count(id) as allShip'); 
	$this->db->from('drs'); 
	$query = $this->db->get();	  	
 //return $this->db->last_query(); die;
	if($query->num_rows()>0) 
	{
		 $data= $query->result_array();
		return $data[0]['allShip'];			 
	}
	}
	
	public function GetDel($drs_unique_id=null) 
	{ 
		
	
	  if(!empty($drs_unique_id))
		{
			$this->db->where("drs_unique_id", $drs_unique_id); 
		}
		
		 
	$this->db->select('count(id) as Del'); 
	$this->db->from('drs'); 
	$this->db->where('delivered','Y');
	$this->db->where('delivery_status','Y');
	$this->db->where('deleted','N');
	$query = $this->db->get();	  	
 //return $this->db->last_query(); die;
	if($query->num_rows()>0) 
	{
		 $data= $query->result_array();
		return $data[0]['Del'];			 
	}
	}
	
	public function GetNotDel($drs_unique_id=null) 
	{ 
		
	
	  if(!empty($drs_unique_id))
		{
			$this->db->where("drs_unique_id", $drs_unique_id); 
		}
		
		 
	$this->db->select('count(id) as NotDel'); 
	$this->db->from('drs'); 
	$this->db->where('delivered','Y');
	$this->db->where('delivery_status','N');
	$this->db->where('deleted','N');
	$query = $this->db->get();	  	
 //return $this->db->last_query(); die;
	if($query->num_rows()>0) 
	{
		 $data= $query->result_array();
		return $data[0]['NotDel'];			 
	}
	}
	
	public function GetNP($drs_unique_id=null) 
	{ 
		
	
	  if(!empty($drs_unique_id))
		{
			$this->db->where("drs_unique_id", $drs_unique_id); 
		}
		
		 
	$this->db->select('count(id) as NP'); 
	$this->db->from('drs'); 
	$this->db->where('delivered','N');
	$this->db->where('delivery_status','N');
	$this->db->where('deleted','N');
	$query = $this->db->get();	  	
 //return $this->db->last_query(); die;
	if($query->num_rows()>0) 
	{
		 $data= $query->result_array();
		return $data[0]['NP'];			 
	}
	}
	
	public function GetCOD_AMOUNT($drs_unique_id=null) 
	{ 
		
	
	  if(!empty($drs_unique_id))
		{
			$this->db->where("drs.drs_unique_id", $drs_unique_id); 
		}
		
		 
		$this->db->select('SUM(shipment.total_cod_amt) as COD_AMOUNT'); 
		$this->db->from('drs');
		$this->db->join('shipment','drs.shipment_id= shipment.slip_no');
		$this->db->where('shipment.mode', 'COD');
		$this->db->where('drs.delivered','Y');
		$this->db->where('drs.delivery_status','Y');
		$this->db->where('drs.deleted','N');
		$query = $this->db->get();	  	
 //return $this->db->last_query(); die;
	if($query->num_rows()>0) 
	{
		 $data= $query->result_array();
		return $data[0]['COD_AMOUNT'];			 
	}
	}
	
	
	 public function gettotalcodData($data=array())
	{ 
		$page_no;
          $limit = 100;
        if(empty($page_no)){
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        } 
		
 		 if(!empty($data['drs_unique_id']))
		 {
			$drs_unique_id=$data['drs_unique_id']; 
			$this->db->where("drs.drs_unique_id", $drs_unique_id); 
						
		 }
	
		 if($data['codstatus']==1)
		 {
			$this->db->where("drs.delivery_status", 'Y');	
		 }else if($data['codstatus']==2)
		 {
			$this->db->where("drs.delivered", 'N');	
		 }else if($data['codstatus']==5)
		 {
			$this->db->where("drs.delivery_status", 'N');	
			$this->db->where("drs.delivered", 'N');	
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
	
	
	 public function getConfirmcodData($data=array())
	{ 
		
		$this->db->select('drs.shipment_id, drs.id');
        $this->db->from('drs');
		$this->db->join('shipment', 'shipment.slip_no = drs.shipment_id');
		$this->db->where("drs.drs_unique_id", $data['drs_unique_id']);
		$this->db->where('drs.deleted','N');
		$this->db->where("drs.delivered", 'Y'); 
		$this->db->where("shipment.delivered", '11');
		$this->db->where("shipment.mode", 'COD'); 
        $query = $this->db->get();
      
	//echo $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
			return $data;
		}
	}
	
	public function insertStatus($data=array()) 
			{
				return $this->db->insert('status',$data); 
			}
	public function UpdateCOD($data=array(),$id=null)
	{
		return $this->db->update('drs',$data,array('drs_unique_id'=>$id));
 
	}   

		public function GetalldrsPritqry($start_date=null,$end_date=null)
	{
		
		 if((!empty($start_date)) && (!empty($end_date)))
		 {
			$this->db->where('drs_date BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
				
		 }
		 
		 
		$this->db->select('*,messanger_id');
        $this->db->from('drs');
		$this->db->where('deleted','N');
		$this->db->where("amount_received", 'Y'); 
		$this->db->where("messanger_id!=", '');
        $query = $this->db->get();
		// echo $this->db->last_query(); die;
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
			return $data;
		}
	}
	
	
		public function GetalldrsPrintPendingqry($start_date=null,$end_date=null)
		{
			
			 if((!empty($start_date)) && (!empty($end_date)))
			 {
				$this->db->where('drs_date BETWEEN "'. date('Y-m-d', strtotime($start_date)). '" and "'. date('Y-m-d', strtotime($end_date)).'"');
					
			 }
			 
			 
			$this->db->select('*,messanger_id');
			$this->db->from('drs');
			$this->db->where('deleted','N');
			$this->db->where("amount_received", 'N'); 
			$this->db->where("messanger_id!=", '');
			$query = $this->db->get();
			// echo $this->db->last_query(); die;
			if($query->num_rows()>0) 
			{
				$data['result']=$query->result_array();
				return $data;
			}

		$query=$this->db->query("select *,messanger_id  from drs  where deleted='N' and amount_received='N'  and  messanger_id!='0'");
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
			return $data;
		}
	}
	
	
	
		public function confirmexportquery($limit=null,$start=null,$data=array()) 
	{
		
		 if((!empty($data['from_date'])) && (!empty($data['to_date'])))   
		 {
			$this->db->where('drs_date BETWEEN "'. date('Y-m-d', strtotime($data['from_date'])). '" and "'. date('Y-m-d', strtotime($data['to_date'])).'"');
				
		 }
		$this->db->select('`id`, `drs_unique_id`, `routecode`, `messanger_id`, `shipment_id`, `city_id`, `drs_date`, `drs_bar_image`, `drs_bar_code`, `sign_image`, `delivey_complete_date`, `delivered`, `delivery_status`, `attempt`, `rto_status`, `rto_datetime`, `amount_received`, `deleted`'); 
		 $this->db->from('drs'); 
		 $this->db->where('messanger_id!=', '0'); 
		 $this->db->where('deleted','N');
		 $this->db->where('amount_received','Y');  
		$this->db->order_by('id','desc');
		$this->db->limit($start,$limit);
		$query = $this->db->get();
	
	
	 // echo $this->db->last_query(); die;    
		return $query->result_array();  
  
		
		
	}
		
		
		public function Pendingexportquery($limit=null,$start=null,$data=array())  
	{
		
		if(!empty($data['start_date']))
		 {
			$this->db->where('drs_date BETWEEN "'. date('Y-m-d', strtotime($data['start_date'])). '" and "'. date('Y-m-d', strtotime($data['end_date'])).'"'); 
				
		 }
		$this->db->select('`id`, `drs_unique_id`, `routecode`, `messanger_id`, `shipment_id`, `city_id`, `drs_date`, `drs_bar_image`, `drs_bar_code`, `sign_image`, `delivey_complete_date`, `delivered`, `delivery_status`, `attempt`, `rto_status`, `rto_datetime`, `amount_received`, `deleted`'); 
		 $this->db->from('drs'); 
		//$this->db->from('drs');
		 $this->db->where('messanger_id!=', '0');
		 $this->db->where('deleted','N');
		 $this->db->where('amount_received','N');  
		$this->db->order_by('id','desc');
		$this->db->limit($start,$limit);
		$query = $this->db->get();
	
	
	 // echo $this->db->last_query(); die;    
		return $query->result_array();  
  
		
		
	}
		

}

?>