<?php
 
require_once('include/MVC/View/SugarView.php');
require_once("custom/VIRemidersAndNotification/VIRemindersAndNotificationFunction.php");
class Viewvi_reminderandnotificationeditview extends SugarView {
    public function __construct() {
        parent::init();
    }
    //display Method
    public function display() {
        global $mod_strings, $theme;

        $randNum = rand();

        $allModules = getAllModulesListForReminderAndNotification();

        $smarty = new Sugar_Smarty();
        if(isset($_REQUEST['records']) && !empty($_REQUEST['records'])){
            $recordId = $_REQUEST['records']; //record id

            $fieldNames = array('*');
            $whereData = array('id'=>$recordId,'deleted'=>0);
            $getReminderNotificationData = getReminderNotificationRecord('vi_reminders_notifications', $fieldNames, $innerJoin = array(), $onData = array(), $whereData, $orderby = array(), $limit = array());
            $reminderNotificationData = $GLOBALS['db']->fetchOne($getReminderNotificationData);

            $allEditUsers = explode(",", $reminderNotificationData['allUsersId']);
            $editUsers = array();
            foreach($allEditUsers as $key => $value){
                $editUsers[$value] = $value; 
            }
    
            $whereData = array('id' => $reminderNotificationData['template_id']);
            $getReminderNotificationTemplateData = getReminderNotificationRecord('vi_templates_notifications', $fieldNames, $innerJoin = array(), $onData = array(), $whereData, $orderby = array(), $limit = array());
            $getReminderNotificationTemplateRow = $GLOBALS['db']->fetchOne($getReminderNotificationTemplateData);
            
            $getTemplateData = array(
                "templateType" => $getReminderNotificationTemplateRow['template_type'],
                "templateBody" => html_entity_decode($getReminderNotificationTemplateRow['template_body'])
            );

            $smarty->assign('ALLEDITUSERS', $editUsers);  
            $smarty->assign('TEMPLATEDATA', $getTemplateData);
            $smarty->assign('REMINDERNOTIFICATIONDATA', $reminderNotificationData);            
            $smarty->assign('RECORDID', $recordId);

            $getAllConditionLines = getReminderNotificationConditionLines($recordId, $reminderNotificationData['module'], 'All', $randNum); //get all condition lines
            $getAnyConditionLines = getReminderNotificationConditionLines($recordId, $reminderNotificationData['module'], 'Any', $randNum); //get any condition lines

            $smarty->assign("REMINDER_NOTIFICATION_ALL_CONDITION_DATA", $getAllConditionLines); //Reminder Notification All Condition Data
            $smarty->assign("REMINDER_NOTIFICATION_ANY_CONDITION_DATA", $getAnyConditionLines); //Reminder Notification Any Condition Data
        }//end of if 

        
        $birthdayTemplateData = $marriageTemplateData = $workTemplateData = $otherTemplateData = array();
        
        $fieldNames = array('*');
        $orderby = array('id'=>'ASC');
        $getReminderNotificationTemplateData = getReminderNotificationRecord('vi_templates_notifications', $fieldNames, $innerJoin=array(), $onData=array(), $whereData=array(), $orderby, $limit=array());
        $getReminderNotificationTemplateResult = $GLOBALS['db']->query($getReminderNotificationTemplateData);
        
        while($getReminderNotificationTemplateRow=$GLOBALS['db']->fetchByAssoc($getReminderNotificationTemplateResult)){
            if($getReminderNotificationTemplateRow['template_type'] == 'Birthday Templates'){
                $birthdayTemplateData[$getReminderNotificationTemplateRow['id']] = html_entity_decode($getReminderNotificationTemplateRow['template_body']);
            }
            if($getReminderNotificationTemplateRow['template_type'] == 'Marriage Anniversary Templates'){
                $marriageTemplateData[$getReminderNotificationTemplateRow['id']] = html_entity_decode($getReminderNotificationTemplateRow['template_body']);
            }
            if($getReminderNotificationTemplateRow['template_type'] == 'Work Anniversary Templates'){
                $workTemplateData[$getReminderNotificationTemplateRow['id']] = html_entity_decode($getReminderNotificationTemplateRow['template_body']);
            }
            if($getReminderNotificationTemplateRow['template_type'] == 'Other Templates'){
                $otherTemplateData[$getReminderNotificationTemplateRow['id']] = html_entity_decode($getReminderNotificationTemplateRow['template_body']);
            }
        }

        $allUsers = getAllUsers();

        $helpLineImagePath = 'custom/modules/Administration/image/helpInline.gif';

        $triggerPeriodFields = array('Hours'=>$mod_strings['LBL_HOURS'], 'Days'=>$mod_strings['LBL_DAYS'], 'Week'=>$mod_strings['LBL_WEEK'], 'Month'=>$mod_strings['LBL_MONTH']);

        $triggerActionFields = array('Before'=>$mod_strings['LBL_BEFORE'], 'After'=>$mod_strings['LBL_AFTER'], 'Immediate Notification'=>$mod_strings['LBL_IMMEDIATE_NOTIFICATION'], 'Now'=>$mod_strings['LBL_NOW']);

        $fieldcomparison = array('Compare Entire Date'=>$mod_strings['LBL_COMPARE_ENTIRE_DATE'], 'Compare Month and Day'=>$mod_strings['LBL_COMPARE_MONTH_DAY'], 'Compare Month and Year'=>$mod_strings['LBL_COMPARE_MONTH_YEAR'], 'Compare Day and Year'=>$mod_strings['LBL_COMPARE_DAY_YEAR'], 'Compare Month'=>$mod_strings['LBL_COMPARE_MONTH'], 'Compare Day'=>$mod_strings['LBL_COMPARE_DAY'], 'Compare Year'=>$mod_strings['LBL_COMPARE_YEAR']);
        
        $smarty->assign('THEME', $theme);
        $smarty->assign('MOD', $mod_strings);
        $smarty->assign('RANDNUM', $randNum);
        $smarty->assign('MODULELIST', $allModules);
        $smarty->assign('BIRTHDAYTEMPLATEDATA', $birthdayTemplateData);
        $smarty->assign('MARRIAGETEMPLATEDATA', $marriageTemplateData);
        $smarty->assign('WORKTEMPLATEDATA', $workTemplateData);
        $smarty->assign('OTHERTEMLATEDATA', $otherTemplateData);
        $smarty->assign('ALLUSERS', $allUsers);
        $smarty->assign('HELPLINEIMAGEPATH', $helpLineImagePath);
        $smarty->assign('TRIGGERPERIODFIELDS', $triggerPeriodFields);
        $smarty->assign('TRIGGERACTIONFIELDS', $triggerActionFields);
        $smarty->assign('FIELDcomparison', $fieldcomparison);
        $smarty->display('custom/modules/Administration/tpl/vi_reminderandnotificationeditview.tpl');
        parent::display();      
        displayTinyMCEForTemplate();   
    }//end of display function

    
}//end of class
?>

