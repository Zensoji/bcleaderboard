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
 * Site's Team Aministration View Default Template
 * default.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


$html = array();

if ($this->params->get('show_page_heading', 1))
{
	$html[] = '<h1>';
	if ($this->escape($this->params->get('page_heading')))
        {
		$html[] = $this->escape($this->params->get('page_heading')); 
        }
	else
        {
		$html[] = $this->escape($this->params->get('page_title')); 
        }
	$html[] = '</h1>';
}

echo implode("\n", $html);

$templateName = $this->templateName;
if ($templateName == '')
{
	$templateName = $this->params->get( 'teamadmintemplate' , 'Default');	
}

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_bootcampleaderboards'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'teamadmin'.DIRECTORY_SEPARATOR.$templateName.DIRECTORY_SEPARATOR.'template.php');

$templateClass = strtolower($templateName).'teamadmintemplate';

$template = new $templateClass;
$template->init($this->item,$this->params);
$template->renderTemplate();

?>