<?php
 
//pre_execute logic
$now = date("Y-m-d");

//Entry Point
if(is_dir('custom/RemidersAndNotification')) {
    if(file_exists('custom/RemidersAndNotification/VIReminderAndNotificationFunction.php')) {
        $nowAddFunctionFile = 'VIReminderAndNotificationFunction'.$now.'.'.'php';
        rename("custom/RemidersAndNotification/VIReminderAndNotificationFunction.php","custom/RemidersAndNotification/".$nowAddFunctionFile);
    }
    if(file_exists('custom/RemidersAndNotification/VIReminderAndNotificationMatchCondition.php')) {
        $nowAddFunctionFile = 'VIReminderAndNotificationMatchCondition'.$now.'.'.'php';
        rename("custom/RemidersAndNotification/VIReminderAndNotificationMatchCondition.php","custom/RemidersAndNotification/".$nowAddFunctionFile);
    }
    if(file_exists('custom/RemidersAndNotification/VIRemindersAndNoificationFetchMonthFirstandLastDate.php')) {
        $nowAddRecordCreatorFile = 'VIRemindersAndNoificationFetchMonthFirstandLastDate'.$now.'.'.'php';
        rename("custom/RemidersAndNotification/VIRemindersAndNoificationFetchMonthFirstandLastDate.php","custom/RemidersAndNotification/".$nowAddRecordCreatorFile);
    }
    if(file_exists('custom/RemidersAndNotification/VIRemindersAndNoificationFetchPrimaryModuleDateDateTimeFields.php')) {
        $nowdateFile = 'VIRemindersAndNoificationFetchPrimaryModuleDateDateTimeFields'.$now.'.'.'php';
        rename("custom/RemidersAndNotification/VIRemindersAndNoificationFetchPrimaryModuleDateDateTimeFields.php","custom/RemidersAndNotification/".$nowdateFile);
    }

    if(file_exists('custom/RemidersAndNotification/VIRemindersAndNotificationcheckModuleFieldTypeEmail.php')) {
        $nowCheckFeildsFile = 'VIRemindersAndNotificationcheckModuleFieldTypeEmail'.$now.'.'.'php';
        rename("custom/RemidersAndNotification/VIRemindersAndNotificationcheckModuleFieldTypeEmail.php","custom/RemidersAndNotification/".$nowCheckFeildsFile);
    }
    if(file_exists('custom/RemidersAndNotification/VIRemindersAndNotificationDeleteRecords.php')) {
        $nowCheckModuleFile = 'VIRemindersAndNotificationDeleteRecords'.$now.'.'.'php';
        rename("custom/RemidersAndNotification/VIRemindersAndNotificationDeleteRecords.php","custom/RemidersAndNotification/".$nowCheckModuleFile);
    }
    if(file_exists('custom/RemidersAndNotification/VIRemindersAndNotificationFetchPrimaryModuleFields.php')) {
        $nowTargetModuleViewFile = 'VIRemindersAndNotificationFetchPrimaryModuleFields'.$now.'.'.'php';
        rename("custom/RemidersAndNotification/VIRemindersAndNotificationFetchPrimaryModuleFields.php","custom/RemidersAndNotification/".$nowTargetModuleViewFile);
    }
    if(file_exists('custom/RemidersAndNotification/VIRemindersAndNotificationFieldTypeOptions.php')) {
        $nowModuleFieldsFile = 'VIRemindersAndNotificationFieldTypeOptions'.$now.'.'.'php';
        rename("custom/RemidersAndNotification/VIRemindersAndNotificationFieldTypeOptions.php","custom/RemidersAndNotification/".$nowModuleFieldsFile);
    }
    if(file_exists('custom/RemidersAndNotification/VIRemindersAndNotificationModuleFields.php')) {
        $nowReminderFile = 'VIRemindersAndNotificationModuleFields'.$now.'.'.'php';
        rename("custom/RemidersAndNotification/VIRemindersAndNotificationModuleFields.php","custom/RemidersAndNotification/".$nowReminderFile);
    }
    if(file_exists('custom/RemidersAndNotification/VIRemindersAndNotificationModuleFieldType.php')) {
        $nowReminderFile = 'VIRemindersAndNotificationModuleFieldType'.$now.'.'.'php';
        rename("custom/RemidersAndNotification/VIRemindersAndNotificationModuleFieldType.php","custom/RemidersAndNotification/".$nowReminderFile);
    }
    if(file_exists('custom/RemidersAndNotification/VIRemindersAndNotificationModuleOperatorField.php')) {
        $nowReminderFile = 'VIRemindersAndNotificationModuleOperatorField'.$now.'.'.'php';
        rename("custom/RemidersAndNotification/VIRemindersAndNotificationModuleOperatorField.php","custom/RemidersAndNotification/".$nowReminderFile);
    }
    if(file_exists('custom/RemidersAndNotification/VIRemindersAndNotificationModuleRelationships.php')) {
        $nowReminderFile = 'VIRemindersAndNotificationModuleRelationships'.$now.'.'.'php';
        rename("custom/RemidersAndNotification/VIRemindersAndNotificationModuleRelationships.php","custom/RemidersAndNotification/".$nowReminderFile);
    }
    if(file_exists('custom/RemidersAndNotification/VIRemindersAndNotificationSaveRecords.php')) {
        $nowReminderFile = 'VIRemindersAndNotificationSaveRecords'.$now.'.'.'php';
        rename("custom/RemidersAndNotification/VIRemindersAndNotificationSaveRecords.php","custom/RemidersAndNotification/".$nowReminderFile);
    }

    $changeReminderFolderName = 'RemidersAndNotification'.$now;
    rename("custom/RemidersAndNotification","custom/".$changeReminderFolderName);
}

//include
if(is_dir('custom/include/ReminderAndNotification')) {
    if(file_exists('custom/include/ReminderAndNotification/VIReminderandNotificationLogicHook.php')) {
        $nowVIReminderNotification = 'VIReminderandNotificationLogicHook'.$now.'.'.'php';
        rename("custom/include/ReminderAndNotification/VIReminderandNotificationLogicHook.php","custom/include/ReminderAndNotification/".$nowVIReminderNotification);
    }
    if(file_exists('custom/include/ReminderAndNotification/VIRemindersAndNotificationGetImmediateNotification.php')) {
        $nowVIReminderNotification = 'VIRemindersAndNotificationGetImmediateNotification'.$now.'.'.'php';
        rename("custom/include/ReminderAndNotification/VIRemindersAndNotificationGetImmediateNotification.php","custom/include/ReminderAndNotification/".$nowVIReminderNotification);
    }
    if(file_exists('custom/include/ReminderAndNotification/css/VIReminderandNotificationIcon.css')) {
        $nowVIReminderNotification = 'VIReminderandNotificationIcon'.$now.'.'.'css';
        rename("custom/include/ReminderAndNotification/css/VIReminderandNotificationIcon.css","custom/include/ReminderAndNotification/css/".$nowVIReminderNotification);
    }
   
    $changeReminderFolderName = 'ReminderAndNotification'.$now;
    rename("custom/include/ReminderAndNotification","custom/include/".$changeReminderFolderName);
}

//Administration
//css
if(file_exists('custom/modules/Administration/css/VIRemindersAndNotificationEditView.css')) {
    $nowRNCss = 'VIRemindersAndNotificationEditView'.$now.'.'.'css';
    rename("custom/modules/Administration/css/VIRemindersAndNotificationEditView.css","custom/modules/Administration/css/".$nowRNCss);
}
if(file_exists('custom/modules/Administration/css/VIRemindersAndNotificationListView.css')) {
    $nowRNCss = 'VIRemindersAndNotificationListView'.$now.'.'.'css';
    rename("custom/modules/Administration/css/VIRemindersAndNotificationListView.css","custom/modules/Administration/css/".$nowRNCss);
}
if(file_exists('custom/modules/Administration/css/VIRemindersAndNotificationTemplates.css')) {
    $nowRNCss = 'VIRemindersAndNotificationTemplates'.$now.'.'.'css';
    rename("custom/modules/Administration/css/VIRemindersAndNotificationTemplates.css","custom/modules/Administration/css/".$nowRNCss);
}

//js
if(file_exists('custom/modules/Administration/js/VIRemindersAndNotificationConditionLines.js')) {
    $nowRNJs = 'VIRemindersAndNotificationConditionLines'.$now.'.'.'js';
    rename("custom/modules/Administration/js/VIRemindersAndNotificationConditionLines.js","custom/modules/Administration/js/".$nowRNJs);
}
if(file_exists('custom/modules/Administration/js/VIRemindersAndNotificationEditView.js')) {
    $nowRNJs = 'VIRemindersAndNotificationEditView'.$now.'.'.'js';
    rename("custom/modules/Administration/js/VIRemindersAndNotificationEditView.js","custom/modules/Administration/js/".$nowRNJs);
}
if(file_exists('custom/modules/Administration/js/VIRemindersAndNotificationListView.js')) {
    $nowRNJs = 'VIRemindersAndNotificationListView'.$now.'.'.'js';
    rename("custom/modules/Administration/js/VIRemindersAndNotificationListView.js","custom/modules/Administration/js/".$nowRNJs);
}

//tpl
if(is_dir('custom/modules/Administration/tpls')) {
    if(file_exists('custom/modules/Administration/tpls/vi_reminderandnotificationeditview.tpl')) {
        $nowVIReminderNotification = 'vi_reminderandnotificationeditview'.$now.'.'.'tpl';
        rename("custom/modules/Administration/tpls/vi_reminderandnotificationeditview.tpl","custom/modules/Administration/tpls/".$nowVIReminderNotification);
    }
    
    if(file_exists('custom/modules/Administration/tpls/vi_reminderandnotificationlistview.tpl')) {
        $nowVIQuickViewListview = 'vi_reminderandnotificationlistview'.$now.'.'.'tpl';
        rename("custom/modules/Administration/tpls/vi_reminderandnotificationlistview.tpl","custom/modules/Administration/tpls/".$nowVIQuickViewListview);
    }
    $changeReminderFolderName = 'tpls'.$now;
    rename("custom/modules/Administration/tpls","custom/modules/Administration/".$changeReminderFolderName);
  
}


//views
if(file_exists('custom/modules/Administration/views/view.vi_reminderandnotificationeditview.php')) {
    $nowViewQuickViewEditview = 'view.vi_reminderandnotificationeditview'.$now.'.'.'php';
    rename("custom/modules/Administration/views/view.vi_reminderandnotificationeditview.php","custom/modules/Administration/views/".$nowViewQuickViewEditview);
}
if(file_exists('custom/modules/Administration/views/view.vi_reminderandnotificationlistview.php')) {
    $nowViewQuickViewListview = 'view.vi_reminderandnotificationlistview'.$now.'.'.'php';
    rename("custom/modules/Administration/views/view.vi_reminderandnotificationlistview.php","custom/modules/Administration/views/".$nowViewQuickViewListview);
}

//Image
//SuiteP
if(file_exists('custom/themes/SuiteP/images/ReminderandNotificationPlugin.png')) {
    $changeReminderFolderName = 'ReminderandNotificationPlugin'.$now.'.'.'png';
    rename("custom/themes/SuiteP/images/ReminderandNotificationPlugin.png","custom/themes/SuiteP/images/".$changeReminderFolderName);
}
if(file_exists('custom/themes/SuiteP/images/ReminderandNotificationPlugin.svg')) {
    $changeReminderFolderName = 'ReminderandNotificationPlugin'.$now.'.'.'svg';
    rename("custom/themes/SuiteP/images/ReminderandNotificationPlugin.svg","custom/themes/SuiteP/images/".$changeReminderFolderName);
}

if(file_exists('themes/SuiteP/images/ReminderandNotification.png')) {
    $nowSuitePReminderNotificationPng = 'ReminderandNotification'.$now.'.'.'png';
    rename("themes/SuiteP/images/ReminderandNotification.png","themes/SuiteP/images/".$nowSuitePReminderNotificationPng);
}
if(file_exists('themes/SuiteP/images/ReminderandNotification.svg')) {
    $nowSuitePReminderandNotificationSvg = 'ReminderandNotification'.$now.'.'.'svg';
    rename("themes/SuiteP/images/ReminderandNotification.svg","themes/SuiteP/images/".$nowSuitePReminderandNotificationSvg);
}
?>