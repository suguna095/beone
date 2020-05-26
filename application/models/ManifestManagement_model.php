<?php
class ManifestManagement_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		
	public function active_menifestUpdate($data=array())
	{
		 $this->db->query("update menifest set arrived='Y' where uniqueid='".$data['uniqueid']."'");               
	}         
	public function GetshipmentrowCount($data=array())
	{
		 // print_r($data);  die;
		 // $this->db->where_in('shipment.slip_no', $data['slip_array']);
			//$query= $this->db->query("SELECT  shipment.*,menifest.* FROM shipment LEFT JOIN menifest ON shipment.slip_no=menifest.awbillno where shipment.deleted='N'  and menifest.uniqueid='".$data['uniqueid']."' and shipment.code!='POD' group by shipment.slip_no order by shipment.id desc");
			 $this->db->select('shipment.*,menifest.*');
         $this->db->from('shipment');
		 $this->db->join('menifest','shipment.slip_no=menifest.awbillno');
		  $this->db->where('menifest.uniqueid', $data['uniqueid']);
		   $this->db->where('shipment.code!=', 'POD');  
		 $this->db->where("shipment.code not in ('POD','FTH')");            
		 $this->db->where('shipment.deleted', 'N');
		 $this->db->where('menifest.arrived', 'N');
		 
		  $this->db->group_by('shipment.slip_no');
		   $this->db->order_by('shipment.id','DESC');     
         $query = $this->db->get();
	//	echo $this->db->last_query(); die();       
		 return $query->result_array();          
		     
	
                
	}

	public function getOriginDropData() 
	{
		
		$this->db->select('*'); 
		$this->db->from('country'); 
		$this->db->where("city!=''");
		$this->db->group_by('city');		
		$this->db->where('status','Y'); 
		$this->db->where('deleted','N');
		 $query = $this->db->get();	   
		if($query->num_rows()>0)
		{
			return $query->result_array();  
		} 
	}


	public function ShipmentUpdateQry($code,$status,$Deliver_date,$single_slip_no)
	{
		$this->db->query("update shipment set in_meni='N', code='".$code."', delivered='".$status."'".$Deliver_date." where slip_no IN ('".$single_slip_no."')");
	}
	public function shipment_data_Qry($data=array())
	{
		 
			$query= $this->db->query("select mto,mfrom,awbillno from menifest where uniqueid='".$data['uniqueid']."' and awbillno IN ('".$data['single_slip_no']."')");
			return $query->result_array();
		
	}
	public function reciever_phoneQry($single_slip_no=null)
	{
		 
			$query= $this->db->query("select reciever_phone from shipment where slip_no='".$single_slip_no."'");
			return $query->row_array();
		
	}
	
	
	public function getmanifest($data=array())
	{
		//$data['page_no']=2;
		page_no;
        $limit = 50;
        if (empty($data['page_no'])) {
            $start = 0;
        } else {
            $start = ($data['page_no'] - 1) * $limit;
        }
        if((!empty($data['from_date'])) && (!empty($data['to_date'])))
		 {
			$this->db->where('mdate BETWEEN "'. date('Y-m-d', strtotime($data['from_date'])). '" and "'. date('Y-m-d', strtotime($data['to_date'])).'"');
				
		 }
         if(!empty($data['uniqueid'])){
			 $this->db->where('uniqueid',$data['uniqueid']);  
		 }
         
        	 
		if(!empty($data['mfrom']))
		 {
			$mfrom=$data['mfrom']; 
			$this->db->where("mfrom in (select id from country where city='$mfrom')"); 
						
		 }	
         if(!empty($data['mto']))
		 {
			$mto=$data['mto']; 
			$this->db->where("mto in (select id from country where city='$mto')"); 
						
		 }	
		 $this->db->select('*');
         $this->db->from('menifest');
        
		  $this->db->where('deleted', 'N');
		  $this->db->group_by('uniqueid');
		$this->db->order_by('id','DESC');
		    $this->db->limit($limit, $start);
		
		
         $query = $this->db->get();
       // echo  $this->db->last_query(); 
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getmanifestCount($data); 
			return $data;
		}
	}
	
	 public function getmanifestCount($data=array())
		{
			
			$this->db->where('deleted', 'N');
			$this->db->select('COUNT(id) as sh_count');
			$this->db->from('menifest');
			 $this->db->group_by('uniqueid');
			
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
	
	public function getmanifestupdate($data=array(),$id=null)
	{
		return $this->db->update('menifest',$data,array('uniqueid'=>$id));

	}
	
	public function getreturnmanifest($data=array())
	{
		$data['page_no'];
          $limit = 20;
        if(empty($data['page_no'])){
            $start = 0;
        }else{
            $start = ($data['page_no']-1)*$limit;
        }  
		 
		 if(!empty($data['user_name']))  
		{
			
		  
		   if(!empty($data['origin'])){
			$origin=$data['origin'];
		   $this->db->where("origin in (select id from country where city='$origin')");  	 
		   }   
		   

			if(!empty($data['destination'])){
				$destination=$data['destination'];
				$this->db->where("destination in (select id from country where city='$destination')");  
			}
			
			if(!empty($data['user_name'])){
				$user_name=$data['user_name'];
			   $this->db->where('cust_id',$user_name );  	 
			   }   
			
		
			$this->db->select('*');
			$this->db->from('shipment');
			$this->db->where('refused', 'YES');
			$this->db->where('deleted', 'N');
			$this->db->where("code NOT IN ('POD','FTH','RTC','DTC','RTR')");
			$this->db->order_by('id','DESC');
			$this->db->limit($limit, $start);
			$query = $this->db->get();

       //echo $this->db->last_query(); die();   
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array(); 
            $data['count']=$this->getreturnmanifestCount($data);    
			return $data;
		}
		}   
		else
		{
				$data['result']=array();
                $data['count']=0;
		}
	}
	
	 public function getreturnmanifestCount($data=array())
		{
			//$this->db->where('status', 'Y');
			//$this->db->where('deleted', 'N');
			$this->db->select('COUNT(id) as sh_count');
		//	$this->db->from('menifest');
			// $this->db->group_by('uniqueid');
			//$this->db->order_by('id','DESC');
			$this->db->from('shipment');
			$this->db->where('refused', 'YES');
			$this->db->where('deleted', 'N');
			$this->db->where("code NOT IN ('POD','FTH','RTC','DTC','RTR')");  
			$this->db->order_by('id','DESC');
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array();
				return $data[0]['sh_count'];    
				}
				return 0;
			
	  }
	
	public function updateawb($data=array())
		{
			return $this->db->insert('menifest',$data);
			
		}
		
		public function update_com($data=array())
	{
		return $this->db->insert('line_hule',$data);
		
	}
	
	
	
	public function geteditDataQuery($data=array())
	
	{
		
		 $this->db->select('*');
         $this->db->from('line_hule');
          
		 $this->db->where('deleted', 'N');
		 
		$this->db->where('id',$data['editid']);
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
	}
	
	
	
	public function getupdatedelete($data=array(),$id=null)
	{
		return $this->db->update('line_hule',$data,array('id'=>$id));

	}
	public function get_com() 
	{
		
		 $this->db->select('*');
         $this->db->from('line_hule');
          
		 $this->db->where('deleted', 'N');
		 
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
	}
	
	public function comUpdate($data=array(),$id=null)
		{
			return $this->db->update('line_hule',$data,array('id'=>$id));   
			
		}
		
		public function gettransit($data=array())
		{
			
			$edit_id=$data['getid'];
			if($edit_id!='')
		   {
			 $listingQry1="select `id`, `name`, `deleted` from line_hule where  id='".$edit_id."' and deleted='N' ";
			$query1=$this->db->query($listingQry1);
			$ldata=$query1->row_array();
			
            if(!empty($ldata))
            {
            $listingQry2="select `zone_from`,`zone_to`,`day`,id, (select name from zone_list where id=zone_from) as f_name ,(select name from zone_list where id=zone_to) as t_name,cutoff   from transit_time where  lid='".$edit_id."' ";
			$query2=$this->db->query($listingQry2);
			$tdata=$query2->result_array();
			
            if(empty($tdata))
            {
            $listingQry3=" SELECT id FROM `zone_list` ";
			$query3=$this->db->query($listingQry3);
			$zdata=$query3->result_array();
			
			  foreach($zdata as $key=>$val)
			  {
            
                foreach($zdata as $key1=>$val1)
               {
                
           // echo'<pre>'. $zdata[$key]['name'].'//'.$zdata[$key1]['name'];
                    $qry="INSERT INTO `transit_time`( `lid`, `zone_from`, `zone_to`) VALUES('".$edit_id."','".$zdata[$key]['id']."','".$zdata[$key1]['id']."')"; 
                   $this->db->query($qry);
               }
                
             }
                
             $listingQry4="select `zone_from`,`zone_to`,`day`,id, (select name from zone_list where id=zone_from) as f_name ,(select name from zone_list where id=zone_to) as t_name ,cutoff  from transit_time where  lid='".$edit_id."' ";
			 $query4=$this->db->query($listingQry4);
			 $tdata=$query4->result_array();
			
            }
            // print_r($tdata);   
                
            }
            return $tdata;
		}
	}
		
		public function getTransitTime_updateQry($data=array(),$id=null)
		{
			return $this->db->update('transit_time',$data,array('id'=>$id));
		}
		
		//==========Line Haul Popup Data=========/// 
		public function getuniqueidData($uniqueid)
	
	{
		
		 $this->db->select('*');
         $this->db->from('menifest');
          
		 $this->db->where('deleted', 'N');
		//  $this->db->where('status', 'Y');
		$this->db->where('uniqueid',$uniqueid);
		$this->db->group_by('uniqueid');
         $query = $this->db->get();
         // echo $this->db->last_query(); die;
		  
		
			return $query->row_array();
		
	} 
	
	public function getViewData($data=array())
	
	{
		if(!empty($data['Sortcodebymani']))
		   $seachcondition=" and shipment.code='".$data['Sortcodebymani']."'";
		   else
		   $seachcondition="";
		
		$query=$this->db->query("select shipment.*,menifest.arrived from menifest left join shipment on menifest.awbillno=shipment.slip_no where menifest.uniqueid='".$data['manid']."' and  shipment.status='Y' and shipment.deleted='N' $seachcondition");
		// echo $this->db->last_query(); die;
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
	}
	
	public function getNotfoundData($data=array())
	
	{
		
		$query=$this->db->query("select shipment.*,menifest.arrived from menifest left join shipment on menifest.awbillno=shipment.slip_no where shipment.status='Y' and menifest.arrived='N' and menifest.uniqueid='".$data['nfoundid']."'  and shipment.deleted='N'");
        // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->result_array();
		}
	}
	public function manifestStatusActiveUpdate($data=array())
	{
		return  $this->db->query("update menifest set status='".$data['type']."' where uniqueid='".$data['uniqueid']."'");
		 echo $this->db->last_query();
	}
	
	public function GetManifestPrntData($uniqueid=null)
	{
		$Query=$this->db->query("select shipment.slip_no,menifest.return_menifest,shipment.sender_name,shipment.reciever_name,shipment.sender_city,shipment.reciever_city ,menifest.messanger_id as scaned, menifest.pcs, menifest.mto ,menifest.mfrom ,menifest.mdate from menifest left join shipment on menifest.awbillno=shipment.slip_no where menifest.deleted='N' and menifest.uniqueid='".$uniqueid."' and shipment.deleted='N'");
		return $Query->result_array();
	}
	

	public function GetManifestPrntCountData($uniqueid=null) 
	{
		$Query=$this->db->query("select shipment.slip_no,menifest.return_menifest,shipment.sender_name,shipment.reciever_name,shipment.sender_city,shipment.reciever_city ,menifest.messanger_id as scaned, menifest.pcs, menifest.mto ,menifest.mfrom ,menifest.mdate from menifest left join shipment on menifest.awbillno=shipment.slip_no where menifest.deleted='N' and menifest.uniqueid='".$uniqueid."' and shipment.deleted='N'");
		return $Query->num_rows();
		// return $this->db->last_query(); die;
		 
		
	}
	


	public function GetupdatelineManifestData($uniqueid=null)
	{
		$Query=$this->db->query("select mto, mfrom from menifest  where uniqueid='".$uniqueid."' limit 1 ");
		return $Query->row_array();
		
	}
	
	public function GetupdateManifestShipmentQry($data=array(),$filename,$expactedDate)
	{
		 $updateShip="update shipment set req_delevery_time='".$expactedDate."' where slip_no IN (select awbillno from menifest  where uniqueid='".$data['uniqueid']."')"; 
		$this->db->query($updateShip);
		 $active_menifest="update menifest set line_hule='".$data['line_hule']."',driver_name='".$data['driver_name']."',plate_number='".$data['plate_number']."',iquma_copy='".$filename."',driver_mobile='".$data['driver_mobile']."' where uniqueid='".$data['uniqueid']."' ";
		return $this->db->query($active_menifest);
	}
	
	public function Getallshipmentdataaddmanifest($id=null)
	{
		$Query=$this->db->query("select destination,origin,entrydate,pieces, weight, total_amt,id, slip_no, sender_name,cust_id,booking_id,cust_id from shipment where deleted='N' and id='".$id."'");
		return $Query->result_array();
	}
	
	public function AddmanifestData($data)
	{
		$this->db->query($data);
	}
	public function updateAddmanifestTime($data)
	{
		$this->db->query($data);
	}
	public function AddManifestStatusdata($data)
	{
		$this->db->query($data);
	}
	
	public function ZonesratesDataqry($from_zone=null,$to_zone=null,$cust_id=0)
	{
		$Query=$this->db->query("select return_fees from zone_price_set where zone_id_form='".$from_zone."'  and zone_id_to='".$to_zone."'  and status='Y' and deleted='N'  and cust_id='".$cust_id."' ");
		return $Query->result_array();
	}
	
	public function ShipmetupdateQryData($awb)
	{
		$Query=$this->db->query("select slip_no,reciever_email,sender_email,reciever_phone,sender_phone,cust_id,delivered,reciever_address,reciever_city,call_attempt,req_delevery_time from shipment where slip_no='".trim($awb)."'");
		return $Query->result_array();
	}
	public function GetselectQry($string=null)
	{
		$query=$this->db->query($string);
		return $query->result_array();
	}
	public function GetUpdateQry($string=null)
	{
		$this->db->query($string);
		
	}
	
	
}
?>