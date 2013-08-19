<?php

App::uses('OAuthAppModel', 'OAuth.Model');
App::uses('String', 'Utility');

/**
 * Client Model
 *
 * @property AccessToken $AccessToken
 * @property AuthCode $AuthCode
 * @property RefreshToken $RefreshToken
 */
class Client extends OAuthAppModel {

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'client_id';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'client_id';

/**
 * Secret to distribute when using addClient
 *
 * @var type
 */
	protected $addClientSecret = false;

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'client_id' => array(
			'isUnique' => array(
				'rule' => array('isUnique'),
			),
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'redirect_uri' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
	);

	public $actsAs = array(
		'OAuth.HashedField' => array(
			'fields' => array(
				'client_secret'
			),
		),
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'AccessToken' => array(
			'className' => 'OAuth.AccessToken',
			'foreignKey' => 'client_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'AuthCode' => array(
			'className' => 'OAuth.AuthCode',
			'foreignKey' => 'client_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'RefreshToken' => array(
			'className' => 'OAuth.RefreshToken',
			'foreignKey' => 'client_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

/**
 * AddClient
 *
 * Convinience function for adding client, will create a uuid client_id and random secret
 *
 * @param mixed $data Either an array (e.g. $controller->request->data) or string redirect_uri
 * @return booleen Success of failure
 */
	public function add($data = null) {
		$this->data['Client'] = array();

		if (is_array($data) && is_array($data['Client']) && array_key_exists('redirect_uri', $data['Client'])) {
			$this->data['Client']['redirect_uri'] = $data['Client']['redirect_uri'];
		} elseif (is_string($data)) {
			$this->data['Client']['redirect_uri'] = $data;
		} else {
			return false;
		}

		/**
		 * in case you have additional fields in the clients table such as name, description etc
		 * and you are using $data['Client']['name'], etc to save
		 **/
		if (is_array($data['Client'])) {
			$this->data['Client'] = array_merge($data['Client'], $this->data['Client']);
		}

		//You may wish to change this
		$this->data['Client']['client_id'] = base64_encode(uniqid() . substr(uniqid(), 11, 2));	// e.g. NGYcZDRjODcxYzFkY2Rk (seems popular format)
		//$this->data['Client']['client_id'] = uniqid();					// e.g. 4f3d4c8602346
		//$this->data['Client']['client_id'] = str_replace('.', '', uniqid('', true));		// e.g. 4f3d4c860235a529118898
		//$this->data['Client']['client_id'] = str_replace('-', '', String::uuid());		// e.g. 4f3d4c80cb204b6a8e580a006f97281a

		$this->addClientSecret = $this->newClientSecret();
		$this->data['Client']['client_secret'] = $this->addClientSecret;

		return $this->save($this->data);
	}

/**
 * Create a new, pretty (as in moderately, not beautiful - that can't be guaranteed ;-) random client secret
 *
 * @return string
 */
	public function newClientSecret() {
		$length = 40;
		$chars = '@#!%*+/-=ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		$str = '';
		$count = strlen($chars);
		while ($length--) {
			$str .= $chars[mt_rand(0, $count - 1)];
		}
		return OAuthComponent::hash($str);
	}

	public function afterSave($created) {
		if ($this->addClientSecret) {
			$this->data['Client']['client_secret'] = $this->addClientSecret;
		}
		return true;
	}

}