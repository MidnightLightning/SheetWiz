<?php

class Controller extends ControllerClass {
	function page_login() {
		if ($_GET['redirect'] == Zend_Registry::get('web_root').'/index.php/user/logout') $_GET['redirect'] = ''; // Don't enter a logout loop
		
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
			
			if (!empty($_POST['redirect'])) {
				// Redirect to that page
				header("Location: {$_POST['redirect']}");
				exit;
			}
			
			$this->view->assign('message', 'Logged in successfully');
			$this->display('thanks', false);
		}
		$this->display('login', false);
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
			
			// Verify password complexity
			if (strlen($_POST['passwd']) < 3) {
				$this->view->assign('error', 'Password is too short');
				$this->display('register', false);
			}
			
			// Verify email is valid
			if (strlen($_POST['email'] < 3) {
				$this->view->assign('error', 'Email address is invalid');
				$this->display('register', false);
			}
			
			// Add the user
			$rs = $db->insert('users', array(
				'username' => $_POST['username'],
				'passwd' => md5($_POST['passwd'].Zend_Registry::get('passwdSalt')),
				'email' => $_POST['email'],
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
	
	function page_logout() {
		$auth = Zend_Auth::getInstance();
		$auth->clearIdentity();
		Zend_Registry::set('cur_user', 'Anonymous'); // Save logged-out status
		$this->view->assign('cur_user', 'Anonymous');
		$this->display('logout', false);
	}
}