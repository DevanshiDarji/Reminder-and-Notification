<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
 
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