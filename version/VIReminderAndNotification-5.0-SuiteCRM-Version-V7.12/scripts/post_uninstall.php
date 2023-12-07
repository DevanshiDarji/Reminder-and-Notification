<?php
 
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