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

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Aop\JoinPointInterface;
use TYPO3\Flow\Cache\Frontend\VariableFrontend;

/**
 * @Flow\Aspect
 * @Flow\Introduce("class(TYPO3\Neos\Controller\Module\Management\WorkspacesController)", traitName="Flownative\WorkspaceModuleSpeedUp\WarmUpChangesCountTrait")
 * @Flow\Scope("singleton")
 */
class WorkspacesControllerCachingAspect
{
    /**
     * @var VariableFrontend
     */
    protected $contentChangesCache;

    /**
     * @param JoinPointInterface $joinPoint
     * @Flow\Around("method(TYPO3\Neos\Controller\Module\Management\WorkspacesController->computeChangesCount(.*))")
     * @return array
     */
    public function computeChangesCountCacheAdvice(JoinPointInterface $joinPoint)
    {
        $selectedWorkspace = $joinPoint->getMethodArgument('selectedWorkspace');
        $changesCount = $this->contentChangesCache->get($selectedWorkspace->getName() . '-count');
        if ($changesCount === false) {
            $changesCount = $joinPoint->getAdviceChain()->proceed($joinPoint);
            $this->contentChangesCache->set($selectedWorkspace->getName() . '-count', $changesCount);
        }
        return $changesCount;
    }
}
