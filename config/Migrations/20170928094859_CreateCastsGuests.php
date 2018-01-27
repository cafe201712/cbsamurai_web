<?php
use Migrations\AbstractMigration;

class CreateCastsGuests extends AbstractMigration
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
        $table = $this->table('casts_guests');
        $table
            ->addColumn('cast_id', 'integer', [
                'default' => null,
                'null' => false,
                'comment' => 'キャバ嬢のID',
            ])
            ->addColumn('guest_id', 'integer', [
                'default' => null,
                'null' => false,
                'comment' => '顧客のID',
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
