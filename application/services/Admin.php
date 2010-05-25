<?php

class Admin {
	/**
	 * Login Attempt 
	 * 
	 * @param $username String Username, Email, or Contact ID used for login
	 * @param $password String Password for login
	 * 
	 * @return array An Array containing the results of the login attempt
	 */
	public function login($email, $password) {
		$success = Red_Admin::login ( $email, $password );
		
		if ($success) {
			return array ('success' => Red_Admin::isLoggedIn() );
		} else {
			return array ('success' => false, 'error' => Red_Admin::$error );
		}
	
	}
	
	
	
	public function isLoggedIn() {
		return Red_Admin::isLoggedIn();
	}
	
	public function changePassword($oldPassword, $newPassword) {
		$success = Red_Admin::changePassword ( $oldPassword, $newPassword );
		
		if ($success) {
			return array ('success' => true );
		} else {
			return array ('success' => false, 'error' => Red_Admin::$error );
		}
	}
	
	/**
	 * Logout of the admin
	 */
	public function logOut() {
		return Red_Admin::logout();
	}
}
