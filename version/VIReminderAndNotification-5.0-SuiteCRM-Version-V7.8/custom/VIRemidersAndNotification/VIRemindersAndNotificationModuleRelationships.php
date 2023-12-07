<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
 
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