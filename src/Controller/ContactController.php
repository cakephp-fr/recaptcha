<?php
/**
 * Recaptcha Example of Controller with Recaptcha
 *
 * This needs is to be used with the following files:
 * - form contact in src/View/Contact/index.ctp
 * - the form in src/Form/ContactForm.php
 *
 * THIS EXAMPLE is accessible with url www.yoursite.com/recaptcha/contact
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://blog.cake-websites.com/
 */
namespace Recaptcha\Controller;

use App\Controller\AppController;
use Recaptcha\Form\ContactForm;

class ContactController extends AppController
{
    /**
     * Initialize callback
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        if (in_array($this->request->action, ['index', 'multipleWidgets'])) {
            $this->loadComponent('Recaptcha.Recaptcha');
        }
    }

    /**
     * Contact Form Page
     *
     * @return void
     */
    public function index()
    {
        $contact = new ContactForm();
        if ($this->request->is('post')) {
            if ($this->Recaptcha->verify()) {
                // Here you can validate your data instead
                if ($contact->execute($this->request->data)) {
                    $this->Flash->success(__('We will get back to you soon.'));
                } else {
                    $this->Flash->error(__('There was a problem submitting your form.'));
                }
            } else {
                // You can debug developers errors with
                // debug($this->Recaptcha->errors());
                $this->Flash->error(__('Please check your Recaptcha Box.'));
            }
        }
        $this->set(compact('contact'));
    }

    /**
     * Contact Form Page With multiple Widgets
     *
     * @return void
     */
    public function multipleWidgets()
    {
        $contact = new ContactForm();
        if ($this->request->is('post')) {
            if ($this->Recaptcha->verify()) {
                if ($contact->execute($this->request->data)) {
                    $this->Flash->success(__('We will get back to you soon.'));
                } else {
                    $this->Flash->error(__('There was a problem submitting your form.'));
                }
            } else {
                debug($contact);
                debug($this->Recaptcha);
                $this->Flash->error(__('Please check your Recaptcha Box.'));
            }
        }
        $this->set(compact('contact'));
    }
}
