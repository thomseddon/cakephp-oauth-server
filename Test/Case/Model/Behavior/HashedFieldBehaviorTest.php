<?php

App::uses('CakeTestCase', 'TestSuite');

class HashedFieldBehaviorTest extends CakeTestCase {

	public $fixtures = array(
		'plugin.o_auth.access_token',
	);

	protected $_clientId = '1234567890';

	protected $_token = '0123456789abcdefghijklmnopqrstuvwxyz';

	public function setUp() {
		$this->AccessToken = ClassRegistry::init('OAuth.AccessToken');
		$this->AccessToken->recursive = -1;
	}

	protected function _createToken() {
		$this->AccessToken->create(array(
			'client_id' => $this->_clientId,
			'oauth_token' => $this->_token,
			'user_id' => 69,
			'expires' => time() + 86400,
		));
		$this->AccessToken->save();
	}

	public function testBeforeSave() {
		$this->_createToken();

		$result = $this->AccessToken->findByClientId($this->_clientId);
		$expected = Security::hash($this->_token, null, true);
		$this->assertEquals($expected, $result['AccessToken']['oauth_token']);
	}

	public function testBeforeFind() {
		$this->_createToken();

		$result = $this->AccessToken->find('first', array(
			'conditions' => array(
				'oauth_token' => $this->_token,
			),
		));
		$this->assertEquals($this->_clientId, $result['AccessToken']['client_id']);
		$this->assertNotEquals($this->_token, $result['AccessToken']['oauth_token']);
	}

/**
 * test saving with missing oauth_token in POSTed data does not corrupt value
 */
	public function testSavingWithMissingToken() {
		$this->_createToken();

		$baseline = $this->AccessToken->find('first');
		$this->assertNull($baseline['AccessToken']['scope']);

		$updated = $baseline;
		$updated['AccessToken']['scope'] = 'all';
		unset($updated['AccessToken']['oauth_token']);

		$this->assertFalse(array_key_exists('oauth_token', $updated));
		$this->AccessToken->save($updated);

		$result = $this->AccessToken->findByClientId($baseline['AccessToken']['client_id']);

		$this->assertEquals('all', $result['AccessToken']['scope']);
		$expected = Security::hash($this->_token, null, true);
		$this->assertEquals($expected, $result['AccessToken']['oauth_token']);
	}

}
