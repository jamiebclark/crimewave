<?php
class UsersController extends AppController {
	public $name = 'Users';
	
	public function index() {
		
	}
	
	public function view($id = null) {
		$user = $this->FormData->findModel($id);
		$isUser = $this->Session->read('Auth.User') == $user['User']['id'];
		$this->set(compact('isUser'));
	}	
	
	public function add() {
		$this->FormData->addData();
	}
	
	public function edit($id = null) {
		$this->FormData->editData($id);
	}
	
	public function login() {
		if (AuthComponent::user('id')) {
			$this->redirect(array('action' => 'view', AuthComponent::user('id')));
		}
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->redirect($this->Auth->redirect());
			} else {
				$this->Session->setFlash(
					__('Username or password is incorrect')
				);
			}
		}
	}
	
	public function logout() {
		$this->redirect($this->Auth->logout());
	}
	
	public function admin_index() {
		$users = $this->paginate();
		$this->set(compact('users'));
	}
	
	public function admin_view($id = null) {
		$this->FormData->findModel($id);
	}
	
	public function admin_add() {
		$this->FormData->addData();
	}
	
	public function admin_edit($id = null) {
		$this->FormData->editData($id);
	}
	
	public function admin_delete($id = null) {
		$this->FormData->deleteData($id);
	}
	
	public function _setFormElements() {
		$userRoles = $this->User->UserRole->selectList();
		$this->set(compact('userRoles'));
	}
	
	public function _setFindModelOptions($options = array()) {
		$options['contain']['UserRole'] = array();
		return $options;
	}
}