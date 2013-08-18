<?php
/***************************************************************************
 * 
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
 * 
 ***************************************************************************
 * 
 * Site's Become a Referee Model.
 * becomearef.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla modelform library
jimport('joomla.application.component.modelform');

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_bootcampleaderboards'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'bootcampleaderboardshelper.php';	

class SquadManagementModelBecomearef extends JModelForm
{
	protected function populateState()
	{		
		$params = JFactory::getApplication()->getParams();
		$this->setState('params', $params);
	}
	
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_bootcampleaderboards.becomearef', 'becomearef', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		
		return $form;
	}
			
	protected function loadFormData()
	{
		$data = (array)JFactory::getApplication()->getUserState('com_bootcampleaderboards.becomearef.data', array());
		return $data;
	}
			
	public function insertItem($data)
	{		
		$user = JFactory::getUser();
                $userid = $user->get('id');
                $username = $user->get('username');
                $db = JFactory::getDbo();
                
                $query = "SELECT * FROM #__bootcamp_leaderboards_referees WHERE referee_user_id='.$userid.'";
                $isreferee = $db->setQuery($query);
                 
		if ($user->guest) {
			JError::raiseError(500, 'NOT_LOGGED_IN');
		}
		if ($isreferee=!NULL)
		{
			JError::raiseError(500, 'USER_ALREADY_A_REFEREE');
		}
		
		// set the data into a query to update the record
		
		$becomearef =new stdClass();
		$becomearef->referee_id = NULL;
		$becomearef->referee_user_id = $userid;
                $becomearef->referee_user_name = $username;
		$becomearef->referee_state = 0;
		$becomearef->referee_description = $data['referee_description'];
		$becomearef->referee_published = 0;

		$db->insertObject('#__bootcamp_leaderboards_referees', $becomearef);
		
		if ($db->getErrorMsg()) 
		{
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		} 
		
		$params = JComponentHelper::getParams( 'com_bootcampleaderboards ' );
		
		return true;		
	}
}
