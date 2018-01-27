<?php
use Migrations\AbstractMigration;

class AddProfileToUsers extends AbstractMigration
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
        $table->addColumn('nickname', 'string', [
            'limit' => 255,
            'null' => false,
            'comment' => 'ニックネーム',
            'after' => 'photo',
        ]);
        $table->addColumn('introduction', 'text', [
            'default' => null,
            'null' => true,
            'comment' => '自己紹介',
            'after' => 'nickname',
        ]);
        $table->addColumn('birthday', 'date', [
            'default' => null,
            'null' => true,
            'comment' => '生年月日',
            'after' => 'introduction',
        ]);
        $table->update();
    }
}
