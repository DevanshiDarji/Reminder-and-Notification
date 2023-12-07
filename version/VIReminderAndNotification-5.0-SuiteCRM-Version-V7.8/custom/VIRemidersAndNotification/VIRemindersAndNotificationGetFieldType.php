<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
 
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