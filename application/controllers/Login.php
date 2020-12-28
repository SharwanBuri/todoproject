<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
			$this->session->set_flashdata('success_msg','Welcome!');
			redirect('dashboard');
		}else{
			$this->form_validation->set_rules('username', 'Username', 'required|trim');
			$this->form_validation->set_rules('password', 'Password', 'required|trim');
			if($this->form_validation->run() == TRUE)
            {				
				$username = $this->security->xss_clean($this->input->post('username'));
				$password = $this->security->xss_clean($this->input->post('password'));
				$usersult  = $this->account_model->checkValidation($username,$password);
				if($usersult>0){
					$this->session->set_flashdata('success_msg','Welcome!');
					redirect('dashboard');
				}else{
					$this->session->set_flashdata('error_msg','Username and password');
					redirect('/');
				}
			}else{
				$this->load->view('login');
			}
		}
	}
}
