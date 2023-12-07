<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
 
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
