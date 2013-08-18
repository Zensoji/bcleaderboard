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
 * Site's Match View
 * view.html.php
 */

// No direct access
defined('_JEXEC') or die('Restricted Access');


jimport('joomla.application.component.view');

class BootcampleaderboardsViewMatch extends JView
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		$match_id = JRequest::getVar( 'match_id', '', 'default', 'int' );
		$templateName = JRequest::getVar( 'matchtemplate', '', 'default', 'string' );
		
		$model = $this->getModel();
		$state = $this->get('State');	
		$item = $model->getData($match_id);

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		$this->assignRef('templateName',$templateName);
		$this->assignRef('item',$item);
		
		$params = &$state->params;
		$this->assignRef('params',$params);
		
		// Display the view
		parent::display($tpl);
	}
}
?>