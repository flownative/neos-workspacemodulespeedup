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

use Neos\Flow\Annotations as Flow;
use Neos\Cache\Frontend\VariableFrontend;
use Neos\Flow\Log\SystemLoggerInterface;
use Neos\Neos\Controller\Module\Management\WorkspacesController;
use Neos\ContentRepository\Domain\Model\Workspace;
use Neos\ContentRepository\Domain\Repository\WorkspaceRepository;

/**
 * @Flow\Scope("singleton")
 */
class WorkspaceChangesCountCacheWarmUpService
{
    /**
     * @var VariableFrontend
     */
    protected $contentChangesCache;

    /**
     * @Flow\Inject
     * @var SystemLoggerInterface
     */
    protected $systemLogger;

    /**
     * @Flow\Inject
     * @var WorkspaceRepository
     */
    protected $workspaceRepository;

    /**
     * @Flow\Inject
     * @var WorkspacesController
     */
    protected $workspacesController;

    /**
     * @return void
     */
    public function warmUp()
    {
        $this->systemLogger->log('Warming up change counts for workspaces.', LOG_INFO);
        foreach ($this->workspaceRepository->findAll() as $workspace) {
            /** @var Workspace $workspace */
            if ($workspace->getBaseWorkspace() !== null) {
                $this->systemLogger->log(sprintf('Calculate change counts for workspace %s ...', $workspace->getName()), LOG_DEBUG);
                $this->workspacesController->warmUpChangesCount($workspace);
            }
        }
    }
}
