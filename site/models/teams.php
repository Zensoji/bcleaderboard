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
 * Site's Team List Model.
 * teams.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class BootcampleaderboardModelTeams extends JModel
{
	function _getTeamsQuery( &$options ){
		$db = JFactory::getDBO();
		$team_id =   @$options['team_id'];
		$select = '*';
		$from = '#__bootcamp_leaderboards_teams ';
		$wheres[] = 'team_published = 1';
		$query = "SELECT ".$select.
			 "\n FROM ".$from .
			 "\n WHERE ".implode("\n AND ",$wheres).
			 "\n ORDER BY team_name";
		return $query;
	}

	function getTeamList( $options=array() ){
		$query = $this->_getTeamsQuery( $options );	
		$result = $this->_getList( $query );
		return @$result;
	}
	
	public function getMembers($team_id)
	{	
		$query  = 'SELECT m.user_id, m.cb_handle, m.username, m.avatar, m.cb_team_tm_points, m.cb_team_lt_points';	
		$query .= ' FROM #__comprofiler m';
		$query .= ' WHERE m.cb_team_memberstate in (1,2) AND m.cb_team_id ='.$team_id;
		$query .= ' ORDER BY ordering';
		
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