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
 * Site's Challenge A Team Model.
 * challengeteam.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla modelform library
jimport('joomla.application.component.modelform');

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_bootcampleaderboards'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'bootcampleaderboardshelper.php';	

class BootcampleaderboardsModelChallengeteam extends JModelForm
{
	protected function populateState()
	{		
		$params = JFactory::getApplication()->getParams();
		$this->setState('params', $params);
	}
	
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_bootcampleaderboards.challengeteam', 'challengeteam', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		
		return $form;
	}
	
	protected function loadFormData()
	{
		$data = (array)JFactory::getApplication()->getUserState('com_bootcampleaderboards.challengeteam.data', array());
		return $data;
	}
	
	public function getOpponentList($namepart, $data)
	{
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__bootcamp_leaderboards_teams WHERE team_published = 1 AND team_name like '%".$namepart."%' AND team_name != '.$data->team_name.' order by team_name";
		
		$db->setQuery($query,0,10); 
		return $db->loadObjectList();
	}
	
	public function insertItem($data)
	{			
		// set the data into a query to update the record
		$db	= JFactory::getDBO();
		
		// try to find the opponent
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__bootcamp_leaderboards_teams');
		$query->where('team_name='.$db->Quote($data['opponent_team_name']));
		$db->setQuery($query);
		$opponentInfo = $db->loadObject();
                
                $query->select('*');
		$query->from('#__bootcamp_leaderboards_teams');
		$query->where('team_name='.$db->Quote($data['team_name']));
		$db->setQuery($query);
		$teamInfo = $db->loadObject();
		
		$challenge =new stdClass();
		$challenge->match_id = NULL;
                $challenge->match_name = $data['team_name'].' vs. '.$opponentInfo['team_name'];
                $challenge->match_leaderboard_id  = $data['leaderboard_id'];
		$challenge->match_date = $data['challenge_date'];
		$challenge->match_state = 2;
		$challenge->match_description = $data['challenge_description'];
		$challenge->match_team1_id = $teamInfo['team_id'];
                $challenge->match_team1_name = $teamInfo['team_name'];
                $challenge->match_team1_logo = $teamInfo['team_logo'];
                $challenge->match_team2_id = $opponentInfo['team_id'];
                $challenge->match_team2_name = $opponentInfo['team_name'];
                $challenge->match_team2_logo = $opponentInfo['team_logo'];
		$challenge->match_published = 0;

		$db = JFactory::getDBO();
		$db->insertObject('#__bootcamp_leaderboards_matches', $challenge);
		
		if ($db->getErrorMsg()) 
		{
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		}
                
                $db = JFactory::getDbo();
                $url1query  = "SELECT match_id FROM #__bootcampleaderboards_matches WHERE match_name='.$challenge->match_name.' AND match_date='.$challenge->match_date.' AND match_description='.$challenge->match_description.'";
		$urlpart = $db->setQuery($url1query);
                $urlfull = JUri::root().'index.php?option=com_bootcampleaderboards&view=match&id='.$urlpart;
                $url2query = "UPDATE #__bootcamp_leaderboards_matches SET match_url='.$urlfull.' WHERE match_id='.$urlpart.'";
                
                $db = JFactory::getDbo();
                $db->query($url2query);
                
                if ($db->getErrorMsg())
                {
                    JError::raiseError(500, $db->getErrorMsg());
                    return false;
                }
                
		$params = JComponentHelper::getParams( 'com_bootcampleaderboards' ); 
		
		return true;
	}
}
