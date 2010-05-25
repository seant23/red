<?php

class GatewayController extends Zend_Controller_Action {
	
	public function init() {
		$this->getHelper ( 'ViewRenderer' )->setNoRender ();
	}
	
	public function indexAction() {
		
		$server = new Zend_Amf_Server ();
		$server->addDirectory ( APPLICATION_PATH . '/services' );
		echo ($server->handle ());
	}
	
	public function testAction() {
		header('content-type: text/plain');
		$database = Zend_Db_Table::getDefaultAdapter ();
	
		/**
		 * Find User Information employee_view
		 */
		Red_User::emailNewUser(array('email'=>'sean@exit12.org', 'password'=>'test'));
		echo 123;
	}

}

