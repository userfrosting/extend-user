<?php
/**
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2013-2016 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/licenses/UserFrosting.md (MIT License)
 */
namespace UserFrosting\Sprinkle\Site;

use UserFrosting\Sprinkle\Site\ServicesProvider\SiteServicesProvider;
use UserFrosting\Sprinkle\Core\Initialize\Sprinkle;

/**
 * Bootstrapper class for the 'site' sprinkle.
 *
 * @author Alex Weissman (https://alexanderweissman.com)
 */
class Site extends Sprinkle
{
    /**
     * Register Site services.
     */
    public function init()
    {
        $serviceProvider = new SiteServicesProvider();
        $serviceProvider->register($this->ci);
    }
}
