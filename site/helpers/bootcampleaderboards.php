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
 * Site's General Helper.
 * bootcampleaderboards.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

class BootcampleaderboardsHelper
{
	public static function getTeamOptions()
	{
		// Initialize variables.
		$options = array();

		$db     = JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('team_id As value, team_name As text');
		$query->from('#__bootcamp_leaderboards_teams AS t');
		$query->order('t.team_name');

		// Get the options.
		$db->setQuery($query);

		$options = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		// Merge any additional options in the XML definition.
		//$options = array_merge(parent::getOptions(), $options);

		array_unshift($options, JHtml::_('select.option', '0', JText::_('COM_BOOTCAMPLEADERBOARDS_ALL_TEAMS')));

		return $options;
	}	
}