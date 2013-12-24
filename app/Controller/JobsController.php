<?php
class JobsController extends AppController {
	public $name = 'Jobs';
	
	public function admin_index($gameId = null) {
		$jobs = $this->paginate();
		$this->set(compact('jobs'));
	}
	
	public function admin_add($gameId = null) {
		if (!$this->request->is('post') && empty($gameId)) {
			$this->Session->setFlash('Please select a game first');
			$this->redirect(array('controller' => 'games', 'action' => 'index'));
		}
		
		$this->FormData->addData(array(
			'default' => array(
				'Job' => array(
					'game_id' => $gameId,
				)
			)
		));
	}
	
	public function admin_edit($id = null) {
		$this->FormData->editData($id);
	}
	
	public function admin_view($id = null) {
		$this->FormData->findModel($id);
	}
	
	public function admin_delete($id = null) {
		$this->FormData->deleteData($id);
	}
	
	public function _setFormElements() {
		$gameId = $this->request->data['Job']['game_id'];
		$jobTemplates = $this->Job->JobTemplate->selectList();
		$this->set(compact('jobTemplates'));
	}
}