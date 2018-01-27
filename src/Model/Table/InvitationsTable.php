<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Invitations Model
 *
 * @method \App\Model\Entity\Invitation get($primaryKey, $options = [])
 * @method \App\Model\Entity\Invitation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Invitation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Invitation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Invitation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Invitation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Invitation findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InvitationsTable extends Table
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

        $this->setTable('invitations');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
                'field' => ['name', 'type', 'Shops.name', 'Users.nickname']
            ]);

        $this->belongsTo('Shops');

        // 招待状を作成したユーザー
        $this->belongsTo('Users');

        // 招待されて登録したユーザー達
        $this->hasMany('InvitedUsers', [
            'className' => 'Users',
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
            ->uuid('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('shop_id')
            ->requirePresence('shop_id', 'create')
            ->notEmpty('shop_id');

        $validator
            ->integer('user_id')
            ->requirePresence('user_id', 'create')
            ->notEmpty('user_id');

        $validator
            ->scalar('name')
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('type')
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->notEmpty('active');

        return $validator;
    }

    public function findOwnedByUser(Query $query, array $options)
    {
        return $query
            ->select([
                'id',
                'user_id',
                'name',
                'type',
                'active',
            ])
            ->where([
                'user_id' => $options['user_id'],
                'active' => true
            ])
            ->order($options['sort_order']);
    }
}
