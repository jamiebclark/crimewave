<?php
class UserRolesController extends AppController {
	public $name = 'UserRoles';
	public $helpers = array('Layout.CollapseList');
	
	public function admin_index() {
		$userRoles = $this->UserRole->find('threaded');
		$this->set(compact('userRoles'));
	}
	
	public function admin_add($parentId = null) {
		$this->FormData->addData(array(
			'default' => array(
				'UserRole' => array('parent_id' => $parentId)
			)
		));
	}
	
	public function admin_edit($id = null) {
		$this->FormData->editData($id);
	}
	
	public function admin_view($id = null) {
		$this->redirect(array('action' => 'index', $id));
	}
	
	public function _setFormElements() {
		$parents = $this->UserRole->selectList();
		$this->set(compact('parents'));
	}
}