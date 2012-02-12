<?php
App::uses('OAuthAppModel', 'OAuth.Model');
/**
 * RefreshToken Model
 *
 * @property Client $Client
 * @property User $User
 */
class RefreshToken extends OAuthAppModel {
/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'refresh_token';
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'refresh_token';
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'refresh_token' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
			'isUnique' => array(
				'rule' => array('isUnique'),
			)
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
		)
	);

/**
 * beforeSave method to hash tokens before saving
 * 
 * @return boolean 
 */
	public function beforeSave() {
		$this->data['AccessToken']['refresh_token'] = OAuthComponent::hash($this->data['AccessToken']['refresh_token']);
		return true;
	}
}
