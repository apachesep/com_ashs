<?php
/**
 * @version     1.0
 * @package     Advanced Search Manager for Hikashop
 * @copyright   Copyright (C) 2016 JoomDev. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      JoomDev <info@joomdev.com> - http://www.joomdev.com/
 */

// no direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_ashs')) 
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

$controller	= JControllerLegacy::getInstance('Ashs');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
