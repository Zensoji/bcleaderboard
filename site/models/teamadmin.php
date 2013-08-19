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
 * Site's Team Administration Model.
 * teamadmin.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modelitem');

class BootcampleaderboardsModelTeamadmin extends JModelItem
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
		
		return $this->_data;
	}
	
	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();
		
		$params = $app->getParams();
		$this->setState('params', $params);
	}
}

?>