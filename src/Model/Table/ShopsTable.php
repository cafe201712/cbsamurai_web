<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Validation\CustomValidation;

/**
 * Shops Model
 *
 * @method \App\Model\Entity\Shop get($primaryKey, $options = [])
 * @method \App\Model\Entity\Shop newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Shop[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Shop|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Shop patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Shop[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Shop findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ShopsTable extends Table
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

        $this->setTable('shops');
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
                'field' => ['name', 'pref', 'area', 'description']
            ]);

        $this->hasMany('Users', [
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->hasMany('Invitations', [
            'dependent' => true,
            'cascadeCallbacks' => true,
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
        $validator->setProvider('custom', CustomValidation::class);

        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        $validator
            ->scalar('zip')
            ->requirePresence('zip', 'create')
            ->notEmpty('zip')
            ->add('zip', 'custom', [
                'rule' => 'zip',
                'provider' => 'custom'
            ]);

        $validator
            ->scalar('pref')
            ->requirePresence('pref', 'create')
            ->notEmpty('pref');

        $validator
            ->scalar('area')
            ->requirePresence('area', 'create')
            ->notEmpty('area');

        $validator
            ->scalar('address1')
            ->requirePresence('address1', 'create')
            ->notEmpty('address1');

        $validator
            ->scalar('address2')
            ->requirePresence('address2', 'create')
            ->allowEmpty('address2');

        $validator
            ->scalar('tel')
            ->requirePresence('tel', 'create')
            ->notEmpty('tel')
            ->add('tel', 'custom', [
                'rule' => 'tel',
                'provider' => 'custom'
            ]);

        $validator
            ->scalar('fax')
            ->requirePresence('fax', 'create')
            ->allowEmpty('fax')
            ->add('fax', 'custom', [
                'rule' => 'tel',
                'provider' => 'custom'
            ]);

        return $validator;
    }
}
