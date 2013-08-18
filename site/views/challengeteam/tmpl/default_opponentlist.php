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
 * Site's Challenge a Team View - Opponent List Template.
 * default_opponentlists.php 
 **/

// no direct access
defined('_JEXEC') or die('Restricted access');

$html = array();

if (count($this->list) == 0)
{
	echo json_encode(implode("\n", $html)); 
	return;
} 

$html[] = '<table id="opponents">';
$html[] = '	<thead>';
$html[] = '		<tr>';
$html[] = '			<th>';
$html[] = '			</th>';
$html[] = '			<th>';
$html[] = '				Name';
$html[] = '			</th>';
$html[] = '			<th>';
$html[] = '				Url';
$html[] = '			</th>';
$html[] = '		</tr>';
$html[] = '	</thead>';

$html[] = '	<tbody>';
foreach	($this->list as $i => $opponent)
{
	$html[] = ' 	<tr class="opponents_row" onclick="assignopponent(\''.$opponent->name.'\',\''.$opponent->url.'\'); return false;">';
	$html[] = ' 		<td align="center" valign="middle">';
	if ($opponent->logo != '')
	{
		$html[] = '<img src="'.JURI::root().$opponent->logo.'" alt="' . $opponent->name . '" height="15" width="15"/>'; 	
	}
	else
	{
		$html[] = '<img src="'.JURI::root().'components/com_squadmanagement/images/defaultfieldimage.png" alt="' . $opponent->name . '" height="15" width="15"/>'; 		
	}	
	$html[] = ' 		</td>';
	$html[] = ' 		<td width="50%">';			
	$html[] = ' 			<span>';
	$html[] = $opponent->name;
	$html[] = ' 			</span>';
	$html[] = ' 		</td>';
	$html[] = ' 		<td width="70%">';
	$html[] = ' 			<span>';
	$html[] = $opponent->url;
	$html[] = ' 			</span>';
	$html[] = ' 		</td>';
	$html[] = ' 	</tr>';
}

$html[] = '	</tbody>';
$html[] = '</table>';

echo json_encode(implode("\n", $html));  

?>