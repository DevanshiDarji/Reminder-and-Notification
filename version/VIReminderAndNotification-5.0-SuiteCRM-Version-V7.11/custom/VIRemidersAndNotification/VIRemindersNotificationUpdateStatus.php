<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
 
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
