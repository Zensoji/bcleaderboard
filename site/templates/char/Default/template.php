<?php
/**
 * PvP Boot Camp Leaderboards Component
 * @comname         com_bootcampleaderboards
 * @package         Bootcampleaderboards.Site
 * @subpackage      Templates
 *
 * @copyright       (C) Copyright 2013 PvP Boot Camp. All rights reserved.
 * @license         http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link            http://www.pvp-boot-camp.com
 * @author          Alex Armstrong
 *                  Lynton Steyn
 * @author-email    zensoji@pvp-boot-camp.com
 *                  drkfrontiers@pvp-boot-camp.com
 **/

// No Direct Access
defined('_JEXEC') or die('Restricted Access');

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_bootcampleaderboards'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'baseawardtemplate.php');

class defaultawardtemplate extends baseawardtemplate
{
	public function renderTemplate()
	{
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::base().'components/com_bootcampleaderboards/templates/award/Default/style.css');	
		$document->addStyleSheet(JURI::base().'components/com_bootcampleaderboards/script/slimbox/css/slimbox2.css');		
		$document->addScript( JURI::root().'components/com_bootcampleaderboards/script/jquery/jquery-1.7.2.min.js' );
		$document->addScript( JURI::root().'components/com_bootcampleaderboards/script/jquery/jquery.noconflict.js' );
		$document->addScript( JURI::root().'components/com_bootcampleaderboards/script/slimbox/js/slimbox2.js' );
		
		$html = array();
                
                $db = JFactory::getDBO();
                
                $query = "SELECT 'award_place', 'award_name_1', 'award_name_2' FROM #__bootcamp_leaderboards_awards WHERE award_id='.&this->award->award_id.'";
                $award_name = $db->setQuery($query);

                //Award Name
                $html[] = ' <table align="center">';
                $html[] = '     <tbody>';
                $html[] = '         <tr>';
                $html[] = '             <td colspan="3">';
                $html[] = '                 <div class="module mod-color style-color">';
                $html[] = '                     <div class="deepest">';
                $html[] = '                         <table align="center">';
                $html[] = '                             <tbody>';
                $html[] = '                                 <tr>';
                $html[] = '                                     <td>';
                $html[] = '                                         <h3 class="module-title" align="center">';
                $html[] = '                                             <span class="color">';
                $html[] = '                                                 '.$award_name[0].' Place<br />
                                                                            '.$award_name[1].'<br />
                                                                            '.$award_name[2];
                $html[] = '                                             </span>';
                $html[] = '                                         </h3>';
                $html[] = '                                     </td>';
                $html[] = '                                 </tr>';
                $html[] = '                             </tbody>';
                $html[] = '                         </table>';
                $html[] = '                     </div>';
                $html[] = '                 </div>';
                $html[] = '             </td>';
                $html[] = '         </tr>';
                //Award
                $html[] = '         <tr>';
                //Award Logo
                $html[] = '             <td width="37%"> </td>';
                $html[] = '             <td align="center">';
                $html[] = '                 <div class="module mod-metal style-metal">';
                $html[] = '                     <div class="deepest">';
                if ($this->award->award_image_url != '')
                {
                    $html[] = '                     <img src="'.$this->award->award_image_url.'" align="center" alt="'.$this->award->award_name.'" style="award-img" />';
                }
                else
                {
                    $html[] = '                     <img src="'.JURI::root().'components/com_bootcampleaderboards/images/defaultawardimage.png" align="center" alt="'.$this->award->award_name.'" style="award-img" />';
                }
                $html[] = '                     </div>';
                $html[] = '                 </div>';
                $html[] = '             </td>';
                $html[] = '             <td width="37%"> </td>';
                $html[] = '         </tr>';
                //Award Details
                $html[] = '         <tr>';
                $html[] = '             <td colspan="3">';
                $html[] = '                 <div class="module mod-color style-color">';
                $html[] = '                     <div class="deepest">';
                $html[] = '                         <dl class="separator">';
                $html[] = '                             <dt><em class="box">'.JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_AWARD_TEAM').'</em></dt>';
                $html[] = '                                 <dd>'.$this->award->award_team.'</dd>';
                $html[] = '                             <dt><em class="box">'.JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_AWARD_DATE').'</em></dt>';
                $html[] = '                                 <dd>'.$this->award->award_date.'</dd>';
                $html[] = '                             <dt><em class="box">'.JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_AWARD_DESCRIPTION').'</em></dt>';
                $html[] = '                                 <dd>'.$this->award->award_description.'</dd>';
                $html[] = '                         </dl>';
                $html[] = '                     </div>';
                $html[] = '                 </div>';
                $html[] = '             </td>';
                $html[] = '         </tr>';
                $html[] = '     </tbody>';
                $html[] = ' </table>';	
	}	
}
?>