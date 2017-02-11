<?php
/**
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2013-2016 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/licenses/UserFrosting.md (MIT License)
 */
namespace UserFrosting\Sprinkle\Site\ServicesProvider;

use Birke\Rememberme\Authenticator as RememberMe;
use Illuminate\Database\Capsule\Manager as Capsule;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Authenticate\AuthGuard;
use UserFrosting\Sprinkle\Account\Authorize\AuthorizationManager;
use UserFrosting\Sprinkle\Account\Log\UserActivityDatabaseHandler;
use UserFrosting\Sprinkle\Account\Log\UserActivityProcessor;
use UserFrosting\Sprinkle\Account\Model\User;
use UserFrosting\Sprinkle\Account\Repository\PasswordResetRepository;
use UserFrosting\Sprinkle\Account\Repository\VerificationRepository;
use UserFrosting\Sprinkle\Account\Twig\AccountExtension;
use UserFrosting\Sprinkle\Core\Facades\Debug;
use UserFrosting\Sprinkle\Core\Log\MixedFormatter;

/**
 *
 * @author Alex Weissman (https://alexanderweissman.com)
 */
class SiteServicesProvider
{
    /**
     * Register UserFrosting's test site services.
     *
     * @param Container $container A DI container implementing ArrayAccess and container-interop.
     */
    public function register($container)
    {
        /**
         * Extend the 'classMapper' service to register model classes.
         *
         * Mappings added: OwlerUser
         */
        $container->extend('classMapper', function ($classMapper, $c) {
            $classMapper->setClassMapping('user', 'UserFrosting\Sprinkle\Site\Model\OwlerUser');
            return $classMapper;
        });
    }
}
