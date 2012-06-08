DROP TABLE IF EXISTS `access_tokens`;
CREATE TABLE `access_tokens` (
  `oauth_token` varchar(40) NOT NULL,
  `client_id` char(36) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `expires` int(11) NOT NULL,
  `scope` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`oauth_token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `auth_codes`;
CREATE TABLE `auth_codes` (
  `code` varchar(40) NOT NULL,
  `client_id` char(36) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `redirect_uri` varchar(200) NOT NULL,
  `expires` int(11) NOT NULL,
  `scope` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `clients`;
CREATE TABLE `clients` (
  `client_id` char(20) NOT NULL,
  `client_secret` char(40) NOT NULL,
  `redirect_uri` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `refresh_tokens`;
CREATE TABLE `refresh_tokens` (
  `refresh_token` varchar(40) NOT NULL,
  `client_id` char(36) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `expires` int(11) NOT NULL,
  `scope` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`refresh_token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;