<?php

class PaypalController extends Zend_Controller_Action
{	
	public function indexAction() {
		$ipn_data = array(
			'payment_status'=>'verified',
			'first_name'=>'Stephan',
			'last_name'=>'Thayne',
			'payer_email'=>'stephan@thayne.com',
			'payer_id'=>'1',
			'address_name'=>'Stephan Thayne',
			'address_country'=>'USA',
			'address_zip'=>'84065',
			'address_state'=>'Utah',
			'address_city'=>'Riverton',
			'address_street'=>'12020 s 2240 e',
			'address_country_code'=>'US',
			'buisness'=>'Stephan',
			'reciever_email'=>'stephan@thayne.com',
			'reciever_id'=>'22',
			'item_name'=>'content',
			'mc_gross'=>'1.00',
			'custom'=>array(
				'user_id'=>'1',
				'content_id'=>'1'
			)
		);
		$user_id = $ipn_data['custom']['user_id'];
		$content_id = $ipn_data['custom']['content_id'];
		$content = $ipn_data['item_name'];
		$first_name = $ipn_data['first_name'];
		$last_name = $ipn_data['last_name'];
		$email = $ipn_data['payer_email'];
		$payment_status = $ipn_data['payment_status'];
		
		if($payment_status == 'verified') {
			
			Red_Content::purchaseContent($user_id, $content_id);
			
			$user = array(
				'first_name'=>$first_name,
				'last_name'=>$last_name,
				'email'=>$email,
				'content'=>$content
			);
			
			Red_Content::emailPurchase($user);
			
		}
		
	}
	
}

