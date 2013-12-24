<?php
class WorldsController extends AppController {
	public $name = 'Worlds';
	public $components = array('WorldTrack');
	public $helpers = array('Layout.CollapseList');
	
	public function admin_index() {
		$worlds = $this->paginate();
		$this->set(compact('worlds'));
	}
	
	public function admin_view($id = null) {
		$this->FormData->findModel($id, null, array(
			'contain' => array(
				'Attribute',
			)
		));
		$locationTypes = $this->World->LocationType->find('threaded', array('conditions' => array('LocationType.world_id' => $id)));
		$characterTypes = $this->World->CharacterType->find('threaded', array('conditions' => array('CharacterType.world_id' => $id)));
		
		$this->set('worldId', $id);
		
		$this->set(compact('locationTypes', 'characterTypes'));
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
		$locationTypes = $this->World->LocationType->selectList();
		$characterTypes = $this->World->CharacterType->selectList();
		$this->set(compact('locationTypes', 'characterTypes'));
	}
	
	public function _setFindModelOptions($options = array()) {
		$options['contain']['LocationType'] = array();
		$options['contain']['CharacterType'] = array();
		$options['contain']['Attribute'] = array();
		return $options;
	}
}