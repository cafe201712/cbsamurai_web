<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Message Entity
 *
 * @property int $id
 * @property string $message
 * @property int $from_id
 * @property int $to_id
 * @property \Cake\I18n\FrozenTime $read
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\From $from
 * @property \App\Model\Entity\To $to
 */
class Message extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    public function isFrom($user_id)
    {
        return $this->from_id === $user_id;
    }

    public function isTo($user_id)
    {
        return $this->to_id === $user_id;
    }
}
