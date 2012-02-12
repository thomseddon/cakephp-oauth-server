<?php
App::uses('OAuthAppModel', 'OAuth.Model');
/**
 * AuthCode Model
 *
 * @property Client $Client
 * @property User $User
 */
class AuthCode extends OAuthAppModel {
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'code';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'code';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'code' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
			),
		),
		'client_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'redirect_uri' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'expires' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Client' => array(
			'className' => 'OAuth.Client',
			'foreignKey' => 'client_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * beforeSave method to hash codes before saving
 * 
 * @return boolean 
 */
	public function beforeSave() {
		$this->data['AuthCode']['code'] = OAuthComponent::hash($this->data['AuthCode']['code']);
		return true;
	}
}
