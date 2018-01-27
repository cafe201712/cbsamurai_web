<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Shop Entity
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $zip
 * @property string $pref
 * @property string $area
 * @property string $address1
 * @property string $address2
 * @property string $tel
 * @property string $fax
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Shop extends Entity
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

    protected function _getAddress()
    {
        return sprintf("%s %s %s",
            $this->_properties['pref'],
            $this->_properties['address1'],
            $this->_properties['address2']
        );
    }
}
