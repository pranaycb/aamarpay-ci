<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Aamarpay{

	protected $CI = null;

	public function __construct(){

		//creating an instance of Codeigniter class
		$this->CI = & get_instance();

		//load aamarpay config class
		$this->CI->config->load('aamarpay');
	}

	public function make_payment($data){

		$fields_string = null;

		$url = $this->CI->config->item("aamarpay_payment_mode") === 'sandbox' ? 'https://sandbox.aamarpay.com/request.php' : 'https://secure.aamarpay.com/request.php';

		$data['store_id'] = $this->CI->config->item("aamarpay_store_id");
		$data['signature_key'] =  $this->CI->config->item("aamarpay_signature_key");

		foreach($data as $key=>$value) { 

			$fields_string .= $key.'='.$value.'&'; 

		}

		$fields_string = rtrim($fields_string, '&'); 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_URL, $url);  
		curl_setopt($ch, CURLOPT_POST, count($data)); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$url_forward = str_replace('"', '', stripslashes(curl_exec($ch)));	
		curl_close($ch); 

		if($this->CI->config->item("aamarpay_payment_mode") === 'sandbox'){

			return "https://sandbox.aamarpay.com".$url_forward;

		}else{

			return "https://secure.aamarpay.com".$url_forward;

		}




	}

	public function verify_payment($trxid){

		$curl_handle=curl_init();

		curl_setopt(
			$curl_handle,
			CURLOPT_URL,
			"https://sandbox.aamarpay.com/api/v1/trxcheck/request.php?request_id=".$trxid."&store_id=".$this->CI->config->item("aamarpay_store_id")."&signature_key=".$this->CI->config->item("aamarpay_signature_key")."&type=json"
		);

		curl_setopt($curl_handle, CURLOPT_VERBOSE, true);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
		$buffer = curl_exec($curl_handle);
		curl_close($curl_handle);
		$a = (array)json_decode($buffer);
		
		return $a;

		
	}




}