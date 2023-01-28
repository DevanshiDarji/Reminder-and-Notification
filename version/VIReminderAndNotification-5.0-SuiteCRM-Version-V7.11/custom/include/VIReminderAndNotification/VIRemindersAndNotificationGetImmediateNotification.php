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
require_once('custom/VIRemidersAndNotification/VIRemindersAndNotificationFunction.php');
class VIRemindersAndNotificationGetImmediateNotification{
    static $already_ran = false; 
    function getImmediateNotification($bean, $event, $arguments){
    	if($_REQUEST['action'] == "Save"){
            global $current_user, $timedate;

            //current time
            $datetime = new datetime();
            $timedates = new TimeDate();
            $formattedDate = $timedates->asUser($datetime, $current_user);
            $currentTime = date('Y-m-d H:i', strtotime($formattedDate));

            if($_REQUEST['module'] != 'AOS_Contracts' && $_REQUEST['module'] != 'Documents'){
                if(self::$already_ran == true) return;self::$already_ran = true;
            }//end of if

            //fetch record id and module
            if(isset($_REQUEST['record']) && !empty($_REQUEST['record'])){
                $moduleName = $_REQUEST['module'];//module
                $recordId = $_REQUEST['record']; //record id
            }else{
                if(isset($bean->fetched_row['record_module'])){
                    $moduleName = $bean->fetched_row['record_module'];//module
                }else if(isset($bean->record_module)){
                    $moduleName = $bean->record_module;//module
                }else if(isset($bean->module_dir)){
                    $moduleName = $bean->module_dir;//module
                }else{
                    $moduleName = '';
                }//end of else

                if(isset($bean->fetched_row['record_id'])){
                    $recordId = $bean->fetched_row['record_id'];//record id
                }else if(isset($bean->record_id)){
                    $recordId = $bean->record_id;//record id
                }else if(isset($bean->id)){
                    $recordId = $bean->id;//record id
                }else{
                    $recordId = '';
                }//end of else

                if($moduleName == 'SugarFeed'){
                    $moduleName = $bean->related_module;
                    $recordId = $bean->related_id;
                }//end of if

                if($_REQUEST['module'] != $moduleName){
                    $moduleName = $_REQUEST['module'];
                }//end of if

                if($moduleName == 'AOS_Contracts'){
                    $moduleDir = $bean->module_dir;
                    if($moduleDir == "AOD_IndexEvent"){
                        $recordModule = $bean->record_module;
                        if($recordModule != $moduleName){
                            $recordId = '';
                        }else{
                            $recordId = $bean->record_id;
                        }//end of else
                    }else{
                        $recordId = $bean->record_id;//record id
                    } 
                }//end of if

                if($moduleName == 'Documents'){
                    $whereCondition = array('id' => "'".$recordId."'"); 
                    $getDocumentQuery = getReminderNotificationRecord('document_revisions', $fieldNames = array(), $innerJoin = array(), $onArray = array(), $whereCondition, $orderby = array(), $limit = array());
                    $getDocumentRow = $GLOBALS['db']->fetchOne($getDocumentQuery);
                    if(!empty($getDocumentRow)){
                        $recordId = $getDocumentRow['document_id'];
                    }
                }//end of if
            }//end of else
   
            if($recordId != ""){
                $fieldNames = array('*');
                $whereData = array('module' => $_REQUEST['module'], 'trigger_action' => 'Immediate Notification', 'status' => 1, 'deleted' => 0);
                $getReminderNotificationData = getReminderNotificationRecord('vi_reminders_notifications', $fieldNames, $innerJoin = array(), $onData = array(), $whereData, $orderby = array(), $limit = array());
                $getReminderNotificationResult = $GLOBALS['db']->query($getReminderNotificationData);

                if(!empty($getReminderNotificationResult)){
                    $recordData = $reminderNotificationData = $matchRecordsId = array();
                    $reminderNotificationData = getConfigDataforNotification($reminderNotificationData, $flag = 1, $getReminderNotificationResult);
                    $bean = BeanFactory::getBean($_REQUEST['module'], $recordId); //bean
                    foreach($reminderNotificationData as $moduleName => $reminderNotificationValues){
                        foreach($reminderNotificationValues as $moduleId => $configValues){ 
                            $matchConditionRecord = array();    
                            if(!empty($bean)){
                                $matchConditionRecord = getAllAnyConditions($recordId, $bean, $configValues, $_REQUEST['module'], $_REQUEST, $flag = 1);
                                if(!empty($matchConditionRecord)){
                                    if(in_array(1, $matchConditionRecord)){
                                        $conditionMatchedRecordId = array_keys($matchConditionRecord, 1);
                                        $matchRecordsId[$moduleName][$moduleId] =  $conditionMatchedRecordId;
                                    }else if(in_array(2, $matchConditionRecord)){
                                        $matchRecordsId[$moduleName][$moduleId] = array($recordId);
                                    }
                                }
                            }
                        }//end of foreach
                    }//end of foreach

                    //get condition values 
                    $conditions = getCheckConditionData($matchRecordsId, $recordData, $reminderNotificationData, $currentTime, $current_user, $flag = 0, $_REQUEST['record'], $timedates);
                }//end of if
            }
        }//end of if
    }//end of function
}//end of class
new VIRemindersAndNotificationGetImmediateNotification();
?>