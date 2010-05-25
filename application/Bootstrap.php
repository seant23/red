<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	protected function _initAutoLoader() {
		$autoloader = Zend_Loader_Autoloader::getInstance ();
		$autoloader->registerNamespace ( 'Red_' );
	}
	protected function _initRegistry() {
		Zend_Registry::set ( 'bootstrap', $this );
		
	}
	protected function _initSession() {
		Zend_Session::start ();
	}
}

