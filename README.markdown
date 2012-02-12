# CakePHP OAuth2 Server Plugin

This is a plugin for implementing an OAuth Server/Provider in CakePHP, built on quizlets [oauth2-php library][1]

## What's inside
* A lovely OAuth component that allows cakey access to the oauth library
* The required models with super safe automatic beforeSave token hashing
* AuthComponent'ish interface for action allow/deny's
* Convenience functions for retrieving the current user and adding clients
* An example controller with authorize and token end points

## Requirements
[CakePHP 2.0.x](http://cakephp.org/)

A clone of [oauth2-php][1] in your Vendors folder

## Installation
First grab the tables.sql and get your tables going.

Then clone this repo into a "OAuth" folder in your Plugins folder:
`$ git clone git://github.com/seddonmedia/cakephp-oauth-server.git Plugin/OAuth`

And include the component in your controller:
`$components = array('OAuth.OAuth');`

## Configuration
If you don't use the Users model with username+password fields for authentication you should specify the correct model and fields to be used to validate users like so:
`$this->OAuth->authenticate = array('userModel' => 'Members', 'fields' => array('username' => 'email'));`

You will need to allow/deny access to actions:
`$this->OAuth->allow(array('userinfo'));`

If you want to use the example controller straight off the bat, routes are included to give you sexy URL's like: "/oauth/token".
You can load this route from your bootstrap like so:
`CakePlugin::loadAll(array(
    'OAuth' => array('routes' => true)
));`

There is quite a bit of documentation through the code, so dive in, get your hands dirty and submit any issues here!


[1]: https://github.com/quizlet/oauth2-php