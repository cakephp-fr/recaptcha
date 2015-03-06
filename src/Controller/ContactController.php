<?php
/**
 * Recaptcha Example of Controller with Recaptcha
 * This works with the form contact in src/View/Contact/index.ctp
 *
 * YOU NEED TO COPY THIS FILE IN YOUR APPLICATION
 *
 * @author   cake17
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://cake17.github.io/
 *
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
        if ($this->request->action === 'index') {
            $this->loadComponent('Recaptcha.Recaptcha');
            // $this->loadComponent('Search.Prg');
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
            if ($contact->execute($this->request->data)) {
                $this->Flash->success(__('We will get back to you soon.'));
            } else {
                $this->Flash->error(__('There was a problem submitting your form.'));
            }
        }
        $this->set(compact('contact'));
    }
}
