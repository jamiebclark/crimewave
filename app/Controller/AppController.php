<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array(
		'Session',
		'Cookie',
		'FormData.FormData',
		'Layout.FormLayout',
		'Auth' => array(
			'authorize' => array('Controller'),
			'allowedActions' => array('index', 'view', 'add', 'logout'),
			'loginAction' => array('controller' => 'users', 'action' => 'login', 'admin' => false, 'plugin' => false),
			'loginRedirect' => array('controller' => 'users', 'action' => 'view', 'plugin' => false),

			'authError' => 'Access denied',
			'authenticate' => array(
				'User',			
				'Form' => array(
					'userModel' => 'User',
					'fields' => array('username' => 'email'),
				)
			)
		),
	);
	
	public $helpers = array(
		'Html' => array('className' => 'TwitterBootstrap.BootstrapHtml'),
		'Form' => array('className' => 'TwitterBootstrap.BootstrapForm'),
		'Paginator' => array('className' => 'TwitterBootstrap.BootstrapPaginator'),
	
		'Layout.Asset',
		'Layout.Calendar',
		'Layout.Crumbs',
		'Layout.Layout',
		'Layout.Iconic',
		'Layout.ModelView',
		'Layout.FormLayout',
		'Layout.Table',
	);
	
	public function beforeFilter() {
		$this->Auth->allow('*');
		return parent::beforeFilter();
	}
	
	public function beforeRender() {
		$isAdmin = false;
		if ($this->Session->check('Auth.User.UserRole')) {
			$userRoles = $this->Session->read('Auth.User.UserRole');
			foreach ($userRoles as $userRole) {
				if ($userRole['id'] == 1) {
					$isAdmin = true;
					break;
				}
			}
		}
		$this->set(compact('isAdmin'));
		
		return parent::beforeRender();
	}
	
	public function isAuthorized($user = null) {
		return true;
	}
}