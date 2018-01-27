<?php
use Migrations\AbstractMigration;

class AddShopIdToUsers extends AbstractMigration
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
        $table->addColumn('shop_id', 'integer', [
            'default' => null,
            'null' => true,
            'comment' => 'ショップID',
            'after' => 'id',
        ]);
        $table->update();
    }
}
