# Flownative.WorkspaceModuleSpeedUp

This package introduces a caching mechanism for the Neos workspace module which improves performance
for projects with many workspace and / or pending changes. The implementation overrides functionality
of the Neos core via AOP and thus is only a preliminary solution until a similar mechanism has been
added to the official Neos releases.

## Installation

    composer require 'flownative/workspacemodulespeedup:*@dev'
