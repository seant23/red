<?php

class User {
	
	public function getStats() {
		$database = Zend_Db_Table::getDefaultAdapter ();
		
		return $database->query("SELECT 
			curdate() as today,
  			(select count(*) from user) as total_user_count,
  			(select count(*) from user where is_admin=1) as total_admin_count,
  			(select count(*) from user where last_login>=CURDATE()) as logins_today,
  			(select count(*) from user where create_date>=CURDATE()) as new_users_today")->fetch();
		
	}

	public function getUserContent($userId) {
		$database = Zend_Db_Table::getDefaultAdapter ();
		$userContent = $database->select()->from('content_view')->where('user_id = ?', $userId)->query()->fetchAll();

		return $userContent;
	}
	
	public function getUser($userId) {
		$database = Zend_Db_Table::getDefaultAdapter ();
		$user = $database->select()->from('user')->where('user_id = ?', $userId)->query()->fetch();

		return $user;
	}
	
	public function saveUser($user) {
		if(!is_array($user)) {
			return false;
		}
		
		if(!isset($user['user_id'])) {
			return false;
		}
		
		$user_id = (int) $user['user_id'];
		$database = Zend_Db_Table::getDefaultAdapter ();
		$database->update('user', $user, "user_id = '$user_id'");
		
		return true;
		
	}
	
	public function getUsers($filters=null, $perPage=25, $page=1) {
		return Red_User::getUsers($filters, $perPage, $page);
	}
	
	public function deleteUser($user_id) {
		$user_id = (int) $user_id;
		$database = Zend_Db_Table::getDefaultAdapter ();
		$database->delete('user', "user_id = '$user_id'");
		
		return true;
	}
}