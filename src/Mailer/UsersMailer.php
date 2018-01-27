<?php

namespace App\Mailer;

use Cake\Datasource\EntityInterface;
use CakeDC\Users\Mailer\UsersMailer as CakeDCUsersMailer;

/**
 * Class UsersMailer
 * @package App\Mailer
 */
class UsersMailer extends CakeDCUsersMailer
{
    /**
     * Send the templated email to the user
     *
     * @param EntityInterface $user User entity
     * @return void
     */
    protected function validation(EntityInterface $user)
    {
        // un-hide the token to be able to send it in the email content
        $user->setHidden(['password', 'token_expires', 'api_token']);
        $subject = __d('CakeDC/Users', 'Your account validation link');
        $this
            ->to($user['email'])
            ->setSubject($subject)
            ->setViewVars($user->toArray())
            ->setTemplate('CakeDC/Users.validation');
    }

    /**
     * Send the reset password email to the user
     *
     * @param EntityInterface $user User entity
     *
     * @return void
     */
    protected function resetPassword(EntityInterface $user)
    {
        $subject = __d('CakeDC/Users', '{0}Your reset password link', '');
        // un-hide the token to be able to send it in the email content
        $user->setHidden(['password', 'token_expires', 'api_token']);

        $this
            ->to($user['email'])
            ->setSubject($subject)
            ->setViewVars($user->toArray())
            ->setTemplate('CakeDC/Users.resetPassword');
    }
}
