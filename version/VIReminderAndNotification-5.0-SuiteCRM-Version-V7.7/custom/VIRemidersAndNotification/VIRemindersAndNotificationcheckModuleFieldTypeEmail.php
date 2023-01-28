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
class VIRemindersAndNotificationcheckModuleFieldTypeEmail{
    public function __construct(){
        $this->checkModuleFieldTypeEmail();
    } 
    //Check Module Field Type Email
    public function checkModuleFieldTypeEmail(){
        $module = $_REQUEST['module'];

        $bean = BeanFactory::newBean($module);//bean
        $fields = $bean->getFieldDefinitions();
        
        $emailFieldStatus = 0;
        foreach($fields as $value){
            if($value['type'] == 'varchar'){
                if(isset($value['function'])){
                    if(in_array("getEmailAddressWidget",$value['function'])){
                        $emailFieldStatus = 1;
                    }
                }
            }
        }//end of for
        echo $emailFieldStatus;
    }
}
new VIRemindersAndNotificationcheckModuleFieldTypeEmail();
?>
