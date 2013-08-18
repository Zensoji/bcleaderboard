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
 * Site's Edit Team View.
 * view.html.php 
 **/

// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

class BootcampleaderboardsViewEditteam extends JView
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		$id = JRequest::getVar( 'id', '', 'default', 'int' );
		
		$form = $this->get('Form');
		$this->form = $form;
		
		$model = $this->getModel(); 
		$this->item = $model->getData($id);
		$this->assignRef('item',$this->item);

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		$params = JComponentHelper::getParams( 'com_bootcampleaderboards' ); 
		$this->assignRef('params',$params);		
		
		$user = JFactory::getUser();
		$userid = $user->get('id');
		if ($userid != $this->item->team_leader)
		{			
			parent::display('noaccess');
			return false;
		}
		// Display the view
		parent::display($tpl);
	}
}
