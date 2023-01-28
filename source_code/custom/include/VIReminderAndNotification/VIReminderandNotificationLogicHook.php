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
class VIReminderandNotificationLogicHook{
	public function viremindernotification($event,$arguments){
		if($GLOBALS['app']->controller->action == 'index' && $_REQUEST['module'] == 'Administration'){
    		global $suitecrm_version;
    		if (version_compare($suitecrm_version, '7.10.2', '>=')){
    			echo '<link rel="stylesheet" type="text/css" href="custom/include/VIReminderAndNotification/css/VIReminderandNotificationIcon.css">';
      		}//end of if
      	}//end of if
	}//end of function
}//end of class
?>