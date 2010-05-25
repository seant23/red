<?php

class UserController extends Zend_Controller_Action {
	
	public $var='123';
	
	public function init() {
		
		$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		Zend_Registry::set('controller', $this);
		
		
	}
	
	public function indexAction() {
		// action body
	}
	
    public function profileAction() {
    	$vote = Red_User::isLoggedIn();
    	if ($vote) {
    		$this->_helper->redirector('vote', 'content');
    	}
    	    $user_id = $this->getRequest()->getParam('user');
            if(!$user_id) {
                $user_id = $_SESSION['user']['user_id'];
            }

            $this->view->contents = Red_Content::getContents(null, 'date_added', $user_id);

            $this->view->user = Red_User::selectProfile($user_id);
        }
	
	public function registerAction() {
		$form = $this->getRegisterForm();
		
		if($this->getRequest()->isPost()) {
			/** 
			 * Form Posted ????
			 */
			
			if($form->isValid($_POST)) {
				$user = $form->getValues();
				$userID = Red_User::createNewUser($user['email'], $user['firstname'], $user['lastname'], $user['password']);
				$this->_flashMessenger->addMessage('
				You have registered successfully!<br/>
				An email has been sent to '.$user['email'].'.<br/>
				Click the link in that message to activate your account!
				');
				$this->_helper->redirector('success', 'user');
			}
		}
		
		$this->view->form = $form;
		
	}

	
	public function successAction() {
		$this->view->message = $this->_flashMessenger->getMessages();
		
	}
	
	public function getRegisterForm() {
		$form = new Zend_Form();
		$form->setMethod('post');
		
		$email = $form->createElement('text', 'email');
		$email->setRequired(true)->addFilter('StringToLower');
		$email->addValidator(new Zend_Validate_EmailAddress());
		
		$email->addValidator(new Zend_Validate_Db_NoRecordExists(
			array(
				'table'=>'user',
				'field'=>'email'
			)
		));
		
		$email->setLabel('Email Address');
		$form->addElement($email);
		
		$firstName = $form->createElement('text', 'firstname');
		$firstName->setRequired(true)->addFilter('StringToLower');
		$firstName->setLabel('First Name');
		$form->addElement($firstName);
		     
		$lastName = $form->createElement('text', 'lastname');
		$lastName->setRequired(true)->addFilter('StringToLower');
		$lastName->setLabel('Last Name');
		$form->addElement($lastName);
		     
		$password = $form->createElement('password', 'password');
		$password->setRequired(true)->addFilter('StringToLower');
		$password->setLabel('Password');
		$form->addElement($password);
		     
		$password2 = $form->createElement('password', 'password_check');
		$password2->setRequired(true)->addFilter('StringToLower');
		$password2->setLabel('Re-Enter Password')
			->addValidator(new Zend_Validate_Identical($_POST['password']));
		$password2->addErrorMessage('Passwords must match');	
		$form->addElement($password2);
		$form->addElement('submit', 'register', array('label'=>'Register!'));
		
		return $form;
	}

	public function getLoginForm() {
		$form = new Zend_Form();
		$form->setMethod('post');

		$email = $form->createElement('text', 'email');
		$email->setRequired(true)->addFilter('StringToLower');
		$email->addValidator(new Zend_Validate_EmailAddress());
		$email->setLabel('Email Address');
		$form->addElement($email);

		$password = $form->createElement('password', 'password');
		$password->setRequired(true)->addFilter('StringToLower');
		$password->setLabel('Password');
		$form->addElement($password);
		$form->addElement('submit', 'register', array('label'=>'Login!'));

		return $form;
	}
	
	public function loginAction() {
		$form = $this->getLoginForm();

		if($this->getRequest()->isPost()) {
			/**
			 * Form Posted ????
			 */

			if($form->isValid($_POST)) {
				$user = $form->getValues();
				$userID = Red_User::login($user['email'], $user['password']);
                                if($userID) {
				$this->_helper->redirector('index', 'content');
                                }
			} 
		}
		$this->view->message = $this->_flashMessenger->getMessages();
		$this->view->form = $form;
	}
	
	public function activateAction() {
		$database = Zend_Db_Table::getDefaultAdapter ();
		
		$activation_code = $this->getRequest()->getParam('activation');
		
		$update = array('activation_code'=>0);
        $database->update('user', $update, "activation_code = '$activation_code'");
        
        $this->_flashMessenger->addMessage('
				Your account has been activated successfully!
				');
        $this->_helper->redirector('login', 'user');
	}
	
	public function logoutAction() {
		$_SESSION['is_logged_in'] = FALSE;
		$this->_helper->redirector('login', 'user');
	}
}

