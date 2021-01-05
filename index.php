<?php
/**
 * @package    Joomla.Site
 *
 * @copyright  Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Define the application's minimum supported PHP version as a constant so it can be referenced within the application.
 */
define('JOOMLA_MINIMUM_PHP', '5.3.10');

if (version_compare(PHP_VERSION, JOOMLA_MINIMUM_PHP, '<'))
{
	die('Your host needs to use PHP ' . JOOMLA_MINIMUM_PHP . ' or higher to run this version of Joomla!');
}

// Saves the start time and memory usage.
$startTime = microtime(1);
$startMem  = memory_get_usage();
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/medoo/Medoo.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/modules/medoo/catalog_models.php');
use Medoo\Medoo;
$database = new Medoo([
    // Started using customized DSN connection
    'dsn' => [
        // The PDO driver name for DSN driver parameter
        'driver' => 'sqlsrv',
        // The parameters with key and value for DSN
        'server' => '192.168.1.170',

    ],
    // [optional] Medoo will have different handle method according to different database type
    'database_type' => 'mssql',
    'database_name' => '516516_General_Data',
    'username' => 'bak',
    'password' => 'gorec'
]);
/**
 * Constant that is checked in included files to prevent direct access.
 * define() is used in the installation folder rather than "const" to not error for PHP 5.2 and lower
 */
define('_JEXEC', 1);

if (file_exists(__DIR__ . '/defines.php'))
{
	include_once __DIR__ . '/defines.php';
}

if (!defined('_JDEFINES'))
{
	define('JPATH_BASE', __DIR__);
	require_once JPATH_BASE . '/includes/defines.php';
}

require_once JPATH_BASE . '/includes/framework.php';

// Set profiler start time and memory usage and mark afterLoad in the profiler.
JDEBUG ? JProfiler::getInstance('Application')->setStart($startTime, $startMem)->mark('afterLoad') : null;

if(!class_exists('Mobile_Detect'))require_once (JPATH_BASE.'/includes/Mobile_Detect.php');

$detect = new Mobile_Detect;
$ismobl = 0;
if ($detect->isMobile()) $ismobl = 1;
JFactory::$ismobile=$ismobl;
// Instantiate the application.
$app = JFactory::getApplication('site');

// Execute the application.
$app->execute();
