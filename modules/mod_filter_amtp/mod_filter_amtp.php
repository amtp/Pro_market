<?php
defined('_JEXEC') or die;

JLoader::register('ModFilterAmtpHelper', __DIR__ . '/helper.php');

$filter_amtp = ModFilterAmtpHelper::getFilter($params);
require JModuleHelper::getLayoutPath('mod_filter_amtp', $params->get('layout', 'default'));
