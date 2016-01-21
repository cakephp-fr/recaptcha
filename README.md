Google reCAPTCHA for CakePHP 3
==============================

[![Build Status](https://api.travis-ci.org/cakephp-fr/recaptcha.png?branch=master)](https://travis-ci.org/cakephp-fr/recaptcha)
[![Latest Stable Version](https://poser.pugx.org/cakephp-fr/recaptcha/v/stable.png)](https://packagist.org/packages/cakephp-fr/recaptcha)
[![Minimum PHP Version](http://img.shields.io/badge/php-%3E%3D%205.4-8892BF.svg)](https://php.net/)
[![License](https://poser.pugx.org/cakephp-fr/recaptcha/license.png)](https://packagist.org/packages/cakephp-fr/recaptcha)
[![Total Downloads](https://poser.pugx.org/cakephp-fr/recaptcha/d/total.png)](https://packagist.org/packages/cakephp-fr/recaptcha)

## Plugin's Objective ##

This plugin adds functionalities to use the new reCAPTCHA API version 2.0 in
CakePHP projects.

This plugin is still under development... For now multiple widgets on a single page is not available.

## Requirements ##

- PHP >= 5.4.16
- [CakePHP 3.x](http://book.cakephp.org/3.0/en/index.html)
- Server under `localhost` name. Be aware that the widgets will not be displayed
  if you have a vhost named local.dev/dev/ for instance.

## Installation ##

_[Using [Composer](http://getcomposer.org/)]_

Add the plugin to your project's `composer.json` - something like this:

```bash
composer require cakephp-fr/recaptcha:~0.4
```

You then need to load the plugin, by running:

```bash
bin/cake plugin load -rb Recaptcha
```

You can check that this command has created the line `Plugin::load('Recaptcha', ['routes' => true, 'bootstrap' => true]);` at the bottom of your `config/boostrap.php` file.

The `'routes' => true` should be deleted in production. It's only useful if you want to see the demo.

## Usage of plugin ##

### 1. Go to Google reCAPTCHA site

Go [here](https://www.google.com/recaptcha/intro/index.html) to create a pair
of keys for your website.

### 2. Configure the plugin

The Easiest way is to add the recaptcha config to the `config/app.php`, something like:

```php
return [

    .... (other configs before)

    'Recaptcha' => [
        // Register API keys at https://www.google.com/recaptcha/admin
        'sitekey' => 'your-sitekey',
        'secret' => 'your-secret',
        // reCAPTCHA supported 40+ languages listed
        // here: https://developers.google.com/recaptcha/docs/language
        'lang' => 'en',
        // either light or dark
        'theme' => 'light',
        // either image or audio
        'type' => 'image',
        // either normal or compact
        'size' => 'normal'
    ]
]
```

Make sure that `/config/app.php` file is in `.gitignore`. The secret key must stay secret.

If you don't have a key and a secret, an exception will be raised.

### 3. Then add the component in your controller where you need the reCAPTCHA.

For example:

```php
public function initialize() {
    parent::initialize();
    if ($this->request->action === 'contact') {
        $this->loadComponent('Recaptcha.Recaptcha');
    }
}
```

```php
public function contact() {
    if ($this->request->is('post')) {
        if ($this->Recaptcha->verify()) {
            // Here you can validate your data
            if (!empty($this->request->data)) {
                $this->Flash->success(__('We will get back to you soon.'));
                return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__('There was a problem submitting your form.'));
            }
        } else {
            // You can debug developers errors with
            // debug($this->Recaptcha->errors());
            $this->Flash->error(__('Please check your Recaptcha Box.'));
        }
    }
}
```

### 4. Finally add `<?= $this->Recaptcha->display() ?>` in your view template inside the form.

**No need** to add the helper: it will be added with the component.

For example:

```php
<?= $this->Form->create() ?>

<?= $this->Form->input('name', [
  'label' => __('Your Name'),
  // 'default' => $this->request->query('name'); // in case you add the Prg Component
]) ?>
<?= $this->Form->input('message', [
  'type' => 'textarea',
  // 'default' => $this->request->query('message'); // in case you add the Prg Component
  'label' => __('Your Message')
]) ?>

<?= $this->Recaptcha->display() ?>

<?= $this->Form->button(__('OK')) ?>
<?= $this->Form->end() ?>
```

See another example of contact with no form in
`src/Controller/ContactController.php`, `src/Template/Contact/index.ctp` and
`src/Form/ContactForm.php`. You can test it by going to
`http://localhost/recaptcha/contact`.

## What's inside ? ##

**COMPONENT**

- RecaptchaComponent

**HELPERS**

- RecaptchaHelper (Automatically added when the RecaptchaComponent is added)

**EXAMPLE**

- Controller : ContactController
- Form : ContactForm
- Template : Contact/index.ctp

## Tests ##

To test the plugin, clone it and run `composer install`. Then run:

```bash
./vendor/bin/phpunit
./vendor/bin/phpcs -n -p --extensions=php --standard=vendor/cakephp/cakephp-codesniffer/CakePHP ./src ./tests --ignore=vendor
```

## Support & Contribution ##

For support and feature request, please contact me through Github issues

Please feel free to contribute to the plugin with new issues, requests, unit
tests and code fixes or new features. If you want to contribute some code,
create a feature branch, and send us your pull request.
Unit tests for new features and issues detected are mandatory to keep quality
high.

## License ##

Copyright (c) [2014-2016] [cakephp-fr]

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
