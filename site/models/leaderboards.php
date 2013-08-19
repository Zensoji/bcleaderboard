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
 * Site's Leaderboard List Model.
 * leaderboards.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class BootcampleaderboardModelLeaderboards extends JModel
{
	function _getLeaderboardsQuery( &$options ){
		$db = JFactory::getDBO();
		$leaderboard_id =   @$options['leaderboard_id'];
		$select = '*';
		$from = '#__bootcamp_leaderboards';
		$wheres[] = 'leaderboard_published = 1';
		$query = "SELECT ".$select.
			 "\n FROM ".$from .
			 "\n WHERE ".implode("\n AND ",$wheres).
			 "\n ORDER BY leaderboard_name";
		return $query;
	}

	function getLeaderboardList( $options=array() ){
		$query = $this->_getLeaderboardsQuery($options);	
		$result = $this->_getList($query);
		return @$result;
	}
	
	public function getMatches($leaderboard_id)
	{	
		$query  = 'SELECT ma.match_name, ma.match_date, ma.match_state, ma.match_logo';	
		$query .= ' FROM #__bootcamp_leaderboards_matches ma';
		$query .= ' WHERE ma.match_leaderboard_id ='.$leaderboard_id;
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
