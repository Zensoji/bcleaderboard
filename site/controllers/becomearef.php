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
 * Site's Become a Referee Controller.
 * becomearef.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');

class BootcampleaderboardsControllerBecomearef extends JControllerForm
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
		$model	= $this->getModel('becomearef');
		
		// Get the data from the form POST
		$data = JRequest::getVar('jform', array(), 'post', 'array');

		$app->setUserState('com_bootcampleaderboards.becomearef.data', $data);

		$user = JFactory::getUser();
		if ($user->guest) 
		{
			$this->setRedirect( JRoute::_('index.php?option=com_bootcampleaderboards&view=becomearef'),JText::_('COM_BOOTCAMPLEADERBOARDS_BECOMEAREF_SAVE_NOT_LOGGED_IN') );
			return false;
		}
		if (BootcampleaderboardsHelper::isUserAReferee($user->get('id'), $data['referee_id']))
		{
			$this->setRedirect( JRoute::_('index.php?option=com_bootcampleaderboards&view=becomearef'),JText::_('COM_BOOTCAMPLEADERBOARDS_BECOMEAREF_SAVE_USER_ALREADY_A_REFEREE') );
			return false;
		}

		$added = $model->insertItem($data);
		
		if ($added) 
		{
			$app->setUserState('com_bootcampleaderboards.becomearef.data', null);
			$this->setRedirect( JRoute::_('index.php?option=com_bootcampleaderboards&view=becomearef'),JText::_('COM_BOOTCAMPLEADERBOARDS_BECOMEAREF_SAVE_SUCCESS') );
			return true;
		}
		
		$this->setRedirect( JRoute::_('index.php?option=com_bootcampleaderboards&view=becomearef'), JText::_('COM_BOOTCAMPLEADERBOARDS_BECOMEAREF_SAVE_FAIL') );
		return false;	
	}
}
?>