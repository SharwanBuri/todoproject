<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Action extends CI_Controller {

	 public function __construct(){
        parent::__construct();
		$this->load->helper('security');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('myrender');
		$this->load->model('R_model');
       }
	
	public function delete($id,$tbl,$atch='rk'){
		if($this->session->userdata('logged_in')){
			$del  = $this->R_model->getData("tbl_".$tbl,array(),array("id"=>$id));
			$attach = $del['0']->$atch;
			if($attach){
				 $upload_folder = FCPATH .$attach ;
				 unlink($upload_folder);
				 $res = $this->R_model->delete('tbl_'.$tbl,array("id"=>$id));
				if($res>0){
					$this->session->set_flashdata('success_msg','Successfully deleted!');
					redirect($_SERVER['HTTP_REFERER']); 
				}else{
					$this->session->set_flashdata('error_msg','Something went wrong!');
					redirect($_SERVER['HTTP_REFERER']); 
				}
			}else{
				$res = $this->R_model->delete('tbl_'.$tbl,array("id"=>$id));
				if($res>0){
					$this->session->set_flashdata('success_msg','Successfully deleted!');
					redirect($_SERVER['HTTP_REFERER']); 
				}else{
					$this->session->set_flashdata('error_msg','Something went wrong!');
					redirect($_SERVER['HTTP_REFERER']); 
				}
			}
		}else{
			redirect('/');
		}
	}
	public function delete_multiple(){
		if($this->session->userdata('logged_in')){
			$this->form_validation->set_rules('item_id[]','Select any value to delete','trim|required');
			if($this->form_validation->run()==true){
				$id = $this->security->xss_clean($this->input->post('item_id'));
				$tbl = $this->security->xss_clean($this->input->post('tbl'));
				$cols = $this->security->xss_clean($this->input->post('cols'));
				//print_r($id);exit;
				foreach($id as $m){
					$del  = $this->R_model->getData("tbl_".$tbl,array(),array("id"=>$m));
					$attach = $del['0']->$cols;
					$upload_folder = FCPATH .$attach ;
					unlink($upload_folder);
					$res = $this->R_model->delete("tbl_".$tbl,array("id"=>$m));
				}
				if($res>0){
					$this->session->set_flashdata('success_msg','Successfully deleted!');
						redirect($_SERVER['HTTP_REFERER']); 
					}else{
						$this->session->set_flashdata('error_msg','Something went wrong!');
						redirect($_SERVER['HTTP_REFERER']); 
					}
			}else{
				$this->session->set_flashdata('error_msg','Something went wrong!');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}else{
			redirect('/');
		}
	}
	public function status($id,$tbl,$status){
		if($this->session->userdata('logged_in')){
			$data['is_active'] = $status;
			$res = $this->R_model->update('tbl_'.$tbl,$data,array("id"=>$id));
			if($res>0){
				$this->session->set_flashdata('success_msg','Successfully updated!');
				redirect($_SERVER['HTTP_REFERER']); 
			}else{
				$this->session->set_flashdata('error_msg','something went wrong!');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}else{
			redirect('/');
		}
	}
	
public function featured($id,$tbl,$featured){
		if($this->session->userdata('logged_in')){
			$data['is_featured'] = $featured;
			$res = $this->R_model->update('tbl_'.$tbl,$data,array("id"=>$id));
			if($res>0){
				$this->session->set_flashdata('success_msg','Successfully updated!');
				redirect($_SERVER['HTTP_REFERER']); 
			}else{
				$this->session->set_flashdata('error_msg','something went wrong!');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}else{
			redirect('/');
		}
	}
	
	public function statusThree($id,$tbl,$status,$role){
		if($this->session->userdata('logged_in')){
			$data['is_active'] = $status;
			$res = $this->R_model->update('tbl_'.$tbl,$data,array("id"=>$id));
			if($res>0){
				$rquery  = $this->db->query("update tbl_user set is_active = '$status' where role ='$role'");
				if($rquery>0){
					$this->session->set_flashdata('success_msg','Successfully updated!');
				redirect($_SERVER['HTTP_REFERER']); 
				}else{
					$this->session->set_flashdata('error_msg','something went wrong!');
				redirect($_SERVER['HTTP_REFERER']);
				}
				
			}else{
				$this->session->set_flashdata('error_msg','something went wrong!');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}else{
			redirect('/');
		}
	}
	public function statusTwo($id,$tbl,$status,$col){
		if($this->session->userdata('logged_in')){
			$data[$col] = $status;
			$res = $this->R_model->update('tbl_'.$tbl,$data,array("id"=>$id));
			if($res>0){
				$this->session->set_flashdata('success_msg','Successfully updated!');
				redirect($_SERVER['HTTP_REFERER']); 
			}else{
				$this->session->set_flashdata('error_msg','something went wrong!');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}else{
			redirect('/');
		}
	}
	
		public function status_change(){
		if($this->session->userdata('admin_logged_in')){
			$this->form_validation->set_rules('item_id[]','Select any value to delete','trim|required');
			if($this->form_validation->run()==true){
				$id = $this->security->xss_clean($this->input->post('item_id'));
				$tbl = $this->security->xss_clean($this->input->post('tbl'));
				$cols = $this->security->xss_clean($this->input->post('colsupdate'));
				$colsValue = $this->security->xss_clean($this->input->post('colsupdateValue'));
				foreach($id as $m){
					$res = $this->R_model->update('tbl_'.$tbl,array($cols=>$colsValue),array('id'=>$m));
				}
				//echo $this->db->last_query();exit;
				if($res>0){
					$this->session->set_flashdata('success_msg','Successfully changed status!');
						redirect($_SERVER['HTTP_REFERER']); 
					}else{
						$this->session->set_flashdata('error_msg','Something went wrong!');
						redirect($_SERVER['HTTP_REFERER']); 
					}
			}else{
				$this->session->set_flashdata('error_msg','Something went wrong!');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}else{
			redirect('admin');
		}
	}
	
}
