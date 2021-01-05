<?php
defined('_JEXEC') or die;

/**
 * Mylib plugin class.
 *
 * @package     Joomla.plugin
 * @subpackage  System.mylib
 */
class plgSystemMdata extends JPlugin
{
    /**
     * Method to register custom library.
     *
     * return  void
     */
    public function onAfterInitialise()
    {
     //   JLoader::registerPrefix('Mdata', JPATH_LIBRARIES . '/mdata');
    }
}