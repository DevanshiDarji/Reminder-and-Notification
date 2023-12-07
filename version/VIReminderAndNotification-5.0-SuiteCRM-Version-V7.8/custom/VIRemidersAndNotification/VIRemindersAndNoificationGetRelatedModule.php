<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
 
class VIRemindersAndNoificationGetRelatedModule{
    public function __construct(){
        $this->getRelateFields();
    } 

    public function getRelateFields(){
        $module = $_REQUEST['module'];
        $flag = $_REQUEST['flag'];

        if($module == "Securitygroups"){
            $module = "SecurityGroups";
        }
        if($module == "Aos_products_purchases"){
            $module = "AOS_Products";
        }
        
        require_once('modules/ModuleBuilder/parsers/ParserFactory.php');
        require_once('modules/'.$module.'/language/en_us.lang.php');
        $editviewData = ParserFactory::getParser('editview', $module);
        $editviewData = $this->getFields($editviewData, $module, $flag);
       
        echo json_encode($editviewData);
    }//end of method

    function getFields($viewData,$module,$flag){
        $panelArray = $viewData->_viewdefs['panels'];
        $bean = BeanFactory::newBean($module);
        $field = $bean->getFieldDefinitions();

        $viewFieldArray = $relateFieldModules = array();
        foreach ($panelArray as $key => $value) {
            foreach ($value as $keys => $values) {
                $viewFieldArray[] = $values;
            }
        }//end of foreach

        foreach($viewFieldArray as $key => $value) {
            foreach($value as $k => $v) {
                if(array_key_exists($v, $field)) {
                    if(isset($_REQUEST['module']) && $flag == 1){
                        if($field[$v]['type'] == 'relate' && isset($field[$v]['module'])){
                            $fieldName = $field[$v]['name'];
                            $fieldLabel = translate($field[$v]['vname'],$module);

                            if(strpos($fieldLabel, ':')){
                                $fieldLabel = substr_replace($fieldLabel, "", -1);
                            }//end of if   

                            if(isset($field[$v]['module'])){
                                $relatedModule = $field[$v]['module'];
                            } 

                            if($fieldName != "currency_symbol" && $fieldName != "currency_name"){
                                $relateFieldModules['relateFields'][][$relatedModule] = array($fieldName => $fieldLabel);                     
                            }
                            
                        }else if($field[$v]['type'] == 'parent'){
                            global $app_list_strings;
                            $domName = $field[$v]['options'];
                            $moduleList = $app_list_strings[$domName];
                            foreach ($moduleList as $mkey => $mvalue) {
                                $relateFieldModules['parentRelateFieldModule'][$mkey] = translate($mkey);
                            }
                        }
                    }else if(isset($_REQUEST['module']) && $flag == 0){
                        if($field[$v]['type'] == 'text' || $field[$v]['type'] == 'email' || (isset($field[$v]['function']) && in_array("getEmailAddressWidget",$field[$v]['function']))){
                            $fieldName = $field[$v]['name'];
                            $fieldLabel = translate($field[$v]['vname'],$module);
                            if(strpos($fieldLabel, ':')){
                                $fieldLabel = str_replace(":","",$fieldLabel);
                            }
                            $relateFieldModules[$fieldName] =  $fieldLabel;

                            unset($relateFieldModules['currency_id']);
                        }
                    }
                }
            }
        }

        $uniqueRelateFieldModules = array_unique($relateFieldModules,SORT_REGULAR);
        asort($uniqueRelateFieldModules);
        return $uniqueRelateFieldModules;
    }
}
new VIRemindersAndNoificationGetRelatedModule();
?>
