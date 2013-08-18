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
 * Site's Team - Join Model.
 * jointeam.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla modelform library
jimport('joomla.application.componencom.modelform');

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_bootcampleaderboards'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'bootcampleaderboardshelper.php';	

class BootcampleaderboardsModelJointeam extends JModelForm
{
	protected function populateState()
	{
		$params = JFactory::getApplication()->getParams();
		$this->setState('params', $params);
	}
	
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_bootcampleaderboards.jointeam', 'jointeam', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		
		return $form;
	}
			
	protected function loadFormData()
	{
		$data = (array)JFactory::getApplication()->getUserState('com_bootcampleaderboards.jointeam.data', array());
		return $data;
	}
			
	public function insertItem($data)
	{		
		$user = JFactory::getUser();
                $userid = $user->get('id');
                
		if ($user->guest) 
                {
			JError::raiseError(500, 'NOT_LOGGED_IN');
		}
		if (BootcampleaderboardsHelper::isUserInTeam($userid, $data['team_id']))
		{
			JError::raiseError(500, 'USER_ALREADY_IN_TEAM');
		}
		
                $db = JFactory::getDbo();		
		$comprofilerupdate = $db->getQuery(true);
		
		$comprofilerupdate->update('#__comprofiler com');
		$comprofilerupdate->set('com.cb_team_id = '.$db->quote($data['team_id']));
		$comprofilerupdate->set('com.cb_team_name = '.$db->quote($data['team_name']));
		$comprofilerupdate->set('com.cb_team_memberstate = 0  ');
		$comprofilerupdate->set('com.cb_team_joindesc = '.$db->quote($data['team_description']));
		$comprofilerupdate->set('com.cb_team_joindate = '.date("j-n-Y"));
                $comprofilerupdate->set('com.cb_team_rank = 0');
			
		$comprofilerupdate->where('com.user_id='.$userid);
		$db->setQuery($comprofilerupdate);
		
		$db->query();	
		
		if ($db->getErrorMsg()) 
		{
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		} 
		else 
		{
			return true;
		}

		if ($db->getErrorMsg()) 
		{
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		} 
		
		$params = JComponentHelper::getParams( 'com_bootcampleaderboards' );
		
		return true;		
	}
}
