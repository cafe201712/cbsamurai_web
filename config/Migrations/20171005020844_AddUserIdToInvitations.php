<?php
use Migrations\AbstractMigration;

class AddUserIdToInvitations extends AbstractMigration
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
        $table = $this->table('invitations');
        $table->addColumn('user_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
            'comment' => 'ユーザーID',
            'after' => 'shop_id',
        ]);
        $table->update();
    }
}
