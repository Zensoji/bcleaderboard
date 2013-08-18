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
 * Site's Edit Team View Default Template - Member List.
 * default_memberlist.php 
 **/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_bootcampleaderboards'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'imagehelper.php');

$html = array();

$html[] = '<table id="squadmembers">';
$html[] = '	<thead>';
$html[] = '		<tr>';
$html[] = '			<th>';
$html[] = '			</th>';
$html[] = '			<th>';
$html[] = '				Username';
$html[] = '			</th>';
$html[] = '			<th>';
$html[] = '				Displayname';
$html[] = '			</th>';
$html[] = '			<th>';
$html[] = '				Role';
$html[] = '			</th>';
$html[] = '			<th>';
$html[] = '				Ordering';			
$html[] = '			</th>';
$html[] = '			<th>';
$html[] = '			</th>';
$html[] = '		</tr>';
$html[] = '	</thead>';

$html[] = '	<tbody>';
foreach	($this->squad->members as $i => $member)
{
	$html[] = ' 	<tr id="squadmemberrow_'. $member->id .'">';
	$html[] = ' 		<td align="center" valign="middle">';
	
	$image = IntegrationHelper::getFullAvatarImagePath($member->avatar);
	$width = ImageHelper::getImageWidth($image,50);
	
	$html[] = ' 			<img src="'.$image.'" alt="' . $member->name . '" height="50" width="'.$width.'"/>'; 
	$html[] = ' 		</td>';
	$html[] = ' 		<td width="40%">';			
	$html[] = ' 			<span>';
	$html[] = ' 				<a href="'.JRoute::_('index.php?option=com_squadmanagement&view=squadmember&id=' . $member->userid) . '">';
	$html[] = $member->name;
	$html[] = ' 				</a>';
	$html[] = ' 			</span>';
	$html[] = ' 		</td>';
	$html[] = ' 		<td width="40%">';
	$html[] = ' 			<span>';
	$html[] = $member->displayname;
	$html[] = ' 			</span>';
	$html[] = ' 		</td>';
	$html[] = ' 		<td width="40%">';
	$html[] = ' 			<span>';
	$html[] = '					<input size="20" name="jform[squadmember_role_'.$member->id.']" id="jform_squadmember_role_'.$member->id.'" type="text" value="'.$member->role.'"/>';
	$html[] = ' 			</span>';
	$html[] = ' 		</td>';
	$html[] = ' 		<td width="20">';
	$html[] = ' 			<span>';
	$html[] = '					<input size="2" name="jform[squadmember_ordering_'.$member->id.']" id="jform_squadmember_ordering_'.$member->id.'" type="text" value="'.$member->ordering.'"/>';
	$html[] = ' 			</span>';
	$html[] = ' 		</td>';
	$html[] = ' 		<td>';
	$html[] = ' 			<a href="#" onClick="removeSquadMember(' . $member->id . ','. $this->squad->id .');return false;">';
	$html[] = ' 				<img  src="'.JURI::base().'components/com_squadmanagement/images/user-delete.png" alt="Delete"/>';
	$html[] = ' 			</a>';
	$html[] = ' 		</td>';
	$html[] = ' 	</tr>';
}

$html[] = '	</tbody>';
$html[] = '</table>';

echo json_encode(implode("\n", $html));  

?>