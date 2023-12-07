<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
 
require_once("modules/AOW_WorkFlow/aow_utils.php");
class VIRemindersAndNotificationModuleOperatorField{
    public function __construct(){
        $this->getModuleOperatorField();
    } 
    //get module operator fields
    public function getModuleOperatorField(){
        global $app_list_strings, $beanFiles, $beanList;

        if(isset($_REQUEST['rel_field']) &&  !empty($_REQUEST['rel_field'])){
            $module = getRelatedModule($_REQUEST['aow_module'],$_REQUEST['rel_field']);
        } else {
            $module = $_REQUEST['aow_module'];
        }

        $fieldName = $_REQUEST['aow_fieldname'];
        $aowField = $_REQUEST['aow_newfieldname'];

        if(isset($_REQUEST['view'])) $view = $_REQUEST['view'];
        else $view= 'EditView';
        if(isset($_REQUEST['aow_value'])) $value = $_REQUEST['aow_value'];
        else $value = '';

        require_once($beanFiles[$beanList[$module]]);

        $focus = new $beanList[$module];

        if($module == "AOS_Invoices" || $module == "AOS_Quotes"){
            if($fieldName == 'product'){
                $vardef = array('name' =>'product','vname'=>'Product','type'=>'link','relationship'=>'aos_products_aos_invoices','module'=>'AOS_Products','bean_name'=>'AOS_Product','source'=>'non-db');    
            }else if($fieldName == 'part_number'){
                $vardef = array('name' =>'part_number','vname'=>'Part Number','type'=>'text'); 
            }else if($fieldName == 'product_qty'){
                $vardef = array('name' =>'product_qty','vname'=>'Quantity','type'=>'number');      
            }else if($fieldName == 'product_list_price'){
                $vardef = array('name' =>'product_list_price','vname'=>'List Price','type'=>'currency','len' => '26,6');
            }else if($fieldName == 'product_discount'){
                $vardef = array('name' =>'product_discount','vname'=>'Product Discount','type'=>'currency','len' => '26,6');
            }else if($fieldName == 'discount'){
                $vardef = array('name' =>'discount','vname'=>'Discount','type'=>'enum','options' => array('Percentage'=>'Pct','Amount'=>'Amt'),'len' => '200');
            }else if($fieldName == 'product_unit_price'){
                $vardef = array('name' =>'product_unit_price','vname'=>'Sale Price','type'=>'currency','len' => '26,6');
            }else if($fieldName == 'vat_amt'){
                $vardef = array('name' =>'vat_amt','vname'=>'Tax Amount','type'=>'currency','len' => '26,6');
            }else if($fieldName == 'vat'){
                $vardef = array('name' =>'vat','vname'=>'Tax','type'=>'enum','options' => array('0.0'=>'0%','5.0'=>'5%','7.5'=>'7.5%','17.5'=>'17.5%','20.0'=>'20%'),'len' => '200');
            }else{
                $vardef = $focus->getFieldDefinition($fieldName);
            }
        }else{
            $vardef = $focus->getFieldDefinition($fieldName);
        }

        if($vardef){
            switch($vardef['type']) {
                case 'double':
                case 'decimal':
                case 'float':
                case 'currency':
                case 'number':
                $operators = array('Equal_To','Not_Equal_To','Greater_Than','Less_Than','Greater_Than_or_Equal_To','Less_Than_or_Equal_To','is_null');
                    break;
                case 'uint':
                case 'ulong':
                case 'long':
                case 'short':
                case 'tinyint':
                case 'int':
                $operators = array('Equal_To','Not_Equal_To','Greater_Than','Less_Than','Greater_Than_or_Equal_To','Less_Than_or_Equal_To','is_null');
                    break;
                case 'date':
                case 'datetime':
                case 'datetimecombo':
                $operators = array('Equal_To','Not_Equal_To','Greater_Than','Less_Than','Greater_Than_or_Equal_To','Less_Than_or_Equal_To','is_null');
                    break;
                case 'enum':
                case 'multienum':
                $operators = array('Equal_To','Not_Equal_To','is_null');
                    break;
                default:
                $operators = array('Equal_To','Not_Equal_To','Contains', 'Starts_With', 'Ends_With','is_null');
                    break;
            }//end of switchcase

            foreach($app_list_strings['aow_operator_list'] as $key => $keyValue){
                if(!in_array($key, $operators)){
                    unset($app_list_strings['aow_operator_list'][$key]);
                }
            }//end of foreach

            $app_list_strings['aow_operator_list'];
            if($view == 'vi_reminderandnotificationeditview'){
                echo "<select type='text' name='$aowField' id='$aowField' title='' tabindex='116' style='width: 205px;'>". get_select_options_with_id($app_list_strings['aow_operator_list'], $value) ."</select>";
            }else{
                echo $app_list_strings['aow_operator_list'][$value];
            }
        }//end of if
        die;
    }//end of function
}//end of class
new VIRemindersAndNotificationModuleOperatorField();
?>