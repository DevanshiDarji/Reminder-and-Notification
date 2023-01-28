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
require_once("modules/AOW_WorkFlow/aow_utils.php");
class VIRemindersAndNotificationModuleRelationships{
	public function __construct(){
		$this->getModuleRelationships();
	} 
	public function getModuleRelationships(){
        if (!empty($_REQUEST['aow_module'])) {
            if(isset($_REQUEST['rel_field']) &&  !empty($_REQUEST['rel_field'])){
                $module = getRelatedModule($_REQUEST['aow_module'],$_REQUEST['rel_field']);
            } else {
                $module = $_REQUEST['aow_module'];
            }
            echo getModuleRelationships($module);
        }//end of if
    }//end of function
}//end of class
new VIRemindersAndNotificationModuleRelationships();
?>