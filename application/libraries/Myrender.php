<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Rendering Library
 *
 * @version    	1.0.0
 * @author     rk
 */
class Myrender
{

    protected $CI;

	//Constructor
	public function __construct()
    {
	    $this->CI =& get_instance();
	    $this->CI->load->model("account_model");
	    $this->CI->load->model("R_model");
			   
              
    }
      //Show Header
     public function header(){
		if($this->CI->session->userdata('logged_in')){
			 $id =  $this->CI->session->userdata('logged_in')['user_id'];
			 $this->CI->load->view("templates/header"); 
		}
		  
    }
	   //Show Footer
	public function footer(){
		$this->CI->load->view("templates/footer");
    }  
    
	
	
	
	
	
	
}