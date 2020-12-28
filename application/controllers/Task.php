<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Controller {

	public function __construct(){
	parent::__construct();
		$this->load->helper('security');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('myrender');
		$this->load->model('account_model');
		$this->load->helper(array('email'));
        $this->load->library(array('email'));
		$this->load->model('r_model');
       }
	public function index()
	{
		if($this->session->userdata('logged_in')){
			$this->myrender->header();
			$uid = $this->session->userdata('logged_in')['user_id'];
			$data['tasks'] = $this->r_model->getData('tbl_task',array(),array("user_id"=>$uid),array("id"=>"desc"));
			$this->load->view('task-list',$data);
			$this->myrender->footer();
		}else{
			redirect('/');
		}
		
	}
	public function view($id)
	{
		if($this->session->userdata('logged_in')){
			$this->myrender->header();
			$uid = $this->session->userdata('logged_in')['user_id'];
			$data['tasks'] = $this->r_model->getData('tbl_task',array(),array("user_id"=>$uid,"id"=>$id),array("id"=>"desc"));
			$this->load->view('task-view',$data);
			$this->myrender->footer();
		}else{
			redirect('/');
		}
		
	}
	public function add(){
		if($this->session->userdata('logged_in')){
			$this->form_validation->set_rules('title','Task Title','required|trim|xss_clean');
			if($this->form_validation->run()==True){
				$data_insert['title'] = $this->security->xss_clean($this->input->post('title'));
				$data_insert['user_id'] = $this->session->userdata('logged_in')['user_id'];
				$data_insert['description'] = $this->security->xss_clean($this->input->post('description'));
				$data_insert['created'] = date('Y-m-d h:i:s');
				$data_insert['is_active'] = 0;
						
				$res  = $this->r_model->save($data_insert,'tbl_task');
				if($res>0){
					$this->session->set_flashdata('success_msg','successfully add book category');
					redirect('task');
				}else{
					$this->session->set_flashdata('error_msg','Something went wrong!');
					redirect('task/add');
				}
			}else{
				$this->myrender->header();
				$this->load->view('task-add');
				$this->myrender->footer();
			}
		}else{
			redirect('/');
		}	
	}
	
		public function edit($id){
		if($this->session->userdata('logged_in')){
			$this->form_validation->set_rules('title','Task Title','required|trim|xss_clean');
			if($this->form_validation->run()==True){
				$data_update['title'] = $this->security->xss_clean($this->input->post('title'));
				$data_update['description'] = $this->security->xss_clean($this->input->post('description'));
				$data_update['updated'] = date('Y-m-d h:i:s');
				$res  = $this->r_model->update('tbl_task',$data_update,array("id"=>$id));
				if($res>0){
					$this->session->set_flashdata('success_msg','successfully Update taks');
					redirect('task');
				}else{
					$this->session->set_flashdata('error_msg','Something went wrong!');
					redirect('task/edit/'.$id);
				}
			}else{
				$this->myrender->header();
				$uid = $this->session->userdata('logged_in')['user_id'];
				$data['task'] = $this->r_model->getdata('tbl_task',array(),array("id"=>$id,"user_id"=>$uid),array("id"=>"desc"));
				$this->load->view('task-edit',$data);
				$this->myrender->footer();
			}
		}else{
			redirect('/');
		}
	}

}
