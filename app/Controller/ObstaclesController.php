<?php
class ObstaclesController extends AppController {
	public $name = 'Obstacles';
	
	public function admin_index($jobId = null) {
		$obstacles = $this->paginate();
		$this->set(compact('obstacles'));
	}
	
	public function admin_add($jobId = null) {
		if (!$this->request->is('post') && empty($jobId)) {
			$this->Session->setFlash('Please select a job first');
			$this->redirect(array('controller' => 'jobs', 'action' => 'index'));
		}
		
		$this->FormData->addData(array(
			'default' => array(
				'Obstacle' => array(
					'job_id' => $jobId,
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
	}
}