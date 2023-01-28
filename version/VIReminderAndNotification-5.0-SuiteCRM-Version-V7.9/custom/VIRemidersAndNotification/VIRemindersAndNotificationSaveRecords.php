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
class VIRemindersAndNotificationSaveRecords{
    public function __construct(){
        $this->saveReminderNotificationConfig();
    }
    
    //Add Data
    public function saveReminderNotificationConfig(){
        global $current_user, $timedate, $sugar_config;

        parse_str($_POST['val'], $formData);
        
        $allUserChkVal = $checkboxVal = "0"; 

        if(isset($formData['allUsers']) && $formData['allUsers'] == "1"){
            $allUserChkVal = $formData['allUsers']; 
        }

        if(isset($formData['sendNotificationReceiver']) && $formData['sendNotificationReceiver'] == "1"){
            $checkboxVal = $formData['sendNotificationReceiver']; 
        }

        $users = $relatedModule = $relateFields = $emailNotification = $templateType = $templates = "";

        if(isset($formData['users'])){
            $users = implode(',',$formData['users']); 
        }
  
        if(isset($formData['relatedModule'])){
            $relatedModule = $formData['relatedModule']; 
        }

        if(isset($formData['relateFields'])){
            $relateFields = implode(',', $formData['relateFields']); 
        }

        if(isset($formData['emailNotification'])){
            $emailNotification = $formData['emailNotification'];
        }
    
        if(isset($formData['templateType'])){
            $templateType = $formData['templateType'];
        }
    
        if(isset($formData['templates'])){
            $templates = $formData['templates'];
        }
        
        //current time
        $datetime = new datetime();
        $timedates = new TimeDate();
        $formattedDate = $timedates->asUser($datetime, $current_user);
        $currentDate = date('Y-m-d H:i', strtotime($formattedDate));
    
        //Get Image for Notification
        $theme = $_REQUEST['theme'];
        $moduleName = get_singular_bean_name(translate($formData['module']));
        $filename = "themes/$theme/images/$moduleName.gif";
        if (!file_exists($filename)) {
            $imagePath = "custom/modules/Administration/image/$moduleName.gif";
            if(file_exists($imagePath)){
                $copyimage = copy($imagePath, $filename);
            }
        }
        if(isset($_REQUEST['templateId']) && $_REQUEST['templateId'] != ""){
            $templateId = $_REQUEST['templateId'];
        }else{
            $templateId = 0;
        }

        $templateMessage = html_entity_decode($_REQUEST['templateMessage']); 

        //All Condition block field value
        $allConditionFieldName = $allConditionOperatorName = $allConditionValueType = $allConditionFieldValue = "";

        if(isset($formData['aowAllConditionsField'])){
            $allConditionFieldName = $formData['aowAllConditionsField'];
        }
        if(isset($formData['aowAllConditionsOperator'])){
            $allConditionOperatorName = $formData['aowAllConditionsOperator'];
        }
        if(isset($formData['aowAllConditionsValueType'])){
            $allConditionValueType = $formData['aowAllConditionsValueType'];
        }
        if(isset($formData['aowAllConditionsValue'])){
            $allConditionFieldValue = $formData['aowAllConditionsValue'];
        }

        //Any Condition block field value
        $anyConditionFieldName = $anyConditionOperatorName = $anyConditionValueType = $anyConditionFieldValue = "";

        if(isset($formData['aowAnyConditionsField'])){
            $anyConditionFieldName = $formData['aowAnyConditionsField'];
        }
        if(isset($formData['aowAnyConditionsOperator'])){
            $anyConditionOperatorName = $formData['aowAnyConditionsOperator'];
        }
        if(isset($formData['aowAnyConditionsValueType'])){
            $anyConditionValueType = $formData['aowAnyConditionsValueType'];
        }
        if(isset($formData['aowAnyConditionsValue'])){
            $anyConditionFieldValue = $formData['aowAnyConditionsValue'];
        }

        if($formData['triggerAction'] == "Immediate Notification" || $formData['triggerAction'] == "Now"){
            $formData['triggerValue'] = '0';
            $formData['triggerPeriod'] = '';
        }

        $reminderNotificationData = array('subject'=>"'".$formData['subject']."'", 'module'=>"'".$formData['module']."'", 'notification_field'=>"'".$formData['fieldNotification']."'", 'comparison_field'=>"'".$formData['fieldcomparison']."'", 'trigger_value'=>"'".$formData['triggerValue']."'", 'trigger_period'=>"'".$formData['triggerPeriod']."'", 'trigger_action'=>"'".$formData['triggerAction']."'", 'triggerMonthValue'=>"'".$formData['triggerMonthValue']."'",'trigger_notification_field'=>"'".$formData['triggerNotificationModuleFields']."'", 'reminder_message'=>"'".$formData['reminderMessage']."'", 'status'=>$formData['status'], 'conditional_operator'=>"'".$formData['conditionalOperator']."'", 'enable_users'=>"'".$allUserChkVal."'", 'allUsersId'=>"'".$users."'", 'related_module'=>"'".$relatedModule."'", 'relate_fields'=>"'".$relateFields."'", 'enable_notification'=>"'".$checkboxVal."'", 'email_notification'=>"'".$emailNotification."'", 'templates'=>"'".$templateType."'", 'template_message'=>"'".$templateMessage."'");
        $databaseType = $sugar_config['dbconfig']['db_type'];

        if($_REQUEST['id'] == ''){
            $reminderNotificationId = create_guid();
            if($templateType == 1){
                $templateData = array('template_type'=>"'".$templates."'", 'template_body'=>"'".$templateMessage."'", 'defualt_template'=>0);
                $insTemplateData = insertReminderNotificationRecord('vi_templates_notifications', $templateData);
                if($databaseType == "mssql"){
                    $getTemplateData = "SELECT TOP 1 * FROM vi_templates_notifications ORDER BY id DESC";
                }else{
                    $fieldNames = array('*');
                    $orderBy = array('id'=>'DESC');
                    $limit = array('0'=>'1');
                    $getTemplateData = getReminderNotificationRecord('vi_templates_notifications', $fieldNames, $innerJoin=array(), $onData = array(), $where=array(), $orderBy, $limit);
                }
               
                $getTemplateRow = $GLOBALS['db']->fetchOne($getTemplateData);
                if($getTemplateRow['id'] == ""){
                    $templateId = 0;
                }else{
                    $templateId = $getTemplateRow['id'];
                }   
            }

            $reminderNotificationData = array_slice($reminderNotificationData, 0, 0, true) +array("id" => "'".$reminderNotificationId."'") + array_slice($reminderNotificationData, 0, count($reminderNotificationData), true);
            $reminderNotificationData = array_slice($reminderNotificationData, 0, 1, true) +array("template_id" => "'".$templateId."'") + array_slice($reminderNotificationData, 1, count($reminderNotificationData), true);

            $reminderNotificationData['date_entered'] = "'".$currentDate."'";
            $reminderNotificationData['date_modified'] = "'".$currentDate."'";

            $reminderNotificationResult = insertReminderNotificationRecord('vi_reminders_notifications', $reminderNotificationData);
        }else{
            $reminderNotificationId = $_REQUEST['id'];
            if($templateType == 1){
                $templateData = array('template_type'=>"'".$templates."'", 'template_body'=>"'".$templateMessage."'", 'defualt_template'=>0);
                $insTemplateDataResult = insertReminderNotificationRecord('vi_templates_notifications', $templateData);

                if($databaseType == "mssql"){
                    $getTemplateData = "SELECT TOP 1 * FROM vi_templates_notifications ORDER BY id DESC";
                }else{
                    $fieldNames = array('id');
                    $orderBy = array('id'=>'DESC');
                    $limit = array('0'=>'1');
                    $getTemplateData = getReminderNotificationRecord('vi_templates_notifications', $fieldNames, $innerJoin=array(), $onData = array(), $where=array(), $orderBy, $limit);
                }
                $getTemplateRow= $GLOBALS['db']->fetchOne($getTemplateData);

                $templateId = $getTemplateRow['id'];

                $fieldData = array('template_type'=>"'".$templates."'",'template_id'=>"'".$templateId."'",'template_message'=>"'".$templateMessage."'",'date_modified'=>"'".$currentDate."'");
                $whereCondition = array('id'=>$reminderNotificationId,'deleted'=>0);
                $updateReminderTempateData = updateReminderNotificationRecord('vi_reminders_notifications', $fieldData, $whereCondition);
            }
            $whereCondition = array('id'=>$reminderNotificationId);

            $reminderNotificationData = array_slice($reminderNotificationData, 0, 0, true) +array("template_id" => "'".$templateId."'") + array_slice($reminderNotificationData, 0, count($reminderNotificationData), true);
            $reminderNotificationData['date_modified'] = "'".$currentDate."'";
          
            $reminderNotificationResult = updateReminderNotificationRecord('vi_reminders_notifications', $reminderNotificationData, $whereCondition);

            //delete Reminder Notificatin Conditions Data
            $whereCondition = array('reminder_notification_id' => "'".$reminderNotificationId."'");
            $deleteDataResult = deleteReminderNotificationConditionData('vi_reminders_notification_condition', $whereCondition);
        }
        
        $allConditionId = $anyConditionId = array();
        //Update Reminder Notification All Condition Data
        if(isset($formData['aowAllConditionsDeleted']) && !empty($formData['aowAllConditionsDeleted'])){
            $allDelId = $formData['aowAllConditionsDeleted'];
        }//end of if

        //Update Reminder Notification Any Condition Data
        if(isset($formData['aowAnyConditionsDeleted']) && !empty($formData['aowAnyConditionsDeleted'])){
            $anyDelId = $formData['aowAnyConditionsDeleted'];
        }//end of if

        //All Condition module_path
        if(isset($formData['aowAllConditionsModulePath']) && !empty($formData['aowAllConditionsModulePath'])){
            foreach($formData['aowAllConditionsModulePath'] as $keys => $values) {
                foreach ($values as $key => $value) {
                    $id = create_guid();
                    $insConditionModuleData = array('id' => "'".$id."'", 'module_path' => "'".$value."'", 'reminder_notification_id' => "'".$reminderNotificationId."'", 'condition_type' => "'All'", 'date_entered' => "'".$currentDate."'");
                    $insResult = insertReminderNotificationRecord('vi_reminders_notification_condition', $insConditionModuleData);
                    $allConditionId[] = $id;  
                }//end of if 
            }//end of foreach
        }
 
        //All Condition field 
        if(isset($allConditionFieldName) && !empty($allConditionFieldName)){
            foreach($allConditionFieldName as $key => $value) {
                $updateFieldData = array('field' => "'".$value."'", 'deleted' => $allDelId[$key]);
                $where = array('id' =>$allConditionId[$key]);
                $updateData = updateReminderNotificationRecord('vi_reminders_notification_condition', $updateFieldData, $where);
            }//end of foreach
        }
        
        //All Condition operator
        if(isset($allConditionOperatorName) && !empty($allConditionOperatorName)){
            foreach($allConditionOperatorName as $key => $value) {
                $updateOperatorData = array('operator' => "'".$value."'", 'deleted' => $allDelId[$key]);
                $where = array('id' =>$allConditionId[$key]);
                $updateData = updateReminderNotificationRecord('vi_reminders_notification_condition', $updateOperatorData, $where);
            }//end of foreach
        }

        //All Condition value type
        if(isset($allConditionValueType) && !empty($allConditionValueType)){
            foreach($allConditionValueType as $key => $value) {
                $updateValueTypeData = array('value_type' => "'".$value."'", 'deleted' => $allDelId[$key]);
                $where = array('id' =>$allConditionId[$key]);
                $updateData = updateReminderNotificationRecord('vi_reminders_notification_condition', $updateValueTypeData, $where);
            }//end of foreach
        }

        //All Condition value
        if(isset($allConditionFieldValue) && !empty($allConditionFieldValue)){
            foreach($allConditionFieldValue as $key => $values) {
                $field = $allConditionFieldName[$key];
                $getallConditionValueType = $allConditionValueType[$key];
                if($field != "product" && $field != "part_number" && $field != "product_qty" && $field != "product_list_price" && $field != "product_discount" && $field != "vat_amt" && $field != "product_unit_price" && $field != "discount" && $field != "vat"){
                    $values = getFieldValues($formData['module'], $field, $values, $getallConditionValueType);   
                }
                
                $updateValueData = array('value' => "'".$values."'", 'deleted' => $allDelId[$key]);
                $where = array('id' =>$allConditionId[$key]);
                $updateData = updateReminderNotificationRecord('vi_reminders_notification_condition', $updateValueData, $where);         
            }//end of foreach
        }

        //Any Condition module_path
        if(isset($formData['aowAnyConditionsModulePath']) && !empty($formData['aowAnyConditionsModulePath'])){
            foreach($formData['aowAnyConditionsModulePath'] as $keys => $values) {
                foreach ($values as $key => $value) {
                    $id = create_guid();
                    $insConditionModuleData = array('id' => "'".$id."'", 'module_path' => "'".$value."'", 'reminder_notification_id' => "'".$reminderNotificationId."'", 'condition_type' => "'Any'", 'date_entered' => "'".$currentDate."'");
                    $insResult = insertReminderNotificationRecord('vi_reminders_notification_condition', $insConditionModuleData);
                    $anyConditionId[] = $id;  
                }//end of if 
            }//end of foreach
        }

        //Any Condition field 
        if(isset($anyConditionFieldName) && !empty($anyConditionFieldName)){
            foreach($anyConditionFieldName as $key => $value) {
                $updateFieldData = array('field' => "'".$value."'", 'deleted' => $anyDelId[$key]);
                $where = array('id' => $anyConditionId[$key]);
                $updateData = updateReminderNotificationRecord('vi_reminders_notification_condition', $updateFieldData, $where);
            }//end of foreach
        }

        //Any Condition operator
        if(isset($anyConditionOperatorName) && !empty($anyConditionOperatorName)){
            foreach($anyConditionOperatorName as $key => $value) {
                $updateOperatorData = array('operator' => "'".$value."'", 'deleted' => $anyDelId[$key]);
                $where = array('id' => $anyConditionId[$key]);
                $updateData = updateReminderNotificationRecord('vi_reminders_notification_condition',$updateOperatorData, $where);
            }//end of foreach
        }

        //Any Condition value type
        if(isset($anyConditionValueType) && !empty($anyConditionValueType)){
            foreach($anyConditionValueType as $key => $value) {
                $updateValueTypeData = array('value_type' => "'".$value."'", 'deleted' => $anyDelId[$key]);
                $where = array('id' => $anyConditionId[$key]);
                $updateData = updateReminderNotificationRecord('vi_reminders_notification_condition', $updateValueTypeData, $where);
            }//end of foreach
        }

        //Any Condition value
        if(isset($anyConditionFieldValue) && !empty($anyConditionFieldValue)){
            foreach($anyConditionFieldValue as $key => $values) {
                $field = $anyConditionFieldName[$key];
                $getAnyConditionValueType = $anyConditionValueType[$key];
                if($field != "product" && $field != "part_number" && $field != "product_qty" && $field != "product_list_price" && $field != "product_discount" && $field != "vat_amt" && $field != "product_unit_price" && $field != "discount" && $field != "vat"){
                    $values = getFieldValues($formData['module'], $field, $values, $getAnyConditionValueType);   
                }
                $updateValueData = array('value' => "'".$values."'", 'deleted' => $anyDelId[$key]);
                $where = array('id' => $anyConditionId[$key]);
                $updateData = updateReminderNotificationRecord('vi_reminders_notification_condition', $updateValueData, $where);  
            }//end of foreach
        }
    }//end of function
}//end of class
new VIRemindersAndNotificationSaveRecords();
?>
