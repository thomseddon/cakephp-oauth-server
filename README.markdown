# CakePHP OAuth2 Server Plugin

This is a plugin for implementing an OAuth Server/Provider in CakePHP, built on quizlets [oauth2-php library][1]

## What's inside?
* A lovely OAuth component that allows cakey access to the oauth library
* The required models with super safe automatic beforeSave token hashing
* AuthComponent'ish interface for action allow/deny's
* Convenience functions for retrieving the current user and adding clients
* An example controller with authorize and token end points

## Requirements
[CakePHP 2.x](http://cakephp.org/)


A clone of [oauth2-php][1] in your Vendors folder
### Cloning oauth2-php
```
$ git clone git://github.com/quizlet/oauth2-php.git Vendor/oauth2-php
```
Or via submodule:

```
$ git submodule add git://github.com/quizlet/oauth2-php.git Vendor/oauth2-php
```

## Installation

### Populate database
First we need to populate the database with the right tables.

Two ways: use schema.sql or Migrations using [Migrations Plugin from CakeDC][2]

Go to Config/Schema/schema.sql to grab the tables

**OR**

```
$ cake Migrations.migration all --plugin OAuth
```

### Cloning
Then clone this repo into a "OAuth" folder in your Plugins folder:

```
$ git clone git://github.com/thomseddon/cakephp-oauth-server.git Plugin/OAuth
```
Or via submodule:

```
$ git submodule add git://github.com/thomseddon/cakephp-oauth-server.git Plugin/OAuth
```

### Loading the Plugin
Load the plugin

```PHP
CakePlugin::loadAll(); // Loads all plugins at once
CakePlugin::load('OAuth'); //Just load OAuth
```

### Include component in controller
And include the component in your controller:

```PHP
$components = array('OAuth.OAuth');
```


## Getting Started
### OAuth
**A good understanding of the OAuth protocol should be considered a prerequisite of using this plugin.**
Good documentation explaining various OAuth2 flows is provided by [Google](https://developers.google.com/accounts/docs/OAuth2), [Facebook](http://developers.facebook.com/docs/authentication/) and [in the official spec](http://tools.ietf.org/html/draft-ietf-oauth-v2-23).
For reference, this plugin currently supports the following grant types:

* [Authorization Code Grant](http://tools.ietf.org/html/draft-ietf-oauth-v2-23#section-4.1)
* [Refresh Token Grant](http://tools.ietf.org/html/draft-ietf-oauth-v2-23#section-6)
* [Resource Owner Password Credentials Grant](http://tools.ietf.org/html/draft-ietf-oauth-v2-23#section-4.3) (requires setup, see below)

If you need any others please build them into the base [oauth2-php library][1] and let me know :)

It should be noted here that most OAuth methods support both GET and POST, so you can test your setup straight from the browser.

### Controller Setup
To use the "Resource Owner Password Credentials Grant" you need to configure the plugin so it knows where to look for your users username/password combinations. By default it will try a "Users" model with "username" and "password" fields, you can change this in your controllers beforeFilter like so:

```PHP
$this->OAuth->authenticate = array(
    'userModel' => 'Members',
    'fields' => array(
        'username' => 'email'
    )
);
```

You can control what actions can be accessed using an OAuth access token in the same way you control access with the AuthComponent, so for example placing this in a controller's beforeFilter:

```PHP
$this->OAuth->allow(array('userinfo', 'example'));
```
Would allow access to the "userinfo" and "example" actions.

### Adding OAuth Clients
An OAuth client is an application that can access resources on behalf of resource owner, i.e. someone who can use your API.

This plugin ships with all required models, including the "Clients" model for adding and accessing OAuth clients.
You may wish to handle adding clients yourself, see the tables.sql for the schema, or you can use the convenience method included in the model, like so:

```PHP
$client = $this->OAuth->Client->add('http://www.return_url.com')
```
Which will generate then client_id and client_secret and return something like:

```
Array(
    [client_id] => NGYcZDRjODcxYzFkY2Rk
    [client_secret] => 8e7ff3208eed06d101bf3da2473fc92ac1c6d2e7
    [redirect_uri] => http://www.return_url.com
)
```

The method includes various schemes for generating client id's, [pick your favourite](https://github.com/thomseddon/cakephp-oauth-server/blob/master/Model/Client.php#L122).

**NOTE:** This convenience method will generate a random client secret __and hash it__ for security before storage. Although it will pass back the actual raw client secret when you first add a new client, it is not possible to ever determine this from the hash stored in the database. So if the client forgets their secret, [a new one will have to be issued](https://github.com/thomseddon/cakephp-oauth-server/blob/master/Model/Client.php#L139).


### Included Endpoints
This plugin ships with an example controller that provides the necessary endpoints to generate access tokens. Routes are also included to give you sexy URL's like: "/oauth/token", you can fire them up by placing this in your bootstrap.php:

```PHP
CakePlugin::loadAll(array(
    'OAuth' => array('routes' => true)
));
```


As an example, once you have registered a client, you could then use the Authorization Code Grant like so:

1. Get an Authorization code
 * `/oauth/authorize?response_type=code&client_id=xxxx&redirect_url=http%3a%2f%2flocalhost`
 * (note the URL encoding on the redirect_uri)
2. Swap code for access token
 * `/oauth/token?grant_type=authorization_code&code=from_above&client_id=xxxx&client_secret=xxxx`
3. Use access token
 * `/oauth/userinfo?access_token=from_above`


There is quite a bit of documentation through the code, so dive in, get your hands dirty and submit any issues here!


[1]: https://github.com/quizlet/oauth2-php
[2]: https://github.com/CakeDC/migrations
