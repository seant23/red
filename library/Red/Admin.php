<?php

class Red_Admin {
	
	public static $error;
	
	public static function isLoggedIn() {
		if(isset($_SESSION['admin_is_logged_in'])) {
			return $_SESSION['admin_is_logged_in'];
		} else {
			return false;
		}
	}
	public function changePassword( $oldPassword, $newPassword ) {
		$database = Zend_Db_Table::getDefaultAdapter ();
		
		if(!self::isLoggedIn()) {
			$error = 'Your not logged in';
			return false;
		} else {
			
			$admin = $database->select()->from('user')->where('user_id = ?', $_SESSION['admin']['user_id'])->query()->fetch();
			
			/**
			 * Check Password
			 */
			if ($admin['password'] != md5 ( $oldPassword )) {
				self::$error = "Incorrect Password";
				return false;
			} else {
				$update = array('password'=>md5($newPassword));
				$database->update('user', $update, "user_id = {$_SESSION['admin']['user_id']}");
				return true;
			}	
		}
	}
	
	public static function login($email, $password) {
		$database = Zend_Db_Table::getDefaultAdapter ();
	
		/**
		 * Find User Information employee_view
		 */
		$admin = $database->select()->from('user')->where('email = ?', $email)->query()->fetch();
		if (! $admin) {
			self::$error = "User not found with that email";
			return false;
		}
		
		/**
		 * Check Password
		 */
		if ($admin ['password'] != md5 ( $password )) {
			self::$error = "Incorrect Password";
			return false;
		}
		
		
		/**
		 * Check Admin Status
		 */
		if (!$admin ['is_admin']) {
			self::$error = "Not an Admin";
			return false;
		}
		
		/**
		 * Check Admin Status
		 */
		if ($admin ['is_banned']) {
			self::$error = "Admin is Banned";
			return false;
		}
		
		
		$_SESSION['admin'] = $admin;
		$_SESSION['admin_is_logged_in'] = true;
		
		
		
		$update = array(
			'last_login' => new Zend_Db_Expr("NOW()")
		);
		
		$database->update('user', $update, "user_id = {$admin['user_id']}");
		
		return true;
	}
	
	public static function logout() {
		$_SESSION['admin_is_logged_in'] = false;
		return true;
	}
	
	
}