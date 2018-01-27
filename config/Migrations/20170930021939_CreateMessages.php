<?php
use Migrations\AbstractMigration;

class CreateMessages extends AbstractMigration
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
        $table = $this->table('messages');
        $table
            ->addColumn('body', 'text', [
                'default' => null,
                'null' => false,
                'comment' => 'メッセージ本文',
            ])
            ->addColumn('from_id', 'integer', [
                'default' => null,
                'null' => false,
                'comment' => '送信者ID',
            ])
            ->addColumn('to_id', 'integer', [
                'default' => null,
                'null' => false,
                'comment' => '宛先ID',
            ])
            ->addColumn('read_at', 'datetime', [
                'default' => null,
                'null' => true,
                'comment' => '既読日時',
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'null' => false,
            ])
            ->create();
    }
}
