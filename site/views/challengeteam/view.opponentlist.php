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
 * Site's Challenge a Team - Opponent List View.
 * view.opponentlist.php 
 **/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view' );

class BootcampleaderboardsViewChallengeteam extends JView
{
	function display($tpl = null)
	{	
		$params = JComponentHelper::getParams( 'com_bootcampleaderboards' ); 
		$this->assignRef('params',$params);
				
		$namepart = JRequest::getVar( 'namepart', '', 'default', 'string' );
				
		$model = $this->getModel(); 
		$list = $model->getOpponentList($namepart);		
		
		$this->assignRef('list', $list);		
		
		parent::display("opponentlist");
	}
	
}
?>