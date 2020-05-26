<?php
class OutsourceManagement_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		
	public function getShowsupplier($searchfield=null,$page_no)
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
         $this->db->from('supplier');
         $this->db->order_by('id','DESC'); 
		 $this->db->limit($limit, $start); 
		 if(!empty($searchfield))
		 {
			$this->db->where("mobile LIKE '%$searchfield%'");
			
		 }
		 $this->db->where('status','Y');
		 $this->db->where('deleted','N');
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getShowsupplierCount($searchfield,$page_no);  
			return $data;
		}
	}
	
	public function getShowsupplierCount($searchfield,$page_no)
	{
		   if(!empty($searchfield))
		 {
			$this->db->where('mobile',$searchfield);
		 }

			$this->db->where('status','Y');
		    $this->db->where('deleted','N');
			$this->db->select('COUNT(id) as sh_count');
			$this->db->from('supplier');
			$this->db->order_by('id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array(); 
				return $data[0]['sh_count'];    
				}
				return 0;
	}
	
	public function getsupplierdelete($data=array(),$id=null)
	{
		return $this->db->update('supplier',$data,array('id'=>$id));

	} 
	
	public function insertsupplier($data=array()) 
		{
			return $this->db->insert('supplier',$data); 
		}
	
		public function Getsupplier_edit($id=null)
		{
		 $this->db->select('*');
         $this->db->from('supplier'); 
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
		
		
		public function GetPaymentData($id=null)
		{
		 $this->db->select('id,rate,name');
         $this->db->from('supplier'); 
         $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		 $this->db->where('id', $id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0) 
	{
		 return $query->row_array(); 
	//return $data[0]['rate'];			 
	}
		}
		
		
         
		 public function GetPaymentDetails($data=array(),$searchfield=null)
		 {
			 $page_no;
        $limit = 20; 
        if(empty($data['page_no'])){
            $start = 0;
        }else{
            $start = ($data['page_no']-1)*$limit;
        }
			 
			 if(!empty($searchfield['invoice_month']) && !empty($searchfield['invoice_year']))
		   {
			$filter_month=$searchfield['invoice_month'];
			$filter_year=$searchfield['invoice_year'];
			
			 $this->db->where('invoice_month',$filter_month);
			 $this->db->where('invoice_year',$filter_year);
		   }
		   
		   	if(!empty($data['search_val']))
		   {
			$this->db->where('invoice_id',$data['search_val']); 
			
		   }
			 $this->db->select('SUM(charge_val) as t_charge,`supplier_id`, `cor_id`, `entry_date`, `close_date`, `awb_no`, `invoice_created_by`,`invoice_created_date`,  `invoice_month`, `invoice_year`,`invoice_no`,charge_val,service_pay_status,services_updated_by,id');
			 $this->db->from('supplier_invoice');
			 $this->db->where('supplier_id',$data['id']);
			 $this->db->group_by('invoice_month','invoice_year');
			 $this->db->order_by('id','DESC');
			// $this->db->limit($limit, $start);
			 
			 $query = $this->db->get();
    //echo $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
			return $data;
		}  
			 
		 }


		public function supplierUpdate($data=array(),$id=null)
		{
			return $this->db->update('supplier',$data,array('id'=>$id));
			//$this->db->last_query(); die(); 
		}
		
		public function GetCityOutDrop() 
		{
			
		 $this->db->select('*'); 
         $this->db->from('country'); 
		 $this->db->where('city!=','');
		$this->db->where('deleted','N');
		 
		// $this->db->order by('sub_status','ASC') 
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();  
		}
		}
		
		public function GetIvoiceSuppDrop() 
		{
			
		 $this->db->select('*'); 
         $this->db->from('supplier'); 
		 //$this->db->where('main_status','16');
		
		 
		// $this->db->order by('sub_status','ASC') 
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();   
		}
		}
		
		public function GetSuppMessage($uid=null)
		{
			$query= $this->db->query("SELECT id,rate FROM supplier where id='".$uid."' and status='Y' and deleted='N'");
			 //return $this->db->last_query(); die;
			return $query->row_array();

		}
		
		public function GetCouriData($uid=null)
		{
			$query=$this->db->query("SELECT cor_id FROM courier_staff where supplier='".$uid."' and status='Y' and deleted='N'");
			//return $this->db->last_query(); die;
			return $query->row_array();
		}
		
		public function fetch_shipments($slip_no=null)
		{
			$query=$this->db->query("select entrydate, messanger_id,delever_date,slip_no,delivered from shipment where   deleted='N' and  delever_date!=''  and  YEAR(delever_date) !='0'  and slip_no='".$slip_no."'");
			return $query->result_array();
		}
	

		public function check_in_invoice($awb_no=null)
		{
			$query=$this->db->query("select awb_no,id from supplier_invoice where awb_no='".$awb_no."' and deleted='N'");
			// return $this->db->last_query(); die;
			return $query->row_array(); 
		}
		
			public function UpdateSupplierInvoice($data=array(),$invoice_no=null)
			{
				return $this->db->update('supplier_invoice',$data,array('invoice_no'=>$invoice_no,'service_pay_status'=>'N'));
		
			}  

			public function AddmanifestData($data)
	{
		$query=$this->db->query($data);
		//return $this->db->last_query(); die;
	}
}
?>