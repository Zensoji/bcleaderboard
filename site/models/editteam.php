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
 * Site's Team - Edit Model.
 * editteam.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modelform');

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_bootcampleaderboards'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'bootcampleaderboardshelper.php';

class BootcampleaderboardsModelEditteam extends JModelForm
{
	public function getTable($type = 'Team', $prefix = 'BootcampleaderboardsTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_bootcampleaderboards.editteam', 'editteam', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}

	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_bootcampleaderboards.edit.team.data', array());
		if (empty($data)) 
		{
			$team_id = JRequest::getVar( 'team_id', '', 'default', 'int' );

			$data = $this->getData($team_id);
		}
		return $data;
	}
	
	public function getData($team_id)
	{		
		$query = ' SELECT * from #__bootcamp_leaderboards_teams WHERE team_id = '.$team_id;
		$this->_db->setQuery( $query );
		$data = $this->_db->loadObject();
		
		if ($data == null)
		{
			return null;	
		}
		// load members
		$data->members = $this->getMemberList($team_id);
		
		return $data;
	}
	
	function getMemberList($team_id)
	{				
            $query =  "SELECT me.username, me.cb_handle, me.avatar, me.cb_team_memberstate, me.cb_team_join_date, me.cb_team_staff_rank";
            $query .= " FROM #__comprofiler me";
            $query .= " WHERE me.cb_team_id='.$team_id.'";
            $query .= " ORDER BY me.cb_team_staff_rank DESC";
            
            $db = $this->getDbo();
		
            $db->setQuery($query); 
            return $db->loadObjectList();
	}
	
	public function updateItem($data)
	{
		$db = JFactory::getDbo();		
		$query = $db->getQuery(true);
		
		$query->update('#__bootcamp_leaderboards_teams t');
		$query->set('t.team_name = '.$db->quote($data['team_name']));
		$query->set('t.team_short_name = '.$db->quote($data['team_short_name']));
		$query->set('t.team_class = '.$db->quote($data['team_class']));
		$query->set('t.team_fleet = '.$db->quote($data['team_fleet']));
		$query->set('t.team_fleet_name = '.$db->quote($data['team_fleet_name']));
                $query->set('t.team_logo = '.$db->quote($data['team_logo']));
		$query->set('t.team_description = '.$db->quote($data['team_description']));
                $query->set('t.team_recruiting = '.$db->quote($data['team_recruiting']));
			
		$query->where('t.team_id = ' . (int)$data['team_id']);
		$db->setQuery($query);
		
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
	}
}

?>