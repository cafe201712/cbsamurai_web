<?php
use Migrations\AbstractMigration;

class CreateNews extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('news');
        $table->addColumn('title', 'string', [
            'default' => null,
            'null' => true,
            'comment' => 'タイトル',
        ]);
        $table->addColumn('description', 'text', [
            'default' => null,
            'null' => true,
            'comment' => '概要',
        ]);
        $table->addColumn('content', 'text', [
            'default' => null,
            'null' => false,
            'comment' => '本文',
        ]);
        $table->addColumn('release_date', 'date', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->create();
    }
}
