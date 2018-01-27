<?php
namespace App\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;

/**
 * Selections Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Casts
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Guests
 *
 * @method \App\Model\Entity\Selection get($primaryKey, $options = [])
 * @method \App\Model\Entity\Selection newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Selection[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Selection|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Selection patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Selection[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Selection findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SelectionsTable extends Table
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

        $this->setTable('selections');
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
        $max_selection = Configure::read('AppLocal.MaxSelection', 0);

        $rules->add($rules->isUnique(
            ['cast_id', 'guest_id'],
            '既に「永久指名」されています。'
        ));

        $rules->add(function ($entity) {
            $user = TableRegistry::get('Users')->get($entity->cast_id);
            return $user->isCast();
        }, 'validRoleCastId', [
            'errorField' => 'cast_id',
            'message' => 'キャバ嬢にしか永久指名を行えません。'
        ]);

        $rules->add(function ($entity) {
            $user = TableRegistry::get('Users')->get($entity->guest_id);
            return $user->isUser();
        }, 'validRoleGuestId', [
            'errorField' => 'guest_id',
            'message' => 'お客様以外は永久指名を行えません。'
        ]);

        $rules->add(function ($entity) use ($max_selection) {
            $count = $this->find()->where(['guest_id' => $entity->guest_id])->count();
            return $count < $max_selection;
        }, 'maxSelection', [
            'errorField' => 'guest_id',
            'message' => sprintf("%s 人以上、永久指名することはできません", $max_selection)
        ]);

        return $rules;
    }
}
