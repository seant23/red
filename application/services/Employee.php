<?php

class Employee {
	
	/**
	 * Login Attempt 
	 * 
	 * @param $username String Username, Email, or Contact ID used for login
	 * @param $password String Password for login
	 * 
	 * @return array An Array containing the results of the login attempt
	 */
	public function login($username, $password) {
		$success = LP_Employee::login ( $username, $password );
		
		if ($success) {
			return array ('success' => true );
		} else {
			return array ('success' => false, 'error' => LP_Employee::$loginError );
		}
	
	}
}
