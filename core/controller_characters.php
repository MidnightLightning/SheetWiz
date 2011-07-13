<?php

class Controller extends ControllerClass {

	function page_index() {
		if (isset($_GET['id']) && $_GET['id'] != '') {
			$char_id = intval($_GET['id']);
			
			// View that character, if possible
			$db = Zend_Registry::get('dbAdapter');
			$rs = $db->fetchOne("SELECT {$db->quoteIdentifier('label')} ".
				"FROM {$db->quoteIdentifier('characters')} ".
				"WHERE {$db->quoteIdentifier('ROWID')}={$db->quote($char_id, 'INTEGER')}"
			);
			if ($rs == '') $this->display('notexist'); // No such character
			
			// Does this user have viewing permission?
			if (Zend_Registry::get('cur_user') == 'Anonymous') {
				$group = Zend_Registry::get('GRP_PUBLIC');
				$rs = $db->fetchOne("SELECT {$db->quoteIdentifier('character_id')} ".
					"FROM {$db->quoteIdentifier('character_permissions')} ".
					"WHERE {$db->quoteIdentifier('character_id')}={$db->quote($char_id, 'INTEGER')} ".
					"AND {$db->quoteIdentifier('group')}={$db->quote($group, 'INTEGER')} ".
					"AND {$db->quoteIdentifier('permissions')}={$db->quote(Zend_Registry::get('PRM_READ'))}"
				);
				if ($rs == '') $this->display('notview'); // Not allowed to view this character
			} else {
				while (true) {
					// Check individual rights
					$rowid = $db->fetchOne("SELECT {$db->quoteIdentifier('ROWID')} ".
						"FROM {$db->quoteIdentifier('users')} ".
						"WHERE {$db->quoteIdentifier('username')}={$db->quote(Zend_Registry::get('cur_user'))}"
					); // Current user's ROWID
					$rs = $db->fetchOne("SELECT {$db->quoteIdentifier('character_id')} ".
						"FROM {$db->quoteIdentifier('character_permissions')} ".
						"WHERE {$db->quoteIdentifier('character_id')}={$db->quote($char_id, 'INTEGER')} ".
						"AND {$db->quoteIdentifier('group')}={$db->quote($rowid, 'INTEGER')} ".
						"AND {$db->quoteIdentifier('permissions')}={$db->quote(Zend_Registry::get('PRM_READ'))}"
					);
					if ($rs != '') break; // User is allowed
					
					// Check ally rights
					
					// Check GM rights
					
					// If we reach here, user is not allowed
					$this->display('notview');
				}
			}
			
			// User can view; show the character
			$c = $db->fetchRow("SELECT * ".
				"FROM {$db->quoteIdentifier('characters')} ".
				"WHERE {$db->quoteIdentifier('ROWID')}={$db->quote($char_id, 'INTEGER')}"
			);
			
			// Get game system information
			$filename = Zend_Registry::get('app_root') . '/systems/'.$c['system'].'.inc.php';
			if (!file_exists($filename)) $this->_error('No such system', "The gaming system {$c['system']} is not recognized.");
			$this->view->system_root =  Zend_Registry::get('web_root') . '/systems/'.$c['system'];
			require_once('char.php'); // Base character class
			require_once('obj.php'); // Base object class
			require_once($filename); // Get system character class
			
			$c['data'] = unserialize($c['data']);
			if ($c['data'] == null) $c['data'] = new Character(); // Initialize if empty
			$this->view->char = $c['data'];
			
			$tplname = Zend_Registry::get('app_root') . '/systems/'.$c['system'].'.tpl';
			$this->display($tplname);
		}
		
		$this->display('index');
	}

	function page_new() {
		if (Zend_Registry::get('cur_user') == 'Anonymous') {
			// Login first
			$this->display('new-login');
		}
		if (!empty($_POST['system'])) {
			// Form submitted
			$db = Zend_Registry::get('dbAdapter');
			
			// Check for valid label
			if (strlen($_POST['label']) < 3) {
				$this->view->error = 'Label too short';
				$this->view->systems = Zend_Registry::get('systems');
				$this->display('new', false);
			}
			
			$rowid = $db->fetchOne("SELECT {$db->quoteIdentifier('ROWID')} ".
				"FROM {$db->quoteIdentifier('users')} ".
				"WHERE {$db->quoteIdentifier('username')}={$db->quote(Zend_Registry::get('cur_user'))}"
			); // Current user's ROWID
			
			$db->beginTransaction();
			try {
				// Add the character
				$db->insert('characters', array(
					'label' => $_POST['label'],
					'system' => $_POST['system'],
					'data' => serialize(NULL)
				));
				$char_id = $db->lastInsertId();
				
				// Add default permissions
				// Public cannot see character by default
				// GMs can always see character
				$db->insert('character_permissions', array(
					'character_id' => $char_id,
					'group' => Zend_Registry::get('GRP_ALLIES'),
					'permissions' => Zend_Registry::get('PRM_READ')
				)); // Allies can see character by default
				$db->insert('character_permissions', array(
					'character_id' => $char_id,
					'group' => $rowid,
					'permissions' => Zend_Registry::get('PRM_READ')
				)); // Owner can see character by default
				$db->insert('character_permissions', array(
					'character_id' => $char_id,
					'group' => $rowid,
					'permissions' => Zend_Registry::get('PRM_EDIT')
				)); // Owner can edit character by default

				$db->commit();
			} catch (Exception $e) {
				$db->rollBack();
				throw $e;
			}
			
			// Character created
			$this->view->char_id = $char_id;
			$this->view->label = $_POST['label'];
			$this->display('new-done', false);
		}
		$this->view->systems = Zend_Registry::get('systems');
		
		$this->display('new', false);
	}
	
	function page_visible() {
		// List all visible characters
		$db = Zend_Registry::get('dbAdapter');
		$sql = "SELECT cp.{$db->quoteIdentifier('character_id')}, c.{$db->quoteIdentifier('label')} ".
			"FROM {$db->quoteIdentifier('character_permissions')} cp ".
			"LEFT JOIN {$db->quoteIdentifier('characters')} c ".
			"ON c.{$db->quoteIdentifier('ROWID')}=cp.{$db->quoteIdentifier('character_id')} ".
			"WHERE {$db->quoteIdentifier('group')}={$db->quote(Zend_Registry::get('GRP_PUBLIC'), 'INTEGER')} ";
		if (Zend_Registry::get('cur_user') != 'Anonymous') {
			// User is logged in; get user's ROWID
			$rowid = $db->fetchOne("SELECT {$db->quoteIdentifier('ROWID')} ".
				"FROM {$db->quoteIdentifier('users')} ".
				"WHERE {$db->quoteIdentifier('username')}={$db->quote(Zend_Registry::get('cur_user'))}"
			);
			if ($rowid != '') $sql .= "OR {$db->quoteIdentifier('group')}={$db->quote($rowid, 'INTEGER')} ";
		}
		$sql .= "AND {$db->quoteIdentifier('permissions')}={$db->quote(Zend_Registry::get('PRM_READ'))} ";
		echo $sql;
	}
	
}