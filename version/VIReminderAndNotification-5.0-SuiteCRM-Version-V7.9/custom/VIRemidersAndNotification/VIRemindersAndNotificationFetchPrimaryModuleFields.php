<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
 
require_once("custom/VIRemidersAndNotification/VIRemindersAndNotificationFunction.php");
class VIRemindersAndNotificationFetchPrimaryModuleFields{
    public function __construct(){
        $this->getPrimaryModuleFields();
    } 
    public function getPrimaryModuleFields(){
        if(isset($_REQUEST['aow_module'])){
            $module = $_REQUEST['aow_module'];
        }else if(isset($_REQUEST['module'])){
            $module = $_REQUEST['module'];
        }
        
        $flag = 0;
        if(isset($_REQUEST['flag']) && $_REQUEST['flag'] != ""){
            $flag = $_REQUEST['flag'];
        }
        if(isset($_REQUEST['view']) && !empty($_REQUEST['view'])){
            $flag = 1;
        }
  
        if($module == "Securitygroups"){
            $module = "SecurityGroups";
        }
        if($module == "Aos_products_purchases"){
            $module = "AOS_Products";
        }
        require_once('modules/ModuleBuilder/parsers/ParserFactory.php');
        require_once('modules/'.$module.'/language/en_us.lang.php');

        $editViewArray = ParserFactory::getParser('editview', $module);
        $detailViewArray = ParserFactory::getParser('detailview', $module);

        $editViewFields = getFields($editViewArray, $module, $flag);
       
        if($flag != 2){
            $detailViewFields = getFields($detailViewArray, $module, $flag);
        }else{
            $detailViewFields = array();
        }
        
        $mergeEditDetailViewFields = array_merge($editViewFields, $detailViewFields);
        $uniqueEditDetailViewFields = array_unique($mergeEditDetailViewFields, SORT_REGULAR);

        $fieldVal = '';
        if($flag == 1){
            $fieldsHtml = "<option value=''>--None--</option>";
            foreach($uniqueEditDetailViewFields as $fieldKey => $fieldValues){
                $fieldsHtml .= "<optgroup label='".$fieldKey."'>";
                foreach($fieldValues as $fieldName => $fieldValue){
                    $fieldsHtml .= "<option value='".$fieldName."'>".$fieldValue."</option>";
                }
                $fieldsHtml .= "</optgroup>";
            }
            echo $fieldsHtml;
        }else{
            echo get_select_options_with_id($uniqueEditDetailViewFields, $fieldVal);
        }   
    }//end of method
}//end of class
new VIRemindersAndNotificationFetchPrimaryModuleFields();
?>