<?php

App::uses('ModelBehavior', 'Model');
App::uses('Security', 'Utility');

/**
 * Enable automatic field hashing when in Model::save() Model::find()
 */
class HashedFieldBehavior extends ModelBehavior {

/**
 * Behavior defaults
 */
	protected $_defaults = array(
		'fields' => array(),
	);

/**
 * Setup behavior
 */
	public function setup(Model $Model, $config = array()) {
		parent::setup($Model, $config);
		$this->settings[$Model->name] = Hash::merge($this->_defaults, $config);
	}

/**
 * Hash field when present in model data (POSTed data)
 */
	public function beforeSave(Model $Model, $options = array()) {
		$setting = $this->settings[$Model->name];
		foreach ((array) $setting['fields'] as $field) {
			if (array_key_exists($field, $Model->data[$Model->alias])) {
				$data = $Model->data[$Model->alias][$field];
				$Model->data[$Model->alias][$field] = Security::hash($data, null, true);
			}
		}
		return true;
	}

/**
 * Hash condition when it contains a field specified in setting
 */
	public function beforeFind(Model $Model, $queryData) {
		$setting = $this->settings[$Model->name];
		$conditions =& $queryData['conditions'];
		foreach ((array) $setting['fields'] as $field) {
			$escapeField = $Model->escapeField($field);
			if (array_key_exists($field, (array)$conditions)) {
				$queryField = $field;
			} elseif (array_key_exists($escapeField, (array)$conditions)) {
				$queryField = $escapeField;
			}
			if (isset($queryField)) {
				$data = $conditions[$queryField];
				$conditions[$queryField] = Security::hash($data, null, true);
			}
		}
		return $queryData;
	}

}
