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
 * Site's Character - Edit Model.
 * editchar.php 
 * 
 **************************************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla modelitem library
jimport('joomla.application.componench.modelform');

require_once JPATH_SITE.DIRECTORY_SEPARATOR.'administrator'.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_bootcampleaderboards'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'bootcampleaderboardshelper.php';

class BootcampleaderboardsModelEditchar extends JModelForm
{
	public function getTable($type = 'Char', $prefix = 'BootcampleaderboardsTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_bootcampleaderboards.editchar', 'editchar', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}

	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_bootcampleaderboards.edich.char.data', array());
		if (empty($data)) 
		{
			$char_id = JRequest::getVar( 'char_id', '', 'default', 'int' );

			$data = $this->getData($char_id);
		}
		return $data;
	}
	
	public function getData($char_id)
	{		
		$query = ' SELECT * from #__bootcamp_leaderboards_chars WHERE char_id = '.$char_id;
		$this->_db->setQuery( $query );
		$data = $this->_db->loadObject();
		
		if ($data == null)
		{
			return null;	
		}
		
		return $data;
	}
	
	public function updateItem($data)
	{
		$db = JFactory::getDbo();		
		$user = JFactory::getUser();
                $userid = $user->get('id');
                
                if ($userid != $data['char_user_id'])
                {
                    JError::raiseError(401, 'ACCESS DENIED - YOU CANNOT CHANGE ANOTHER PLAYERS CHARACTER');
                    return false;
                }
		
                class charClass
                {
                    public $char_id;
                    public $char_image;
                    public $char_name;
                    public $char_faction;
                    public $char_career;
                    public $char_race;
                    public $char_gender;
                    public $char_role;
                    public $char_ship;
                    public $char_ship_name;
                    public $char_build;
                    public $char_bio;
                    public $char_published;
                }
		$editchar = new charClass();
                
                $editchar->char_image        =   $data['char_image'];
		$editchar->char_name         =   $data['char_name'];
                $editchar->char_faction      =   $data['char_faction'];
		$editchar->char_career       =   $data['char_career'];
		$editchar->char_race         =   $data['char_race'];
                $editchar->char_gender       =   $data['char_gender'];
                $editchar->char_role         =   $data['char_role'];
                $editchar->char_ship         =   $data['char_ship'];
                $editchar->char_ship_name    =   $data['char_sname_prefix']." ".$data['char_ship_name'];
                $editchar->char_build        =   $data['char_build'];
                $editchar->char_bio          =   $data['char_bio'];
		$editchar->char_published    =   1;
			
                $db->updateObject('#__bootcamp_leaderboards_chars', $editchar, 'char_id', true);
		
		if ($db->getErrorMsg()) 
		{
			JError::raiseError(500, $db->getErrorMsg());
			return false;
		} 
		else 
		{
			return true;
		}
	}
}

?>