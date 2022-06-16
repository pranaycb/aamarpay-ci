<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends CI_Controller {

	public function type($type){

		$user_session = $this->input->post('opt_a');

		if($type === 'cancel'){
			
			echo "<h1>Your payment is canceled</h1>";

		}else{

			//re-create session to keep user logged in
			if(! $this->session->userdata('user_session')){
				$this->session->set_userdata('user_session', $user_session);
			}

			$status = $this->input->post('pay_status');

			if($status === 'Successful'){
				echo "<h1>Your payment ".$this->input->post('amount')." ".$this->input->post('currency')." is Successful. Transaction id is- ".$this->input->post("mer_txnid")."</h1>";

			}else{
				echo "<h1>Your payment ".$this->input->post('amount')." ".$this->input->post('currency')." is Failed. Transaction id is- ".$this->input->post("mer_txnid")."</h1>";
			}

		}

	}


}