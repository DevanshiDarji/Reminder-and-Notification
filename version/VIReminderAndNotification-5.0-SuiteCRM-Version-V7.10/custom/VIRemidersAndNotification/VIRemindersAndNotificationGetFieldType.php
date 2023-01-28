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
class VIRemindersAndNotificationGetFieldType{
	public function __construct(){
        $this->getFieldType();
    }//end of function
    public function getFieldType(){
    	$dateTimeFieldStatus = 0;

      	$bean = BeanFactory::newBean($_REQUEST['module']);
    	$fieldDefs = $bean->field_defs[$_REQUEST['field']];

    	if($fieldDefs['type'] == 'date'){
    		$dateTimeFieldStatus = 1;
    	}
        
    	echo $dateTimeFieldStatus;
   	}//end of function
}//end of class
new VIRemindersAndNotificationGetFieldType();
?>