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
namespace App\Controller;

use App\Controller\AppController;
use App\Form\ContactForm;

class ContactController extends AppController
{

    public function initialize() {
        parent::initialize();
        if ($this->request->action === 'index'):
            $this->loadComponent('Recaptcha.Recaptcha');
            // $this->loadComponent('Search.Prg');
        endif;
    }

    public function index()
    {
        $contact = new ContactForm();
        if ($this->request->is('post')) {
            if ($contact->execute($this->request->data)) {
                $this->Flash->success('We will get back to you soon.');
            } else {
                $this->Flash->error('There was a problem submitting your form.');
            }
        }
        $this->set('contact', $contact);
    }
}
