<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

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
		
			$this->form_validation->set_rules('fullname','Full Name','required|trim|xss_clean');
			$this->form_validation->set_rules('email','Email','required|trim|valid_email|is_unique[tbl_user.email]');
			$this->form_validation->set_rules('password','Password','required|trim|xss_clean');
			if($this->form_validation->run()==True){
				$data_insert['fullname'] = $this->security->xss_clean($this->input->post('fullname'));
				$data_insert['email'] = $this->security->xss_clean($this->input->post('email'));
				$password = $this->security->xss_clean($this->input->post('password'));
				$data_insert['created'] = date('Y-m-d h:i:s');
				$data_insert['is_active'] = 1;
				$data_insert['role'] = 1;
				$salt= '6a3d';
				$hash = sha1($password.$salt);
				$data_insert['password'] = $hash;
				$data_insert['hash_key'] = $salt;
				$res  = $this->r_model->save($data_insert,'tbl_user');
				if($res>0){
					$this->session->set_flashdata('success_msg','successfully add book category');
					redirect('login');
				}else{
					$this->session->set_flashdata('error_msg','Something went wrong!');
					redirect('register');
				}
			}else{
				$this->load->view('register');
			}
		
		
	}
}
