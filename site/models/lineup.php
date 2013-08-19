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
 * Site's Edit a Match's Lineup Model.
 * lineup.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modelform');

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_bootcampleaderboards'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'bootcampleaderboardshelper.php';

class BootcampleaderboardsModelLineup extends JModelForm
{
	public function getTable($type = 'Lineup', $prefix = 'BootcampleaderboardsTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_bootcampleaderboards.lineup', 'lineup', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}

	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_bootcampleaderboards.lineup.data', array());
		if (empty($data)) 
		{
			$lineup_id = JRequest::getVar( 'lineup_id', '', 'default', 'int' );

			$data = $this->getData($lineup_id);
                        
		}
		return $data;
	}
	
	public function getData($lineup_id)
	{		
		$query = ' SELECT * from #__bootcamp_leaderboards_matches_lineups WHERE lineup_id = '.$lineup_id;
		$this->_db->setQuery( $query );
		$data = $this->_db->loadObject();
                $team_id  = $data['lineup_team_id'];
		
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
        
        function getCharlist($user_id)
        {
            $query  = "SELECT *";
            $query .= " FROM #__bootcamp_leaderboards_chars";
            $query .= " WHERE char_user_id='.$user_id.'";
            $query .= " ORDER BY char_name";
            
            $db = $this->getDbo();
            
            $db->setQuery($query);
            return $db->loadObjectList();
        }
	
	public function updateItem($data)
	{
		$db = JFactory::getDbo();		
		$query = $db->getQuery(true);
		
		$query->update('#__bootcamp_leaderboards_matches_lineups li');
                $query->set('li.lineup_team_member_1 = '.$db->quote($data['tm1_id'])); 
                $query->set('li.lineup_team_member_1_name = '.$db->quote($data['tm1_name'])); 
                $query->set('li.lineup_team_member_1_char = '.$db->quote($data['tm1_char']));
                $query->set('li.lineup_team_member_1_role = '.$db->quote($data['tm1_role']));
                
                $query->set('li.lineup_team_member_2 = '.$db->quote($data['tm2_id'])); 
                $query->set('li.lineup_team_member_2_name = '.$db->quote($data['tm2_name'])); 
                $query->set('li.lineup_team_member_2_char = '.$db->quote($data['tm2_char'])); 
                $query->set('li.lineup_team_member_2_role = '.$db->quote($data['tm2_role']));
                
                $query->set('li.lineup_team_member_3 = '.$db->quote($data['tm3_id']));
                $query->set('li.lineup_team_member_3_name = '.$db->quote($data['tm3_name']));
                $query->set('li.lineup_team_member_3_char = '.$db->quote($data['tm3_char']));
                $query->set('li.lineup_team_member_3_role = '.$db->quote($data['tm3_role']));
                
                $query->set('li.lineup_team_member_4 = '.$db->quote($data['tm4_id']));
                $query->set('li.lineup_team_member_4_name = '.$db->quote($data['tm4_name']));
                $query->set('li.lineup_team_member_4_char = '.$db->quote($data['tm4_char']));
                $query->set('li.lineup_team_member_4_role = '.$db->quote($data['tm4_role']));
                
                $query->set('li.lineup_team_member_5 = '.$db->quote($data['tm5_id']));
                $query->set('li.lineup_team_member_5_name = '.$db->quote($data['tm5_name']));
                $query->set('li.lineup_team_member_5_char = '.$db->quote($data['tm5_char']));
                $query->set('li.lineup_team_member_5_role = '.$db->quote($data['tm5_role']));
			
		$query->where('li.lineup_id = ' . (int)$data['lineup_id']);
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