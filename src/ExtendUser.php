<?php
/**
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2013-2016 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/licenses/UserFrosting.md (MIT License)
 */
namespace UserFrosting\Sprinkle\ExtendUser;

use UserFrosting\Sprinkle\ExtendUser\ServicesProvider\ServicesProvider;
use UserFrosting\Sprinkle\Core\Initialize\Sprinkle;

/**
 * Bootstrapper class for the 'extend-user' sprinkle.
 *
 * @author Alex Weissman (https://alexanderweissman.com)
 */
class ExtendUser extends Sprinkle
{
    /**
     * Register services.
     */
    public function init()
    {
        $serviceProvider = new ServicesProvider();
        $serviceProvider->register($this->ci);
    }
}
