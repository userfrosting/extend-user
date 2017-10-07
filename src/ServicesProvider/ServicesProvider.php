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
         * Mappings added: Member
         */
        $container->extend('classMapper', function ($classMapper, $c) {
            $classMapper->setClassMapping('user', 'UserFrosting\Sprinkle\ExtendUser\Database\Models\Member');
            return $classMapper;
        });
    }
}
