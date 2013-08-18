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
 * Site's Team - Create Model.
 * createteam.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modelform');

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_bootcampleaderboards'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'bootcampleaderboardshelper.php';

class BootcampleaderboardsModelCreateteam extends JModelForm
{
	public function getTable($type = 'Team', $prefix = 'BootcampleaderboardsTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_bootcampleaderboards.createteam', 'createteam', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}

	protected function loadFormData() 
	{
		$data = (array)JFactory::getApplication()->getUserState('com_bootcampleaderboards.createteam.data', array());
		return $data;
	}
	
	public function insertItem($data)
	{
		$user = JFactory::getUser();
                $userid = $user->get('id');
                $username = $user->get('username');
                $db = JFactory::getDbo();
                
                $query = "SELECT * FROM #__comprofiler WHERE user_id='.$userid.'";
                $userinfo = $db->setQuery($query);
                 
		if ($user->guest) {
			JError::raiseError(500, 'NOT_LOGGED_IN');
		}
		if ($userinfo['cb_team']!=NULL)
		{
			JError::raiseError(500, 'USER_ALREADY_IN_A_TEAM');
		}
		
		// set the data into a query to update the record
		
		$createateam = new stdClass();
                
		$createateam->team_id           =   NULL;
		$createateam->team_name         =   $data['team_name'];
                $createateam->team_short_name   =   $data['team_short_name'];
		$createateam->team_class        =   $data['team_class'];
		$createateam->team_founder      =   $userid;
                $createateam->team_fleet        =   $data['team_fleet'];
                $createateam->team_fleet_name   =   $data['team_fleet_name'];
                $createateam->team_description  =   $data['team_description'];
                $createateam->team_recruiting   =   $data['team_recruiting'];
		$createateam->team_published    =   0;

		$db->insertObject('#__bootcamp_leaderboards_teams', $createateam);
                
                $teamforcom = $db->query("SELECT team_id FROM #__bootcamp_leaderboards_teams WHERE team_name=".$db->quote($data['team_name'])." AND team_founder=".$db->quote($userid));
                
                $db = JFactory::getDbo();		
		$comprofilerupdate = $db->getQuery(true);
		
		$comprofilerupdate->update('#__comprofiler com');
		$comprofilerupdate->set('com.cb_team_id = '.$db->quote($teamforcom));
		$comprofilerupdate->set('com.cb_team_name = '.$db->quote($data['team_name']));
		$comprofilerupdate->set('com.cb_team_memberstate = 2');
		$comprofilerupdate->set('com.cb_team_joindesc = "Team Founder"');
		$comprofilerupdate->set('com.cb_team_joindate = '.date("j-n-Y"));
                $comprofilerupdate->set('com.cb_team_rank = 4');
			
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
		
		$params = JComponentHelper::getParams('com_bootcampleaderboards');
		
		return true;
	}
}

?>