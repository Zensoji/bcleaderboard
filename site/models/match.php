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
 * Site's Match Model.
 * match.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modelitem');

class BootcampleaderboardsModelMatch extends JModelItem
{
	protected $_data;

	public function getTable($type = 'Match', $prefix = 'BootcampleaderboardsTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function &getData($match_id,$match_team1_id,$match_team2_id)
	{
		if (empty( $this->_data )) {
			
			$query = ' SELECT * from #__bootcamp_leaderboards_matches m '.
				'  WHERE m.match_id = '.$match_id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
                
                $this->_data->Team1Lineup = $this->getTeam1MatchLineup($match_id, $match_team1_id);
                $this->_data->Team2Lineup = $this->getTeam2MatchLineup($match_id, $match_team2_id);
		
		return $this->_data;
	}
        
        function getTeam1MatchLineup($match_id,$match_team1_id)
	{		
		
		$query = "SELECT *";
				
		$query .= " FROM #__bootcamp_leaderboards_matches_lineups";
		$query .= " WHERE lineup_match_id='.$match_id.' AND lineup_team_id='.$match_team1_id.'";
		
		$db = $this->getDbo();
		
		$db->setQuery($query); 
		return $db->loadObjectList();
	}
        
        function getTeam2MatchLineup($match_id,$match_team2_id)
	{		
		
		$query = "SELECT *";
				
		$query .= " FROM #__bootcamp_leaderboards_matches_lineups";
		$query .= " WHERE lineup_match_id='.$match_id.' AND lineup_team_id='.$match_team2_id.'";
		
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