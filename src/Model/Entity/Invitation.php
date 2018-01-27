<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Routing\Router;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\RendererInterface;

/**
 * Invitation Entity
 *
 * @property string $id
 * @property string $name
 * @property string $type
 * @property bool $active
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Invitation extends Entity
{
    const SIZE = 280;
    const TYPES = [
        'cast' => 'キャバ嬢',
        'user' => 'お客様',
    ];

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

    protected $_virtual = [
        'url',
    ];

    protected function _getCreatedDate()
    {
        return $this->created->format('Y/m/d');
    }

    public function _getUrl()
    {
        return Router::url("/r?i=$this->id", true);
    }

    public function isTypeCast()
    {
        return $this->type === 'cast';
    }

    public function isTypeUser()
    {
        return $this->type === 'user';
    }

    public function qrcode(RendererInterface $renderer)
    {
        $renderer->setHeight($this::SIZE)->setWidth($this::SIZE);
        $writer = new Writer($renderer);
        return $this->active ? $writer->writeString($this->url) : null;
    }
}
