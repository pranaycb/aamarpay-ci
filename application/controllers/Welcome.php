<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){
		parent::__construct();

		if( $this->session->userdata('user_session')){
			redirect(base_url('payment'));
		}

		//load form validation helper
		$this->load->library('form_validation');
	}

	public function index()
	{

		$error = null;

		if($this->input->post()){

			//validate email id
			$this->form_validation->set_rules('emailid', 'Email', 'required', array(
	                'required'	=> 'Enter your email id to login'
	        ));

			//validate password
			$this->form_validation->set_rules('password', 'password', 'required', array(
	                'required'	=> 'Enter your password to login'
	        ));

	        //if form is validated
	        if($this->form_validation->run()){

	        	$email = $this->input->post('emailid');
	        	$password = $this->input->post('password');

	        	//we are doing all kind of database operations here. You can do this in model file if you want

	        	//check the user
	        	$check_user = $this->db->where(['user_email' => $email])->get('user')->row();

	        	if($check_user){

	        		//verify password
	        		if(password_verify($password, $check_user->user_password)){

	        			//login user
	        			$this->session->set_userdata('user_session', $check_user->user_id); 
	        			// you can use session token to make it more secure

	        			//redirect user to payment page
	        			redirect(base_url('payment'));


	        		}else{

	        			$error = "Password is invalid";

	        		}


	        	}else{

	        		$error = "Email id is invalid";

	        	}



	        }



		}

		$this->load->view('welcome_message',['error'=>$error]);
	}
}
