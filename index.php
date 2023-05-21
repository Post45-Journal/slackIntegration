<?php
/**
 * @file index.php
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @brief Wrapper for the Slack Integration plugin.
 *
 */
require_once('SlackIntegrationPlugin.inc.php');
return new SlackIntegrationPlugin();
