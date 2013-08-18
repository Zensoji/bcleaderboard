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
 * Site's Edit Team View Default Template - User Lookup.
 * default_userlookup.php 
 **/

// no direct access
defined('_JEXEC') or die('Restricted access');

$html = array();

$html[] = '<table id="usersuggestions_table">';
$html[] = '	<tr>';
$html[] = '		<th>';
$html[] = '			Name';
$html[] = '		</th>';
$html[] = '		<th style="text-align:left;">';
$html[] = '			Email';
$html[] = '		</th>';
$html[] = '	</tr>';

$cnt = 0;

foreach	($this->users as $user)
{		
	if (!isUserInTeam($user,$this->team))
	{			
		$html[] = '	<tr class="usersuggestions_row" onClick="assignteammember(\''.$user->name.'\',\''.$user->id.'\'); return false;">';
		$html[] = '		<td class="usersuggestions_column_username">';
		$html[] = $user->name;
		$html[] = '		</td>';
		$html[] = '		<td class="usersuggestions_column_email">';
		$html[] = $user->email;
		$html[] = '		</td>';
		$html[] = '	</tr>';
		
		$cnt++;	
	}
}

if ($cnt == 0)
{
	$html[] = '<tr><td colspan="3">0 Users found</td></tr>';	
}

$html[] = '</table>';

echo json_encode(implode("\n", $html));  

function isUserInTeam($user,$team)
{
	foreach ($team->members as $member)
	{
		if ($user->id == $member->userid)
		{
			return true;	
		}	
	}	
	
	return false;
}

?>