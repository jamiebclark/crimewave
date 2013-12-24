<?php
class JobTemplatesController extends AppController {
	public $name = 'JobTemplates';
	public $components = array('WorldTrack');
	
	public function admin_index() {
		$this->paginate = array(
			'conditions' => array(
				'JobTemplate.world_id' => $this->WorldTrack->getId(),
			)
		);
		$jobTemplates = $this->paginate();
		$this->set(compact('jobTemplates'));
	}
	
	public function admin_view($id = null) {
		$this->FormData->findModel($id);
	}
	
	public function admin_add() {
		$this->FormData->addData(array(
			'default' => array(
				'JobTemplate' => array(
					'world_id' => $this->WorldTrack->getId(),
				)
			)
		));
	}
	
	public function admin_edit($id = null) {
		if (!empty($this->request->data)) {
			debug($this->request->data);
			//exit();
		}

		$this->FormData->editData($id, null, null, array('success' => array('redirect' => false)), array('deep' => true));
		debug($this->request->data);
	}
	
	public function admin_delete($id = null) {
		$this->FormData->deleteData($id);
	}
	
	public function _setFormElements() {
		$locationTypes = $this->JobTemplate->LocationType->selectList(array('blank' => false));
		$characterTypes = $this->JobTemplate->ObstacleTemplate->CharacterType->selectList(array('blank' => false));
		$this->set(compact('characterTypes', 'locationTypes'));
	}
	
	public function _setFindModelOptions($options = array()) {
		$options['contain']['LocationType'] = array();
		$options['contain']['ObstacleTemplate']['CharacterType'] = array();
		return $options;
	}
}