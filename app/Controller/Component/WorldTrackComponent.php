<?php
/**
 * World Track Component
 * Used to keep track of a World ID from controller to controller
 *
 **/
App::uses('Url', 'Layout.Lib');
class WorldTrackComponent extends Component {
	public $name = 'WorldTrack';
	
	public $controller;
	public $settings = array();
	
	public $components = array('Session');
	
	private $sessionKey = 'WorldTrack';
	
	public function __construct(ComponentCollection $collection, $settings = array()) {
		$settings = array_merge(array(
			'trackActions' => array('add', 'index'),
		), $settings);
		return parent::__construct($collection, $settings);
	}
	
	public function initialize(Controller $controller) {
		$this->controller = $controller;
		
		$action = Url::getAction();
		$request =& $controller->request;
		$isWorld = $request->params['controller'] == 'worlds';
		
		if ($isWorld) {
			if (isset($request->pass[0])) {
				$this->set($request->pass[0]);
			}
		} else {
			if (!empty($controller->request->data[$controller->modelClass]['world_id'])) {
				$this->set($controller->request->data[$controller->modelClass]['world_id']);
			} else if ($action == 'index' && !$this->getId() && isset($request->pass[0])) {
				$this->set($request->pass[0]);
			}
			if (in_array($action, $this->settings['trackActions'])) {
				if (!$this->getId()) {
					$controller->Session->setFlash('Please select a world first');
					$controller->redirect(array('controller' => 'worlds', 'action' => 'index'));
				}
			}
		}
		$this->set($this->getId());
		return parent::initialize($controller);
	}
	
	public function get() {
		if ($this->Session->check($this->sessionKey)) {
			return $this->Session->read($this->sessionKey);
		}
		return false;
	}
	
	public function getId() {
		$worldId = null;
		if ($world = $this->get()) {
			$worldId = $world['World']['id'];
		}
		return $worldId;
	}
	
	public function set($worldId) {
		if (!$this->Session->check($worldId) || $this->Session->read($worldId) == $worldId) {
			$world = ClassRegistry::init('World')->read(null, $worldId);
			$this->Session->write($this->sessionKey, $world);
		} else {
			$world = $this->get();
		}
		$this->controller->set(compact('worldId', 'world'));
	}
}