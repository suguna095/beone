<?php
class PickupManagement_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		
		
	public function getPickupData($data=array())
	{
		$page_no;
          $limit = 20;
        if(empty($data['page_no'])){
            $start = 0;
        }else{
            $start = ($data['page_no']-1)*$limit;
        }    
		
		 $this->db->select('*');
         $this->db->from('pickup');
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
            $data['count']=$this->getPickupDataCount($data); 
			return $data;
		}
	}
	
	public function getPickupDataCount($data=array()) 
		{
			 $this->db->select('count(id) as sh_count');
         $this->db->from('pickup');
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
	  
	  public function getPickupDetail($data=array())
	
	{
		
         $query = $this->db->query("select shipment.* from pickup left join shipment on pickup.shipment_id=shipment.slip_no where pickup.drs_unique_id='".$data['drs_unique_id']."' and  shipment.status='Y' and shipment.deleted='N'"); 
        // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
	}	
	
	public function GetpickupPrintData($drs_unique_id=null)
	{
		$query=$this->db->query("select shipment.*,pickup . *,courier_staff . * from pickup left join shipment on pickup.shipment_id=shipment.slip_no left join courier_staff on pickup.messanger_id=courier_staff.cor_id where pickup.drs_unique_id='".$drs_unique_id."' and shipment.status='Y' and shipment.deleted='N'");
		//echo $this->db->last_query();
		return $query->result_array();
	}
	
	
	
	
}
?>