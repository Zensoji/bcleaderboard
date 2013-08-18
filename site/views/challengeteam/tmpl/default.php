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
 * Site's Challenge a Team View Template.
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
$document->addScript( JURI::root().'/components/com_bootcampleaderboards/script/challenge.js' );
$document->addStyleSheet(JURI::base().'components/com_bootcampleaderboards/style/form.css');

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

jimport( 'joomla.access.access' );
$groups = JAccess::getGroupsByUser($user_id, false);

$html[] = ' <table class="challengeform" align="center"';
$html[] = '     <tbody>';
$html[] = '         <tr>';
$html[] = '             <td>';
$html[] = '                 <form class="form-validate box style" action="'. JRoute::_('index.php?option=com_bootcampleaderboards&view=challengeteam') . '" method="post" name="challengeteamForm" id="challengeteam-form">';
$html[] = '                     <fieldset>';
$html[] = '                         <div>';
$html[] =                               $this->form->getLabel('leaderboard');
$html[] =                               $this->form->getInput('leaderboard');
$html[] = '                         </div>';
$html[] = '                         <div>';
$html[] =                               $this->form->getLabel('matchdate');
$html[] =                               $this->form->getInput('matchdate'); 
$html[] = '                         </div>';
$html[] = '                         <div>';
$html[] =                               $this->form->getLabel('opponent');
$html[] =                               $this->form->getInput('opponent');
$html[] = '                         </div>';
$html[] = '                         <div>';
$html[] =                               $this->form->getLabel('challengedescription');
$html[] =				$this->form->getInput('challengedescription');
$html[] = '                         </div>';
$html[] = '                         <div>';
$html[] =                               $this->form->getLabel('teamid');
$html[] =				$this->form->getInput('teamid');
$html[] = '                         </div>';
$html[] = '                         <div>';
$html[] = '                             <button type="submit" class="button">'.JText::_('COM_BOOTCAMPLEADERBOARDS_FIELD_CHALLENGETEAM_SUBMIT') . '</button>';
$html[] = '                         </div>';
$html[] = '                         <input type="hidden" name="option" value="com_bootcampleaderboards" />';
$html[] = '                         <input type="hidden" name="task" value="challengeteam.submit" />';
$html[] =                           JHtml::_('form.token');
$html[] = '                     </fieldset>';
$html[] = '                 </form>';
$html[] = '             </td>';
$html[] = '             <td>';
$html[] = '                 <form class="box style">';
$html[] = '                     <fieldset>';
$html[] = '                         <div>';
$html[] = '                             <label for="oppinfo1">'.$opponentname.'</label>';
$html[] = '                             <input type="text" id="oppinfo1" readonly="yes" />';
$html[] = '                         </div>';
$html[] = '                         <div>';
$html[] = '                             <label for="oppinfo1">'.$opponentdescription.'</label>';
$html[] = '                             <textarea id="oppinfo1" readonly="yes" />';
$html[] = '                         </div>';
$html[] = '                     </fieldset>';
$html[] = '                 </form>';
$html[] = '             </td>';
$html[] = '         </tr>';
$html[] = '     </tbody>';
$html[] = ' </table>';

echo implode("\n", $html); 

?>

