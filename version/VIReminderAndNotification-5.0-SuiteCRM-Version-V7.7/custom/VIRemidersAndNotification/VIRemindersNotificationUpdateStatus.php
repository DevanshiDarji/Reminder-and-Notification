<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
class VIRemindersNotificationUpdateStatus{
    public function __construct(){
        $this->updateRemindersNotifcationStatus();
    } 
    public function updateRemindersNotifcationStatus(){
        $dateModified = date("Y-m-d H:i:s");
        if(isset($_REQUEST['id']) && isset($_REQUEST['enableRemindersNotification'])){
            $fieldData = array('status'=>"'".$_REQUEST['enableRemindersNotification']."'",'date_modified'=>"'".$dateModified."'");
            $where = array('id'=>$_REQUEST['id']);
            $updateReminderNotificationStatus = updateReminderNotificationRecord("vi_reminders_notifications", $fieldData, $where);
        }else if(isset($_REQUEST['recordId']) && isset($_REQUEST['enableRemindersNotification'])){
            $recordIds = explode(',', $_REQUEST['recordId']);
            foreach($recordIds as $id){
                $fieldNames = array('status'=>"'".$_REQUEST['enableRemindersNotification']."'", 'date_modified'=>"'".$dateModified."'");
                $whereCondition = array('id'=>$id);
                $updateReminderNotificationStatus = updateReminderNotificationRecord("vi_reminders_notifications", $fieldNames, $whereCondition);
            } 
        }
        if(!empty($updateReminderNotificationStatus)){
            echo 1;
        }else{
            echo 0;
        }
    }
}//end of class
new VIRemindersNotificationUpdateStatus();
?>
