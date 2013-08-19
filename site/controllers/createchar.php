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
 * Site's Create a Character Controller.
 * createchar.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');

class BootcampleaderboardsControllerCreatechar extends JControllerForm
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
		$model	= $this->getModel('createchar');
		
		// Get the data from the form POST
		$data = JRequest::getVar('jform', array(), 'post', 'array');

		$form = $model->getForm();
		if (!$form) {
			JError::raiseError(500, $model->getError());
			return false;
		}
		$validate = $model->validate($form, $data);

		if ($validate === false) {
			// Get the validation messages.
			$errors	= $model->getErrors();
			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if ($errors[$i] instanceof Exception) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				} else {
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			// Save the data in the session.
			$app->setUserState('com_bootcampleaderboards.createchar.data', $data);

			$this->setRedirect(JRoute::_('index.php?option=com_bootcampleaderboards&view=createchar', false));
			return false;
		}

		$added = $model->insertItem($data);
		
		if ($added) 
		{
			$this->setRedirect( JRoute::_('index.php?option=com_bootcampleaderboards&view=createchar'),JText::_('COM_BOOTCAMPLEADERBOARDS_CREATECHAR_SAVE_SUCCESS'));
		} 
		else
		{
			$app->setUserState('com_bootcampleaderboards.createchar.data', $data);
			$this->setRedirect( 'index.php?option=com_bootcampleaderboards&view=createchar&task=failed',false );
			return false;
		}
		
		// Flush the data from the session
		$app->setUserState('com_bootcampleaderboards.createchar.data', null);
		
		return true;
	}
}
?>