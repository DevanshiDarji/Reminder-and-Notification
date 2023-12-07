<?php
 
require_once("custom/VIRemidersAndNotification/VIRemindersAndNotificationFunction.php");

//post_execute logic
global $sugar_config;
$databaseType = $sugar_config['dbconfig']['db_type'];

if($databaseType == 'mysql'){
	$checkTableExist = "SHOW TABLES LIKE 'vi_reminders_notifications'";
	$checkTableExistResult = $GLOBALS['db']->query($checkTableExist);

	if($checkTableExistResult->num_rows > 0){
		updateReminderNotificationConfigData();
	}//end of if

	//reminder and notification configuration table
	$ReminderAndNotification = "CREATE TABLE IF NOT EXISTS vi_reminders_notifications(							  id CHAR(36) PRIMARY KEY,
									template_id int(11),
									subject TEXT,
									module VARCHAR(255),
									notification_field VARCHAR(255),
									comparison_field VARCHAR(255),
									trigger_value int(10),
									trigger_period VARCHAR(255),
									trigger_action VARCHAR(255),
									triggerMonthValue VARCHAR(255),
									trigger_notification_field VARCHAR(55),
									reminder_message longtext,
									status TINYINT(1),
									conditional_operator VARCHAR(255),
									enable_users VARCHAR(255),
									allUsersId longtext,
									related_module VARCHAR(50),
									relate_fields VARCHAR(255),
									enable_notification VARCHAR(255),
									email_notification VARCHAR(255),
									templates TINYINT(1) NOT NULL DEFAULT 0,
									template_message longtext,
									date_entered datetime,
									date_modified datetime,
									deleted TINYINT(1) NOT NULL DEFAULT 0
								)";
	$ReminderAndNotificationResult = $GLOBALS['db']->query($ReminderAndNotification);
	
	//NOT NULL DEFAULT 0
	$ReminderAndNotificationUpdateStatusField = "ALTER TABLE vi_reminders_notifications MODIFY COLUMN status TINYINT(1) NOT NULL DEFAULT 0";
	$ReminderAndNotificationUpdateStatusFieldRes = $GLOBALS['db']->query($ReminderAndNotificationUpdateStatusField);

	$ReminderAndNotificationUpdateTemplateField = "ALTER TABLE vi_reminders_notifications MODIFY COLUMN templates TINYINT(1)";
	$ReminderAndNotificationUpdateTemplateFieldRes = $GLOBALS['db']->query($ReminderAndNotificationUpdateTemplateField);

	$columnExist = "SHOW COLUMNS FROM vi_reminders_notifications LIKE 'comparison_field'";
	$columnExistResult = $GLOBALS['db']->query($columnExist);
	if($columnExistResult->num_rows == 0){
	    $ReminderAndNotificationAddComparisonField = "ALTER TABLE vi_reminders_notifications ADD comparison_field VARCHAR(55) NOT NULL after notification_field";
		$ReminderAndNotificationAddComparisonFieldRes = $GLOBALS['db']->query($ReminderAndNotificationAddComparisonField);
	}

	$columnExist = "SHOW COLUMNS FROM vi_reminders_notifications LIKE 'trigger_notification_field'";
	$columnExistResult = $GLOBALS['db']->query($columnExist);
	if($columnExistResult->num_rows == 0){
		$ReminderAndNotificationAddField = "ALTER TABLE vi_reminders_notifications ADD trigger_notification_field VARCHAR(55) NOT NULL after triggerMonthValue";
		$ReminderAndNotificationAddFieldResult = $GLOBALS['db']->query($ReminderAndNotificationAddField);
	}

	$columnExist = "SHOW COLUMNS FROM vi_reminders_notifications LIKE 'related_module'";
	$columnExistResult = $GLOBALS['db']->query($columnExist);
	if($columnExistResult->num_rows == 0){
		$ReminderAndNotificationAddRelateModuleField = "ALTER TABLE vi_reminders_notifications ADD related_module VARCHAR(50) NOT NULL after allUsersId";
		$ReminderAndNotificationAddFieldResult = $GLOBALS['db']->query($ReminderAndNotificationAddRelateModuleField);
	}

	$columnExist = "SHOW COLUMNS FROM vi_reminders_notifications LIKE 'relate_fields'";
	$columnExistResult = $GLOBALS['db']->query($columnExist);
	if($columnExistResult->num_rows == 0){
		$ReminderAndNotificationAddRelateField = "ALTER TABLE vi_reminders_notifications ADD relate_fields VARCHAR(255) NOT NULL after related_module";
		$ReminderAndNotificationAddFieldResult = $GLOBALS['db']->query($ReminderAndNotificationAddRelateField);
	}
	
	$columnExist = "SHOW COLUMNS FROM vi_reminders_notifications LIKE 'enable_assigned_user'";
	$columnExistResult = $GLOBALS['db']->query($columnExist);
	if($columnExistResult->num_rows == 1){
		$ReminderAndNotificatioDropAssignUser = "ALTER TABLE vi_reminders_notifications DROP COLUMN enable_assigned_user";
		$ReminderAndNotificationAddFieldResult = $GLOBALS['db']->query($ReminderAndNotificatioDropAssignUser);
	}

	//reminder and notification condition table
	$ReminderAndNotificatinCondition = "CREATE TABLE IF NOT EXISTS vi_reminders_notification_condition(
											id CHAR(36) PRIMARY KEY,
											module_path VARCHAR(255),
											field VARCHAR(255),
											operator VARCHAR(255),
											value_type VARCHAR(255),
											value VARCHAR(255),
											reminder_notification_id CHAR(36),
											condition_type VARCHAR(255),
											date_entered DATETIME,
											deleted TINYINT(1) DEFAULT 0
										)";
	$ReminderAndNotificationConditionResult = $GLOBALS['db']->query($ReminderAndNotificatinCondition);

	$columnExist = "SHOW COLUMNS FROM vi_reminders_notification_condition LIKE 'condition_type'";
	$columnExistResult = $GLOBALS['db']->query($columnExist);
	if($columnExistResult->num_rows == 0){
		$ReminderAndNotificationAddConditionField = "ALTER TABLE vi_reminders_notification_condition ADD condition_type VARCHAR(255) after reminder_notification_id";
		$ReminderAndNotificationAddFieldResult = $GLOBALS['db']->query($ReminderAndNotificationAddConditionField);
	}

	$columnExist = "SHOW COLUMNS FROM vi_reminders_notification_condition LIKE 'date_entered'";
	$columnExistResult = $GLOBALS['db']->query($columnExist);
	if($columnExistResult->num_rows == 0){
		$ReminderAndNotificationAdddateField = "ALTER TABLE vi_reminders_notification_condition ADD date_entered DATETIME after condition_type";
		$ReminderAndNotificationAddFieldResult = $GLOBALS['db']->query($ReminderAndNotificationAdddateField);
	}

	$checkTableExist = "SHOW TABLES LIKE 'vi_reminders_notification_condition'";
	$checkConditionTableExistResult = $GLOBALS['db']->query($checkTableExist);
	if($checkConditionTableExistResult->num_rows > 0){
		updateReminderNotificationConditionData();
	}

	$ReminderAndNotificationAlert = "CREATE TABLE IF NOT EXISTS vi_reminder_alert(
										id CHAR(36) PRIMARY KEY,
										alert_id CHAR(36),
										module_record_id VARCHAR(50),
										notification_field VARCHAR(255),
										notificationField_value VARCHAR(255)
									)";
	$ReminderAndNotificationAlertResult = $GLOBALS['db']->query($ReminderAndNotificationAlert);

	//templates table
	$templates = "CREATE TABLE IF NOT EXISTS vi_templates_notifications(
						id int(11) NOT NULL AUTO_INCREMENT,
  						template_type text NOT NULL,
  						template_body longtext NOT NULL,
  						defualt_template tinyint(1) DEFAULT '1',
  						PRIMARY KEY (id)
					)";
	$templatesResult = $GLOBALS['db']->query($templates);

	$insertTemplates = "INSERT INTO `vi_templates_notifications` (`id`, `template_type`, `template_body`, `defualt_template`) VALUES
		(1, 'Birthday Templates', '<img src=\"custom/modules/Administration/image/hbd_2.jpg\" class=\"tmplt_img\" alt=\"Birthday\" style=\"width:100%\" >\r\n<span class=\"tmplt_txt\">Dear XYZ, May the days ahead of you be filled with prosperity, great health and above all joy in its truest and purest form. Happy birthday!</span>', 1),
		(2, 'Birthday Templates', '<img src=\"custom/modules/Administration/image/hbd_3.jpg\" class=\"tmplt_img\" alt=\"birthday\" style=\"width:100%\" >\r\n<span class=\"tmplt_txt\">Dear XYZ, May the days ahead of you be filled with prosperity, great health and above all joy in its truest and purest form. Happy birthday!</span>', 1),
		(3, 'Birthday Templates', '<img src=\"custom/modules/Administration/image/hbd_4.png\" class=\"tmplt_img\" alt=\"Avatar\" style=\"width:100%\" >\r\n<span class=\"tmplt_txt\">Dear XYZ, A wish for you on your birthday, whatever you ask may you receive, whatever you seek may you find, whatever you wish may it be fulfilled on your birthday and always. Happy birthday!</span>', 1),
		(4, 'Birthday Templates', '<img src=\"custom/modules/Administration/image/hbd_5.gif\" class=\"tmplt_img\" alt=\"Avatar\" style=\"width:100%\" ><span class=\"tmplt_txt\">Dear XYZ, May the joy that you have spread in the past come back to you on this day. Wishing you a very happy birthday!</span>', 1),
		(5, 'Birthday Templates', '<img src=\"custom/modules/Administration/image/hbd_6.png\" class=\"tmplt_img\" alt=\"Avatar\" style=\"width:100%\" ><span class=\"tmplt_txt\">Dear XYZ, May the joy that you have spread in the past come back to you on this day. Wishing you a very happy birthday!</span>', 1),
		(6, 'Birthday Templates', '<img src=\"custom/modules/Administration/image/hbd_7.gif\" class=\"tmplt_img\" alt=\"Avatar\" style=\"width:84%; margin-left: 7%;\" align=\"center\" >\r\n			<span class=\"tmplt_txt\"></br>Dear XYZ, May the days ahead of you be filled with prosperity, great health and above all joy in its truest and purest form. Happy birthday!</span>', 1),
		(7, 'Marriage Anniversary Templates', '<img src=\"custom/modules/Administration/image/wed_ann_1.png\" class=\"tmplt_img\" style=\"width:100%\" >\r\n<div class=\"tmplt_txt_height tmplt_txt\">Dear XYZ,Wishing you all the happiness and love in the world and congratulations on your anniversary.</div>', 1),
		(8, 'Marriage Anniversary Templates', '<img src=\"custom/modules/Administration/image/wed_ann_2.png\" class=\"tmplt_img\" style=\"width:100%\" >\r\n<div class=\"tmplt_txt_height tmplt_txt\">Sending you warm wishes on your anniversary; may you continue to grow older and happier together.</div>', 1),
		(9, 'Marriage Anniversary Templates', '<img src=\"custom/modules/Administration/image/wed_ann_3.png\" class=\"tmplt_img\" style=\"width:100%\" >\r\n<div class=\"tmplt_txt_height tmplt_txt\">Dear XYZ,Sending you both loving wishes on your anniversary, may it be something so very special.</div>', 1),
		(10, 'Marriage Anniversary Templates', '<img src=\"custom/modules/Administration/image/wed_ann_4.png\" class=\"tmplt_img\" style=\"width:100%\" >\r\n<div class=\"tmplt_txt_height tmplt_txt\">Dear XYZ,This is not the time to look back on the good days of your life. This is the time to look ahead to the best days of your life that are yet to come. Happy marriage anniversary.</div>', 1),
		(11, 'Marriage Anniversary Templates', '<img src=\"custom/modules/Administration/image/wed_ann_5.png\" class=\"tmplt_img\" style=\"width:100%\" >\r\n<div class=\"tmplt_txt_height tmplt_txt\">May the love that you share lasts a lifetime and may you accomplish all the dreams a that you have entwined together!</div>', 1),
		(12, 'Marriage Anniversary Templates', '<img src=\"custom/modules/Administration/image/wed_ann_6.png\" class=\"tmplt_img\" style=\"width:100%\" >\r\n<div class=\"tmplt_txt_height tmplt_txt\">Dear XYZ,Most congratulation on your Marriage Anniversary. May your golden union will always be like this, and may you have many more happy anniversaries.</div>', 1),
		(13, 'Work Anniversary Templates', '<img src=\"custom/modules/Administration/image/work_ann_1.png\" class=\"tmplt_img\"  style=\"width:100%;\"  >\r\n<div class=\"tmplt_txt_height tmplt_txt\">Dear XYZ, Happy work anniversary! Thanks for everything you do around here. This place wouldn’t be the same without you.</div>', 1),
		(14, 'Work Anniversary Templates', '<img src=\"custom/modules/Administration/image/work_ann_2.png\" class=\"tmplt_img\"  style=\"width:100%\" >\r\n<div class=\"tmplt_txt_height tmplt_txt\">Another year of excellence! Thanks for all the amazing work you do. Your effort and enthusiasm are much needed, and very much appreciated.</div>', 1),
		(15, 'Work Anniversary Templates', '<img src=\"custom/modules/Administration/image/work_ann_3.png\" class=\"tmplt_img\"  style=\"width:100%;\" align=\"center\" >\r\n<div class=\"tmplt_txt_height tmplt_txt\">Dear XYZ, From all of us… happy anniversary! Thank you for your hard work, your generosity, and your contagious enthusiasm.</div>', 1),
		(16, 'Work Anniversary Templates', '<img src=\"custom/modules/Administration/image/work_ann_4.png\" class=\"tmplt_img\" style=\"width:100%\" >\r\n<div class=\"tmplt_txt_height tmplt_txt\">Dear XYZ, Congratulations on your work anniversary! We appreciate your energy, your kindness, and all the work you do, but most of all, we just appreciate you!</div>', 1),
		(17, 'Work Anniversary Templates', '<img src=\"custom/modules/Administration/image/work_ann_5.png\" class=\"tmplt_img\" style=\"width:100%\" >\r\n<div class=\"tmplt_txt_height tmplt_txt\">You are an inspiration to others. Your dedication to your work is exemplary. Thank you for making a difference in our lives. Happy work anniversary!</div>', 1),
		(18, 'Work Anniversary Templates', '<img src=\"custom/modules/Administration/image/work_ann_6.png\" class=\"tmplt_img\" style=\"width:100%\" >\r\n<div class=\"tmplt_txt_height tmplt_txt\">Dear XYZ,Employees like you are the pride and joy of a company. We are proud to have you with us. On the way forward, you deserve all you have achieved and more. Wishing you a happy work anniversary.</div>', 1)";
	$templatesResult = $GLOBALS['db']->query($insertTemplates);

}else if($databaseType == 'mssql'){
	$checkTableExist = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'vi_reminders_notifications'";
	$checkTableExistResult = $GLOBALS['db']->query($checkTableExist);

	if(!empty($checkTableExistResult)){
		updateReminderNotificationConfigData();
	}//end of if

	$ReminderAndNotification = "IF NOT EXISTS (SELECT * FROM dbo.sysobjects where id = object_id(N'dbo.[vi_reminders_notifications]') and OBJECTPROPERTY(id, N'IsTable') = 1)
					BEGIN
					CREATE TABLE [dbo].[vi_reminders_notifications](
						[id] [char](36) NOT NULL PRIMARY KEY,
						[template_id] [int] NULL,
						[subject] [varchar](255) NULL ,
						[module] [varchar](255) NULL,
						[notification_field] [varchar](255) NULL,
						[comparison_field] [varchar](255),
						[trigger_value] [int] NULL,
						[trigger_period] [varchar](255) NULL,
						[trigger_action] [varchar](255) NULL,
						[triggerMonthValue] [varchar](255) NULL,
						[trigger_notification_field] [varchar](55) NULL,
						[reminder_message] [nvarchar](max) NULL,
						[status] [varchar](255) NULL,
						[conditional_operator] [varchar](255) NULL,
						[enable_users] [varchar](255) NULL,
						[allUsersId] [nvarchar](max) NULL,
						[related_module] [varchar](50) NULL,
						[relate_fields] [varchar](255) NULL,
						[enable_notification] [varchar](255) NULL,
						[email_notification] [varchar](255) NULL,
						[templates] [varchar](255) NULL,
						[template_message] [nvarchar](max) NULL,
						[date_entered] [datetime] NULL,
						[date_modified] [datetime] NULL,
						[deleted] [smallint] NULL Default 0
					)
					END";
	$ReminderAndNotificatinConditionResult = $GLOBALS['db']->query($ReminderAndNotification);

	$columnExist = "IF NOT EXISTS(
					  SELECT *
					  FROM INFORMATION_SCHEMA.COLUMNS
					  WHERE 
					    TABLE_NAME = 'vi_reminders_notifications'
					    AND COLUMN_NAME = 'comparison_field')
					BEGIN
					  ALTER TABLE vi_reminders_notifications
					    ADD comparison_field VARCHAR( 255 ) NULL
					END";
	$addColumnResult = $GLOBALS['db']->query($columnExist);

	$columnExist = "IF NOT EXISTS(
					  SELECT *
					  FROM INFORMATION_SCHEMA.COLUMNS
					  WHERE 
					    TABLE_NAME = 'vi_reminders_notifications'
					    AND COLUMN_NAME = 'trigger_notification_field')
					BEGIN
					  ALTER TABLE vi_reminders_notifications
					    ADD trigger_notification_field VARCHAR( 55 ) NULL
					END";
	$addColumnResult = $GLOBALS['db']->query($columnExist);

	$columnExist = "IF NOT EXISTS(
					  SELECT *
					  FROM INFORMATION_SCHEMA.COLUMNS
					  WHERE 
					    TABLE_NAME = 'vi_reminders_notifications'
					    AND COLUMN_NAME = 'related_module')
					BEGIN
					  ALTER TABLE vi_reminders_notifications
					    ADD related_module VARCHAR( 50 ) NULL
					END";
	$addColumnResult = $GLOBALS['db']->query($columnExist);

	$columnExist = "IF NOT EXISTS(
					  SELECT *
					  FROM INFORMATION_SCHEMA.COLUMNS
					  WHERE 
					    TABLE_NAME = 'vi_reminders_notifications'
					    AND COLUMN_NAME = 'relate_fields')
					BEGIN
					  ALTER TABLE vi_reminders_notifications
					    ADD relate_fields VARCHAR( 255 ) NULL
					END";
	$addColumnResult = $GLOBALS['db']->query($columnExist);

	$dropcolumnExist = "IF NOT EXISTS(
					  SELECT *
					  FROM INFORMATION_SCHEMA.COLUMNS
					  WHERE 
					    TABLE_NAME = 'vi_reminders_notifications'
					    AND COLUMN_NAME = 'relate_fields')
					BEGIN
					    ALTER TABLE vi_reminders_notifications DROP COLUMN enable_assigned_user
					END";
	$dropColumnResult = $GLOBALS['db']->query($dropcolumnExist);

	//reminder and notification condition table
	$ReminderAndNotificatinCondition = "IF NOT EXISTS (SELECT * FROM dbo.sysobjects where id = object_id(N'dbo.[vi_reminders_notification_condition]') and OBJECTPROPERTY(id, N'IsTable') = 1)
					BEGIN

					CREATE TABLE [dbo].[vi_reminders_notification_condition](
						[id] [char](36) NOT NULL PRIMARY KEY,
						[module_path] [varchar](255) NULL,
						[field] [varchar](255) NULL,
						[operator] [varchar](255) NULL,
						[value_type] [varchar](255) NULL,
						[value] [varchar](255),
						[reminder_notification_id] [char](36),
						[condition_type] [varchar](255) NULL,
						[date_entered] [datetime] NULL,
						[deleted] [smallint] NULL Default 0
					)
					END";
	$ReminderAndNotificatinConditionResult = $GLOBALS['db']->query($ReminderAndNotificatinCondition);

	$columnExist = "IF NOT EXISTS(
					  SELECT *
					  FROM INFORMATION_SCHEMA.COLUMNS
					  WHERE 
					    TABLE_NAME = 'vi_reminders_notification_condition'
					    AND COLUMN_NAME = 'condition_type')
					BEGIN
					  ALTER TABLE vi_reminders_notification_condition
					    ADD condition_type VARCHAR( 255 ) NULL
					END";
	$addColumnResult = $GLOBALS['db']->query($columnExist);

	$columnExist = "IF NOT EXISTS(
					  SELECT *
					  FROM INFORMATION_SCHEMA.COLUMNS
					  WHERE 
					    TABLE_NAME = 'vi_reminders_notification_condition'
					    AND COLUMN_NAME = 'date_entered')
					BEGIN
					  ALTER TABLE vi_reminders_notification_condition
					    ADD date_entered DATETIME NULL
					END";
	$addColumnResult = $GLOBALS['db']->query($columnExist);

	$ReminderAndNotificationAlert = "IF NOT EXISTS (SELECT * FROM dbo.sysobjects where id = object_id(N'dbo.[vi_reminder_alert]') and OBJECTPROPERTY(id, N'IsTable') = 1)
					BEGIN

					CREATE TABLE [dbo].[vi_reminder_alert](
						[id] [char](36) NOT NULL PRIMARY KEY,
						[alert_id] [char](36) NULL,
						[module_record_id] [varchar](50) NULL,
						[notification_field] [varchar](255) NULL,
						[notificationField_value] [varchar](255) NULL
					)
					END";
	$ReminderAndNotificationAlertResult = $GLOBALS['db']->query($ReminderAndNotificationAlert);

	$checkTableExist = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'vi_reminders_notification_condition'";
	$checkConditionTableExistResult = $GLOBALS['db']->query($checkTableExist);
	if(!empty($checkConditionTableExistResult)){
		updateReminderNotificationConditionData();
	}

	//templates table
	$templates = "IF NOT EXISTS (SELECT * FROM dbo.sysobjects where id = object_id(N'dbo.[vi_templates_notifications]') and OBJECTPROPERTY(id, N'IsTable') = 1)
					BEGIN
					CREATE TABLE [dbo].[vi_templates_notifications](
						[id] [int]  NOT NULL IDENTITY(1,1) PRIMARY KEY,
						[template_type] [varchar](255) NULL,
						[template_body] [nvarchar](max) NULL,
						[defualt_template] TINYINT NOT NULL DEFAULT '1',
					)
					END";
	$templatesResult = $GLOBALS['db']->query($templates);
	
	//defualt tempalates inserted
	$birthday1 = '<img src="custom/modules/Administration/image/hbd_2.jpg" class="tmplt_img" alt="Birthday" style="width:100%"><span class="tmplt_txt">Dear XYZ, May the days ahead of you be filled with prosperity, great health and above all joy in its truest and purest form. Happy birthday!</span>';
	$birthday2 = '<img src="custom/modules/Administration/image/hbd_3.jpg" class="tmplt_img" alt="birthday" style="width:100%"><span class="tmplt_txt">Dear XYZ, May the days ahead of you be filled with prosperity, great health and above all joy in its truest and purest form. Happy birthday!</span>';
	$birthday3 = '<img src="custom/modules/Administration/image/hbd_4.png" class="tmplt_img" alt="Avatar" style="width:100%" ><span class="tmplt_txt">Dear XYZ, A wish for you on your birthday, whatever you ask may you receive, whatever you seek may you find, whatever you wish may it be fulfilled on your birthday and always. Happy birthday!</span>';
	$birthday4 = '<img src="custom/modules/Administration/image/hbd_5.gif" class="tmplt_img" alt="Avatar" style="width:100%" ><span class="tmplt_txt">Dear XYZ, May the joy that you have spread in the past come back to you on this day. Wishing you a very happy birthday!</span>';
	$birthday5 = '<img src="custom/modules/Administration/image/hbd_6.png" class="tmplt_img" alt="Avatar" style="width:100%" ><span class="tmplt_txt">Dear XYZ, May the joy that you have spread in the past come back to you on this day. Wishing you a very happy birthday!</span>';
	$birthday6 = '<img src="custom/modules/Administration/image/hbd_7.gif" class="tmplt_img" alt="Avatar" style="width:84%; margin-left: 7%;" align="center" ><span class="tmplt_txt"></br>Dear XYZ, May the days ahead of you be filled with prosperity, great health and above all joy in its truest and purest form. Happy birthday!</span>';
	
	$marriage1 = '<img src="custom/modules/Administration/image/wed_ann_1.png" class="tmplt_img" style="width:100%" ><div class="tmplt_txt_height tmplt_txt">Dear XYZ,Wishing you all the happiness and love in the world and congratulations on your anniversary.</div>';
	$marriage2 = '<img src="custom/modules/Administration/image/wed_ann_2.png" class="tmplt_img" style="width:100%" ><div class="tmplt_txt_height tmplt_txt">Sending you warm wishes on your anniversary; may you continue to grow older and happier together.</div>';
	$marriage3 = '<img src="custom/modules/Administration/image/wed_ann_3.png" class="tmplt_img" style="width:100%" ><div class="tmplt_txt_height tmplt_txt">Dear XYZ,Sending you both loving wishes on your anniversary, may it be something so very special.</div>';
	$marriage4 = '<img src="custom/modules/Administration/image/wed_ann_4.png" class="tmplt_img" style="width:100%" ><div class="tmplt_txt_height tmplt_txt">Dear XYZ,This is not the time to look back on the good days of your life. This is the time to look ahead to the best days of your life that are yet to come. Happy marriage anniversary.</div>';
	$marriage5 = '<img src="custom/modules/Administration/image/wed_ann_5.png" class="tmplt_img" style="width:100%" ><div class="tmplt_txt_height tmplt_txt">May the love that you share lasts a lifetime and may you accomplish all the dreams a that you have entwined together!</div>';
	$marriage6 = '<img src="custom/modules/Administration/image/wed_ann_6.png" class="tmplt_img" style="width:100%" ><div class="tmplt_txt_height tmplt_txt">Dear XYZ,Most congratulation on your Marriage Anniversary. May your golden union will always be like this, and may you have many more happy anniversaries.</div>';
	
	$work1 = '<img src="custom/modules/Administration/image/work_ann_1.png" class="tmplt_img"  style="width:100%;"  ><div class="tmplt_txt_height tmplt_txt">Dear XYZ, Happy work anniversary! Thanks for everything you do around here. This place wouldn’t be the same without you.</div>';
	$work2 = '<img src="custom/modules/Administration/image/work_ann_2.png" class="tmplt_img"  style="width:100%" ><div class="tmplt_txt_height tmplt_txt">Another year of excellence! Thanks for all the amazing work you do. Your effort and enthusiasm are much needed, and very much appreciated.</div>';
	$work3 = '<img src="custom/modules/Administration/image/work_ann_3.png" class="tmplt_img"  style="width:100%;" align="center" ><div class="tmplt_txt_height tmplt_txt">Dear XYZ, From all of us… happy anniversary! Thank you for your hard work, your generosity, and your contagious enthusiasm.</div>';
	$work4 = '<img src="custom/modules/Administration/image/work_ann_4.png" class="tmplt_img" style="width:100%" ><div class="tmplt_txt_height tmplt_txt">Dear XYZ, Congratulations on your work anniversary! We appreciate your energy, your kindness, and all the work you do, but most of all, we just appreciate you!</div>';
	$work5 = '<img src="custom/modules/Administration/image/work_ann_5.png" class="tmplt_img" style="width:100%" ><div class="tmplt_txt_height tmplt_txt">You are an inspiration to others. Your dedication to your work is exemplary. Thank you for making a difference in our lives. Happy work anniversary!</div>';
	$work6 = '<img src="custom/modules/Administration/image/work_ann_6.png" class="tmplt_img" style="width:100%" ><div class="tmplt_txt_height tmplt_txt">Dear XYZ,Employees like you are the pride and joy of a company. We are proud to have you with us. On the way forward, you deserve all you have achieved and more. Wishing you a happy work anniversary.</div>';
	
	//defualt tempalates inserted
	$insertTemplates = "INSERT INTO vi_templates_notifications(template_type,template_body,defualt_template)VALUES
	('Birthday Templates','$birthday1',1),
	('Birthday Templates','$birthday2',1),
	('Birthday Templates','$birthday3',1),
	('Birthday Templates','$birthday4',1),
	('Birthday Templates','$birthday5',1),
	('Birthday Templates','$birthday6',1),
	('Marriage Anniversary Templates','$marriage1',1),
	('Marriage Anniversary Templates','$marriage2',1),
	('Marriage Anniversary Templates','$marriage3',1),
	('Marriage Anniversary Templates','$marriage4',1),
	('Marriage Anniversary Templates','$marriage5',1),
	('Marriage Anniversary Templates','$marriage6',1),
	('Work Anniversary Templates','$work1',1),
	('Work Anniversary Templates','$work2',1),
	('Work Anniversary Templates','$work3',1),
	('Work Anniversary Templates','$work4',1),
	('Work Anniversary Templates','$work5',1),
	('Work Anniversary Templates','$work6',1)";
	$templatesResult = $GLOBALS['db']->query($insertTemplates);
}	

$Id = create_guid();
global $timedate;
$CurrenrDateTime = $timedate->getInstance()->nowDb();
$selectSchedular = "SELECT * from schedulers where name ='Run Reminders And Notification'";
$selResult = $GLOBALS['db']->query($selectSchedular);
if($selResult->num_rows > 0){
	$selRow = $GLOBALS['db']->fetchByAssoc($selResult);
	$id = $selRow['id'];
	$del = "DELETE FROM schedulers WHERE id = '$id'";
	$delResult = $GLOBALS['db']->query($del);
	
	if($delResult == 1){
		//schedular job
		$sched1 = new Scheduler();
		$sched1->name               = 'Run Reminders And Notification';
		$sched1->job                = 'function::reminderandnotification';
		$sched1->date_time_start    =  $CurrenrDateTime;
		$sched1->date_time_end      =  null;
		$sched1->job_interval       = '*::*::*::*::*';
		$sched1->status             = 'Active';
		$sched1->created_by         = '1';
		$sched1->modified_user_id   = '1';
		$sched1->catch_up           = '1';
		$sched1->save();
	}
}else{
	//schedular job
	$sched1 = new Scheduler();
	$sched1->name               = 'Run Reminders And Notification';
	$sched1->job                = 'function::reminderandnotification';
	$sched1->date_time_start    =  $CurrenrDateTime;
	$sched1->date_time_end      =  null;
	$sched1->job_interval       = '*::*::*::*::*';
	$sched1->status             = 'Active';
	$sched1->created_by         = '1';
	$sched1->modified_user_id   = '1';
	$sched1->catch_up           = '1';
	$sched1->save();
}
?>