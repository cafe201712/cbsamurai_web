<?php
use Migrations\AbstractMigration;

class CreateIndex extends AbstractMigration
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
        $table->addIndex(['user_id']);
        $table->update();

        $table = $this->table('likes');
        $table->addIndex(['cast_id']);
        $table->addIndex(['guest_id']);
        $table->addIndex(['cast_id', 'guest_id'], ['unique' => true, 'name' => 'cast_id-guest_id']);
        $table->update();

        $table = $this->table('messages');
        $table->addIndex(['from_id', 'to_id'], ['name' => 'from_id-to_id']);
        $table->update();

        $table = $this->table('selections');
        $table->addIndex(['cast_id']);
        $table->addIndex(['guest_id']);
        $table->addIndex(['cast_id', 'guest_id'], ['unique' => true, 'name' => 'cast_id-guest_id']);
        $table->update();

        $table = $this->table('users');
        $table->addIndex(['username']);
        $table->addIndex(['email']);
        $table->update();
    }
}
