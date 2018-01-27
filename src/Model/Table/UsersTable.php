<?php
namespace App\Model\Table;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use CakeDC\Users\Model\Table\UsersTable as CakeDcUsersTable;
use App\Model\Validation\CustomValidation;
use App\Model\Entity\User;

/**
 * Users Model
 *
 * @property \CakeDC\Users\Model\Table\SocialAccountsTable|\Cake\ORM\Association\HasMany $SocialAccounts
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends CakeDcUsersTable
{
    const PREFIX_THUMBNAIL = 'thumbnail-';
    const PHOTO_SIZE = 800;
    const THUMBNAIL_SIZE = 300;
    const PHOTO_MAX_FILE_SIZE = 1024 * 1024 * 3;    // 3MByte

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addBehavior('Timestamp');
        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'photo' => [
                'path' => 'webroot{DS}files{DS}{model}{DS}{field}{DS}{primaryKey}{DS}',
                'keepFilesOnDelete' => false,
                'nameCallback' => function ($data, $settings) {
                    // ユニークなファイル名を生成
                    $ext = pathinfo($data['name'], PATHINFO_EXTENSION);
                    return uniqid() . '.' . $ext;
                },
                'transformer' =>  function ($table, $entity, $data, $field, $settings) {
                    $extension = pathinfo($data['name'], PATHINFO_EXTENSION);

                    // Store the thumbnail in a temporary file
                    $tmp_photo = tempnam(sys_get_temp_dir(), 'photo-') . '.' . $extension;
                    $tmp_thumbnail = tempnam(sys_get_temp_dir(), 'thumbnail-') . '.' . $extension;

                    // Use the Imagine library to DO THE THING
                    $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
                    $imagine = new \Imagine\Gd\Imagine();

                    // thumbnail 作成
                    $size = new \Imagine\Image\Box(self::THUMBNAIL_SIZE, self::THUMBNAIL_SIZE);
                    $imagine->open($data['tmp_name'])
                        ->thumbnail($size, $mode)
                        ->save($tmp_thumbnail);

                    // upload file 縮小
                    $size = new \Imagine\Image\Box(self::PHOTO_SIZE, self::PHOTO_SIZE);
                    $imagine->open($data['tmp_name'])
                        ->thumbnail($size, $mode)
                        ->save($tmp_photo);

                    // Now return the original *and* the thumbnail
                    return [
                        $tmp_photo => $data['name'],
                        $tmp_thumbnail => self::PREFIX_THUMBNAIL . $data['name'],
                    ];
                },
                'deleteCallback' => function ($path, $entity, $field, $settings) {
                    // When deleting the entity, both the original and the thumbnail will be removed
                    // when keepFilesOnDelete is set to false
                    return [
                        $path . $entity->{$field},
                        $path . self::PREFIX_THUMBNAIL . $entity->{$field}
                    ];
                },
            ],
        ]);
        $this->addBehavior('Search.Search');

        // setup search
        $this->searchManager()
            ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'fieldMode' => 'OR',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'field' => ['nickname', 'role', 'Shops.name', 'Shops.pref', 'Shops.area']
            ]);

        // 作成した招待状
        $this->hasMany('Invitations')
            ->setDependent(true)
            ->setCascadeCallbacks(true);

        // 受信したメッセージ
        $this->hasMany('ReceivedMessages', [
            'className' => 'Messages'
        ])
            ->setForeignKey('to_id')
            ->setDependent(true)
            ->setCascadeCallbacks(true);

        // 送信したメッセージ
        $this->hasMany('SentMessages', [
            'className' => 'Messages'
        ])
            ->setForeignKey('from_id')
            ->setDependent(true)
            ->setCascadeCallbacks(true);

        // いいね
        $this->hasMany('Likes')
            ->setForeignKey('guest_id')
            ->setDependent(true)
            ->setCascadeCallbacks(true);

        // ユーザー登録時に使った招待状
        $this->belongsTo('Invitee', [
            'className' => 'Invitations',
        ]);

        // 所属ショップ
        $this->belongsTo('Shops');

        // いいねされているキャバ嬢
        $this->belongsToMany('LikedCasts', [
            'className' => 'Users',
            'joinTable' => 'likes',
        ])
            ->setThrough('Likes')
            ->setForeignKey('guest_id')
            ->setTargetForeignKey('cast_id')
            ->setProperty('liked_casts');

        // いいねしている顧客
        $this->belongsToMany('LikingGuests', [
            'className' => 'Users',
            'joinTable' => 'likes',
        ])
            ->setThrough('Likes')
            ->setForeignKey('cast_id')
            ->setTargetForeignKey('guest_id')
            ->setProperty('liking_guests');

        // 永久指名されているキャバ嬢
        $this->belongsToMany('SelectedCasts', [
            'className' => 'Users',
            'joinTable' => 'selections',
        ])
            ->setThrough('Selections')
            ->setForeignKey('guest_id')
            ->setTargetForeignKey('cast_id')
            ->setProperty('selected_casts');

        // 永久指名している顧客
        $this->belongsToMany('SelectingGuests', [
            'className' => 'Users',
            'joinTable' => 'selections',
        ])
            ->setThrough('Selections')
            ->setForeignKey('cast_id')
            ->setTargetForeignKey('guest_id')
            ->setProperty('selecting_guests');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $roles = User::ROLES;
        unset($roles['superuser']);  // superuser は登録出来ないよう、チェック対象から外す
        $roles = array_keys($roles);

        $validator->setProvider('custom', CustomValidation::class);
        $validator->setProvider('upload', \Josegonzalez\Upload\Validation\DefaultValidation::class);

        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->allowEmpty('token');

        $validator
            ->add('token_expires', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('token_expires');

        $validator
            ->allowEmpty('api_token');

        $validator
            ->add('activation_date', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('activation_date');

        $validator
            ->add('tos_date', 'valid', ['rule' => 'datetime'])
            ->allowEmpty('tos_date');

        $validator
            ->inList('role', $roles);

        $validator
            ->scalar('nickname')
            ->requirePresence('nickname', 'create')
            ->notEmpty('nickname');

        $validator->equals('tos', true, '利用規約に同意が必要です。');

        $validator
            ->scalar('introduction')
            ->allowEmpty('introduction');

        $validator
            ->date('birthday')
            ->allowEmpty('birthday');

        $validator
            ->allowEmpty('photo')
            ->add('photo', 'fileUnderPhpSizeLimit', [
                'rule' => 'isUnderPhpSizeLimit',
                'message' => 'ファイルのサイズが大きすぎます。',
                'provider' => 'upload',
                'last' => true,
            ])
            ->add('photo', 'fileUnderFormSizeLimit', [
                'rule' => 'isUnderFormSizeLimit',
                'message' => 'ファイルのサイズが大きすぎます。',
                'provider' => 'upload',
                'last' => true,
            ])
            ->add('photo', 'fileCompletedUpload', [
                'rule' => 'isCompletedUpload',
                'message' => 'ファイルを完全にアップロードできませんでした。',
                'provider' => 'upload',
                'last' => true,
            ])
            ->add('photo', 'fileFileUpload', [
                'rule' => 'isFileUpload',
                'message' => 'アップロードするファイルが見つかりません。',
                'provider' => 'upload',
                'last' => true,
            ])
            ->add('photo', 'fileSuccessfulWrite', [
                'rule' => 'isSuccessFulWrite',
                'message' => 'アップロードに失敗しました。',
                'provider' => 'upload',
                'last' => true,
            ])
            ->add('photo', 'fileBelowMaxSize', [
                'rule' => ['isBelowMaxSize', self::PHOTO_MAX_FILE_SIZE],
                'message' => 'ファイルのサイズが大きすぎます。',
                'provider' => 'upload',
                'last' => true,
            ])
            ->add('photo', 'fileExtension', [
                'rule' => ['extension', ['gif', 'jpeg', 'png', 'jpg']],
                'message' => 'ファイルタイプ（拡張子）が不正です。',
                'last' => true,
            ])
            ->add('photo', 'mimeType', [
                'rule' => ['mimeType', ['image/gif', 'image/png', 'image/jpg', 'image/jpeg']],
                'message' => 'MIME 型が不正です。',
                'last' => true,
            ]);

        return $validator;
    }

    /**
     * Adds some rules for password confirm
     * @param Validator $validator
     * @return Validator
     */
    public function validationPasswordConfirm(Validator $validator)
    {
        $validator = parent::validationPasswordConfirm($validator);

        $validator
            ->minLength('password', '8', '8 文字以上入力してください。');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules = parent::buildRules($rules);

        $rules->add($rules->isUnique(['api_token'], '重複する api_token を作成しようとしました。'));

        $rules->add(function ($entity, $options) {
            if (in_array($entity->role, ["manager", "cast"])) {
                return isset($entity->shop_id);
            }
            return true;
        }, 'requireShopId', [
            'errorField' => 'shop_id',
            'message' => '所属ショップを指定してください。'
        ]);

        $rules->add(function ($entity, $options) {
            if (!in_array($entity->role, ["manager", "cast"])) {
                return empty($entity->shop_id);
            }
            return true;
        }, 'emptyShopId', [
            'errorField' => 'shop_id',
            'message' => '所属ショップを指定できません。'
        ]);

        return $rules;
    }

    public function beforeSave(Event $event, EntityInterface $entity, \ArrayObject $options)
    {
        if ($entity->isDirty('photo')) {
            $dir = sprintf("%s/files/Users/photo/%d", WWW_ROOT, $entity->id);
            $photo = sprintf("%s/%s", $dir, $entity->photo);
            $thumbnail = sprintf("%s/%s%s", $dir, self::PREFIX_THUMBNAIL, $entity->photo);
            $wildcard = sprintf("%s/*", $dir);

            // プロフィール写真を更新時に、古いファイルを削除
            foreach (glob($wildcard) as $file) {
                if ($photo !== $file && $thumbnail !== $file) { // 今アップロードしているファイルは対象外
                    unlink($file);
                }
            }
        }
    }

    public function findGuests(Query $query, array $options)
    {
        return $query
            ->select(['id', 'nickname', 'photo', 'introduction', 'birthday'])
            ->where(['role' => 'user'])
            ->where(['active' => true]);
    }

    public function findCasts(Query $query, array $options)
    {
        return $query
            ->select(['Users.id', 'nickname', 'photo', 'introduction', 'birthday', 'shop_id'])
            ->where(['Users.role' => 'cast'])
            ->where(['active' => true])
            ->contain(['Shops' => function ($q) {
                return $q->select(['name', 'pref', 'address1', 'address2', 'tel', 'fax', 'description']);
            }]);
    }

    public function findUnLikedCasts(Query $query, array $options)
    {
        $guest_id = $options['guest_id'] ?? null;
        return $query
            ->find('search', ['search' => $options['query']])
            ->select(['id', 'shop_id', 'nickname', 'photo'])
            ->where(['role' => 'cast'])
            ->where(['active' => true])
            ->contain(['Shops' => function($q) {
                return $q->select(['name', 'pref', 'area']);
            }])
            ->notMatching('LikingGuests', function ($query) use ($guest_id) {
                return $query->where(['guest_id' => $guest_id]);
            });
    }

    public function findProfile(Query $query, array $options)
    {
        $query->where(['id' => $options['id']])
            ->select([
                'id',
                'nickname',
                'email',
                'introduction',
                'birthday',
                'photo',
            ]);

        return $query;
    }
}
