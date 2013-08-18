<?php
/**
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
 **/

/**
 * Site's Edit Team View - Member List.
 * view.memberlist.php 
 **/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view' );

class BootcampleaderboardsViewEditteam extends JView
{
	function display($tpl = null)
	{	
		$params = JComponentHelper::getParams( 'com_bootcampleaderboards' ); 
		$this->assignRef('params',$params);
		
		$teamid = JRequest::getVar( 'team_id', '', 'default', 'string' );	
		if ($teamid == '')
		{			
			parent::display('noaccess');
			return false;
		}
		
		$model = $this->getModel(); 
		$team = $model->getData($teamid);
		
		if ($team == null)
		{			
			parent::display('noaccess');
			return false;
		}
		
		$this->assignRef('team', $team);		
		
		$user = JFactory::getUser();
		$userid = $user->get('id');
		if ($userid != $team->team_leader)
		{			
			parent::display('noaccess');
			return false;
		}		
		
		parent::display("memberlist");
	}
	
}