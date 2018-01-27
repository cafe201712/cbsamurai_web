<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use App\Model\Entity\User;
use App\Model\Entity\Like;

/**
 * Messages Model
 *
 * @property \App\Model\Table\FromsTable|\Cake\ORM\Association\BelongsTo $Froms
 * @property \App\Model\Table\TosTable|\Cake\ORM\Association\BelongsTo $Tos
 *
 * @method \App\Model\Entity\Message get($primaryKey, $options = [])
 * @method \App\Model\Entity\Message newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Message[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Message|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Message patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Message[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Message findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */

class MessagesTable extends Table
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

        $this->setTable('messages');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Senders', [
            'className' => 'Users',
            'foreignKey' => 'from_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Receivers', [
            'className' => 'Users',
            'foreignKey' => 'to_id',
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
        $maxLength = Configure::read('AppLocal.MaxMessageLength');

        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('from_id')
            ->requirePresence('from_id')
            ->notEmpty('from_id');

        $validator
            ->integer('to_id')
            ->requirePresence('to_id')
            ->notEmpty('to_id');

        $validator
            ->scalar('body')
            ->requirePresence('body')
            ->notEmpty('body')
            ->maxLength('body', $maxLength, "${maxLength} 文字より長いメッセージを送ることはできません。");

        $validator
            ->dateTime('read')
            ->allowEmpty('read');

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
        $rules->add(function ($entity, $options) {
            /**
             * @var Like $like
             * @var User $from_user
             */
            $like = $options['like'];
            $from_user = TableRegistry::get('Users')->get($entity->from_id);

            if ($from_user->isUser()) {
                return $like->num_of_tickets > 0;
            }
            return true;
        }, 'requireTicketsRemaining', [
            'errorField' => 'body',
            'message' => 'チケットの残りがありません。お店に行ってリクエストしてください。',
        ]);

        return $rules;
    }

    public function findOurMessages(Query $query, array $options)
    {
        $query
            ->where(['OR' => [
                ['from_id' => $options['user1_id']],
                ['to_id' => $options['user1_id']],
            ]])
            ->where(['OR' => [
                ['from_id' => $options['user2_id']],
                ['to_id' => $options['user2_id']],
            ]])
            ->orderAsc('created');

        return $query;
    }

    public function findUnreadCount(Query $query, array $options)
    {
        $query->select(['count' => $query->func()->count('*')]);
        $query->where(['read_at IS' => null]);

        if (isset($options['from_id'])) {
            $query->where(['from_id' => $options['from_id']]);
        }
        if (isset($options['to_id'])) {
            $query->where(['to_id' => $options['to_id']]);
        }

        return $query;
    }

    /**
     * 現在時刻より前のメッセージを既読にする
     *
     * @param integer $from_id
     */
    public function updateReadAt($from_id, $to_id)
    {
        $now = new \DateTime();
        $this->updateAll(
            ['read_at' => $now],
            [
                'read_at IS' => null,
                'created <' => $now,
                'from_id' => $from_id,
                'to_id' => $to_id
            ]
        );
    }
}
