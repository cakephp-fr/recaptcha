<?php
/**
 * Example of contact form with no model.
 * See more in http://book.cakephp.org/3.0/en/core-libraries/form.html
 * Works with src/Controller/ContactController.
 *
 * YOU NEED TO COPY THIS FILE IN YOUR APPLICATION
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://cake17.github.io/
 *
 */
?>
<?= $this->Form->create($contact) ?>
<?= $this->Form->input('name') ?>
<?= $this->Form->input('email') ?>
<?= $this->Form->input('body') ?>
<?= $this->Recaptcha->display() ?>
<?= $this->Form->button('Submit') ?>
<?= $this->Form->end() ?>
