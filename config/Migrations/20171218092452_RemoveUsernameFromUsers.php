<?php
use Migrations\AbstractMigration;

class RemoveUsernameFromUsers extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('users');
        $table->removeColumn('username');
    }

    public function down()
    {
        $table = $this->table('users');
        $table->addColumn('username', 'string', [
            'limit' => 255,
            'null' => false,
            'comment' => 'CakeDC/Users のデフォルト項目',
            'after' => 'shop_id',
        ]);
        $table->addIndex(['username']);
        $table->update();
    }
}
