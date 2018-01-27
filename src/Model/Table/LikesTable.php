<?php
namespace App\Model\Table;

use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Likes Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Casts
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Guests
 *
 * @method \App\Model\Entity\Likes get($primaryKey, $options = [])
 * @method \App\Model\Entity\Likes newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Likes[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Likes|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Likes patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Likes[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Likes findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LikesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('likes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Casts', [
            'className' => 'Users',
            'foreignKey' => 'cast_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Guests', [
            'className' => 'Users',
            'foreignKey' => 'guest_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('cast_id')
            ->requirePresence('cast_id', 'create')
            ->notEmpty('cast_id');

        $validator
            ->integer('guest_id')
            ->requirePresence('guest_id', 'create')
            ->notEmpty('guest_id');

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
        $rules->add($rules->isUnique(
            ['cast_id', 'guest_id'],
            '既に「いいね」されています。'
        ));

        $rules->add(function ($entity) {
            $user = TableRegistry::get('Users')->get($entity->cast_id);
            return $user->isCast();
        }, 'validRoleCastId', [
            'errorField' => 'cast_id',
            'message' => 'キャバ嬢にしか「いいね」を行えません。'
        ]);

        $rules->add(function ($entity) {
            $user = TableRegistry::get('Users')->get($entity->guest_id);
            return $user->isUser();
        }, 'validRoleGuestId', [
            'errorField' => 'guest_id',
            'message' => 'お客様以外は「いいね」を行えません。'
        ]);

        return $rules;
    }

    public function beforeSave(Event $event, EntityInterface $entity)
    {
        if ($entity->isNew()) {
            // 新規登録の時、デフォルトチケット数をセットする
            $entity->num_of_tickets = Configure::read('AppLocal.default_tickets') ?: 0;
        }
    }

    // 永久指名されているユーザーの一覧を取得
    public function findSelectingGuests(Query $query, array $options)
    {
        $cast_id = $options['cast_id'];

        return $query
            ->select(['id', 'cast_id', 'guest_id', 'num_of_tickets'])
            ->contain('Guests', function ($query) use ($cast_id) {
                $query->select(['id', 'shop_id', 'nickname', 'photo', 'role']);
                $query->contain('SentMessages', function ($query) use ($cast_id) {
                    $query
                        ->select(['id', 'from_id', 'to_id', 'body'])
                        ->where(['to_id' => $cast_id, 'read_at IS' => null]);
                    return $query;
                });
                $query->Matching('SelectedCasts', function ($query) use ($cast_id) {
                    return $query->where(["Selections.cast_id" => $cast_id]);
                });
                return $query;
            })
            ->where(["Likes.cast_id" => $cast_id]);
    }

    // いいねされているユーザーの一覧を取得
    public function findLikingGuests(Query $query, array $options)
    {
        $cast_id = $options['cast_id'];

        return $query
            ->select(['id', 'cast_id', 'guest_id', 'num_of_tickets'])
            ->contain('Guests', function ($query) use ($cast_id) {
                $query->select(['id', 'shop_id', 'nickname', 'photo', 'role']);
                $query->contain('SentMessages', function ($query) use ($cast_id) {
                    $query
                        ->select(['id', 'from_id', 'to_id', 'body'])
                        ->where(['to_id' => $cast_id, 'read_at IS' => null]);
                    return $query;
                });
                $query->notMatching('SelectedCasts', function ($query) use ($cast_id) {
                    return $query->where(["Selections.cast_id" => $cast_id]);
                });
                return $query;
            })
            ->where(["Likes.cast_id" => $cast_id]);
    }

    // 永久指名しているキャバ嬢の一覧を取得
    public function findSelectedCasts(Query $query, array $options)
    {
        $guest_id = $options['guest_id'];

        return $query
            ->select(['id', 'cast_id', 'guest_id', 'num_of_tickets'])
            ->contain('Casts', function ($query) use ($guest_id) {
                $query->select(['id', 'shop_id', 'nickname', 'photo', 'role']);
                $query->contain('SentMessages', function ($query) use ($guest_id) {
                    $query
                        ->select(['id', 'from_id', 'to_id', 'body'])
                        ->where(['to_id' => $guest_id, 'read_at IS' => null]);
                    return $query;
                });
                $query->contain('Shops', function ($query) {
                    return $query->select(['name', 'pref', 'area']);
                });
                $query->Matching('SelectingGuests', function ($query) use ($guest_id) {
                    return $query->where(["Selections.guest_id" => $guest_id]);
                });
                return $query;
            })
            ->where(["Likes.guest_id" => $guest_id]);
    }

    // いいねしているキャバ嬢の一覧取得
    public function findLikedCasts(Query $query, array $options)
    {
        $guest_id = $options['guest_id'];

        return $query
            ->select(['id', 'cast_id', 'guest_id', 'num_of_tickets'])
            ->contain('Casts', function ($query) use ($guest_id) {
                $query->select(['id', 'shop_id', 'nickname', 'photo', 'role']);
                $query->contain('SentMessages', function ($query) use ($guest_id) {
                    $query
                        ->select(['id', 'from_id', 'to_id', 'body'])
                        ->where(['to_id' => $guest_id, 'read_at IS' => null]);
                    return $query;
                });
                $query->contain('Shops', function ($query) {
                    return $query->select(['name', 'pref', 'area']);
                });
                $query->notMatching('SelectingGuests', function ($query) use ($guest_id) {
                    return $query->where(["Selections.guest_id" => $guest_id]);
                });
                return $query;
            })
            ->where(["Likes.guest_id" => $guest_id]);
    }
}