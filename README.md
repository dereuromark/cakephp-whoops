[![Build Status](https://travis-ci.org/dereuromark/cakephp-whoops.svg?branch=master)](https://travis-ci.org/dereuromark/cakephp-whoops) 
[![Total Downloads](https://poser.pugx.org/dereuromark/cakephp-whoops/d/total.svg)](https://packagist.org/packages/dereuromark/cakephp-whoops) 
[![Latest Stable Version](https://poser.pugx.org/dereuromark/cakephp-whoops/v/stable.svg)](https://packagist.org/packages/dereuromark/cakephp-whoops)
[![Minimum PHP Version](http://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://packagist.org/packages/dereuromark/cakephp-whoops)

# Whoops for CakePHP

Seamlessly integrate [Whoops] into [CakePHP 3] applications.

## Install

Using [Composer]:

```
composer require dereuromark/cakephp-whoops
```

As this package only offers a Whoops handler for CakePHP, there is no need to
enable it (no `Plugin::load()` call). You only need to configure that handler instead of CakePHP's own
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

### Debug Mode
An important note: This plugin is installed as require dependency, but even so it is more used as require-dev one.
If the debug mode is off, it will completely ignore the Whoops handler, as without debug mode there is no exception to render.
It will then display the public error message and only log internally.

So make sure you enable debug (locally) for checking out this package.
For each error and exception you should then see the improved whoops handler output on your screen.

## Editor
Opening the file in the editor via click in the browser is supported for most major IDEs.
It uses `phpstorm://` URLs which can open the file through a command line call and directly jump to the right line.

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

[CakePHP 3]:https://cakephp.org
[Composer]:https://getcomposer.org
[Whoops]:https://filp.github.io/whoops/
