<?php
/**
 * Routes for administrative user management.  Overrides routes defined in routes://admin/users.php
 */
$app->group('/admin/users', function () {
    $this->get('/u/{user_name}', 'UserFrosting\Sprinkle\ExtendUser\Controller\MemberController:pageInfo');
})->add('authGuard');