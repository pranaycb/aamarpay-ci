<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

	public function __construct(){
		parent::__construct();

		if(! $this->session->userdata('user_session')){
			redirect(base_url());
		}


		//load aamarpay library
		$this->load->library('aamarpay');

		//load form validation helper
		$this->load->library('form_validation');
	}

	public function index(){

		$user = $this->db->where(['user_id'=>$this->session->userdata('user_session')])->get('user')->row();

		if($user){

			if($this->input->post()){

				//validate email id
				$this->form_validation->set_rules('amount', 'Amount', 'required', array(
		                'required'	=> 'Enter payment amount to continue'
		        ));

		        //if form is validated
	        	if($this->form_validation->run()){

	        		$amount = $this->input->post('amount');

	        		$data =  array( 

					    'amount' => $amount, 

					    'currency' => 'BDT',

					    'tran_id' => $this->gen_transaction_id(11),

					    'cus_name' => $user->user_name, 

					    'cus_email' => $user->user_email, 

					    'cus_add1' => $user->user_address, 

					    'cus_add2' => $user->user_address,

					    'cus_city' => $user->user_city,

					    'cus_state' => $user->user_state,

					    'cus_postcode' => $user->user_postcode,

					    'cus_country' => $user->user_country, 

					    'cus_phone' => $user->user_mobile,

					    'desc' => "aamarpay payment gateway integration in codeigniter",

					    'success_url' => base_url('status/type/success'),

					    'fail_url' => base_url('status/type/failed'),

					    'cancel_url' => base_url('status/type/cancel'),

					    'opt_a' => $this->session->userdata('user_session'), //we are sending this sesion data so that we can keep our user logged in after payment
					);

					$payment_url = $this->aamarpay->make_payment($data);

					header("Location: ".$payment_url);

	        	}

			}

			$this->load->view('payment', ['user' => $user]);

		}else{

			show_404();

		}

	}

	protected function gen_transaction_id( $length ) {
		$str="";
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++) { $str .= $chars[ rand( 0, $size - 1 ) ]; }
		return $str;
	}

	public function verify(){

		$payment_data = null;

		$error = null;

		if($this->input->post()){

			//validate email id
			$this->form_validation->set_rules('trxid', 'Trandaction id', 'required', array(
	                'required'	=> 'Enter payment transaction id to continue'
	        ));

	        //if form is validated
	        if($this->form_validation->run()){

	        	$trxid = $this->input->post("trxid");

	        	$data = $this->aamarpay->verify_payment($trxid);

	        	if(isset($data['status']) && $data['status'] == 'Invalid-Data'){

	        		$error = "No payment record found";

	        	}else{

	        		$payment_data = $data;

	        	}

	        }

		}

		$this->load->view('verify',['payment_data' => $payment_data, 'error' => $error]);

		

	}



}
