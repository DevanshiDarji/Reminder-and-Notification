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
class VIRemindersAndNoificationFetchPrimaryModuleDateDateTimeFields{
    public function __construct(){
        $this->getPrimaryModuleDateTimeFields();
    }
    public function getPrimaryModuleDateTimeFields(){
        $module = $_POST['module'];
        
        if($module == "Securitygroups"){
            $module = "SecurityGroups";
        }
        if($module == "Aos_products_purchases"){
            $module = "AOS_Products";
        }

        $bean = BeanFactory::newBean($module);//bean
        $fields = $bean->getFieldDefinitions();//fields

        $dateFieldData = array();
        foreach($fields as $value){
            if($value['type'] == 'date' || $value['type'] == 'datetime' || $value['type'] == 'datetimecombo'){
                $fieldName = $value['name'];
                $fieldLabel = translate($value['vname'], $module);
                if(strpos($fieldLabel, ':')){
                    $fieldLabel = substr_replace($fieldLabel, "", -1);
                }
                $dateFieldData[$fieldName] =  $fieldLabel;
            }
        }//end of for

        if($module == "Tasks"){
            unset($dateFieldData['time_due']);
        }elseif($module == "Calls" || $module == "Meetings"){
            unset($dateFieldData['repeat_until']);
        }
        
        $uniqueDateTimeFields = array_unique($dateFieldData, SORT_REGULAR);

        $fieldVal = '';
        echo get_select_options_with_id($uniqueDateTimeFields, $fieldVal);
    }//end of method
}//end of class
new VIRemindersAndNoificationFetchPrimaryModuleDateDateTimeFields();
?>