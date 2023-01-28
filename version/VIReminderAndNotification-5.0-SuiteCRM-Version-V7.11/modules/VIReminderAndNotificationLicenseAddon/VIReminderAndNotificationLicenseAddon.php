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
class VIReminderAndNotificationLicenseAddon extends SugarBean
{
    var $module_dir = 'VIReminderAndNotificationLicenseAddon';
    var $object_name = 'VIReminderAndNotificationLicenseAddon';
    var $table_name = 'vireminderandnotificationlicenseaddon';
    var $disable_var_defs = true;
    var $new_schema = true;
    var $disable_row_level_security = true;
    var $disable_custom_fields = true;
    var $relationship_fields = array();
    
    function bean_implements($interface){
        return false;
    }
}//end of class
?>