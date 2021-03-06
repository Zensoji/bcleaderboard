<?php
/***************************************************************************
 * 
 * PvP Boot Camp Leaderboards Component
 * @comname         com_bootcampleaderboards
 * @package         Bootcampleaderboards.Site
 * @subpackage      Framework
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
 * Site's Base Team List template Framework.
 * baseteamlisttemplate.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_bootcampleaderboards'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'basetemplate.php');

abstract class baseTeamListTemplate extends baseTemplate
{
	public $teamlist;
	public $params;
	
	function init($squadlist)
	{    
		$this->squadlist = $squadlist;		
	}
	
	public function getImageUrlOrDefault($team_logo)
	{
		if ($team_logo == '')
		{
			return 'components/com_bootcampleaderboards/images/unknownuser.jpg';
		}
		
		return $team_logo;
	}
}

?>