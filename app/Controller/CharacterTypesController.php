<?php
class CharacterTypesController extends AppController {
	public $name = 'CharacterTypes';
	public $components = array('WorldTrack');
	public $helpers = array('Layout.CollapseList');
	
	public function admin_index($worldId = null) {
		$characterTypes = $this->CharacterType->find('threaded');
		$this->set(compact('characterTypes'));
	}
	
	public function admin_add($parentId = null) {
		$this->FormData->addData(array(
			'default' => array(
				'CharacterType' => array(
					'parent_id' => $parentId,
					'world_id' => $this->WorldTrack->getId(),
				)
			)
		));
	}
	
	public function admin_edit($id = null) {
		$this->FormData->editData($id);
	}
	
	public function admin_view($id = null) {
		$this->redirect(array('action' => 'index', $id));
	}
	
	public function admin_delete($id = null) {
		$this->FormData->deleteData($id);
	}
	
	public function _setFormElements() {
		$parents = $this->CharacterType->selectList();
		$this->set(compact('parents'));
	}
}