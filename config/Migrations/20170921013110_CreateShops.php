<?php
use Migrations\AbstractMigration;

class CreateShops extends AbstractMigration
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
        $table = $this->table('shops');
        $table
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
                'comment' => '店名',
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'null' => true,
                'comment' => 'お店の説明',
            ])
            ->addColumn('zip', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
                'comment' => '郵便番号',
            ])
            ->addColumn('pref', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
                'comment' => '都道府県',
            ])
            ->addColumn('area', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
                'comment' => 'エリア',
            ])
            ->addColumn('address1', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
                'comment' => '住所（市区町村番地）',
            ])
            ->addColumn('address2', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
                'default' => '',
                'comment' => '住所（ビル名等）',
            ])
            ->addColumn('tel', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
                'comment' => '電話番号',
            ])
            ->addColumn('fax', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
                'default' => '',
                'comment' => 'FAX番号',
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
