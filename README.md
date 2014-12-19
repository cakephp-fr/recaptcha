Google Recaptcha for CakePHP 3
==============================

[![Build Status](https://api.travis-ci.org/cake17/cakephp-recaptcha.png?branch=master)](https://travis-ci.org/cake17/cakephp-recaptcha)
[![Latest Stable Version](https://poser.pugx.org/cake17/cakephp-recaptcha/v/stable.png)](https://packagist.org/packages/cake17/cakephp-recaptcha)
[![License](https://poser.pugx.org/cake17/cakephp-recaptcha/license.png)](https://packagist.org/packages/cake17/cakephp-recaptcha)
[![Total Downloads](https://poser.pugx.org/cake17/cakephp-recaptcha/d/total.png)](https://packagist.org/packages/cake17/cakephp-recaptcha)

This plugin is still under development...

## Plugin's Objective ##

This plugin adds functionnalities to use Google Recaptcha in CakePHP projects.

## Requirements ##

- PHP 5.4.16
- [CakePHP 3.x](http://book.cakephp.org/3.0/en/index.html)

## Installation ##

_[Using [Composer](http://getcomposer.org/)]_

Add the plugin to your project's `composer.json` - something like this:

```javascript
{
    "require": {
        "cake17/cakephp-recaptcha": "dev-master"
    }
}
```

Because this plugin has the type `cakephp-plugin` set in it's own `composer.json`, composer knows to install it inside your `/plugins` directory, rather than in the usual vendors file. It is recommended that you add `/plugins/Recaptcha` to your .gitignore file. (Why? [read this](http://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md).)

_[Manual]_

- Download this: http://github.com/cake17/cakephp-recaptcha/zipball/master
- Unzip that download.
- Copy the resulting folder to `/plugins`
- Rename the folder you just copied to `Recaptcha`

_[GIT Submodule]_

In your app directory type:

```bash
git submodule add git://github.com/cake17/cakephp-recaptcha.git plugins/Recaptcha
git submodule init
git submodule update
```

_[GIT Clone]_

In your plugin directory type

```bash
git clone git://github.com/cake17/cakephp-recaptcha.git Recaptcha
```

## Usage of plugin ##

### 1. Enable the plugin in your config/bootstrap.php file:

	Plugin::load('Recaptcha', ['routes' => false, 'bootstrap' => true]);

### 2. Go to Google Recaptcha site to create a pair of keys for your website.

### 3. Create a /config/recaptcha.php file

I made a composer install command to add in composer.json that will create the default file in /config from `/plugins/Recaptcha/config`. To use it, add this in your project composer.json::

    ...
    "scripts": {
      "post-install-cmd": [
        "Recaptcha\\Console\\Installer::postInstall"
      ]
    }
    ...

The template used is in plugins/Recaptcha/config/recaptcha.default.php. Don't forget to put `/config/recaptcha.php` file in .gitignore.

### 4. Fullfill the information in `/config/recaptcha.php`

- siteKey
- secret
- default lang.

### 5. Then add the component in your controller where you need the recaptcha.

For example:

    public function initialize() {
      parent::initialize();
      if ($this->request->action === 'contact'):
        $this->loadComponent('Recaptcha.Recaptcha');
        // $this->loadComponent('Search.Prg');
      endif;
    }

As you can see, you can optionnaly add the Prg Component from friendsofcake/search plugin (need to be added to your composer.json). This
put the request data into querystring, so the form contains the entries of
the user even if the checkbox is not checked.

### 6. No need to add the helper.

It will be added with the component.

### 7. Finally add `<?= $this->Recaptcha->display() ?>` in your view template inside the form.

For example:

    <?= $this->Form->create() ?>
    <?= $this->Recaptcha->recaptcha() ?>

    <?= $this->Form->input('name', [
      'label' => __('Your Name'),
      // 'default' => $this->request->query('name'); // in case you add the Prg Component
    ]) ?>
    <?= $this->Form->input('message', [
      'type' => 'textarea',
      // 'default' => $this->request->query('message'); // in case you add the Prg Component
      'label' => __('Your Message')
    ]) ?>

    <?= $this->Form->button(__('OK')) ?>
    <?= $this->Form->end() ?>


## What's inside ? ##

**COMPONENT**

- RecaptchaComponent

**HELPERS**

- RecaptchaHelper (Automatically added when the RecaptchaComponent is added)

**CONSOLE**

- Installer


## Support & Contribution ##

For support and feature request, please contact me through Github issues

Please feel free to contribute to the plugin with new issues, requests, unit tests and code fixes or new features. If you want to contribute some code,
create a feature branch, and send us your pull request.
Unit tests for new features and issues detected are mandatory to keep quality high.

## License ##

Copyright (c) [2014-2015] [cake17]

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
