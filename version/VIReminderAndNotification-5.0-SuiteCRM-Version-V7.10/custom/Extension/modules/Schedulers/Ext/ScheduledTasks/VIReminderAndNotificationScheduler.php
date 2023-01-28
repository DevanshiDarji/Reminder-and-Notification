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
array_push($job_strings,'reminderandnotification');

function reminderandnotification(){
    require_once('custom/VIRemidersAndNotification/VIRemindersAndNotificationFunction.php');
    
    global $current_user, $timedate;

    //current time
    $currentTime = date('Y-m-d H:i');
    
    $fieldNames = array('*');
    $whereData = array('status'=>1, 'deleted'=>0);
    $getReminderNotificationData = getReminderNotificationRecord('vi_reminders_notifications', $fieldNames, $innerJoin = array(), $onData = array(), $whereData, $orderby = array(), $limit = array());
    $getReminderNotificationResult = $GLOBALS['db']->query($getReminderNotificationData);
    
    $recordData = $reminderNotificationData = $matchRecordsIds = array();
    
    $reminderNotificationData = getConfigDataforNotification($reminderNotificationData, $flag = 0, $getReminderNotificationResult);

    foreach($reminderNotificationData['reminderNotificationData'] as $key => $value){
        foreach($value as $k => $val){
            if(isset($val['triggerAction']) && $val['triggerAction'] != "Immediate Notification"){
                    $matchConditionIds = matchCondition($key, $reminderNotificationData['allRecordsIds'][$key], $val);
                    if(!empty($matchConditionIds)){
                        if(in_array(1, $matchConditionIds)){
                            $conditionMatchedRecordIds = array_keys($matchConditionIds, 1);
                            $matchRecordsIds[$key][$k] =  $conditionMatchedRecordIds;
                        }else if(in_array(2, $matchConditionIds)){
                            $recordsIds = array();
                            foreach($reminderNotificationData['allRecordsIds'][$key] as $id => $date){
                                $recordsIds[] = $id;
                            }
                            $matchRecordsIds[$key][$k] =  $recordsIds;
                        }
                    }
                }
        }
    }//end of foreach

    getCheckConditionData($matchRecordsIds, $recordData, $reminderNotificationData, $currentTime, $current_user, $flag = 1, "", "");

    return true;   
}//end of function
?>