<?php

/** 
 * @author seant23
 * 
 * 
 */
class  Lender_AE {
	
	/**
	 * Attempt to login as AE, for AE Admin
	 * 
	 * @param string $login Contact Email Address or Username for login
	 * @param string $password Password for login
	 * 
	 * @return array Array containing results from the login attempt
	 */
	public function login($login, $password) {
		$success = LP_LenderAE::login ( $login, $password );
		
		if ($success) {
			return array ('success' => true );
		} else {
			return array ('success' => false, 'error' => LP_LenderAE::$loginError );
		}
	}
	
	/**
	 * Change password
	 * 
	 * @todo
	 * 
	 * @return array An Array containing results from attempt
	 */
	public function setPassword() {
	
	}
	
	/**
	 * Get information about the current AE's Session
	 * 
	 * @return array An Array of this AE's session information
	 */
	public function getSessionDetails() {
		if(LP_LenderAE::isLoggedIn()) {
			$ae = $_SESSION['ae'];
			
			return array(	
				'isLoggedIn' => true,
				'ae' => $ae,
			);
		} else {
			return array(	
				'isLoggedIn' => false
			);
		}
	}
	
	/**
	 * Logout the ae out
	 * 
	 * @return boolean success boolean
	 */
	public function logout() {
		return LP_LenderAE::logout ();
	}

}
