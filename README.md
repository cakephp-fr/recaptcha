Google reCAPTCHA for CakePHP 3
==============================

[![Build Status](https://api.travis-ci.org/cake17/cakephp-recaptcha.png?branch=master)](https://travis-ci.org/cake17/cakephp-recaptcha)
[![Latest Stable Version](https://poser.pugx.org/cake17/cakephp-recaptcha/v/stable.png)](https://packagist.org/packages/cake17/cakephp-recaptcha)
[![Minimum PHP Version](http://img.shields.io/badge/php-%3E%3D%205.4-8892BF.svg)](https://php.net/)
[![License](https://poser.pugx.org/cake17/cakephp-recaptcha/license.png)](https://packagist.org/packages/cake17/cakephp-recaptcha)
[![Total Downloads](https://poser.pugx.org/cake17/cakephp-recaptcha/d/total.png)](https://packagist.org/packages/cake17/cakephp-recaptcha)

This plugin is still under development...

## Plugin's Objective ##

This plugin adds functionalities to use the new Google reCAPTCHA in CakePHP
projects.
For now multiple widgets on a single page is not available.

## Requirements ##

- PHP >= 5.4.16
- [CakePHP 3.x](http://book.cakephp.org/3.0/en/index.html)
- Server under `localhost` name. Be aware that the widgets will not be displayed
  if you have a vhost named local.dev/dev/ for instance.

## Installation ##

_[Using [Composer](http://getcomposer.org/)]_

Add the plugin to your project's `composer.json` - something like this:

```json
{
    "require": {
        "cake17/cakephp-recaptcha": "dev-master"
    }
}
```

And run `composer update`.

Because this plugin has the type `cakephp-plugin` set in it's own
`composer.json`, composer knows to install it inside your `/vendor` directory.
It is recommended that you add `/vendor` to your .gitignore file.
(Why? [read this](http://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md).)

## Usage of plugin ##

### 1. Enable the plugin

In your `config/bootstrap.php` file:

    Plugin::load('Recaptcha', ['routes' => true, 'bootstrap' => true]);

### 2. Go to Google reCAPTCHA site

Go [here](https://www.google.com/recaptcha/intro/index.html) to create a pair
of keys for your website.

### 3. Create or copy the reCAPTCHA config file

- Either copy the default file in `/config/recaptcha.php` from
  `/vendor/cake17/cakephp-recaptcha/config/recaptcha.default.php`.

- Either use the composer install command to add in composer.json that will
  make the copy for you
  To use it, add the following snippet in your project composer.json and run
  `composer run-script post-install-cmd` after::

      ...
      "scripts": {
        "post-install-cmd": [
          "Recaptcha\\Console\\Installer::postInstall"
        ]
      }
      ...

Whatever the method you used to copy the recaptcha config file, don't forget to
put `/config/recaptcha.php` file in .gitignore.

### 4. Fullfill the information in `/config/recaptcha.php`

- sitekey: get it on google website
- secret: get it on google website
- lang: see the list on google website
- theme: dark or light
- type: image or audio

If you don't have a key and a secret, an exception will be raised.

### 5. Then add the component in your controller where you need the reCAPTCHA.

For example:

    public function initialize() {
        parent::initialize();
        if ($this->request->action === 'contact') {
            $this->loadComponent('Recaptcha.Recaptcha');
        }
    }

### 6. Add the following in your controller.

    public function contact() {
        if ($this->request->is('post')) {
            if ($this->Recaptcha->verify()) {
                if ($contact->execute($this->request->data)) {
                    $this->Flash->success(__('We will get back to you soon.'));
                    return $this->redirect($this->referer());
                } else {
                    $this->Flash->error(__('There was a problem submitting your form.'));
                }
            } else {
                $this->Flash->error(__('Please check your Recaptcha Box.'));
            }
        }
    }

### 7. No need to add the helper.

It will be added with the component.

### 8. Finally add `<?= $this->Recaptcha->display() ?>` in your view template inside the form.

For example:

    <?= $this->Form->create() ?>
    <?= $this->Recaptcha->display() ?>

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

See another example of contact with no form in
`src/Controller/ContactController.php`, `src/Template/Contact/index.ctp` and
`src/Form/ContactForm.php`. You can test it by going to
`http://localhost/recaptcha/contact`.

## What's inside ? ##

**COMPONENT**

- RecaptchaComponent

**HELPERS**

- RecaptchaHelper (Automatically added when the RecaptchaComponent is added)

**CONSOLE**

- Installer

**EXAMPLE**

- Controller : ContactController
- Form : ContactForm
- Template : Contact/index.ctp

## Tests ##

To test the plugin, clone it and run `composer install`. Then run
`./vendor/bin/phpunit` and `./vendor/bin/phpcs -n -p --extensions=php --standard=vendor/cakephp/cakephp-codesniffer/CakePHP ./src ./tests --ignore=vendor`

## Support & Contribution ##

For support and feature request, please contact me through Github issues

Please feel free to contribute to the plugin with new issues, requests, unit
tests and code fixes or new features. If you want to contribute some code,
create a feature branch, and send us your pull request.
Unit tests for new features and issues detected are mandatory to keep quality
high.

## License ##

Copyright (c) [2014-2015] [cake17]

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies
of the Software, and to permit persons to whom the Software is furnished to do
so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
