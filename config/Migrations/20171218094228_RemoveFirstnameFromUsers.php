<?php
use Migrations\AbstractMigration;

class RemoveFirstnameFromUsers extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('users');
        $table->removeColumn('first_name');
    }

    public function down()
    {
        $table = $this->table('users');
        $table->addColumn('first_name', 'string', [
            'limit' => 50,
            'null' => true,
            'comment' => 'CakeDC/Users のデフォルト項目',
            'after' => 'password',
        ]);
        $table->update();
    }
}
