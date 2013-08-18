<?php
/***************************************************************************
 * 
 * PvP Boot Camp Leaderboards Component
 * @comname         com_bootcampleaderboard
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
 * Site's Leaderboard Model.
 * leaderboard.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modelitem');

class BootcampleaderboardsModelLeaderboard extends JModelItem
{
	protected $_data;

	public function getTable($type = 'Leaderboard', $prefix = 'BootcampleaderboardsTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function &getData($leaderboard_id)
	{
		if (empty( $this->_data )) {
			
			$query = ' SELECT * from #__bootcamp_leaderboards l '.
				'  WHERE l.leaderboard_id = '.$leaderboard_id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
                
		$this->_data->rankings = $this->getTeamResultList($leaderboard_id,50);
		
                return $this->_data;
	}
        
        function getTeamResultList($leaderboard_id)
	{		
		
		$query = "SELECT 'ranking_team_name', 'ranking_team_points_tm', 'ranking_team_logo'";
				
		$query .= " FROM #__bootcamp_leaderboards_results_rankings";
		$query .= " WHERE ranking_leaderboard_id='.$leaderboard_id.'";
		$query .= " ORDER BY 'ranking_team_points_tm' DESC";
		
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