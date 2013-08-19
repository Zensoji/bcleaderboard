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
 * Site's Base Match List Template Framework.
 * basematchlisttemplate.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');
require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_bootcampleaderboards'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'basetemplate.php');

abstract class baseMatchListTemplate extends baseTemplate
{
	public $matchlist;
	public $matchstate;
	public $pagination;
	var $wartemplatename;
	
	function init($matchlist,$pagination,&$matchstate,$matchtemplatename)
	{    
		$this->matchlist = $matchlist;		
		$this->pagination = $pagination;
		$this->matchstate = $matchstate;		
		$this->matchtemplatename = $matchtemplatename;
	}
	
	public function getMatchLink($match_id)
	{
		if ($this->matchtemplatename != '')
		{
			return JRoute::_( 'index.php?option=com_bootcampleaderboards&amp;view=match&customtemplate='.$this->matchtemplatename.'&match_id='. $match_id );	
		}
		else
		{
			return JRoute::_( 'index.php?option=com_bootcampleaderboards&amp;view=match&match_id='. $match_id );	
		}
	}	
}

?>