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
class VIRemindersAndNotificationFieldTypeOptions{
	public function __construct(){
		$this->getFieldTypeOptions();
	} 
	public function getFieldTypeOptions(){
		global $app_list_strings, $beanFiles, $beanList;

        if(isset($_REQUEST['rel_field']) &&  !empty($_REQUEST['rel_field'])){
            $module = getRelatedModule($_REQUEST['aow_module'], $_REQUEST['rel_field']);
        } else {
            $module = $_REQUEST['aow_module'];
        }

        $aowField = $_REQUEST['aow_newfieldname'];

        if(isset($_REQUEST['view'])) $view = $_REQUEST['view'];
        else $view = 'EditView';

		if(isset($_REQUEST['aow_value'])) $value = $_REQUEST['aow_value'];
        else $value = '';

        $fieldTypeOptions = array('Value');

        if(!file_exists('modules/SecurityGroups/SecurityGroup.php')){
            unset($app_list_strings['aow_condition_type_list']['SecurityGroup']);
        }
        foreach($app_list_strings['aow_condition_type_list'] as $key => $keyValue){
            if(!in_array($key, $fieldTypeOptions)){
                unset($app_list_strings['aow_condition_type_list'][$key]);
            }
        }
        
		if($view == 'vi_reminderandnotificationeditview'){
            echo "<select type='text'  name='$aowField' id='$aowField' title='' tabindex='116'>". get_select_options_with_id($app_list_strings['aow_condition_type_list'], $value) ."</select>";
        }else{
            echo $app_list_strings['aow_condition_type_list'][$value];
        }
        die;
    }//end of function
}//end of class
new VIRemindersAndNotificationFieldTypeOptions();
?>