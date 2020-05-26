<?php
class BulkInvoiceManagement_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		
	public function getviewcod($data=array()) 
	{ 
		$data['page_no'];
          $limit = 20;
        if(empty($data['page_no']))
		{
            $start = 0;
        }
		else
		{
         $start = ($data['page_no']-1)*$limit;
		} 
		
		if(!empty($data))
			{
			
				if(!empty($data['cust_id']))
				{
					 $cust_data=implode(',',$_POST['cust_id']);
					 $cond1="Payable_invoice.cust_id IN (".$cust_data.")";
					$this->db->where($cond1);
				}
				if(!empty($data['created']))
				{
					 $created=implode(',',$_POST['created']); 
					 $cond2="Payable_invoice.invoice_created_by IN (".$created.")";
					 $this->db->where($cond2);
				}
				if(!empty($data['paid']))
				{
					 $paid=implode(',',$data['paid']); 
					 $cond3=" Payable_invoice.cod_paid_by IN (".$paid.")";
					  $this->db->where($cond3);
				}
				if(!empty($data['received']))
				{
					 $received=implode(',',$data['received']); 
					 $cond4=" Payable_invoice.receivable_paid_by IN (".$received.")";
					  $this->db->where($cond4);
				}
				if(!empty($data['invoices']))
				{
					 $invoices=implode("','",$data['invoices']); 
					 $cond5="(Payable_invoice.invoice_no IN ('".$invoices."') || Payable_invoice.r_invoice IN ('".$invoices."')) ";
					  $this->db->where($cond5);
				}
				
				if(!empty($data['mode']))
				{
					 
					 $cond6="Payable_invoice.mode = '".$data['mode']."' ";
					  $this->db->where($cond6);
				}
				if(!empty($data['status']))
				{
					 
					 $cond7=" Payable_invoice.status = '".$data['status']."' ";
					  $this->db->where($cond7);
				}
				if(!empty($data['p_date1']) && !empty($data['p_date2'])  )
			{
			
			$cond8=" DATE(Payable_invoice.cod_paid_date) BETWEEN '".$data['p_date1']."' AND '".$data['p_date2']."'";
			 $this->db->where($cond8);
				}
				
					if(!empty($data['c_date1']) && !empty($data['c_date2'])  )
			{
			
			$cond9="DATE(Payable_invoice.invoice_created_date) BETWEEN '".$data['c_date1']."' AND '".$data['c_date2']."'";
			 $this->db->where($cond9);
				}
				
				if(!empty($data['r_date1']) && !empty($data['r_date2'])  )
			{
			
			$cond10="DATE(Payable_invoice.receivable_paid_date) BETWEEN '".$data['r_date1']."' AND '".$data['r_date2']."'";
			 $this->db->where($cond10);
				}	
				
					if(!empty($data['cl_date1']) && !empty($data['cl_date2'])  )
			{
			
			$cond11="DATE(Payable_invoice.close_date) BETWEEN '".$data['cl_date1']."' AND '".$data['cl_date2']."'";
			$this->db->where($cond11);
				}	
				
		
			}
		 $this->db->select("*,Payable_invoice.id as pid,customer.name,customer.uniqueid");
         $this->db->from('Payable_invoice');
       	$this->db->join('customer', 'customer.id = Payable_invoice.cust_id');
		$this->db->where('Payable_invoice.deleted','N');
		$this->db->where('Payable_invoice.mode','COD');
		$this->db->where("Payable_invoice.invoice_no not in (select DISTINCT invoice_no from Payable_invoice where mode='CC' || Payable_invoice.status='Return to shiper')");
		$this->db->group_by("Payable_invoice.invoice_no");
		$this->db->limit($limit, $start);    

         $query = $this->db->get();
        //echo  $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getviewcodCount($data);  
			return $data;
		}  
	}
	
	public function getviewcodCount()
	{
		   
			
			$this->db->where('deleted', 'N');
			$this->db->select('COUNT(id) as sh_count');  
			 $this->db->from('Payable_invoice');
			$this->db->group_by("Payable_invoice.invoice_no");
			$this->db->order_by('id','DESC'); 
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array();   
				return $data[0]['sh_count'];     
				}
				return 0; 
	}
	
	
	public function getviewPayableInvoice($data=array()) 
	{ 
		$data['page_no'];
          $limit = 20;
        if(empty($data['page_no']))
		{
            $start = 0;
        }
		else
		{
         $start = ($data['page_no']-1)*$limit;
		} 
		
		if(!empty($data))
			{
			
				if(!empty($data['cust_id']))
				{
					 $cust_data=implode(',',$_POST['cust_id']);
					 $cond1="Payable_invoice.cust_id IN (".$cust_data.")";
					$this->db->where($cond1);
				}
				if(!empty($data['created']))
				{
					 $created=implode(',',$_POST['created']); 
					 $cond2="Payable_invoice.invoice_created_by IN (".$created.")";
					 $this->db->where($cond2);
				}
				if(!empty($data['paid']))
				{
					 $paid=implode(',',$data['paid']); 
					 $cond3=" Payable_invoice.cod_paid_by IN (".$paid.")";
					  $this->db->where($cond3);
				}
				if(!empty($data['received']))
				{
					 $received=implode(',',$data['received']); 
					 $cond4=" Payable_invoice.receivable_paid_by IN (".$received.")";
					  $this->db->where($cond4);
				}
				if(!empty($data['invoices']))
				{
					 $invoices=implode("','",$data['invoices']); 
					 $cond5="(Payable_invoice.invoice_no IN ('".$invoices."') || Payable_invoice.r_invoice IN ('".$invoices."')) ";
					  $this->db->where($cond5);
				}
				
				if(!empty($data['mode']))
				{
					 
					 $cond6="Payable_invoice.mode = '".$data['mode']."' ";
					  $this->db->where($cond6);
				}
				if(!empty($data['status']))
				{
					 
					 $cond7=" Payable_invoice.status = '".$data['status']."' ";
					  $this->db->where($cond7);
				}
				if(!empty($data['p_date1']) && !empty($data['p_date2'])  )
			{
			
			$cond8=" DATE(Payable_invoice.cod_paid_date) BETWEEN '".$data['p_date1']."' AND '".$data['p_date2']."'";
			 $this->db->where($cond8);
				}
				
					if(!empty($data['c_date1']) && !empty($data['c_date2'])  )
			{
			
			$cond9="DATE(Payable_invoice.invoice_created_date) BETWEEN '".$data['c_date1']."' AND '".$data['c_date2']."'";
			 $this->db->where($cond9);
				}
				
				if(!empty($data['r_date1']) && !empty($data['r_date2'])  )
			{
			
			$cond10="DATE(Payable_invoice.receivable_paid_date) BETWEEN '".$data['r_date1']."' AND '".$data['r_date2']."'";
			 $this->db->where($cond10);
				}	
				
					if(!empty($data['cl_date1']) && !empty($data['cl_date2'])  )
			{
			
			$cond11="DATE(Payable_invoice.close_date) BETWEEN '".$data['cl_date1']."' AND '".$data['cl_date2']."'";
			$this->db->where($cond11);
				}	
				
		
			}
		 $this->db->select("*,Payable_invoice.id as pid,customer.name,customer.uniqueid,customer.company");
         $this->db->from('Payable_invoice');
         $this->db->join('customer', 'customer.id = Payable_invoice.cust_id AND Payable_invoice.awb_no!="" ');
		$this->db->where('Payable_invoice.deleted','N');
		$this->db->group_by("Payable_invoice.invoice_no");
		 $this->db->limit($limit, $start); 
		
		
         $query = $this->db->get();
       //echo $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getviewPayableInvoiceCount($data);  
			return $data;
		}
	}
	
	public function getviewPayableInvoiceCount($data=array())
	{
			$this->db->where('deleted', 'N');
			$this->db->select('COUNT(id) as sh_count');  
			 $this->db->from('Payable_invoice');
			 $this->db->group_by("Payable_invoice.invoice_no");
			  $query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array();   
				return $data[0]['sh_count'];     
				}
				return 0; 
	}
	
	public function getviewPayable($data=array()) 
	{ 
		$data['page_no'];
          $limit = 20;
        if(empty($data['page_no']))
		{
            $start = 0;
        }
		else
		{
         $start = ($data['page_no']-1)*$limit;
		}
		
		if(!empty($data))
			{
			
				if(!empty($data['cust_id']))
				{
					 $cust_data=implode(',',$_POST['cust_id']);
					 $cond1="Payable_invoice.cust_id IN (".$cust_data.")";
					$this->db->where($cond1);
				}
				if(!empty($data['created']))
				{
					 $created=implode(',',$_POST['created']); 
					 $cond2="Payable_invoice.invoice_created_by IN (".$created.")";
					 $this->db->where($cond2);
				}
				if(!empty($data['paid']))
				{
					 $paid=implode(',',$data['paid']); 
					 $cond3=" Payable_invoice.cod_paid_by IN (".$paid.")";
					  $this->db->where($cond3);
				}
				if(!empty($data['received']))
				{
					 $received=implode(',',$data['received']); 
					 $cond4=" Payable_invoice.receivable_paid_by IN (".$received.")";
					  $this->db->where($cond4);
				}
				if(!empty($data['invoices']))
				{
					 $invoices=implode("','",$data['invoices']); 
					 $cond5="(Payable_invoice.invoice_no IN ('".$invoices."') || Payable_invoice.r_invoice IN ('".$invoices."')) ";
					  $this->db->where($cond5);
				}
				
				if(!empty($data['mode']))
				{
					 
					 $cond6="Payable_invoice.mode = '".$data['mode']."' ";
					  $this->db->where($cond6);
				}
				if(!empty($data['status']))
				{
					 
					 $cond7=" Payable_invoice.status = '".$data['status']."' ";
					  $this->db->where($cond7);
				}
				if(!empty($data['p_date1']) && !empty($data['p_date2'])  )
			{
			
			$cond8=" DATE(Payable_invoice.cod_paid_date) BETWEEN '".$data['p_date1']."' AND '".$data['p_date2']."'";
			 $this->db->where($cond8);
				}
				
					if(!empty($data['c_date1']) && !empty($data['c_date2'])  )
			{
			
			$cond9="DATE(Payable_invoice.invoice_created_date) BETWEEN '".$data['c_date1']."' AND '".$data['c_date2']."'";
			 $this->db->where($cond9);
				}
				
				if(!empty($data['r_date1']) && !empty($data['r_date2'])  )
			{
			
			$cond10="DATE(Payable_invoice.receivable_paid_date) BETWEEN '".$data['r_date1']."' AND '".$data['r_date2']."'";
			 $this->db->where($cond10);
				}	
				
					if(!empty($data['cl_date1']) && !empty($data['cl_date2'])  )
			{
			
			$cond11="DATE(Payable_invoice.close_date) BETWEEN '".$data['cl_date1']."' AND '".$data['cl_date2']."'";
			$this->db->where($cond11);
				}	
				
		
			}
		 $this->db->select("*,Payable_invoice.id as pid,customer.name,customer.uniqueid");
         $this->db->from('Payable_invoice');
         $this->db->join('customer', 'customer.id = Payable_invoice.cust_id');
	
		$this->db->where('Payable_invoice.deleted','N');
		$this->db->group_by("Payable_invoice.invoice_no");
		 $this->db->limit($limit, $start); 
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getviewPayableCount($data);  
			return $data;
		}
	}
	
	public function getviewPayableCount()
	{
		   
			
			$this->db->where('deleted', 'N');
			$this->db->select('COUNT(id) as sh_count');  
			 $this->db->from('Payable_invoice');
			 $this->db->group_by("Payable_invoice.invoice_no");
			$this->db->order_by('id','DESC'); 
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array();   
				return $data[0]['sh_count'];     
				}
				return 0; 
	}

		public function Getpay_edit($id=null)
		{
		 $this->db->select('*');
         $this->db->from('Payable_invoice'); 
		 $this->db->where('deleted', 'N');
		 $this->db->where('id', $id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		}
		

		public function Getinvoice($pid=null)
		{
		 $this->db->select('Payable_invoice.*,customer.name,customer.uniqueid,customer.company,customer.address,customer.account_number,customer.account_manager,customer.city,customer.vat_no');
         $this->db->from('Payable_invoice');
         $this->db->join('customer', 'customer.id = Payable_invoice.cust_id');
		 $this->db->where('Payable_invoice.deleted', 'N');
		 $this->db->where('Payable_invoice.invoice_no', $pid);
		 
		
         $query = $this->db->get();
     // echo $this->db->last_query(); 
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
		}
		


		public function Getpayableinvoice($pid=null)
		{
		 $this->db->select('*');
         $this->db->from('Payable_invoice');
         $this->db->join('customer', 'customer.id = Payable_invoice.cust_id');
		 $this->db->where('Payable_invoice.deleted', 'N');
		 $this->db->where('Payable_invoice.id', 7);
		 
		
         $query = $this->db->get();
         // return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		}

		public function GetpayableCODinvoice($pid=null)
		{
		 $this->db->select('*');
         $this->db->from('Payable_invoice');
         $this->db->join('customer', 'customer.id = Payable_invoice.cust_id');
		 $this->db->where('Payable_invoice.deleted', 'N');
		 $this->db->where('Payable_invoice.id', 7);
		 
		
         $query = $this->db->get();
         // return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		}


		
		
		public function GetcreateinvocieShipmentData($slip_no=null)
		{
			$query=$this->db->query("select code,service_charge,service_id,weight,origin,destination,entrydate, delever_date,reciever_name,slip_no,delivered,pieces,cust_id,cod_fees,booking_id,total_cod_amt,mode,d_attempt from shipment where   deleted='N' and  delever_date!=''  and  YEAR(delever_date) !='0'  and slip_no='".$slip_no."'");
			return $query->result_array();
			
		}
		public function GetpaybaleInvocieQry($slip_no=null)
		{
			
			$query=$this->db->query("select awb_no,id from Payable_invoice where awb_no='".$slip_no."' and deleted='N'");
			//echo $this->db->last_query(); die;
			return $query->row_array();
			
		}
		
		public function GetinvocieInsertData($insertdata)
		{
			$this->db->query("INSERT INTO `Payable_invoice`(`invoice_no`,`r_invoice`,`entry_date`, `close_date`, `cust_id`, `receiver_name`, `origin`, `destination`, `awb_no`, `refrence_no`, `qty`, `weight`, `mode`, `status`, `return_charge`,`service_charge`,`cod_charge`, `cod_amount`, `vat`, `invoice_date`, `invoice_week`, `invoice_month`, `invoice_year`,`invoice_created_by`,`invoice_created_date`,`d_attempt`) VALUES ".$insertdata);
			//echo $this->db->last_query(); die;
		}
		public function GetinvoiceUpdatedata($invoiceNumberMonthy=null,$receivble_invoice=null,$slip_no=null)
		{
			$this->db->query("update shipment set pay_invoice_no='".$invoiceNumberMonthy."',rec_invoice_no='".$receivble_invoice."' where slip_no='".$slip_no."'");
		//echo $this->db->last_query(); die;
		}
		
		public function GetupdateFinalInvocie($data=array(),$dataW=array())
		{
			$this->db->update('Payable_invoice',$data,$dataW);
			
			 return $this->db->update('shipment',array('pay_invoice_status'=>'YES'),array('pay_invoice_no'=>$dataW['invoice_no'],'cust_id'=>$dataW['cust_id']));
			///echo $this->db->last_query();
			
			
		}
		public function addInvoiceUpdate($data=array(),$dataW=array())
		{
			$this->db->update('Payable_invoice',$data,$dataW);
			///echo $this->db->last_query();
			 return $this->db->update('shipment',array('rec_invoice_status'=>'YES'),array('rec_invoice_no'=>$dataW['invoice_no'],'cust_id'=>$dataW['cust_id']));
			
		}
		
		public function bulkPrintPayableQry($r_invoice=null)
		{
			$query=$this->db->query("select * from Payable_invoice where r_invoice='".$r_invoice."' and deleted='N'");
			//echo $this->db->last_query(); die;
			return $query->result_array();
		}
		public function bulkPrintPayable_cod_Qry($invoice_no=null)
		{
			$query=$this->db->query("select * from Payable_invoice where invoice_no='".$invoice_no."' and deleted='N'");
			//echo $this->db->last_query(); die;
			return $query->result_array();
		}
		public function codreceivablePrintQry($invoice_no=null)
		{
			$query=$this->db->query("select * from Payable_invoice where r_invoice='".$invoice_no."' and deleted='N'");
			//echo $this->db->last_query(); die;
			return $query->result_array();
		}
		

	
}
?>