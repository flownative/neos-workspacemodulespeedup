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
use TYPO3\Flow\Cache\Frontend\VariableFrontend;
use TYPO3\Flow\Log\SystemLoggerInterface;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;
use TYPO3\TYPO3CR\Domain\Model\Workspace;

/**
 * @Flow\Scope("singleton")
 */
class WorkspaceChangesCountCacheFlusher
{
    /**
     * @var VariableFrontend
     */
    protected $contentChangesCache;

    /**
     * @var array
     */
    protected $changedWorkspaceNames = [];

    /**
     * @Flow\Inject
     * @var SystemLoggerInterface
     */
    protected $systemLogger;

    /**
     * @param NodeInterface $node
     * @param Workspace|null $targetWorkspace
     */
    public function handleNodePublished(NodeInterface $node, Workspace $targetWorkspace = null)
    {
        $this->changedWorkspaceNames[$node->getWorkspace()->getName()] = true;

        $targetWorkspace = ($targetWorkspace !== null ? $targetWorkspace : $node->getWorkspace()->getBaseWorkspace());
        if ($targetWorkspace instanceof Workspace && $targetWorkspace->getBaseWorkspace() !== null) {
            $this->changedWorkspaceNames[$targetWorkspace->getName()] = true;
        }
    }

    /**
     * @param NodeInterface $node
     */
    public function handleNodeDiscarded(NodeInterface $node)
    {
        $this->changedWorkspaceNames[$node->getWorkspace()->getName()] = true;
    }

    /**
     * @return void
     */
    public function shutdownObject()
    {
        foreach (array_keys($this->changedWorkspaceNames) as $workspaceName) {
            $this->contentChangesCache->remove($workspaceName . '-count');
            $this->systemLogger->log(sprintf('Flushed count cache for workspace %s', $workspaceName), LOG_DEBUG);
        }
    }
}
