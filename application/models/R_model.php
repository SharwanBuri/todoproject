<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Author : RAHUL (rk)
 * Description : This model is used for Account Operation
 */
class R_model extends CI_Model
{
    function __construct(){
		parent::__construct();
	}

    
	public function save($data_array,$tbl){
		$this->db->set($data_array);
		$this->db->insert($tbl);
		return $insert_id = $this->db->insert_id();
	}
	public function getData($tbl,$col_array,$whr_array=array(),$orderby_array=array(),$limit_value=1000,$ofset_value=0,$type='where'){
		$fetch_string = implode(",",$col_array);
		$this->db->select($fetch_string);
		if(!empty($whr_array)){
		    if($type=='where'){
		       $this->db->where($whr_array); 
		    }elseif($type=='where_in'){
		        foreach($whr_array as $key=>$val){
		            $this->db->where_in($key, $val);
		        }
		    }
			
		}
		if(!empty($orderby_array)){
		foreach($orderby_array as $okey=>$oval){
			$this->db->order_by($okey,$oval);
			}
		}
		$this->db->from($tbl);
		$this->db->limit($limit_value,$ofset_value);
		$query=$this->db->get();
		// echo $this->db->last_query();
		// exit;
		 return $res  = $query->result();
		//print_r($res);exit;
	}
	public function update($tbl,$data_array,$whr_array=array()){
		$this->db->where($whr_array);
		$rquery = $this->db->update($tbl, $data_array);
		//echo $this->db->last_query();exit;
		if($rquery){
			return true;
		}else{
			return false;
		}
		
	}
	public function delete($tbl,$whr_array=array()){
		$this->db->where($whr_array);
		$rquery = $this->db->delete($tbl);
		//echo $this->db->last_query();exit;
		if($rquery){
			return true;
		}else{
			return false;
		}
		
	}

}

?>