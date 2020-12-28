<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Author : RAHUL
 * Description : This model is used for Account Operation
 */

class Account_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	public function checkValidation($username,$password)
	{
		$rquery = $this->db->query("select * from tbl_user where is_active = 1 and (email='".$username."' )");
		$results = $rquery->result();
		if(!empty($results))
		{				
			$salt= $results[0]->hash_key;
			$dbpassword= $results[0]->password;
			$password_hash = sha1($password.$salt);
			$pwd=$results[0]->hash_key;
			if($password_hash==$dbpassword)
			{
				$login_user=array('user_id'=>$results[0]->id,
					'email'=>$results[0]->email,
					'profile_pic'=>$results[0]->profile_pic,
					'role' => $results[0]->role,
					'fullname'=>$results[0]->fullname,
					);						
				if($results[0]->role==1){
					$this->session->set_userdata('logged_in',$login_user);
				}					
				return true;
		}
		return false;
	}
	return false;
			
	}
	
	public function setPassword($username)
	{
		$rquery = $this->db->query("select * from tbl_user where is_active = 1 and (email='".$username."' || username='".$username."' )");
		$results = $rquery->result();
		if(!empty($results))
		{
			$id = $results[0]->id;
			$password = mt_rand(100000, 999999);
			$salt = "tes12t";
			$salt_key = substr(md5($salt),28);
			$hash = sha1($password.$salt_key);
			
			$data = array(
					'hash_key' => $salt_key,
					'password' => $hash,
					'updated' =>date('Y-m-d h:i:s')
			);
			//print_r($data);
			$this->db->where('id', $id);
			$res = $this->db->update('tbl_user', $data);
			//echo $this->db->last_query();exit;
			if($res>0){
				return $changearray = array('email'=>$results[0]->email,
					'password'=>$password,
					'name'=>$results[0]->name
				);
				
			}else{
				return false;
			}
		}
		return false;
			
	}	
	
	public function register_user($data){
		$check=$this->db->insert('tbl_user',$data);
		if($check)
			return $this->db->insert_id();
		else
			return false;
	}
	public function fetch_admindetail($uid){
		$this->db->select('*');
		$this->db->from('tbl_user');
		$this->db->where('id',$uid);
		$this->db->where('is_active',1);
		$query = $this->db->get();
		return $res = $query->result();
	}
	
	public function update_pic($pic,$uid){
		$data_array  = array(
			'profile_pic'=>$pic
		);
		$this->db->where('id',$uid);
		$res  = $this->db->update('tbl_user',$data_array);
		if($res){
			return true;
		}else{
			return false;
		}
		
	}
	
	public function updateSiteData($data,$uid=1){
		
		$this->db->where('id',$uid);
		$res  = $this->db->update('tbl_site_info',$data);
		if($res){
			return true;
		}else{
			return false;
		}
	}
	
	public function getSiteinFo(){
		$rquery  = $this->db->get_where('tbl_site_info',array('is_active'=>1,'id'=>1));
		return $res  = $rquery->result();
	}
	
	public function fetch_data($tbl,$id){
		$rquery  = $this->db->get_where($tbl,array('id'=>$id));
		return $res  = $rquery->result();
	}
}