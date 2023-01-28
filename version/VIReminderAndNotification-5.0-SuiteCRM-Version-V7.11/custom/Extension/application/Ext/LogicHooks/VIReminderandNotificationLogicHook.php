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
