<?php
/*********************************************************************************
 * This file is part of package Reminder And Notification.
 * 
 * Author : Variance InfoTech PVT LTD (http://www.varianceinfotech.com)
 * All rights (c) 2020 by Variance InfoTech PVT LTD
 *
 * This Version of Reminder And Notification is licensed software and may only be used in 
 * alignment with the License Agreement received with this Software.
 * This Software is copyrighted and may not be further distributed without
 * written consent of Variance InfoTech PVT LTD
 * 
 * You can contact via email at info@varianceinfotech.com
 * 
 ********************************************************************************/
require_once("custom/VIRemidersAndNotification/VIRemindersAndNotificationFunction.php");
class Viewvi_reminderandnotificationlistview extends SugarView {
    public function __construct() {
        parent::SugarView();
    }
    //display Method
    public function display() {
        global $theme, $mod_strings, $current_user, $app_list_strings;

        $dateFormat = $current_user->getPreference('datef');

        $fieldNames = array('*');
        $whereCondition = array('deleted'=>0);
        $orderby = array('date_modified'=>'DESC');
        $getReminderNotificationData = getReminderNotificationRecord('vi_reminders_notifications', $fieldNames, $innerJoin=array(), $onData=array(), $whereCondition, $orderby, $limit=array());
        $getReminderNotificationDataResult = $GLOBALS['db']->query($getReminderNotificationData);
       
        $reminderNotificationData = array();
        if(!empty($getReminderNotificationDataResult)){
            while($getReminderNotificationDataRow = $GLOBALS['db']->fetchByAssoc($getReminderNotificationDataResult)){
                $bean = BeanFactory::newBean($getReminderNotificationDataRow['module']);
                if($getReminderNotificationDataRow['notification_field'] != ""){
                    $fieldDef = $bean->field_defs[$getReminderNotificationDataRow['notification_field']];
                }else if($getReminderNotificationDataRow['trigger_notification_field'] != ""){
                    $fieldDef = $bean->field_defs[$getReminderNotificationDataRow['trigger_notification_field']];
                }
                $notificationField = translate($fieldDef['vname'], $getReminderNotificationDataRow['module']);
                if(strpos($notificationField, ':')){
                    $notificationField = substr_replace($notificationField, "", -1);
                }

                $reminderNotificationData[] = array(
                    "id" => $getReminderNotificationDataRow['id'],
                    "module" => $app_list_strings['moduleList'][$getReminderNotificationDataRow['module']],
                    "notificationField" => $notificationField,
                    "status" => $getReminderNotificationDataRow['status'],
                    "dateEntered" => date($dateFormat.' '.'H:i',strtotime($getReminderNotificationDataRow['date_entered'])),
                    "dateModified" => date($dateFormat.' '.'H:i',strtotime($getReminderNotificationDataRow['date_modified']))
                );
            }
        }

        $url = "https://suitehelp.varianceinfotech.com";
        $helpBoxContent = getReminderNotificationHelpBoxHtml($url);

        $editViewURL="index.php?module=Administration&action=vi_reminderandnotificationeditview";
        $listViewURL="index.php?module=Administration&action=vi_reminderandnotificationlistview";

        $smarty = new Sugar_Smarty();

        $smarty->assign('THEME', $theme);
        $smarty->assign('MOD', $mod_strings);
        $smarty->assign("REMINDERNOTIFICATIONDATA", $reminderNotificationData);
        $smarty->assign('HELPBOXCONTENT', $helpBoxContent);
        $smarty->assign("EDITVIEWURL", $editViewURL);
        $smarty->assign("LISTVIEWURL", $listViewURL);
        
        parent::display();
        $smarty->display('custom/modules/Administration/tpl/vi_reminderandnotificationlistview.tpl');            
    }//end of display
}//end of class
?>

