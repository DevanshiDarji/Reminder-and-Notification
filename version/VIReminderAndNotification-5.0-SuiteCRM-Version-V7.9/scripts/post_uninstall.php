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
//post_uninstall logic
global $db;
$db->dropTableName('vi_reminders_notifications');
$db->dropTableName('vi_reminders_notification_condition');
$db->dropTableName('vi_templates_notifications');
$db->dropTableName('vi_reminder_alert');

$delete_table = "DELETE from config where name = 'reminder-notification'";
$result = $GLOBALS['db']->query($delete_table);
$delete_table2 = "DELETE from config where name = 'lic_reminder-notification'";
$result2 = $GLOBALS['db']->query($delete_table2);
?>