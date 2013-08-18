<?php
/**
 * PvP Boot Camp Leaderboards Component
 * @comname         com_bootcampleaderboards
 * @package         Bootcampleaderboards.Site
 * @subpackage      Views
 *
 * @copyright       (C) Copyright 2013 PvP Boot Camp. All rights reserved.
 * @license         http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link            http://www.pvp-boot-camp.com
 * @author          Alex Armstrong
 *                  Lynton Steyn
 * @author-email    zensoji@pvp-boot-camp.com
 *                  drkfrontiers@pvp-boot-camp.com
 **/

/**
 * Site's Team Admin View
 * view.html.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

class BootcampleaderboardsViewTeamAdmin extends JView
{
	function display($tpl = null) 
	{
		// Set the toolbar
		$this->addToolBar();
                $templateName = JRequest::getVar( 'teamadmintemplate', '', 'default', 'string' );

		$model = $this->getModel();
                
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		$this->assignRef('templateName',$templateName);
		$this->assignRef('item',$item);
		
		$params = &$state->params;
		$this->assignRef('params',$params);

		// Display the template
		parent::display($tpl);
	}

	protected function addToolBar() 
	{
		JToolBarHelper::title(JText::_('COM_BOOTCAMPLEADERBOARDS_MANAGER_TEAMADMIN'),'teamadmin');		
		JToolBarHelper::divider();
		JToolBarHelper::preferences('com_bootcampleaderboards',400,650);
	}
}
