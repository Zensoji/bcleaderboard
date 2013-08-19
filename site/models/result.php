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
 * Site's Report A Result Model.
 * result.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla modelform library
jimport('joomla.application.component.modelform');

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_bootcampleaderboards'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'bootcampleaderboardshelper.php';	

class BootcampleaderboardsModelResult extends JModelForm
{
	protected function populateState()
	{		
		$params = JFactory::getApplication()->getParams();
		$this->setState('params', $params);
	}
	
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_bootcampleaderboards.result', 'result', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		
		return $form;
	}
	
	protected function loadFormData()
	{
		$data = (array)JFactory::getApplication()->getUserState('com_bootcampleaderboards.result.data', array());
		return $data;
	}
        
        public function getLeaderboardList($namepartleaderboard,$data)
        {
            $db = JFactory::getDbo();
            $query = "SELECT * FROM #__bootcamp_leaderboards WHERE leaderboard_published = 1 AND leaderboard_name like '%".$namepartleaderboard."%' ORDER BY leaderboard_name";
            
            $db->setQuery($query,0,10);
            return $db->loadObjectList();
            
            $leaderboard  = $data['leaderboard_id'];
        }
        
        public function getMatchList($namepartmatch,$leaderboard)
        {
            $db = JFactory::getDbo();
            
            $query = "SELECT * FROM #__bootcamp_leaderboards_matches WHERE match_published = 1 AND match_leaderboard_id = '.$db->Quote($leaderboard).' AND match_name like '%".$namepartmatch."%' ORDER BY match_name";
            
            $db->setQuery($query,0,10);
            return $db->loadObjectList();
            
            $team1 = $data['match_team1_id'];
            $team2 = $data['match_team2_id'];
        }
	
	public function getTeamList($namepartteam,$team1,$team2)
	{
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__bootcamp_leaderboards_teams WHERE team_published = 1 AND team_name like '%".$namepartteam."%' AND team_name = '.$team1.' OR team_name = '.$team2.' order by team_name";
		
		$db->setQuery($query,0,10); 
		return $db->loadObjectList();
	}
        
        public function getMemberList($namepartmember,$data)
        {
            $db = JFactory::getDbo();
            $team = $data['team_id'];
            
            $query = "SELECT * FROM #__comprofiler WHERE cb_team_id='.$team.' AND cb_team_memberstate != 0 ORDER BY username";
            
            $db->setQuery($query,0,10);
            return $db->loadObjectList();
        }
	
	public function insertItem($data)
	{			
		// set the data into a query to update the record
		$db	= JFactory::getDBO();
                
                $user = JFactory::getUser();
                $userid = $user->get('id');
		
		// try to find the leaderboard
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__bootcamp_leaderboards');
		$query->where('leaderboard_name='.$db->Quote($data['leaderboard_name']));
		$db->setQuery($query);
		$leaderboardInfo = $db->loadObject();
                
                // try to find the match
                $query->select('*');
		$query->from('#__bootcamp_leaderboards_matches');
		$query->where('match_id='.$db->Quote($data['match_id']));
		$db->setQuery($query);
		$matchInfo = $db->loadObject();
                
                // try to find the team
                $query->select('*');
		$query->from('#__bootcamp_leaderboards_teams');
		$query->where('team_id='.$db->Quote($data['team_id']));
		$db->setQuery($query);
		$teamInfo = $db->loadObject();
                
                // try to find the team member
                $query->select('*');
		$query->from('#__comprofiler');
		$query->where('user_id='.$db->Quote($data['user_id']));
		$db->setQuery($query);
		$userInfo = $db->loadObject();
		
                //create and fill a new stdclass with the 
                //form info ready to be sent to the DB
		$results =new stdClass();
		$results->result_id = NULL;
                $results->result_name = $matchInfo['match_name'];
                $results->result_leaderboard = $leaderboardInfo['leaderboard_id'];
		$results->result_date = date("j-n-Y");
		$results->result_team = $teamInfo['team_id'];
		$results->result_team_member = $userInfo['user_id'];
		$results->result_match = $matchInfo['match_id'];
                $results->result_damage = $data['damage'];
                $results->result_healing = $data['healing'];
                $results->result_kills = $data['kills'];
                $results->result_deaths = $data['deaths'];
                $results->result_points = $data['points'];
		$results->result_createdby = $userid;

                //get DB Object to initialize DB Connection
		$db = JFactory::getDBO();
                //insert the new record into the table
		$db->insertObject('#__bootcamp_leaderboards_results', $results);
                
                class matchresults 
                {
                    public $match_id;
                    public $match_result_screenshot;
                    public $match_notes;
                    public $match_issues;
                    public $match_state;
                }
                class comprofilerstuff
                {
                    public $user_id;
                    public $cb_tm_points;
                    public $cb_lt_points;
                }
		
                $matchresults = new matchresults();
                $matchresults->match_id = $matchInfo['match_id'];
                $matchresults->match_notes = $data['result_notes'];
                $matchresults->match_issues = $data['result_issues'];
                $matchresults->match_result_screenshot = $data['result_screenshot'];
                $matchresults->match_state = $data['result_matchstate'];
                
                //assign the user id to a variable
                $resultuser  = $userInfo['user_id'];
                
                //get current points earned this month from the Community Builder Table
                $query = "SELECT cb_tm_points FROM #__comprofiler WHERE user_id=".$resultuser;
                
                //assigns those points to a new variable
                $currenttmpts = $db->setQuery($query);
                //adds current value to the existing value as a new variable
                $totaltmpts = $currenttmpts + $data['points'];
                
                //get current points earned over the user's lifetime from the Community Builder Table
                $query = "SELECT cb_lt_points FROM #__comprofiler WHERE user_id=".$resultuser;
                
                //assigns these points to a new variable
                $currentltpts = $db->setQuery($query);
                //adds current value to the existing value as a new variable
                $totalltpts = $currentltpts + $data['points'];
                
                $comprofilerstuff = new comprofilerstuff();
                $comprofilerstuff->user_id      = $resultuser;
                $comprofilerstuff->cb_lt_points = $totalltpts;
                $comprofilerstuff->cb_tm_points = $totaltmpts;
                
                $db->updateObject('#__bootcamp_leaderboards_matches', $matchresults, 'match_id', true);
                $db->updateObject('#__comprofiler', $comprofilerstuff, 'user_id', false);
                
		if ($db->getErrorMsg()) 
		{
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		}
                
                
                
                
                //update the Community Builder Table with the new values
                $query = "  UPDATE #_comprofiler 
                            SET cb_tm_points ='.$totaltmpts.'
                            SET cb_lt_points ='.$totalltpts.'
                            WHERE user_id='.$resultuser.'";
                
                
                if ($db->getErrorMsg())
                {
                    JError::raiseError(500, $db->getErrorMsg());
                    return false;
                }
                
		$params = JComponentHelper::getParams( 'com_bootcampleaderboards' ); 
		
		return true;
	}
}
