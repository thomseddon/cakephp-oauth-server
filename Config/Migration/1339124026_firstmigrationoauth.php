<?php

class FirstMigrationOAuth extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	public $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'access_tokens' => array(
					'oauth_token' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'client_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'oauth_token'),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'after' => 'client_id'),
					'expires' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'after' => 'user_id'),
					'scope' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'expires'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'oauth_token', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM'),
				),

				'auth_codes' => array(
					'code' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'client_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'code'),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'after' => 'client_id'),
					'redirect_uri' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'user_id'),
					'expires' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'after' => 'redirect_uri'),
					'scope' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'expires'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'code', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM'),
				),

				'clients' => array(
					'client_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'client_secret' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'client_id'),
					'redirect_uri' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'client_secret'),
					'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'after' => 'redirect_uri'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'client_id', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM'),
				),

				'refresh_tokens' => array(
					'refresh_token' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 40, 'key' => 'primary', 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
					'client_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'refresh_token'),
					'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'after' => 'client_id'),
					'expires' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'after' => 'user_id'),
					'scope' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'expires'),
					'indexes' => array(
						'PRIMARY' => array('column' => 'refresh_token', 'unique' => 1),
					),
					'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM'),
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'access_tokens', 'auth_codes', 'clients', 'refresh_tokens'
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function after($direction) {
		return true;
	}

}
