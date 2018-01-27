<?php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Mailer\Email;
use Cake\Validation\Validator;
use App\Model\Validation\CustomValidation;
use Cake\Core\Configure;

/**
 * Contact Form.
 */
class ContactForm extends Form
{
    /**
     * Builds the schema for the modelless form
     *
     * @param \Cake\Form\Schema $schema From schema
     * @return \Cake\Form\Schema
     */
    protected function _buildSchema(Schema $schema)
    {
        $schema->addField('name', 'string')
            ->addField('email', 'string')
            ->addField('tel', 'string')
            ->addField('message', 'text');

        return $schema;
    }

    /**
     * Form validation builder
     *
     * @param \Cake\Validation\Validator $validator to use against the form
     * @return \Cake\Validation\Validator
     */
    protected function _buildValidator(Validator $validator)
    {
        $validator->setProvider('custom', CustomValidation::class);

        $validator
            ->scalar('name')
            ->requirePresence('name')
            ->notEmpty('name');

        $validator
            ->scalar('email')
            ->notEmpty('email')
            ->add('email', 'format', [
                'rule' => 'email',
            ]);

        $validator
            ->scalar('tel')
            ->requirePresence('tel')
            ->allowEmpty('tel')
            ->add('tel', 'format', [
                'rule' => 'tel',
                'provider' => 'custom',
            ]);

        $validator
            ->scalar('subject')
            ->notEmpty('subject');

        $validator
            ->scalar('message')
            ->notEmpty('message');

        return $validator;
    }

    /**
     * Defines what to execute once the From is being processed
     *
     * @param array $data Form data.
     * @return bool
     */
    protected function _execute(array $data)
    {
        $email = new Email();

        try {
            $email
                ->setTemplate('contact')
                ->setEmailFormat('text')
                ->setViewVars($data)
                ->setTo(Configure::read('AppLocal.Mail.contact_to'))
                ->setSubject('[お問い合わせ] ' . $data['subject'])
                ->setReplyTo($data['email'])
                ->send($data['message']);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
