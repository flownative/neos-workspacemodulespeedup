<?php
namespace Flownative\WorkspaceModuleSpeedUp;

/*
 * This file is part of the Flownative.WorkspaceModuleSpeedUp package.
 *
 * (c) Flownative GmbH - www.flownative.com
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\Flow\Command\CacheCommandController;
use Neos\Flow\Core\Bootstrap;
use Neos\Flow\Package\Package as BasePackage;
use Neos\ContentRepository\Domain\Service\PublishingService;

/**
 * Package
 */
class Package extends BasePackage
{
    /**
     * @param Bootstrap $bootstrap The current bootstrap
     * @return void
     */
    public function boot(Bootstrap $bootstrap)
    {
        $dispatcher = $bootstrap->getSignalSlotDispatcher();
        $dispatcher->connect(PublishingService::class, 'nodePublished', WorkspaceChangesCountCacheFlusher::class, 'handleNodePublished');
        $dispatcher->connect(PublishingService::class, 'nodeDiscarded', WorkspaceChangesCountCacheFlusher::class, 'handleNodeDiscarded');
        $dispatcher->connect(CacheCommandController::class, 'warmupCaches', WorkspaceChangesCountCacheWarmUpService::class, 'warmUp');
    }
}
