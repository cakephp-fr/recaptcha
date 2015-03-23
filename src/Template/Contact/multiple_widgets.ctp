<?php
/**
 * Contact form with no model Form Example.
 * See more in http://book.cakephp.org/3.0/en/core-libraries/form.html
 *
 * This needs is to be used with the following files:
 * - form contact in src/View/Contact/index.ctp
 * - form controller in src/Controller/ContactController.php
 *
 * THIS EXAMPLE is accessible with url www.yoursite.com/recaptcha/contact
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
?>
<?= $this->Form->create($contact) ?>
<?= $this->Form->input('name') ?>
<?= $this->Form->input('email') ?>
<?= $this->Form->input('body') ?>
<?= $this->Form->button('Submit') ?>
<?= $this->Form->end() ?>

<?php
$this->Recaptcha->widget(['id' => 'widget']);
$this->Recaptcha->widget(['id' => 'widget2']);
?>
<?= $this->Recaptcha->render(); ?>
