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
 * Site's Image Helper Framework.
 * imagehelper.php 
 * 
 **************************************************************************/

class ImageHelper
{
	public static function getImageHeight($imgUrl, $width)
	{
		list($orgWidth, $orgHeight, $type, $attr) = getimagesize($imgUrl);
		
		$factor = $orgWidth / $width;
		return round($orgHeight / $factor);	
	}	
	
	public static function getImageWidth($imgUrl, $height)
	{
		list($orgWidth, $orgHeight, $type, $attr) = getimagesize($imgUrl);
		
		$factor = $orgHeight / $height;
		return round($orgWidth / $factor);	
	}
}