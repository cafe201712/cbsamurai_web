<?php
use Migrations\AbstractMigration;

class CreateInvitations extends AbstractMigration
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
        $table = $this->table('invitations', ['id' => false, 'primary_key' => ['id']]);
        $table
            ->addColumn('id', 'uuid', [
                'null' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
                'comment' => '招待状名',
            ])
            ->addColumn('type', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
                'comment' => 'タイプ',
            ])
            ->addColumn('active', 'boolean', [
                'default' => false,
                'null' => false,
                'comment' => '有効',
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
