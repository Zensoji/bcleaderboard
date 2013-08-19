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
 * Site's Base Template Framework.
 * basetemplate.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

abstract class baseTemplate
{
	public abstract function renderTemplate();
	
	function renderField($field, $member, $withcaption = true)
	{			
	}
}

?>