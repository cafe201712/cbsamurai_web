<?php
use Migrations\AbstractSeed;
use Cake\Datasource\ModelAwareTrait;
use Cake\Datasource\ConnectionManager;

/**
 * Develop seed.
 */
class DevelopSeed extends AbstractSeed
{
    use ModelAwareTrait;

    const SHOP_CNT = 5;
    const CAST_CNT = 5;
    const USER_CNT = 10;

    private $shops;
    private $casts;
    private $users;

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
        $connection = ConnectionManager::get('default');
        $connection->transactional(function ($connection) {
            $result = true;

            try {
                $this->seed_shops();
                $this->seed_casts();
                $this->seed_users();
            } catch (Exception $e) {
                $result = false;
            }
            return $result;
        });
    }

    private function seed_shops()
    {
        $prefs = [
            ['name' => '東京都', 'areas' => ['新宿', '渋谷', '六本木', '銀座']],
            ['name' => '神奈川県', 'areas' => ['横浜（市街地）', '横浜（北東）', '横浜（南西）', '川崎']],
            ['name' => '埼玉県', 'areas' => ['さいたま市', '川口', '川越', '上尾']],
            ['name' => '千葉県', 'areas' => ['千葉市', '船橋', '松戸', '市原']],
        ];

        $table = $this->loadModel('Shops');
        for ($i = 1; $i <= self::SHOP_CNT; $i++) {
            $pref = $prefs[array_rand($prefs)];
            $areas = $pref['areas'];
            $area = $areas[array_rand($areas)];

            $data = [
                'name' => sprintf("ショップ #%d", $i),
                'zip' => '999-9999',
                'pref' => $pref['name'],
                'area' => $area,
                'address1' => sprintf("%s %d 丁目", $area, $i),
                'address2' => '',
                'tel' => '999-999-9999',
                'fax' => '',
            ];

            $entity = $table->newEntity($data);
            if (!$table->save($entity)) {
                echo "エラーがあります!!";
                dump($entity);
            } else {
                $this->shops[] = $entity;
            }
        }
    }

    private function seed_casts()
    {
        $table = $this->loadModel('Users');
        foreach ($this->shops as $shop) {
            for ($i = 1; $i <= self::CAST_CNT; $i++) {
                $cast_id = sprintf("%d-%d", $shop->id, $i);
                $data = [
                    'shop_id' => $shop->id,
                    'email' => sprintf("%s@cast.com", $cast_id),
                    'password' => '12345678',
                    'last_name' => sprintf("shop-%d", $shop->id),
                    'first_name' => sprintf("%d子", $i),
                    'nickname' => sprintf("キャバ嬢-%s", $cast_id),
                    'active' => true,
                    'role' => 'cast',
                    'introduction' => "かくかく\nしかじか",
                ];

                $entity = $table->newEntity($data);
                if (!$table->save($entity)) {
                    echo "エラーがあります!!";
                    dump($entity);
                } else {
                    $this->casts[] = $entity;
                }
            }
        }
    }

    private function seed_users()
    {
        $table = $this->loadModel('Users');
        for ($i = 1; $i <= self::USER_CNT; $i++) {
            $username = sprintf("user-%d", $i);
            $data = [
                'email' => sprintf("%s@user.com", $username),
                'password' => '12345678',
                'last_name' => $username,
                'first_name' => sprintf("%d郎", $i),
                'nickname' => sprintf("顧客-%d", $i),
                'active' => true,
                'role' => 'user',
            ];

            $entity = $table->newEntity($data);
            if (!$table->save($entity)) {
                echo "エラーがあります!!";
                dump($entity);
            } else {
                $this->users[] = $entity;
            }
        }
    }
}
