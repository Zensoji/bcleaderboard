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
 * Site's Challenge a Team View - No Access Template.
 * default.php 
 **/

// no direct access
defined('_JEXEC') or die('Restricted access');

$html = array();

if ($this->params->get('show_page_heading', 1)) : 
	$html[] = '<h1>';
	if ($this->escape($this->params->get('page_heading'))) :
		$html[] = $this->escape($this->params->get('page_heading')); 
	else : 
		$html[] = $this->escape($this->params->get('page_title')); 
	endif;
	$html[] = '</h1>';
endif; 

$message = $this->params->get('challengeteamerrormessage');

if ($message != '')
{
	$html[] = $message;
}
else
{
	$html[] = JText::_('COM_BOOTCAMPLEADERBOARDS_CHALLENGETEAM_NOACCESS');	
}

echo implode("\n", $html); 

?>