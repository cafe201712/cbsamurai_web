<?php
use Migrations\AbstractMigration;

class AddInvitationIdToUsers extends AbstractMigration
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
        $table = $this->table('users');
        $table->addColumn('invitation_id', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
            'comment' => '招待状ID',
            'after' => 'birthday',
        ]);
        $table->update();
    }
}
