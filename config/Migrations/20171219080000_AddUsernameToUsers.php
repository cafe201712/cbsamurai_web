<?php
use Migrations\AbstractMigration;

class AddUsernameToUsers extends AbstractMigration
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
        $table->addColumn('username', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
            'comment' => '未使用だが、cakedb/user が findBy*Or* しているので削除しないこと',
            'after' => 'id',
        ]);
        $table->update();
    }
}
