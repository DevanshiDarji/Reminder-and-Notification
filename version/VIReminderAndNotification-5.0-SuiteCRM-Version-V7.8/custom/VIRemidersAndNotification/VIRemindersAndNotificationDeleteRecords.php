<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
 
require_once("custom/VIRemidersAndNotification/VIRemindersAndNotificationFunction.php");
class VIRemindersAndNotificationDeleteRecords{
    public function __construct(){
        $this->deleteReminderNotificationRecords();
    } 
    public function deleteReminderNotificationRecords(){
        if(isset($_POST['delId'])){
            $delId = explode(',',$_POST['delId']);
            foreach($delId as $id){
                //Update Reminder Notification Config Deleted = 1 
                $fieldData = array('deleted' => 1);
                $whereCondition = array('id' => $id);
                $updateReminderNotificationResult = updateReminderNotificationRecord('vi_reminders_notifications', $fieldData, $whereCondition);

                //Update Reminder Notification Condition Deleted = 1 
                $whereCondition = array('reminder_notification_id' => $id);
                $updateReminderNotificationResult = updateReminderNotificationRecord('vi_reminders_notification_condition', $fieldData, $whereCondition);
            }//end of foreach
            
            if(!empty($updateReminderNotificationResult)){
                echo 1;
            }else{
                echo 0;
            }
        }//end of if
    }//end of function   
}//end of class
new VIRemindersAndNotificationDeleteRecords();
?>