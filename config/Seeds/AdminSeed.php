<?php
use Migrations\AbstractSeed;
use Cake\Core\Configure;
use Cake\Datasource\ModelAwareTrait;

/**
 * Admin seed.
 */
class AdminSeed extends AbstractSeed
{
    use ModelAwareTrait;

    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'username' => 'admin',
                'email' => 'admin@cbsamurai.jp',
                'password' => 'admin123',
                'is_superuser' => true,
                'role' => 'superuser',
                'first_name' => 'cbsamurai',
                'last_name' => 'admin',
                'nickname' => 'admin',
                'active' => true,
            ],
        ];


        $table = $this->loadModel(Configure::read('Users.table'));
        foreach ($datas as $data) {
            // User エンティティでは "superuser" の登録はバリデーションでエラーとする為、ここではバリデーションを無効化して登録する
            // $user = $table->newEntity($data);
            $user = $table->newEntity($data, ['validate' => false]);

            if (!$table->save($user)) {
                echo "エラーがあります!!";
                dump($user->getErrors());
            }
        }
    }
}
