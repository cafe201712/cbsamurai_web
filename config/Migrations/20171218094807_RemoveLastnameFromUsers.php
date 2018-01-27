<?php
use Migrations\AbstractMigration;

class RemoveLastnameFromUsers extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('users');
        $table->removeColumn('last_name');
    }

    public function down()
    {
        $table = $this->table('users');
        $table->addColumn('last_name', 'string', [
            'limit' => 50,
            'null' => true,
            'comment' => 'CakeDC/Users のデフォルト項目',
            'after' => 'password',
        ]);
        $table->update();
    }
}
