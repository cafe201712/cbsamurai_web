<?php
/**
 * Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

use Migrations\AbstractMigration;

class InitialCakeDCUsers extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('users');
        $table
            ->addColumn('username', 'string', [
                'limit' => 255,
                'null' => false,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('password', 'string', [
                'limit' => 255,
                'null' => false,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('first_name', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('last_name', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('token', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('token_expires', 'datetime', [
                'default' => null,
                'null' => true,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('api_token', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('activation_date', 'datetime', [
                'default' => null,
                'null' => true,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('tos_date', 'datetime', [
                'default' => null,
                'null' => true,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('active', 'boolean', [
                'default' => false,
                'null' => false,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('is_superuser', 'boolean', [
                'default' => false,
                'null' => false,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('role', 'string', [
                'default' => 'user',
                'limit' => 255,
                'null' => true,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('created', 'datetime', [
                'null' => false,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('modified', 'datetime', [
                'null' => false,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->create();

        $table = $this->table('social_accounts');
        $table
            ->addColumn('user_id', 'integer', [
                'null' => false,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('provider', 'string', [
                'limit' => 255,
                'null' => false,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('reference', 'string', [
                'limit' => 255,
                'null' => false,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('avatar', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'null' => true,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('link', 'string', [
                'limit' => 255,
                'null' => false,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('token', 'string', [
                'limit' => 500,
                'null' => false,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('token_secret', 'string', [
                'default' => null,
                'limit' => 500,
                'null' => true,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('token_expires', 'datetime', [
                'default' => null,
                'null' => true,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('active', 'boolean', [
                'default' => true,
                'null' => false,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('data', 'text', [
                'null' => false,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('created', 'datetime', [
                'null' => false,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addColumn('modified', 'datetime', [
                'null' => false,
                'comment' => 'CakeDC/Users のデフォルト項目',
            ])
            ->addForeignKey('user_id', 'users', 'id', array('delete' => 'CASCADE', 'update' => 'CASCADE'))
            ->create();
    }
}
