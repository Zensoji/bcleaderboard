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
 * Site's Become a Refeee View - Template.
 * default.php 
 **/

// no direct access
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');

$document = JFactory::getDocument();
$document->addScript( JURI::root().'/components/com_bootcampleaderboards/script/jquery/jquery-1.7.2.min.js' );
$document->addScript( JURI::root().'/components/com_bootcampleaderboards/script/jquery/jquery.noconflict.js' );
$document->addStyleSheet(JURI::base().'components/com_bootcampleaderboards/style/form.css');
$document->addScript( JURI::root().'/components/com_bootcampleaderboards/script/becomearef.js' );

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

// User
$user = JFactory::getUser();
$user_id = $user->get('id');
$user_name = $user->get('username');

$html[] = ' <table class="becomearef" align="center"';
$html[] = '     <tbody>';
$html[] = '         <tr>';
$html[] = '             <td>';
$html[] = '                 <form class="form-validate box style" action="'. JRoute::_('index.php?option=com_bootcampleaderboards&view=bcomearef') . '" method="post" name="becomearefForm" id="becomearef-form">';
$html[] = '                     <fieldset>';
$html[] = '                         <legend>Become a Referee</legend>';
$html[] = '                         <div>';
$html[] = '                             <label for="f1">'.JText::_('COM_BOOTCAMPLEADERBOARDS_FIELD_BECOMEAREF_DESCRIPTION').'</label>';
$html[] = '                             <input type="editor" id="f1">';
$html[] = '                         </div>';
$html[] = '                         <button type="submit">'.JText::_('COM_BOOTCAMPLEADERBOARDS_FIELD_BECOMEAREF_SAVE').'</button>';
$html[] = '                         <input type="hidden" name="option" value="com_bootcampleaderboards" />';
$html[] = '                         <input type="hidden" name="task" value="becomearef.submit" />';
$html[] =                           JHtml::_('form.token');
$html[] = '                     </fieldset>';
$html[] = '                 </form>';
$html[] = '             </td>';
$html[] = '         </tr>';
$html[] = '     </tbody>';
$html[] = ' </table>';

echo implode("\n", $html); 

?>