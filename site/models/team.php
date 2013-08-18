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
 * Site's Team Model.
 * team.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modelitem');

class BootcampleaderboardsModelTeam extends JModelItem
{
	protected $_data;

	public function getTable($type = 'Team', $prefix = 'BootcampleaderboardsTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function &getData($team_id)
	{
		if (empty( $this->_data )) {
			
			$query = ' SELECT * from #__bootcamp_leaderboards_teams t '.
				'  WHERE t.team_id = '.$team_id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
                
                $this->_data->TeamMembers = $this->getTeamMembers($team_id);
                $this->_data->TeamAwards = $this->getTeamAwards($team_id);
                $this->_data->TeamMatches = $this->getTeamMatches($team_id);
		
		return $this->_data;
	}
        
        function getTeamMembers($team_id)
        {
            $query =  "SELECT me.username, me.cb_handle, me.avatar, me.cb_team_memberstate, me.cb_team_join_date, me.cb_team_staff_rank";
            $query .= " FROM #__comprofiler me";
            $query .= " WHERE me.cb_team_id='.$team_id.'";
            $query .= " ORDER BY me.cb_team_staff_rank DESC";
            
            $db = $this->getDbo();
		
            $db->setQuery($query); 
            return $db->loadObjectList();
        }
        
        function getTeamAwards($team_id)
        {
            $query =  "SELECT aw.award_name, aw.award_logo, aw.award_date, aw.award_place, aw.award_leaderboard";
            $query .= " FROM #__bootcamp_leaderboards_awards aw";
            $query .= " WHERE aw.award_team_id='.$team_id.'";
            $query .= " ORDER BY aw.award_date DESC";
            
            $db = $this->getDbo();
		
            $db->setQuery($query); 
            return $db->loadObjectList();
        }
        
        function getTeamMatches($team_id)
        {
            $query =  "SELECT ma.match_name, ma.match_date, ma.match_logo, ma.match_state, ma.match_leaderboard, ma.match_url";
            $query .= " FROM #__bootcamp_leaderboards_matches ma";
            $query .= " WHERE ma.match_team1_id='.$team_id.' OR ma.match_team2_id='.$team_id.'";
            $query .= " ORDER BY ma.match_date DESC";
            
            $db = $this->getDbo();
		
            $db->setQuery($query); 
            return $db->loadObjectList();
        }
        
	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();
		
		$params = $app->getParams();
		$this->setState('params', $params);
	}
}

?>