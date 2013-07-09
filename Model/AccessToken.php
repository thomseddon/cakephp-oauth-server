<?php

App::uses('OAuthAppModel', 'OAuth.Model');

/**
 * AccessToken Model
 *
 * @property Client $Client
 * @property User $User
 */
class AccessToken extends OAuthAppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'oauth_token';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'oauth_token';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'oauth_token' => array(
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
		)
	);

/**
 * beforeSave method to hash tokens before saving
 *
 * @return boolean
 */
	public function beforeSave($options = array()) {
		$this->data['AccessToken']['oauth_token'] = OAuthComponent::hash($this->data['AccessToken']['oauth_token']);
		return true;
	}

}
