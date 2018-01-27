<?php
use Migrations\AbstractMigration;

class AddPhotoToUsers extends AbstractMigration
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
        $table->addColumn('photo', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => true,
            'comment' => '写真',
            'after' => 'last_name',
        ]);
        $table->update();
    }
}
