<?php
class AttributesController extends AppController {
	public $name = 'Attributes';
	public $components = array('WorldTrack');
	
	public function admin_index($worldId = null) {
		$this->paginate = array(
			'conditions' => array(
				'Attribute.world_id' => $worldId,
			)
		);
		$this->set('attributes', $this->paginate());
	}
	
	public function admin_add($worldId = null) {
		$this->FormData->addData(array(
			'default' => array(
				'Attribute' => array(
					'world_id' => $worldId,
					'min' => 0,
					'max' => 100,
					'default' => 0,
				)
			)
		));
	}
	
	public function admin_edit($id = null) {
		$this->FormData->editData($id);
	}
	
	public function admin_delete($id = null) {
		$this->FormData->deleteData($id);
	}
	
	public function _setFormElements() {
		$characterTypes = $this->Attribute->CharacterType->selectList();
		$this->set(compact('characterTypes'));
	}
}