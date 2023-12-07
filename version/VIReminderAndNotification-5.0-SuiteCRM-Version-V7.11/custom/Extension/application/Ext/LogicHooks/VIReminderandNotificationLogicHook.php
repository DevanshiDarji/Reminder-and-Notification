<?php
 
if (!isset($hook_array) || !is_array($hook_array)) {
    $hook_array = array();
}
if (!isset($hook_array['after_ui_frame']) || !is_array($hook_array['after_ui_frame'])) {
    $hook_array['after_ui_frame'] = array();
}
$hook_array['after_ui_frame'][] = array(
  1, //Hook version
  'VIReminderandNotification',  //Label
  'custom/include/VIReminderAndNotification/VIReminderandNotificationLogicHook.php', //Include file
  'VIReminderandNotificationLogicHook', //Class
  'viremindernotification' //Method
);

if(!isset($hook_array['after_save']) || !is_array($hook_array['after_save'])) {
  $hook_array['after_save'] = array();
}

$hook_array['after_save'][] = array(
  1, //Hook version
  'VIReminderandNotification',  //Label
  'custom/include/VIReminderAndNotification/VIRemindersAndNotificationGetImmediateNotification.php', //Include file
  'VIRemindersAndNotificationGetImmediateNotification', //Class
  'getImmediateNotification' //Method
);
