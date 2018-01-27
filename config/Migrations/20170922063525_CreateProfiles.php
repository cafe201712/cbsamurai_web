<?php
use Migrations\AbstractMigration;

class CreateProfiles extends AbstractMigration
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
        $table = $this->table('profiles');
        $table->addColumn('user_id', 'integer', [
            'null' => false,
            'comment' => 'ユーザーID',
        ]);
        $table->addColumn('nickname', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
            'comment' => 'ニックネーム',
        ]);
        $table->addColumn('introduction', 'text', [
            'default' => null,
            'null' => true,
            'comment' => '自己紹介',
        ]);
        $table->addColumn('birthday', 'date', [
            'default' => null,
            'null' => true,
            'comment' => '生年月日',
        ]);
        $table->create();
    }
}
