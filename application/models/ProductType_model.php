<?php
class ProductType_model extends CI_Model
{
	
	function __construct() 
	{
		parent::__construct();
		
	
	}  
		
	
	public function getAddProduct($searchcod=null,$page_no)
	{ 
		$page_no;
          $limit = 40;
        if(empty($page_no)){  
            $start = 0;
        }else{
            $start = ($page_no-1)*$limit;
        }    
		 $this->db->select('*');
         $this->db->from('product_detail');
         $this->db->order_by('pac_id','DESC'); 
		 $this->db->limit($limit, $start); 
		 if(!empty($searchcod))
		 {
			$this->db->where("supplier LIKE '%$searchcod%'");
			
		 }
		 $this->db->where('status','Y');
		 $this->db->where('deleted','N');
         $query = $this->db->get();
          ////return $this->db->last_query(); die; 
		  
		if($query->num_rows()>0)
		{
			$data['result']=$query->result_array();
            $data['count']=$this->getAddProductCount($searchcod,$page_no);  
			return $data;
		}
	}
	
	public function getAddProductCount($searchcod,$page_no)
	{
		 if(!empty($searchcod))
		 {
			$this->db->where('supplier',$searchcod); 
		 }
		   
			$this->db->where('status','Y');
		    $this->db->where('deleted','N');
			$this->db->select('COUNT(pac_id) as sh_count');
			$this->db->from('product_detail'); 
			$this->db->order_by('pac_id','DESC');
			
			$query = $this->db->get();
				if($query->num_rows()>0){
				$data= $query->result_array();  
				return $data[0]['sh_count'];    
				}
				return 0;
	}
		
	
	public function getProductdelete($data=array(),$pac_id=null)
	{
		return $this->db->update('product_detail',$data,array('pac_id'=>$pac_id));

	}
	
	 
		public function InsertProduct($data=array()) 
	{
		return $this->db->insert('product_detail',$data);
		 
		 // $this->db->last_query(); die;
		
	}
	
	public function Getproductlist_edit($pac_id=null)
		{
		 $this->db->select('*');
         $this->db->from('product_detail');
         $this->db->where('status', 'Y');
		 $this->db->where('deleted', 'N');
		 $this->db->where('pac_id', $pac_id);
		
		
         $query = $this->db->get();
         // return $this->db->last_query(); die;
		  
		if($query->num_rows()>0)
		{
			return $query->row_array();
		}
		}
		
		public function EditFormQuery($data=array(),$id=null)
		{
			return $this->db->update('product_detail',$data,array('id'=>$id));     
			//return $this->db->last_query(); die; 
		}
}
?>