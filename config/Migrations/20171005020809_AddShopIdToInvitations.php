<?php
use Migrations\AbstractMigration;

class AddShopIdToInvitations extends AbstractMigration
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
        $table->addColumn('shop_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
            'comment' => 'ショップID',
            'after' => 'id',
        ]);
        $table->update();
    }
}
