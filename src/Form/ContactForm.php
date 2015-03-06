<?php
/**
 * Example of Contact Form
 *
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://book.cakephp.org/3.0/en/core-libraries/form.html#
 *
 */
namespace Recaptcha\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class ContactForm extends Form
{
    /**
     * Build Schema
     *
     * @param Schema $schema Schema.
     * @return schema
     */
    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('name', 'string')
            ->addField('email', ['type' => 'string'])
            ->addField('body', ['type' => 'text']);
    }

    /**
     * Build Validator
     *
     * @param Validator $validator Validator.
     * @return validator
     */
    protected function _buildValidator(Validator $validator)
    {
        return $validator->add('name', 'length', [
            'rule' => ['minLength', 5],
            'message' => 'A name is required'
        ])->add('email', 'format', [
            'rule' => 'email',
            'message' => 'A valid email address is required',
        ]);
    }

    /**
     * Execute
     *
     * @param array $data Data.
     * @return bool
     */
    protected function _execute(array $data)
    {
        // Send an email.
        return true;
    }
}
