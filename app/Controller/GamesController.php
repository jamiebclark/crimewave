<?php
class GamesController extends AppController {
	public $name = 'Games';
	
	public function view($id) {
		//$this->Game->resetTurn();
		$this->Game->advanceTurn($id);
		$game = $this->FormData->findModel($id);

		$log = APP . 'tmp' . DS . 'logs' . DS . 'story.log';
		$log = explode("\n", file_get_contents($log));
		//$log = array_reverse($log);
		$this->set(compact('log'));		
	}
	
	public function admin_index() {
		$games = $this->paginate();
		$this->set(compact('games'));
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
}