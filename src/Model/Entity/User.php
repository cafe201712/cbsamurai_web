<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use CakeDC\Users\Model\Entity\User as CakeDcUsers;
use Cake\View\Helper\UrlHelper;
use Cake\View\View;
use App\Model\Table\UsersTable;

/**
 * User Entity
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $token
 * @property \Cake\I18n\FrozenTime $token_expires
 * @property string $api_token
 * @property \Cake\I18n\FrozenTime $activation_date
 * @property string $secret
 * @property bool $secret_verified
 * @property \Cake\I18n\FrozenTime $tos_date
 * @property bool $active
 * @property bool $is_superuser
 * @property string $role
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \CakeDC\Users\Model\Entity\SocialAccount[] $social_accounts
 */
class User extends CakeDcUsers
{
    const ROLES = [
        'superuser' => 'システム管理者',
        'manager' => 'ショップ管理者',
        'cast' => 'キャバ嬢',
        'user' => 'お客様',
    ];
    const ROLE_ICONS = [    // role と bootstrap3 のアイコン class の対応表
        'superuser' => 'glyphicon-cog',
        'manager' => 'glyphicon-home',
        'cast' => 'glyphicon-heart',
        'user' => 'glyphicon-user',
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

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
        'token'
    ];

    private $icons = [
        'superuser' => 'glyphicon-cog',
        'manager' => 'glyphicon-home',
        'cast' => 'glyphicon-heart',
        'user' => 'glyphicon-user',
    ];

    protected function _getRoleIcon()
    {
        return $this->icons[$this->_properties['role']] ?? $this->icons['user'];
    }

    protected function _getPhotoPath()
    {
        return $this->photoPath();
    }

    protected function _getThumbnailPath()
    {
        return $this->thumbnailPath();
    }

    protected function _getPhotoUrl()
    {
        return $this->photoPath(true);
    }

    protected function _getThumbnailUrl()
    {
        return $this->thumbnailPath(true);
    }

    protected function _getThumbnail()
    {
        return UsersTable::PREFIX_THUMBNAIL . $this->_properties['photo'];
    }

    public function isSuperUser()
    {
        return $this->role === 'superuser';
    }

    public function isManager()
    {
        return $this->role === 'manager';
    }

    public function isCast()
    {
        return $this->role === 'cast';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    private function photoPath($url = false)
    {
        $url = new UrlHelper(new View());

        if (empty($this->_properties['photo'])) {
            return $url->image('avatar_placeholder.png', ['fullBase' => $url]);
        }
        return $url->build(sprintf("/files/Users/photo/%d/%s", $this->id, $this->_properties['photo']), $url);
    }

    private function thumbnailPath($url = false)
    {
        $url = new UrlHelper(new View());

        if (empty($this->_properties['photo'])) {
            return $url->image('avatar_placeholder.png', ['fullBase' => $url]);
        }
        return $url->build(sprintf("/files/Users/photo/%d/%s", $this->id, $this->thumbnail), $url);
    }
}
