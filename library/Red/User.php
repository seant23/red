<?php
/**
 * This class handles all core user credentials
 * 
 * @author seant23
 *
 */
class Red_User {
	
	/**
	 * Describes failure
	 * @var string
	 */
	public static $error;
	
	/**
	 * Attempt login
	 * 
	 * @param string $username
	 * @param string $password
	 */
	public function login($email, $password) {
		$database = Zend_Db_Table::getDefaultAdapter ();
		
		/**
		 * Find User Information employee_view
		 */
		$user = $database->select ()->from ( 'user' )->where ( 'email = ?', $email )->query ()->fetch ();
		if (!$user) {
			self::$error = "User not found with that email";
			return false;
		}
		
		/**
		 * Check Password
		 */
		if ($user ['password'] != md5 ( $password )) {
			self::$error = "Incorrect Password";
			return false;
		}
		/**
		 * Check Admin Status
		 */
		if ($user ['is_banned']) {
			self::$error = "User is Banned";
			return false;
		}
		
		if ($user ['activation_code'] != 0) {
			self::$error = "This account has not been activated.";
			return false;
		}
		
		$_SESSION ['user'] = $user;
		$_SESSION ['is_logged_in'] = true;
		
		$update = array ('last_login' => new Zend_Db_Expr ( "NOW()" ) );
		
		$database->update ( 'user', $update, "user_id = {$user['user_id']}" );
		
		return true;
	}
	/**
	 * Returns the currently logged in user's contact_id if applicable
	 * 
	 * @return int Contact ID
	 */
	public static function getUserID() {
		if (self::isLoggedIn ()) {
			return ( int ) $_SESSION ['user'] ['user_id'];
		} else {
			return 0;
		}
	}
	
	public function getNeedsVote($user_id) {
		$database = Zend_Db_Table::getDefaultAdapter ();
		
		$needed = $database->select()->from('purchase')
							->where('user_id = ?', $user_id)
							->query()->fetchAll();
							
		return $needed;
		
		
	}
	
	public function selectProfile($user_id) {
		$database = Zend_Db_Table::getDefaultAdapter ();
		
		$user = $database->select ()->from ( 'user' )->where ( 'user_id = ?', $user_id )->query ()->fetch ();
		
		if (! $user) {
			self::$error = "User not found.";
			return false;
		} else {
			return $user;
		}
	
	}
	
	public static function generateRandomPassword($len, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') {
		$string = '';
		for($i = 0; $i < $len; $i ++) {
			$pos = rand ( 0, strlen ( $chars ) - 1 );
			$string .= $chars {$pos};
		}
		return $string;
	}
	
	public static function emailNewUser($user) {
		
		$database = Zend_Db_Table::getDefaultAdapter ();
		if(is_array($user)) {
			
			$user_data = self::selectProfile($user['user_id']);
			
			$mailer = new Zend_Mail();
			$mailer->setBodyText('Test');
			
			$view = new Zend_View();
			$view->setScriptPath( APPLICATION_PATH . '/views/email/user/');
			$view->user = $user;
			$view->user_data = $user_data;
			$html = $view->render('Register.phtml');
			
			$mailer->setBodyHtml($html);
			$mailer->addTo($user['email']);
			$mailer->setSubject('Welcome Sucker');
			$mailer->send();
		}
	}
	
	public static function createNewUser($email, $firstName, $lastName, $password, $emailUser=true) {
		global $application; 
		
		$database = Zend_Db_Table::getDefaultAdapter ();
		
		
		$activation_code = self::generateRandomPassword(6);
		
		$newUser = array(
			'email' 		=> $email,
			'first_name' 	=> $firstName,
			'last_name'  	=> $lastName,
			'activation_code'  	=> $activation_code,
			'password'		=> md5($password),
			'create_date' 	=> new Zend_Db_Expr ( "NOW()" )
		);
		
		/**
		 * Check for duplicate email address
		 */
		$user = $database->select()->from( 'user' )->where('email = ?', $newUser['email'])->query()->fetch();
		
		if($user) {
			$front = Zend_Controller_Front::getInstance();
			
			
			echo "Email Already Exists";
			exit;	
		}
		
		$database->insert('user', $newUser);
		
		$newUser['user_id'] = $database->lastInsertId();
		$newUser['password'] = $password;
		
		if($emailUser) {
			self::emailNewUser($newUser);
		}
		
		return $newUser;
	}
	
	public static function getUsers($filters=null, $perPage=25, $page=1) {
		$database = Zend_Db_Table::getDefaultAdapter ();
		$users = $database->select()->from( 'user' );
		
		/**
		 * Loop through filters and apply them
		 */
		if(is_array($filters)) {
			foreach($filters as $filter) {
				/**
				 * Check for optional keys, set defaults if missing
				 */
				if(!isset($filter['type'])) {
					$filter['type'] = '=';
				}
				
				/**
				 * Check for required keys
				 */
				if(!isset($filter['column']) || !isset($filter['value'])) {
					continue;
				}
				
				/**
				 * Check for true column name
				 * 
				 * Used to make sure they are injecting!!!
				 */
				if(!in_array($filter['column'], array('user_id', 'email', 'first_name', 'last_name', 'is_admin', 'is_banned'))){
					continue;
				}
				
				/**
				 * Check for true filter type
				 * 
				 * Used to make sure they are injecting!!!
				 */
				if(!in_array($filter['type'], array('=', '!=', '>', '<'))){
					continue;
				}
				
				$users->where("{$filter['column']} {$filter['type']} ?", $filter['value']);
					
			}
		}
		
		return $users->limitPage($page, $perPage)->query()->fetchAll();
	}

	public function isLoggedIn() {
		if (isset($_SESSION['is_logged_in'])){
			$purchase = self::getNeedsVote($_SESSION['user']['user_id']);
			foreach ($purchase as $check) {
				if ($check['positive'] == ''){
					return true;
				}
			}
		}
	}
	
	public function logout() {
		$_SESSION ['is_logged_in'] = false;
		return true;
	}
}