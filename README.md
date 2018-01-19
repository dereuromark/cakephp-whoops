[![Build Status](https://travis-ci.org/dereuromark/cakephp-whoops.svg?branch=master)](https://travis-ci.org/dereuromark/cakephp-whoops) 
[![Total Downloads](https://poser.pugx.org/dereuromark/cakephp-whoops/d/total.svg)](https://packagist.org/packages/dereuromark/cakephp-whoops) 
[![Latest Stable Version](https://poser.pugx.org/dereuromark/cakephp-whoops/v/stable.svg)](https://packagist.org/packages/dereuromark/cakephp-whoops)
[![Minimum PHP Version](http://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://packagist.org/packages/dereuromark/cakephp-whoops)

# Whoops

Built to seamlessly integrate [Whoops] with [CakePHP 3].

## Install

Using [Composer]:

```
composer require dereuromark/cakephp-whoops
```

As this plugin only offers a Whoops handler for CakePHP, there is no need to
enable it per se. You only need to configure that handler instead of CakePHP's own
`ErrorHandler` by replacing the following line in `bootstrap.php`:

```php
(new ErrorHandler(Configure::read('Error')))->register();
```

with the Whoops handler:

```php
(new \CakephpWhoops\Error\WhoopsHandler(Configure::read('Error')))->register();
```

When using new Application.php and Middleware approach, you also need to adjust that:
```php
// Replace ErrorHandlerMiddleware with
 ->add(new \CakephpWhoops\Error\Middleware\WhoopsHandlerMiddleware())
```

That's it!


## Editor
Opening the file via click in the editor is supported for most major IDEs.

Set your config as
```php
	'Whoops' => [
		'editor' => true,
	],
```
To enable it.

If you are using a VM, e.g. CakeBox, you will also need the path mapping:
```php
		'userBasePath' => 'C:\wamp\www\cakebox\Apps\my-app.local',
		'serverBasePath' => '/home/vagrant/Apps/my-app.local',
```

See the Wiki for more details on different OS and Browsers.

## License

Copyright (c)2015, Jad Bitar and licensed under [The MIT License][mit].

[CakePHP 3]:http://cakephp.org
[Composer]:http://getcomposer.org
[mit]:http://www.opensource.org/licenses/mit-license.php
[Whoops]:http://filp.github.io/whoops/
