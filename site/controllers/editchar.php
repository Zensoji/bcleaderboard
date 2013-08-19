<?php
/***************************************************************************
 * 
 * PvP Boot Camp Leaderboards Component
 * @comname         com_bootcampleaderboards
 * @package         Bootcampleaderboards.Site
 * @subpackage      Framework
 *
 * @copyright       (C) Copyright 2013 PvP Boot Camp. All rights reserved.
 * @license         http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link            http://www.pvp-boot-camp.com
 * @author          Alex Armstrong
 *                  Lynton Steyn
 * @author-email    zensoji@pvp-boot-camp.com
 *                  drkfrontiers@pvp-boot-camp.com
 * 
 ***************************************************************************
 * 
 * Site's Edit Character Controller.
 * editchar.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');

class BootcampleaderboardsControllerEditchar extends JControllerForm
{
	public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, array('ignore_request' => false));
	}
	
	public function submit()
	{
		// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		// Initialise variables.
		$app	= JFactory::getApplication();
		$model	= $this->getModel('editchar');
		
		// Get the data from the form POST
		$data = JRequest::getVar('jform', array(), 'post', 'array');

		$added = $model->updateItem($data);
		
		if ($added) 
		{
			$this->setRedirect( JRoute::_('index.php?option=com_bootcampleaderboards&view=editchar&char_id='. $data['char_id']),JText::_('COM_BOOTCAMPLEADERBOARDS_FIELD_EDITCHAR_SAVE_SUCCESS') );
			return true;
		} 
		
		$this->setRedirect( JRoute::_('index.php?option=com_bootcampleaderboards&view=editchar&char_id='. $data['char_id']),JText::_('COM_BOOTCAMPLEADERBOARDS_FIELD_EDITCHAR_SAVE_FAIL') );
		return false;		
	}
}
?>