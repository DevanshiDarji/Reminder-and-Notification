<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
 
require_once("modules/AOW_WorkFlow/aow_utils.php");
require_once("custom/VIRemidersAndNotification/VIRemindersAndNotificationFunction.php");
class VIRemindersAndNotificationModuleFieldType{
	public function __construct(){
		$this->getModuleFieldType();
	}
    public function getModuleFieldType(){
		if(isset($_REQUEST['rel_field']) &&  !empty($_REQUEST['rel_field'])){
            $relModule = getRelatedModule($_REQUEST['aow_module'],$_REQUEST['rel_field']);
        } else {
            $relModule = $_REQUEST['aow_module'];
        }
      
        $fieldName = $_REQUEST['aow_fieldname'];
        $aowField = $_REQUEST['aow_newfieldname'];
        $lineCount = $_REQUEST['ln'];
        $id = $_REQUEST['recordId'];

        if(isset($_REQUEST['view'])) $view = $_REQUEST['view'];
        else $view= 'EditView';
        if(isset($_REQUEST['aow_value'])) $value = $_REQUEST['aow_value'];
        else $value = ' ';


        $productAllCondition = $productAnyCondition = array();

        $fieldNames = array('value','condition_type');
        $whereData = array('reminder_notification_id'=>$id,'deleted'=>0);
        $getProductConditionQuery = getReminderNotificationRecord('vi_reminders_notification_condition', $fieldNames, $innerJoin=array(), $onData=array(), $whereData, $orderby=array(), $limit=array());
        $getProductConditionResult = $GLOBALS['db']->query($getProductConditionQuery);
        
        $i = $j = 0;
        while($getProductConditionRows = $GLOBALS['db']->fetchByAssoc($getProductConditionResult)){
            if($getProductConditionRows['condition_type'] == "All"){
                $productAllCondition[$i] = $getProductConditionRows['value'];
                $i++;
            }else{
                $productAnyCondition[$j] = $getProductConditionRows['value'];
                $j++;   
            }    
        }
        
        if($fieldName == "product"){
            if($view == 'vi_reminderandnotificationeditview'){

                getProductNameFieldHtml($productAllCondition, $productAnyCondition, $lineCount, $aowField);

            }
        }else if($fieldName == "part_number" || $fieldName == "product_qty" || $fieldName == "product_list_price" || $fieldName == "product_discount" || $fieldName == "vat_amt" || $fieldName == "product_unit_price"){

            getProductFieldsHtml($productAllCondition, $productAnyCondition, $lineCount, $aowField);

        }else if($fieldName == "discount"){
            if(isset($productAllCondition[$lineCount]) && $productAllCondition[$lineCount] != "" && $aowField == "aowAllConditionsValue[".$lineCount."]"){

                getProductDicountFieldHtml($productAllCondition, $lineCount, $aowField);

            }else if(isset($productAnyCondition[$lineCount]) && $productAnyCondition[$lineCount] != "" && $aowField == "aowAnyConditionsValue[".$lineCount."]"){

                getProductDicountFieldHtml($productAnyCondition, $lineCount, $aowField);
                
            }else{
                echo '<select onchange="getProductField(this)"><option value="Percentage">Pct</option><option value="Amount">Amt</option></select>';
                echo '<input type="hidden" name="'.$aowField.'" id="'.$aowField.'" value="">';
            }

        }else if($fieldName == "vat"){
            if(isset($productAllCondition[$lineCount]) && $productAllCondition[$lineCount] != "" && $aowField == "aowAllConditionsValue[".$lineCount."]"){

                getProductVatFieldHtml($productAllCondition, $lineCount, $aowField);

            }else if(isset($productAnyCondition[$lineCount]) && $productAnyCondition[$lineCount] != "" && $aowField == "aowAnyConditionsValue[".$lineCount."]"){

                getProductVatFieldHtml($productAnyCondition, $lineCount, $aowField);

            }else{
                echo '<select onchange="getProductField(this)"><option value="0.0">0%</option><option value="5.0">5%</option><option value="7.5">7.5%</option><option value="17.5">17.5%</option><option value="20.0">20%</option></select>';
                echo '<input type="hidden" name="'.$aowField.'" id="'.$aowField.'" value="">';
            }
        }else{
            //switch case 
            switch($_REQUEST['aow_type']) {
                case 'Value':
                default:
                    if($view == 'vi_reminderandnotificationeditview'){
                        echo getModuleField($relModule, $fieldName, $aowField, 'EditView', $value);
                    }
                    break;
            }//end of switch
            die;
        }
    }//end of function
}//end of class
new VIRemindersAndNotificationModuleFieldType();
?>