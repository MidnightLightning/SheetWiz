<?php

class Controller extends ControllerClass {
	function page_index() {
		if (isset($_POST['username'])) {
			// Attempt to login from form data
			$db = Zend_Registry::get('dbAdapter');
			$authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users', 'username', 'passwd');
			$authAdapter->setIdentity($_POST['username']);
			$authAdapter->setCredential(md5($_POST['passwd'].Zend_Registry::get('passwdSalt')));
			$auth = Zend_Auth::getInstance();
			
			// Do the login
			$rs = $auth->authenticate($authAdapter);
			if (!$rs->isValid()) {
				// Login failed
				$this->view->assign('error', 'Login failed');
				$this->display('index', false);				
			}
			
			// Login succeeded
			// Zend_Auth::getInstance()->getIdentity() = username
			// Zend_Auth::hasIdentity() = true
		}
		$this->display('index', false);
	}
	
	function page_register() {
		if (isset($_POST['username'])) {
			// Attempt to register the user

			// Check and see if that user already exists
			$db = Zend_Registry::get('dbAdapter');
			$sql = "SELECT COUNT(*) FROM {$db->quoteIdentifier('users')} ".
				"WHERE {$db->quoteIdentifier('username')}={$db->quote($_POST['username'])}";
			if ($db->fetchOne($sql) > 0) {
				$this->view->assign('error', 'Username already exists');
				$this->display('register', false);
			}
			
			// Verify passwords match
			if ($_POST['passwd'] != $_POST['passwd_verify']) {
				$this->view->assign('error', 'Passwords don\'t match');
				$this->display('register', false);
			}
			
			// Add the user
			$rs = $db->insert('users', array(
				'username' => $_POST['username'],
				'passwd' => md5($_POST['passwd'].Zend_Registry::get('passwdSalt'))
			));
			if ($rs != 0) {
				// Successfully inserted
				$this->view->assign('message', "Successfully added username '{$_POST['username']}'; you're now able to go back and login.");
				$this->display('thanks', false);
			} else {
				$this->_error('Failed to add user', "Failed to insert a new user for username {$_POST['username']}");
			}
		}
		$this->display('register', false);
	}
}