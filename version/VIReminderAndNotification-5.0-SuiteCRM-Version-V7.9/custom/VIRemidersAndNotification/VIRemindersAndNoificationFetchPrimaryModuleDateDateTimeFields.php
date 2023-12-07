<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
 
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