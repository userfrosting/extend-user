<?php
/**
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2013-2016 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/licenses/UserFrosting.md (MIT License)
 */

/**
 * Routes for administrative user management.  Overrides routes defined in routes://admin/users.php
 */
$app->group('/admin/users', function () {
    $this->get('/u/{user_name}', 'UserFrosting\Sprinkle\Site\Controller\OwlerController:pageInfo');
})->add('authGuard');

$app->group('/api/users', function () {
    $this->get('', 'UserFrosting\Sprinkle\Site\Controller\OwlerController:getList');
});
