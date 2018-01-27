<?php
/**
 * Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/*
 * IMPORTANT:
 * This is an example configuration file. Copy this file into your config directory and edit to
 * setup your app permissions.
 *
 * This is a quick roles-permissions implementation
 * Rules are evaluated top-down, first matching rule will apply
 * Each line define
 *      [
 *          'role' => 'role' | ['roles'] | '*'
 *          'prefix' => 'Prefix' | , (default = null)
 *          'plugin' => 'Plugin' | , (default = null)
 *          'controller' => 'Controller' | ['Controllers'] | '*',
 *          'action' => 'action' | ['actions'] | '*',
 *          'allowed' => true | false | callback (default = true)
 *      ]
 * You could use '*' to match anything
 * 'allowed' will be considered true if not defined. It allows a callable to manage complex
 * permissions, like this
 * 'allowed' => function (array $user, $role, Request $request) {}
 *
 * Example, using allowed callable to define permissions only for the owner of the Posts to edit/delete
 *
 * (remember to add the 'uses' at the top of the permissions.php file for Hash, TableRegistry and Request
   [
        'role' => ['user'],
        'controller' => ['Posts'],
        'action' => ['edit', 'delete'],
        'allowed' => function(array $user, $role, Request $request) {
            $postId = Hash::get($request->params, 'pass.0');
            $post = TableRegistry::get('Posts')->get($postId);
            $userId = Hash::get($user, 'id');
            if (!empty($post->user_id) && !empty($userId)) {
                return $post->user_id === $userId;
            }
            return false;
        }
    ],
 */

use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;

return [
    // このファイルを vendor/cakedc/users/config/permission.php からコピーして作成しないこと。
    // キーが間違っている bug がある為、ここで設定した内容が有効にならない。
    // ver 2017/09/20 現在の CakeDC/users@dev-develop
    // https://github.com/CakeDC/auth/pull/13/commits/b2696690aa9dea584069cb1b61704cf082db68f8
    //
    // 誤) 'Users.SimpleRbac.permissions' => [
    // 正) 'CakeDC/Auth.permissions' => [
    'CakeDC/Auth.permissions' => [
        /*
         * prefix 'api/v1'
         */
        // プロフィール
        [
            'role' => '*',
            'prefix' => 'api/v1',
            'controller' => 'Profile',
            'action' => ['view', 'edit', 'changePassword'],
        ],
        // キャバ嬢
        [
            'role' => '*',
            'prefix' => 'api/v1',
            'controller' => 'Casts',
            'action' => ['index', 'view'],
        ],
        [
            'role' => ['superuser', 'manager', 'user'],
            'prefix' => 'api/v1',
            'controller' => 'Casts',
            'action' => ['like', 'select'],
        ],
        // 顧客
        [
            'role' => 'cast',
            'prefix' => 'api/v1',
            'controller' => 'Guests',
            'action' => ['view', 'addTickets'],
        ],
        // ホーム
        [
            'role' => '*',
            'prefix' => 'api/v1',
            'controller' => 'Home',
            'action' => ['likedCasts', 'selectedCasts', 'likingGuests', 'selectingGuests'],
        ],
        // メッセージ
        [
            'role' => '*',
            'prefix' => 'api/v1',
            'controller' => 'Messages',
            'action' => ['index', 'add', 'unreadCount'],
        ],
        /*
         * prefix 'admin'
         */
		// ユーザー管理
        [
            'role' => 'manager',
            'prefix' => 'admin',
            'controller' => 'Users',
            'action' => ['view', 'edit', 'delete'],
            'allowed' => function (array $user, $role, \Cake\Network\Request $request) {
				// 自分が属するショップのユーザー（キャバ嬢）しか扱えない
                $user_id = Hash::get($request->getParam('pass'), 0);
                $target_user = TableRegistry::get('Users')->get($user_id);
                $shop_id = $user['shop_id'];
                if (!empty($target_user->shop_id) && !empty($shop_id)) {
                    return $target_user->shop_id === $shop_id;
                }
                return false;
            },
        ],
        [
            'role' => 'manager',
            'prefix' => 'admin',
            'controller' => 'Users',
            'action' => '*',
        ],
		// 招待状管理
        [
            'role' => ['manager', 'cast'],
            'prefix' => 'admin',
            'controller' => 'Invitations',
            'action' => ['view', 'edit', 'delete'],
            'allowed' => function (array $user, $role, \Cake\Network\Request $request) {
				// 自分が作成した招待状しか扱えない
                $invitation_id = Hash::get($request->getParam('pass'), 0);
                $invitation = TableRegistry::get('Invitations')->get($invitation_id);
				return $invitation->user_id === $user['id'];
            },
        ],
        [
            'role' => ['manager', 'cast'],
            'prefix' => 'admin',
            'controller' => 'Invitations',
            'action' => '*',
        ],
        /*
         * prefix null
         *
         * ※ prefix があるアクションでもマッチしてしまうので、注意すること
         *   prefix があるアクションに対する権限は、ここより上に記述すること
         */
        // プロフィール
        [
            'role' => ['cast', 'user'],
            'controller' => 'Profile',
            'action' => 'delete',
        ],
        [
            'role' => '*',
            'controller' => 'Profile',
            'action' => ['view', 'edit'],
        ],
		// メッセージ
        [
            'role' => ['cast', 'user'],
            'controller' => 'Messages',
            'action' => ['index'],
        ],
		// 顧客表示
        [
            'role' => 'cast',
            'controller' => 'Guests',
            'action' => ['view'],
            'allowed' => function (array $user, $role, \Cake\Network\Request $request) {
                // 自分を「いいね」している人しか表示できない
                $guest_id = Hash::get($request->getParam('pass'), 0);
                $like = TableRegistry::get('Likes')->find()->where([
                    'guest_id' => $guest_id,
                    'cast_id' => $user['id'],
                ])->first();

                return $like;
            },
        ],
		// ホーム（顧客: いいねしたキャバ嬢一覧画面, キャバ嬢: いいねされた顧客一覧画面）
        [
            'role' => '*',
            'controller' => 'Home',
            'action' => '*',
        ],
		// ログアウト
        [
            'role' => '*',
            'prefix' => 'admin',
            'controller' => 'Users',
            'action' => ['logout'],
        ],
    ]
];
