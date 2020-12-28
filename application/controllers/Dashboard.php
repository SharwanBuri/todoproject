<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
			$this->load->view('dashboard');
			$this->myrender->footer();
		}else{
			redirect('/');
		}
		
	}
	public function logout(){
		
		if($this->session->userdata('logged_in')){
			$this->session->unset_userdata('logged_in');
			redirect('/');
		}else{
			redirect('/');
		}
		
	}
}
