<?php

// In /app/sprinkles/site/src/ServicesProvider/ServicesProvider.php

namespace UserFrosting\Sprinkle\ExtendUser\ServicesProvider;

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
         * Mappings added: MemberUser
         */
        $container->extend('classMapper', function ($classMapper, $c) {
            $classMapper->setClassMapping('member', 'UserFrosting\Sprinkle\ExtendUser\Database\Models\Member');
            $classMapper->setClassMapping('user', 'UserFrosting\Sprinkle\ExtendUser\Database\Models\MemberUser');
            return $classMapper;
        });
    }
}