<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;
use Cake\Http\Middleware\CsrfProtectionMiddleware;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

// API 用のスコープ（CSRF プロテクションをかけない）
Router::scope('/', function (RouteBuilder $routes) {
    $routes->setExtensions(['json']);   // JSON ファイル拡張子を許可

    // API のルート
    $routes->prefix('api', function (RouteBuilder $routes) {
        $routes->setExtensions(['json']);   // JSON ファイル拡張子を許可

        $routes->prefix('v1', function (RouteBuilder $routes) {
            $routes->post('/login', ['controller' => 'Users', 'action' => 'login']);

            $routes->get('/profile', ['controller' => 'Profile', 'action' => 'view']);
            $routes->patch('/profile', ['controller' => 'Profile', 'action' => 'edit']);
            $routes->patch('/profile/change-password', ['controller' => 'Profile', 'action' => 'changePassword']);

            $routes->get('/home/liked-casts', ['controller' => 'Home', 'action' => 'likedCasts']);
            $routes->get('/home/selected-casts', ['controller' => 'Home', 'action' => 'selectedCasts']);
            $routes->get('/home/liking-guests', ['controller' => 'Home', 'action' => 'likingGuests']);
            $routes->get('/home/selecting-guests', ['controller' => 'Home', 'action' => 'selectingGuests']);

            $routes->get('/messages/:user_id', ['controller' => 'Messages', 'action' => 'index'])
                ->setPatterns(['user_id' => '\d+'])->setPass(['user_id']);
            $routes->post('/messages', ['controller' => 'Messages', 'action' => 'add']);
            $routes->get('/messages/unread-count', ['controller' => 'Messages', 'action' => 'unreadCount']);

            $routes->get('/casts', ['controller' => 'Casts', 'action' => 'index']);
            $routes->get('/casts/:id', ['controller' => 'Casts', 'action' => 'view'])
                ->setPatterns(['id' => '\d+'])->setPass(['id']);
            $routes->post('/casts/like/:id', ['controller' => 'Casts', 'action' => 'like'])
                ->setPatterns(['id' => '\d+'])->setPass(['id']);
            $routes->post('/casts/select/:id', ['controller' => 'Casts', 'action' => 'select'])
                ->setPatterns(['id' => '\d+'])->setPass(['id']);

            $routes->get('/guests/:id', ['controller' => 'Guests', 'action' => 'view'])
                ->setPatterns(['id' => '\d+'])->setPass(['id']);
            $routes->patch('/guests/add_tickets/:id', ['controller' => 'Guests', 'action' => 'addTickets'])
                ->setPatterns(['id' => '\d+'])->setPass(['id']);
        });
    });
});

Router::scope('/', function (RouteBuilder $routes) {
    // Middleware
    $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware());    // CSRF プロテクション
    $routes->applyMiddleware('csrf');

    // バックエンド（管理画面）のルート
    $routes->prefix('admin', function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class); // catch all（コントローラ名とアクションを補完してディスパッチ）
    });

    // フロントのルート
    $routes->get('/', ['controller' => 'Pages', 'action' => 'display', 'top']); // トップページ
    $routes->get('/home', ['controller' => 'Home', 'action' => 'index']);       // ホームページ
    $routes->get('/pages/*', ['controller' => 'Pages', 'action' => 'display']); // 静的ページ

    $routes->connect('/register', ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'register']);
    $routes->connect('/r', ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'register']); // 招待状ようの短い URL
    $routes->connect('/change-password', ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'changePassword']);
    $routes->connect('/request-reset-password', ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'requestResetPassword']);
    $routes->connect('/resend-validation-email', ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'resendValidationEmail']);
    $routes->connect('/login', ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'login']);
    $routes->connect('/logout', ['prefix' => 'admin', 'controller' => 'Users', 'action' => 'logout']);

    $routes->get('/profile', ['controller' => 'Profile', 'action' => 'view']);
    $routes->connect('/profile/edit', ['controller' => 'Profile', 'action' => 'edit'])->setMethods(['PUT', 'PATCH']);
    $routes->delete('/profile', ['controller' => 'Profile', 'action' => 'delete']);

    $routes->connect('/messages/:user_id', ['controller' => 'Messages', 'action' => 'index'])    // メッセージ一覧
        ->setMethods(['GET', 'POST'])
        ->setPatterns(['user_id' => '\d+'])
        ->setPass(['user_id']);

    $routes->fallbacks(DashedRoute::class); // catch all（コントローラ名とアクションを補完してディスパッチ）
});

/**
 * Load all plugin routes. See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
