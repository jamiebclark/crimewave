<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	public $actsAs = array(
		'Layout.BlankDelete', 
		'Containable',
		'Layout.SelectList',
		'Linkable',
	);
	public $recursive = -1;
	
	public function &getData() {
		if (isset($this->data[$this->alias])) {
			$data =& $this->data[$this->alias];
		} else {
			$data =& $this->data;
		}
		return $data;
	}
	
	public function getResult($result) {
		if (is_numeric($result)) {
			$id = $result;
			$result = $this->read(null, $id);
		} else {
			if (!empty($result[$this->alias][$this->primaryKey])) {
				$id =  $result[$this->alias][$this->primaryKey];
			} else {
				$id = $result[$this->primaryKey];
			}
		}
		return array($result, $id);
	}	
}