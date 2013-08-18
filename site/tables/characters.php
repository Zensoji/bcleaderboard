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
 * Site's Characters Table.
 * characters.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla table library
jimport('joomla.database.table');

class BootcampleaderboardsTableChars extends JTable
{
	function __construct(&$db) 
	{
		parent::__construct('#__bootcamp_leaderboards_chars', 'char_id', $db);
	}
}

?>