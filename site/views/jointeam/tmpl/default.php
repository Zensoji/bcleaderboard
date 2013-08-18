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
 * Site's Join Team View Default Template
 * default.php
 */


// no direct access
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');

$document = JFactory::getDocument();
$document->addScript( JURI::root().'/components/com_bootcampleaderboards/script/jquery/jquery-1.7.2.min.js' );
$document->addScript( JURI::root().'/components/com_bootcampleaderboards/script/jquery/jquery.noconflict.js' );
$document->addStyleSheet(JURI::base().'components/com_bootcampleaderboards/style/form.css');
$document->addScript( JURI::root().'/components/com_bootcampleaderboards/script/jointeam.js' );

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

$html[] = '<form class="form-validate" action="'. JRoute::_('index.php?option=com_squadmanagement&view=joinus') . '" method="post" name="joinusForm" id="joinus-form">';
$html[] = '	<div id="squadmanagement_challenge">';
$html[] = '			<div class="adminform">';
$html[] = '				<div>'. $this->form->getLabel('displayname');
$html[] =				$this->form->getInput('displayname') . '</div>';
$html[] = '				<div>'. $this->form->getLabel('squadid');
$html[] =				$this->form->getInput('squadid') . '</div>';
$html[] = '				<div>';
$html[] = '			<div class="clr"></div>';
$html[] =			$this->form->getLabel('joinusdescription'); 
$html[] = '			<div class="clr"></div>';
$html[] =			$this->form->getInput('joinusdescription');
$html[] = '				</div>';
$html[] = '			</div>';
$html[] = '	</div>';
$html[] = '	<button type="submit" class="button">' . JText::_('COM_SQUADMANAGEMENT_FIELD_JOINUS_SAVE') . '</button>';
$html[] = '	<div>';
$html[] = '		<input type="hidden" name="option" value="com_squadmanagement" />';
$html[] = '		<input type="hidden" name="task" value="joinus.submit" />';
$html[] = JHtml::_('form.token');
$html[] = '	</div>';
$html[] = '</form>';

echo implode("\n", $html); 