<?php
/**
 * PvP Boot Camp Leaderboards Component
 * @package Bootcampleaderboards.Site
 * @subpackage Templates
 *
 * @copyright (C) 2013 PvP Boot Camp. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.pbc-beta.co.nf
 **/

//No Direct Access
defined('_JEXEC') or die('Restricted Access');

require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_bootcampleaderboards'.DIRECTORY_SEPARATOR.'framework'.DIRECTORY_SEPARATOR.'basematchtemplate.php');

JHTML::_('behavior.tooltip');

class defaultmatchtemplate extends basematchtemplate
{
	public function renderTemplate()
	{
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::base().'components/com_bootcampleaderboards/templates/war/Default/style.css');			
		$document->addStyleSheet(JURI::base().'components/com_bootcampleaderboards/script/slimbox/css/slimbox2.css');		
		$document->addScript( JURI::root().'components/com_bootcampleaderboards/script/jquery/jquery-1.7.2.min.js' );
		$document->addScript( JURI::root().'components/com_bootcampleaderboards/script/jquery/jquery.noconflict.js' );
		$document->addScript( JURI::root().'components/com_bootcampleaderboards/script/slimbox/js/slimbox2.js' );
		
		$html = array();
                
                $db = JFactory::getDBO();
                
                $query = "SELECT 'leaderboard_name', 'leaderboard_class' FROM #__bootcamp_leaderboards WHERE leaderboard_id='.$this->match->match_leaderboard_id.'";
                $leaderboard = $db->setQuery($query);
                
                $query = 'SELECT result_points FROM #__bootcamp_leaderboards_results WHERE result_match='.$this->match->match_id.' AND result_team='.$this->match->match_team1_id.' ORDER BY result_team_staff_rank DESC';
                $points1 = $db->setQuery($query);
                
                $query = 'SELECT result_points FROM #__bootcamp_leaderboards_results WHERE result_match='.$this->match->match_id.' AND result_team='.$this->match->match_team2_id.' ORDER BY result_team_staff_rank DESC';
                $points2 = $db->setQuery($query);
                
                $query = "SELECT 'lineup_team_member_1_name', 'lineup_team_member_2_name', 'lineup_team_member_3_name', 'lineup_team_member_4_name', 'lineup_team_member_5_name' FROM #__bootcamp_leaderboards_matches_lineups WHERE lineup_match_id='.$this->match->match_id.' AND lineup_team_id='.$this->match->match_team1_id.'";
                $teammembers1 = $db->setQuery($query);
                
                $query = "SELECT 'lineup_team_member_1_name', 'lineup_team_member_2_name', 'lineup_team_member_3_name', 'lineup_team_member_4_name', 'lineup_team_member_5_name' FROM #__bootcamp_leaderboards_matches_lineups WHERE lineup_match_id='.$this->match->match_id.' AND lineup_team_id='.$this->match->match_team2_id.'";
                $teammembers2 = $db->setQuery($query);
                
                $query = "SELECT 'referee_name' FROM #__bootcamp_leaderboards_referee WHERE referee_id='.$this->match->match_referee_id.'";
                $referee = $db->setQuery($query);
                
                if ($this->match->match_state == 0) {
                    $matchstate = JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_MATCH_SCHEDULED');
                }
                else
                {
                    if ($this->match->match_state == 1) {
                        $matchstate = JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_MATCH_STATE_PLAYED');
                    }
                    else
                    {
                        $matchstate = JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_MATCH_STATE_FORFEIT');
                    }
                }
                
                $totalpoints1 = $points1[0]+$points1[1]+$points1[2]+$points1[3]+$points1[4];
                $totalpoints2 = $points2[0]+$points2[1]+$points2[2]+$points2[3]+$points2[4];
                
                //Leaderboard
                $html[] = ' <table align="center">';
                $html[] = '     <tbody>';
                $html[] = '         <tr>';
                $html[] = '             <td colspan="3">';
                $html[] = '                 <div class="module mod-metal style-metal">';
                $html[] = '                     <div class="deepest">';
                $html[] = '                         <table align="center">';
                $html[] = '                             <tbody>';
                $html[] = '                                 <tr>';
                $html[] = '                                     <td>';
                $html[] = '                                         <h3 class="module-title" align="center">';
                $html[] = '                                             <span class="color">';
                $html[] = '                                                 '.$leaderboard[1].'<br /> ';
                $html[] = '                                             </span>';
                $html[] = '                                             '.$leaderboard[2];
                $html[] = '                                         </h3>';
                $html[] = '                                     </td>';
                $html[] = '                                 </tr>';
                $html[] = '                             </tbody>';
                $html[] = '                         </table>';
                $html[] = '                     </div>';
                $html[] = '                 </div>';
                $html[] = '             </td>';
                $html[] = '         </tr>';
                //Teams
                $html[] = '         <tr>';
                //Team 1
                $html[] = '             <td width="45%">';
                $html[] = '                 <div class="module mod-color style-color">';
                $html[] = '                     <div class="deepest">';
                $html[] = '                         <h3 align="center" class="module-title">';
                $html[] = '                             <span class="color">';
                $html[] = '                                 '.JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_MATCH_TEAM1_1');
                $html[] = '                             </span> ';
                $html[] = '                             '.JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_MATCH_TEAM1_2');
                $html[] = '                         </h3>';
                if ($this->match->match_team1_logo != '')
                {
                    $html[] = '                     <img src="'.$this->match->match_team1_logo.'" align="center" alt="'.$this->match->match_team1_name.'" style="display: block; margin-left: auto; margin-right: auto;" />';
                }
                else
                {
                    $html[] = '                     <img src="'.JURI::root().'components/com_bootcampleaderboards/images/defaultteamimage.png" align="center" alt="'.$this->match->match_team1_name.'" style="display: block; margin-left: auto; margin-right: auto;" />';
                }
                $html[] = '                         <p align="center">';
                $html[] = '                             <h2 class="module-title" align="center">'.$this->match->match_team1_name.'</h2>';
                $html[] = '                             <h3 class="module-title" align="center">'.$totalpoints1.'</h3>';
                $html[] = '                             <strong>';
                $html[] = '                                 '.JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_MATCH_LINEUP').'::';
                $html[] = '                             </strong>';
                $html[] = '                         </p>';
                $html[] = '                         <table class="zebra">';
                $html[] = '                             <tbody>';
                $html[] = '                                 <tr class="odd">';
                $html[] = '                                     <td>';
                $html[] = '                                         '.$teammembers1[0].' (TL)';
                $html[] = '                                     </td>';
                $html[] = '                                     <td>';
                $html[] = '                                         '.$points1[0].' Points';
                $html[] = '                                     </td>';
                $html[] = '                                 </tr>';
                $html[] = '                                 <tr>';
                $html[] = '                                     <td>';
                $html[] = '                                         '.$teammembers1[1];
                $html[] = '                                     </td>';
                $html[] = '                                     <td>';
                $html[] = '                                         '.$points1[1].' Points';
                $html[] = '                                     </td>';
                $html[] = '                                 </tr>';
                $html[] = '                                 <tr class="odd">';
                $html[] = '                                     <td>';
                $html[] = '                                         '.$teammembers1[2];
                $html[] = '                                     </td>';
                $html[] = '                                     <td>';
                $html[] = '                                         '.$points1[2].' Points';
                $html[] = '                                     </td>';
                $html[] = '                                 </tr>';
                $html[] = '                                 <tr>';
                $html[] = '                                     <td>';
                $html[] = '                                         '.$teammembers1[3];
                $html[] = '                                     </td>';
                $html[] = '                                     <td>';
                $html[] = '                                         '.$points1[3].' Points';
                $html[] = '                                     </td>';
                $html[] = '                                 </tr>';
                $html[] = '                                 <tr class="odd">';
                $html[] = '                                     <td>';
                $html[] = '                                         '.$teammembers1[4];
                $html[] = '                                     </td>';
                $html[] = '                                     <td>';
                $html[] = '                                         '.$points1[4].' Points';
                $html[] = '                                     </td>';
                $html[] = '                                 </tr>';
                $html[] = '                             </tbody>';
                $html[] = '                         </table>';
                $html[] = '                     </div>';
                $html[] = '                 </div>';
                $html[] = '             </td>';
                // vs.
                $html[] = '             <td width="10%">';
                $html[] = '                 <h3 align="center" class="module-title">';
                $html[] = '                     vs.';
                $html[] = '                 </h3>';
                $html[] = '             </td>';
                // Team 2 
                $html[] = '             <td width="45%">';
                $html[] = '                 <div class="module mod-color style-color">';
                $html[] = '                     <div class="deepest">';
                $html[] = '                         <h3 align="center" class="module-title">';
                $html[] = '                             <span class="color">';
                $html[] = '                                 '.JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_MATCH_TEAM2_1');
                $html[] = '                             </span> ';
                $html[] = '                             '.JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_MATCH_TEAM2_2');
                $html[] = '                         </h3>';
                if ($this->match->match_team2_logo != '')
                {
                    $html[] = '                     <img src="'.$this->match->match_team2_logo.'" align="center" alt="'.$this->match->match_team2_name.'" style="display: block; margin-left: auto; margin-right: auto;" />';
                }
                else
                {
                    $html[] = '                     <img src="'.JURI::root().'components/com_bootcampleaderboards/images/defaultteamimage.png" align="center" alt="'.$this->match->match_team2_name.'" style="display: block; margin-left: auto; margin-right: auto;" />';
                }
                $html[] = '                         <p align="center">';
                $html[] = '                             <h2 class="module-title" align="center">'.$this->match->match_team2_name.'</h2>';
                $html[] = '                             <h3 class="module-title" align="center">'.$totalpoints2.'</h3>';
                $html[] = '                             <strong>';
                $html[] = '                                 '.JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_MATCH_LINEUP').'::';
                $html[] = '                             </strong>';
                $html[] = '                         </p>';
                $html[] = '                         <table class="zebra">';
                $html[] = '                             <tbody>';
                $html[] = '                                 <tr class="odd">';
                $html[] = '                                     <td>';
                $html[] = '                                         '.$teammembers2[0].' (TL)';
                $html[] = '                                     </td>';
                $html[] = '                                     <td>';
                $html[] = '                                         '.$points2[0].' Points';
                $html[] = '                                     </td>';
                $html[] = '                                 </tr>';
                $html[] = '                                 <tr>';
                $html[] = '                                     <td>';
                $html[] = '                                         '.$teammembers2[1];
                $html[] = '                                     </td>';
                $html[] = '                                     <td>';
                $html[] = '                                         '.$points2[1].' Points';
                $html[] = '                                     </td>';
                $html[] = '                                 </tr>';
                $html[] = '                                 <tr class="odd">';
                $html[] = '                                     <td>';
                $html[] = '                                         '.$teammembers2[2];
                $html[] = '                                     </td>';
                $html[] = '                                     <td>';
                $html[] = '                                         '.$points2[2].' Points';
                $html[] = '                                     </td>';
                $html[] = '                                 </tr>';
                $html[] = '                                 <tr>';
                $html[] = '                                     <td>';
                $html[] = '                                         '.$teammembers2[3];
                $html[] = '                                     </td>';
                $html[] = '                                     <td>';
                $html[] = '                                         '.$points2[3].' Points';
                $html[] = '                                     </td>';
                $html[] = '                                 </tr>';
                $html[] = '                                 <tr class="odd">';
                $html[] = '                                     <td>';
                $html[] = '                                         '.$teammembers2[4];
                $html[] = '                                     </td>';
                $html[] = '                                     <td>';
                $html[] = '                                         '.$points2[4].' Points';
                $html[] = '                                     </td>';
                $html[] = '                                 </tr>';
                $html[] = '                             </tbody>';
                $html[] = '                         </table>';
                $html[] = '                     </div>';
                $html[] = '                 </div>';
                $html[] = '             </td>';
                $html[] = '         </tr>';
                //Match Details
                $html[] = '         <tr>';
                $html[] = '             <td colspan="3">';
                $html[] = '                 <div class="module mod-metal style-metal">';
                $html[] = '                     <div class="deepest">';
                $html[] = '                         <table align="center">';
                $html[] = '                             <tbody>';
                $html[] = '                                 <tr>';
                $html[] = '                                     <td>';
                $html[] = '                                         <dl class="separator">';
                $html[] = '                                             <dt><em class="box">'.JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_MATCH_DATE').'</em></dt>';
                $html[] = '                                                 <dd>'.$this->match->match_date.'</dd>';
                $html[] = '                                             <dt><em class="box">'.JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_MATCH_REFEREE').'</em></dt>';
                $html[] = '                                                 <dd>'.$referee.'</dd>';
                $html[] = '                                             <dt><em class="box">'.JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_MATCH_DESCRIPTION').'</em></dt>';
                $html[] = '                                                 <dd>'.$this->match->match_decription.'</dd>';
                $html[] = '                                             <dt><em class="box">'.JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_MATCH_STATE').'</em></dt>';
                $html[] = '                                                 <dd>'.$matchstate.'</dd>';
                if ($this->match->match_state == 1) {
                    if ($totalpoints1 == $totalpoints2)
                    {
                        $html[] = '                                     <dt><em class="box">'.JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_MATCH_OUTCOME').'</em></dt>';
                        $html[] = '                                         <dd>'.JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_MATCH_STATE_DRAW').'</dd>';
                    }				
                    if ($totalpoints1 > $totalpoints2)
                    {
                        $html[] = '                                     <dt><em class="box">'.JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_MATCH_OUTCOME').'</em></dt>';
                        $html[] = '                                         <dd>'.JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_MATCH_STATE_T1_WINNER').'</dd>';
                    }
                    if ($totalpoints1 < $totalpoints2)
                    {
                        $html[] = '                                     <dt><em class="box">'.JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_MATCH_OUTCOME').'</em></dt>';
                        $html[] = '                                         <dd>'.JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_MATCH_STATE_T2_WINNER').'</dd>';
                    }
                    $html[] = '                                         <dt><em class="box">'.JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_MATCH_NOTES').'</em></dt>';
                    $html[] = '                                             <dd>'.$this->match->match_notes.'</dd>';
                    $html[] = '                                     </dl>';
                    
                    $parts = pathinfo(JURI::root().$this->match->match_result_screenshot);		
                    $imagepath = $parts['dirname'].'/thumbs/'.$parts['basename'];
					
                    $html[] = '<a href="'.$imagepath.'" rel="lightbox-screens" title="'. $this->match->match_name . ' - ' . $totalpoints1 . ' : ' . $totalpoints2 . '">';
                    $html[] = '<img src="'.JURI::root().$this->match->match_result_screenshot.'" alt="' . $imagepath . '" title="' . $this->match->match_name . '" height="100" width="200"/>'; 	
                    $html[] = '</a>';                    
                }
                else
                {
                    if ($this->match->match_state == 2) {
                        $html[] = '                                     <dt><em class="box">'.JText::_('COM_BOOTCAMPLEADERBOARDS_TEMPLATE_MATCH_ISSUES').'</em></dt>';
                        $html[] = '                                         <dd>'.$this->match->match_issues.'</dd>';
                        $html[] = '                                 </dl>';
                    }
                    else
                    {
                        $html[] = '                                 </dl>';
                    }
                }
                $html[] = '                                     </td>';
                $html[] = '                                 </tr>';
                $html[] = '                             </tbody>';
                $html[] = '                         </table>';
                $html[] = '                     </div>';
                $html[] = '                 </div>';
                $html[] = '             </td>';
                $html[] = '         </tr>';
                $html[] = '     </tbody>';
                $html[] = ' </table>';	
	}	
}
