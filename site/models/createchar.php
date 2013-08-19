<?php
/***************************************************************************
 * 
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
 * 
 ***************************************************************************
 * 
 * Site's Character - Create Model.
 * createchar.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.component.modelform');

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_bootcampleaderboards'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'bootcampleaderboardshelper.php';

class BootcampleaderboardsModelCreatechar extends JModelForm
{
	public function getTable($type = 'Char', $prefix = 'BootcampleaderboardsTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_bootcampleaderboards.createchar', 'createchar', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}

	protected function loadFormData() 
	{
		$data = (array)JFactory::getApplication()->getUserState('com_bootcampleaderboards.createchar.data', array());
		return $data;
	}
	
	public function insertItem($data)
	{
		$user = JFactory::getUser();
                $userid = $user->get('id');
                
                $db = JFactory::getDbo();
                 
		if ($user->guest) {
			JError::raiseError(500, 'NOT_LOGGED_IN');
		}
		
		// set the data into a query to update the record
		
		$createachar = new stdClass();
                
		$createachar->char_id           =   NULL;
                $createachar->char_user_id      =   $userid;
                $createachar->char_image        =   $data['char_image'];
		$createachar->char_name         =   $data['char_name'];
                $createachar->char_faction      =   $data['char_faction'];
		$createachar->char_career       =   $data['char_career'];
		$createachar->char_race         =   $data['char_race'];
                $createachar->char_gender       =   $data['char_gender'];
                $createachar->char_role         =   $data['char_role'];
                $createachar->char_ship         =   $data['char_ship'];
                $createachar->char_ship_name    =   $data['char_sname_prefix']." ".$data['char_ship_name'];
                $createachar->char_build        =   $data['char_build'];
                $createachar->char_bio          =   $data['char_bio'];
		$createachar->char_published    =   1;

		$db->insertObject('#__bootcamp_leaderboards_chars', $createachar);	
		
		if ($db->getErrorMsg()) 
		{
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		} 
		
		$params = JComponentHelper::getParams('com_bootcampleaderboards');
		
		return true;
	}
}

?>