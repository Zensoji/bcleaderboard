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
 * Site's Edit Team View Default Template.
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
$document->addScript( JURI::root().'/components/com_bootcampleaderboards/script/editteam.js' );

$html = array();


$html[] = '<form action="'. JRoute::_('index.php?option=com_squadmanagement&tmpl=component&view=editsquad&id='.$this->item->id).'" method="post" name="adminForm" id="squad-form">';

jimport ( 'joomla.html.pane');

$myTabs = JPane::getInstance( 'tabs' );
$html[] = $myTabs->startPane( "my_tabbed_content" );
$html[] = $myTabs->startPanel(JText::_('COM_SQUADMANAGEMENT_TAB_EDITSQUAD_COMMON'),"tab1-common");	

$html[] = '	<div class="width-100 fltlft">';
$html[] = '		<div class="adminform">';	
$html[] = '			<div>'. $this->form->getLabel('div');
$html[] =			$this->form->getInput('id').'</div>';
$html[] = '			<div>'. $this->form->getLabel('shortname');
$html[] =			$this->form->getInput('shortname').'</div>';
$html[] = '			<div>'. $this->form->getLabel('name');
$html[] =			$this->form->getInput('name').'</div>';
$html[] = '			<div>'. $this->form->getLabel('waradmin');
$html[] =			$this->form->getInput('waradmin').'</div>';

$html[] = '			<div>'. $this->form->getLabel('icon');
$html[] =			$this->form->getInput('icon').'</div>';
$html[] = '			<div style="clear:both">'. $this->form->getLabel('image');
$html[] =			$this->form->getInput('image').'</div>';
$html[] = '		</div>';
$html[] = '	</div>';

$html[] = $myTabs->endPanel(); 
$html[] = $myTabs->startPanel(JText::_('COM_SQUADMANAGEMENT_TAB_EDITSQUAD_DESCRIPTION'),"tab2-description");	

$html[] = '		<div class="adminform">';
$html[] = '			<div style="clear:both">';
$html[] =			$this->form->getInput('description').'</div>';
$html[] = '		</div>';

$html[] = $myTabs->endPanel(); 
$html[] = $myTabs->startPanel(JText::_('COM_SQUADMANAGEMENT_TAB_EDITSQUAD_MEMBERS'),"tab3-members");	

$html[] = '<div id="memberlist">';
$html[] = '</div>';

$html[] = '<div id="addmember">';

$html[] = '<table>';
$html[] = '	<tr>';
$html[] = '		<td>';
$html[] = '			UserID';
$html[] = '		</td>';
$html[] = '		<td>';
$html[] = '			Username';
$html[] = '		</td>';
$html[] = '		<td>';
$html[] = '			Role';
$html[] = '		</td>';
$html[] = '		<td>';
$html[] = '		</td>';
$html[] = '	</tr>';
$html[] = '	<tr>';
$html[] = '		<td>';
$html[] = '			<input id="userid" style="width: 40px;" />';
$html[] = '		</td>';
$html[] = '		<td>';
$html[] = '			<input autocomplete="off" id="usernamefilter" type="text" onkeyup="queryUsers('.$this->item->id.')"/>';
$html[] = '		</td>';
$html[] = '		<td>';
$html[] = '			<input id="role" type="text"/>';
$html[] = '		</td>';
$html[] = '		<td>';
$html[] = '			<a href="#" onClick="addSquadMember('.$this->item->id.'); return false;">';
$html[] = '				<img  src="'.JURI::base().'components/com_squadmanagement/images/user-add.png" alt="Add"/>';
$html[] = '			</a>';
$html[] = '		</td>';
$html[] = '	</tr>';
$html[] = '</table>';

$html[] = '<div id="usernamesugestions" style="display:none;" >';
$html[] = '</div>';

$html[] = '<div id="errormessage" style="display:none;" >';
$html[] = '</div>';

$html[] = '</div>';

$html[] = $myTabs->endPanel(); 
$html[] = $myTabs->endPane();

$html[] = '<br />';
$html[] = '	<button type="submit" class="button">' . JText::_('COM_SQUADMANAGEMENT_FIELD_EDITSQUAD_SAVE') . '</button>';
$html[] = '	<div>';
$html[] = '		<input type="hidden" name="option" value="com_squadmanagement" />';
$html[] = '		<input type="hidden" name="task" value="editsquad.submit" />';
$html[] = JHtml::_('form.token'); 
$html[] = '	</div>';
$html[] = '</form>';

echo implode("\n", $html); 

?>