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

use TYPO3\TYPO3CR\Domain\Model\Workspace;

/**
 * WarmUpChangesCountTrait
 */
trait WarmUpChangesCountTrait
{

    /**
     * @param Workspace $workspace
     */
    public function warmUpChangesCount(Workspace $workspace)
    {
        $this->computeChangesCount($workspace);
    }
}
