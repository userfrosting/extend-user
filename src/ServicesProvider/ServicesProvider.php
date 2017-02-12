<?php
/**
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2013-2016 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/licenses/UserFrosting.md (MIT License)
 */
namespace UserFrosting\Sprinkle\ExtendUser\ServicesProvider;

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;

/**
 *
 * @author Alex Weissman (https://alexanderweissman.com)
 */
class ServicesProvider
{
    /**
     * Register extended user fields services.
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
            $classMapper->setClassMapping('user', 'UserFrosting\Sprinkle\ExtendUser\Model\OwlerUser');
            return $classMapper;
        });
        
        /**
         * Initialize Eloquent Capsule, which provides the database layer for UF.
         *
         * @todo construct the individual objects rather than using the facade
         */
        $container['db'] = function ($c) {
            $config = $c->config;

            $capsule = new Capsule;

            foreach ($config['db'] as $name => $dbConfig) {
                $capsule->addConnection($dbConfig, $name);
            }

            $capsule->setEventDispatcher(new Dispatcher(new Container));

            // Register as global connection
            $capsule->setAsGlobal();

            // Start Eloquent
            $capsule->bootEloquent();

            return $capsule;
        };
    }
}
