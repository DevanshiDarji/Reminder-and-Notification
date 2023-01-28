<?php
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
//Insert Reminder Notifiation Data
function insertReminderNotificationRecord($tableName, $fielddata){
    //data key
    $key = array_keys($fielddata);
    $fieldName = implode(",",$key);
    
    //data val
    $val = array_values($fielddata);
    $fieldVal = implode(",",$val);
    
    //insert
    $insertReminderNotificationData = "INSERT INTO $tableName ($fieldName)VALUES($fieldVal)";
    $insertReminderNotificationResult = $GLOBALS['db']->query($insertReminderNotificationData);

    return $insertReminderNotificationResult;
}//end of function

//Update Reminder Notifiation Data
function updateReminderNotificationRecord($tabelName, $data, $where){
    //update
    $updateReminderNotificationData = "UPDATE $tabelName SET";

    $fieldName = array_keys($data); //database field name
    $fieldValue = array_values($data); //field value

    $whereFieldName = array_keys($where); //where condition field name
    $whereFieldValue = array_values($where); // where condition field value

    $i=0;
    $count = count($data);
    foreach($data as $fieldData){
        if($count == $i+1){
            $updateReminderNotificationData .= " $fieldName[$i]=$fieldValue[$i]";
        }else{
            $updateReminderNotificationData .= " $fieldName[$i]=$fieldValue[$i],";
        }//end of else
        $i++;
    }//end of foreach
    if(!empty($where)){
       $j=0;
        $updateReminderNotificationData .= " where";
        foreach($where as $whereConditionData){
            if($j == 0){
                $updateReminderNotificationData .=" $whereFieldName[$j]='$whereFieldValue[$j]'";
            }else{
                $updateReminderNotificationData .=" and $whereFieldName[$j]='$whereFieldValue[$j]'";
            }//end of else 
            $j++;
        }//end of foreach
    }
    $updateReminderNotificationDataResult = $GLOBALS['db']->query($updateReminderNotificationData);

    return $updateReminderNotificationDataResult;
}//end of function

//Delete Reminder Notification Condition Data
function deleteReminderNotificationConditionData($tableName, $where){
    $deleteTable = "DELETE FROM $tableName";
    foreach($where as $k => $val){
        $deleteTable .=" WHERE  $k=$val";
    }//end of foreach
    $deleteTableResult = $GLOBALS['db']->query($deleteTable);
    return $deleteTableResult;
}//end of function

//Get Reminder Notifiation Data
function getReminderNotificationRecord($tableName, $fieldNames, $innerJoin, $tableFieldRelation, $where, $orderby, $limit){
   
    $getReminderNotificationQuery = '';
    //select
    $getReminderNotificationQuery .= "SELECT ";
    foreach($fieldNames as $key => $value){
        if($key == 0){
            $getReminderNotificationQuery .= $value;
        }else{
            $getReminderNotificationQuery .= ",".$value;
        }
    }
    $getReminderNotificationQuery .= " FROM $tableName"; 

    if(!empty($innerJoin)){
        foreach($innerJoin as $key => $value){
            $getReminderNotificationQuery .= " INNER JOIN $value";
        }
    }

    if(!empty($tableFieldRelation)){
        foreach($tableFieldRelation as $key => $value){
            $getReminderNotificationQuery .= " ON $key=$value";
        }
    }

    $whereFieldName = array_keys($where); //where condition field name
    $whereFieldValue = array_values($where); // where condition field value

    $j=0;
    if(!empty($where)){
        $getReminderNotificationQuery .= " WHERE";
        $count = count($where);
        foreach($where as $key => $w){
            $fieldName = $whereFieldName[$j];
            $fieldValue = $whereFieldValue[$j];
            if($count > 1 && $j >= 1){
                $getReminderNotificationQuery .=" AND $fieldName='$fieldValue'";
            }else{
                $getReminderNotificationQuery .=" $fieldName='$fieldValue'";
            }
            $j++;
        }//end of foreach
    }
    
    if(!empty($orderby)){
        $getReminderNotificationQuery .= " ORDER BY";  
        foreach($orderby as $k => $v){
            $getReminderNotificationQuery .= " $k $v";
        } 
    }

    if(!empty($limit)){
        $getReminderNotificationQuery .= " LIMIT";  
        foreach($limit as $k => $v){
            $getReminderNotificationQuery .= " $k,$v";
        } 
    }
    
    return $getReminderNotificationQuery;
}//end of function

//get all modules
function getAllModulesListForReminderAndNotification(){
    require_once("modules/MySettings/TabController.php");
    $controller = new TabController();
    $tabs = $controller->get_tabs_system();
    foreach ($tabs[0] as $key=>$value) {
        if($key != 'Home' && $key != 'Calendar' && $key != 'AOR_Reports' && $key != 'Emails' && $key != 'Campaigns' && $key != 'EmailTemplates' && $key != 'AOW_WorkFlow'){
        $moduleList[$key] = translate($key);
        }//end of if
    }//end of foreach
    asort($moduleList); //sort modules

    return $moduleList;
}//end of function

//Get All Users
function getAllUsers(){
    $active_users = get_user_array(false); 
    asort($active_users);
    return $active_users;
}//end of function

//Get TMCE For Template
function displayTinyMCEForTemplate(){
    require_once("include/SugarTinyMCE.php");
    global $locale;
    $tiny = new SugarTinyMCE();
    $tinyMCE = $tiny->getConfig();
    $js =<<<JS
    <script language="javascript" type="text/javascript">
        $tinyMCE
        var df = '{$locale->getPrecedentPreference('default_date_format')}';
        tinyMCE.init({
            theme : "advanced",
            theme_advanced_toolbar_align : "left",
            mode: "exact",
            elements : "template_message",
            theme_advanced_toolbar_location : "top",
            theme_advanced_buttons1: "code,help,separator,bold,italic,underline,strikethrough,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,forecolor,backcolor,separator,styleprops,styleselect,formatselect,fontselect,fontsizeselect",
            theme_advanced_buttons2: "cut,copy,paste,pastetext,pasteword,selectall,separator,search,replace,separator,bullist,numlist,separator,outdent,indent,separator,ltr,rtl,separator,undo,redo,separator,link,unlink,anchor,image,separator,sub,sup,separator,charmap,visualaid",
            theme_advanced_buttons3: "tablecontrols,separator,advhr,hr,removeformat,separator,insertdate,pagebreak",
                theme_advanced_fonts:"Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Helvetica Neu=helveticaneue,sans-serif;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats",
            plugins : "advhr,insertdatetime,table,paste,searchreplace,directionality,style,pagebreak",
            height:"300",
            width:"100%",
            inline_styles : true,
            directionality : "ltr",
            remove_redundant_brs : true,
            entity_encoding: 'raw',
            cleanup_on_startup : true,
            strict_loading_mode : true,
            convert_urls : false,
            plugin_insertdate_dateFormat : '{DATE '+df+'}',
            pagebreak_separator : "<pagebreak />",
            extended_valid_elements : "textblock,barcode[*]",
            custom_elements: "textblock",
        });
    </script>
JS;
    echo $js;
}//end of function

function getProductNameFieldHtml($productAllCondition, $productAnyCondition, $lineCount, $aowField){
    $getProductNameFieldHtml = '';
    
    $productModuleName = 'AOS_Products';
    
    if(isset($productAllCondition[$lineCount]) && $productAllCondition[$lineCount] != "" && $aowField == "aowAllConditionsValue[".$lineCount."]"){
        $productId = $productAllCondition[$lineCount];
    }
    if(isset($productAnyCondition[$lineCount]) && $productAnyCondition[$lineCount] != "" && $aowField == "aowAnyConditionsValue[".$lineCount."]"){
        $productId = $productAnyCondition[$lineCount];
    }
    if(isset($productId)){
        $fieldNames = array('name');
        $whereData = array('id'=>$productId,'deleted'=>0);
        $getProductData = getReminderNotificationRecord('aos_products', $fieldNames, $innerJoin=array(), $onData = array(), $whereData, $orderby=array(), $limit=array());
        $getProductNameRow = $GLOBALS['db']->fetchOne($getProductData);
    }
    if(isset($productAllCondition[$lineCount]) && $productAllCondition[$lineCount] != "" && $aowField == "aowAllConditionsValue[".$lineCount."]"){
        if($aowField == "aowAllConditionsValue[".$lineCount."]"){
            $getProductNameFieldHtml = '<input class="sqsEnabled productName" autocomplete="off" type="text" name="productAllName'.$lineCount.'" id="productAllName'.$lineCount.'" maxlength="50"  title="" tabindex="116" value="'.$getProductNameRow['name'].'">';
        }
    }else{
        if($aowField == "aowAllConditionsValue[".$lineCount."]"){
            $getProductNameFieldHtml .= '<input class="sqsEnabled productName" autocomplete="off" type="text" name="productAllName'.$lineCount.'" id="productAllName'.$lineCount.'" maxlength="50"  title="" tabindex="116" value="">';
        }
    }
    if(isset($productAnyCondition[$lineCount]) && $productAnyCondition[$lineCount] != "" && $aowField == "aowAnyConditionsValue[".$lineCount."]"){
        if($aowField == "aowAnyConditionsValue[".$lineCount."]"){
            $getProductNameFieldHtml .= '<input class="sqsEnabled productName" autocomplete="off" type="text" name="productAnyName'.$lineCount.'" id="productAnyName'.$lineCount.'" maxlength="50"  title="" tabindex="116" value="'.$getProductNameRow['name'].'">';
        }    
    }else{
        if($aowField == "aowAnyConditionsValue[".$lineCount."]"){
            $getProductNameFieldHtml .= '<input class="sqsEnabled productName" autocomplete="off" type="text" name="productAnyName'.$lineCount.'" id="productAnyName'.$lineCount.'" maxlength="50"  title="" tabindex="116" value="">';
        }
    }
    if(isset($productAllCondition[$lineCount]) && $productAllCondition[$lineCount] != "" && $aowField == "aowAllConditionsValue[".$lineCount."]"){
        if($aowField == "aowAllConditionsValue[".$lineCount."]"){
            $getProductNameFieldHtml .= '<input type="hidden" name="allProductId'.$lineCount.'" id="allProductId'.$lineCount.'" maxlength="50" value="'.$productAllCondition[$lineCount].'">';
        }
    }else{
        if($aowField == "aowAllConditionsValue[".$lineCount."]"){
            $getProductNameFieldHtml .= '<input type="hidden" name="allProductId'.$lineCount.'" id="allProductId'.$lineCount.'" maxlength="50" value="">';
        }
    }
    if(isset($productAnyCondition[$lineCount]) && $productAnyCondition[$lineCount] != ""){
        if($aowField == "aowAnyConditionsValue[".$lineCount."]"){
            $getProductNameFieldHtml .= '<input type="hidden" name="anyProductId'.$lineCount.'" id="anyProductId'.$lineCount.'" maxlength="50" value="'.$productAnyCondition[$lineCount].'">';
        }
    }else{
        if($aowField == "aowAnyConditionsValue[".$lineCount."]"){
            $getProductNameFieldHtml .= '<input type="hidden" name="anyProductId'.$lineCount.'" id="anyProductId'.$lineCount.'" maxlength="50" value="">';
        }
    }
    
    if(isset($productAllCondition[$lineCount]) && $productAllCondition[$lineCount] != "" && $aowField == "aowAllConditionsValue[".$lineCount."]"){
        $getProductNameFieldHtml .= '<input type="hidden" name="'.$aowField.'" id="'.$aowField.'" value="'.$productAllCondition[$lineCount].'">';
    }else if(isset($productAnyCondition[$lineCount]) && $productAnyCondition[$lineCount] != "" && $aowField == "aowAnyConditionsValue[".$lineCount."]"){
        $getProductNameFieldHtml .= '<input type="hidden" name="'.$aowField.'" id="'.$aowField.'" value="'.$productAnyCondition[$lineCount].'">';
    }else{
        $getProductNameFieldHtml .= '<input type="hidden" name="'.$aowField.'" id="'.$aowField.'" value="">';
    }

    if($aowField == "aowAllConditionsValue[".$lineCount."]"){
        $productName = 'productAllName'.$lineCount;
        $productId = 'allProductId'.$lineCount;
    }else if($aowField == "aowAnyConditionsValue[".$lineCount."]"){
        $productName = 'productAnyName'.$lineCount;
        $productId = 'anyProductId'.$lineCount;
    }

    $getProductNameFieldHtml .= '<span class="id-ff multiple">
                        <button type="button" name="btn_relate" id="productButton" tabindex="0" class="button firstChild" onclick="openModulePopup('."'".
                        $productModuleName."'".','."'".$productName."'".','."'".$productId."'".','."'".$aowField."'".');">
                            <img src="themes/default/images/id-ff-select.png?v=mTmf-1lP7RIiI-bMI3e72w">
                        </button>';
    $getProductNameFieldHtml .= '<button type="button" name="" id="productRemoveButton" tabindex="0" class="button lastChild " onclick="SUGAR.clearRelateField(this.form,'."'".$productName."'".','."'".$productId."'".'); removeProductConditionField(this);" value=""><img src="themes/default/images/id-ff-clear.png?v=mTmf-1lP7RIiI-bMI3e72w"></button>
    </span>'; 

    echo $getProductNameFieldHtml; 
}//end of function

function getProductFieldsHtml($productAllCondition, $productAnyCondition, $lineCount, $aowField){
    $getProductFieldsHtml = "";
    if(isset($productAllCondition[$lineCount]) && $productAllCondition[$lineCount] != "" && $aowField == "aowAllConditionsValue[".$lineCount."]"){
        $getProductFieldsHtml .= '<input type="text" name="'.$aowField.'" id="'.$aowField.'" size="30" maxlength="255" value="'.$productAllCondition[$lineCount].'" title="" tabindex="1">';
    }else if(isset($productAnyCondition[$lineCount]) && $productAnyCondition[$lineCount] != "" && $aowField == "aowAnyConditionsValue[".$lineCount."]"){
        $getProductFieldsHtml .=  '<input type="text" name="'.$aowField.'" id="'.$aowField.'" size="30" maxlength="255" value="'.$productAnyCondition[$lineCount].'" title="" tabindex="1">';
    }else{
        $getProductFieldsHtml .=  '<input type="text" name="'.$aowField.'" id="'.$aowField.'" size="30" maxlength="255" value="" title="" tabindex="1">';
    }

    echo $getProductFieldsHtml;
}//end of function

function getProductDicountFieldHtml($productCondition, $lineCount, $aowField){
    $getProductDiscountHtml = "<select onchange='getProductField(this)'><option";
    if($productCondition[$lineCount] == "Percentage"){
        $getProductDiscountHtml .= " selected='selected'";
    }
    $getProductDiscountHtml .= " value='Percentage'>Pct</option><option";
    if($productCondition[$lineCount] == "Amount"){
        $getProductDiscountHtml .= " selected='selected'";
    } 
    $getProductDiscountHtml .= " value='Amount'>Amt</option>";
    $getProductDiscountHtml .= "</select>";
    $getProductDiscountHtml .= '<input type="hidden" name="'.$aowField.'" id="'.$aowField.'" value="'.$productCondition[$lineCount].'">';
        
    echo $getProductDiscountHtml;
}

function getProductVatFieldHtml($productCondition, $lineCount, $aowField){
    $getProductVatFieldHtml = "<select onchange='getProductField(this)'><option";
    if($productCondition[$lineCount] == "0.0"){
        $getProductVatFieldHtml .= " selected='selected'";
    }
    $getProductVatFieldHtml .= " value='0.0'>0%</option><option";
    if($productCondition[$lineCount] == "5.0"){
        $getProductVatFieldHtml .= " selected='selected'";
    } 
    $getProductVatFieldHtml .= " value='5.0'>5%</option><option";
    if($productCondition[$lineCount] == "7.5"){
        $getProductVatFieldHtml .= " selected='selected'";
    } 
    $getProductVatFieldHtml .= " value='7.5'>7.5%</option><option";
    if($productCondition[$lineCount] == "17.5"){
        $getProductVatFieldHtml .= " selected='selected'";
    } 
    $getProductVatFieldHtml .= " value='17.5'>17.5%</option><option";
    if($productCondition[$lineCount] == "20.0"){
        $getProductVatFieldHtml .= " selected='selected'";
    } 
    $getProductVatFieldHtml .= " value='20.0'>20%</option>";
    $getProductVatFieldHtml .= "</select>";
    $getProductVatFieldHtml .= '<input type="hidden" name="'.$aowField.'" id="'.$aowField.'" value="'.$productCondition[$lineCount].'">';
    
    echo $getProductVatFieldHtml;
}//end of function

//get selected module fields values in Condition Block
function getFieldValues($module, $fieldName, $value, $selValueType){
    global $timedate;
    $bean = BeanFactory::newBean($module);
    $field = $bean->field_defs[$fieldName];
   
    if($field['type'] == 'datetime' || $field['type'] == 'datetimecombo'){
        $date = date('Y-m-d',strtotime($value));
        $time = date('h:i:s',strtotime($value));
        $dbtime = $timedate->to_db_time($value);
        $value = $date.' '.$dbtime;
    }else if($field['type'] == 'date'){
        $value = date('Y-m-d',strtotime($value));
    }else if($field['type'] == 'multienum'){
        $value = encodeMultienumValue($value);
    }else if($field['type'] == 'enum'){
        if($selValueType == 'Multi'){
            $value = encodeMultienumValue($value);
        }//end of if
    }else {
        $numericValue = str_replace( ',', '', $value);
        if( is_numeric( $numericValue ) ) {
            $value = $numericValue;
        }//end of if
    }//end of else
    return $value;
}//end of function

//get condition lines
function getReminderNotificationConditionLines($recordId, $moduleName, $conditionType, $randNum){
    $conditionLinesHtml = '';
    
    if($conditionType == 'All'){
        $tableId = 'aowAllConditionLines';
        $conditionButtonId = 'btnAllConditionLine';
        $conditionLinesHtml .= '<script src="custom/modules/Administration/js/VIRemindersAndNotificationConditionLines.js?v='.$randNum.'"></script>';
    }else{
        $tableId = 'aowAnyConditionLines';
        $conditionButtonId = 'btnAnyConditionLine';
    }//end of else

    $conditionLinesHtml .= "<table border='0' cellspacing='4' width='100%' id='".$tableId."'></table>";
    $conditionLinesHtml .= "<div style='padding-top: 10px; padding-bottom:10px;'>";
    $conditionLinesHtml .= "<input type=\"button\" tabindex=\"116\" class=\"button\" value=\"Add Condition\" id='".$conditionButtonId."' onclick=\"insertConditionLine('".$conditionType."')\"/>";
    $conditionLinesHtml .= "</div>";

    if($moduleName != ''){
        $relatedModules[$moduleName] = translate($moduleName);
        $flowRelModules = get_select_options_with_id($relatedModules, $moduleName);
        require_once("modules/AOW_WorkFlow/aow_utils.php");
        $conditionLinesHtml .= "<script>";

        $conditionLinesHtml .= "flowRelModules = \"".trim(preg_replace('/\s+/', ' ', $flowRelModules))."\";";
        $conditionLinesHtml .= "flowModule = \"".$moduleName."\";";

        $conditionLinesHtml .= "document.getElementById('".$conditionButtonId."').disabled = '';";
        
        //get conditions
        $fieldNames = array('*');
        $orderBy = array('date_entered'=>'ASC');
        $whereAllData = array('reminder_notification_id' => $recordId,'condition_type' => $conditionType,'deleted' => 0);
        $getRNCondition = getReminderNotificationRecord('vi_reminders_notification_condition', $fieldNames, $innerJoin=array(), $onData=array(), $whereAllData, $orderBy, $limit=array());
        $getRNConditionResult = $GLOBALS['db']->query($getRNCondition);

        $fields = "";
        $fields .= "flowFields = \"".trim(preg_replace('/\s+/', ' ',getPrimaryModuleFields($moduleName)))."\";";

        while ($getRNConditionRow = $GLOBALS['db']->fetchByAssoc($getRNConditionResult)) {
            $conditionLinesHtml .= $fields;
            $conditionItem = json_encode($getRNConditionRow);
            $conditionLinesHtml .= "loadConditionLine(".$conditionItem.",'".$getRNConditionRow['condition_type']."');";
        }//end of while
        
        $conditionLinesHtml .= $fields;
        $conditionLinesHtml .= "</script>";
    }//end of if

    return $conditionLinesHtml;
}//end of function

function getPrimaryModuleFields($module, $view = 'EditView', $val = '', $flag=1){
    if ($module !== '') {
        if($module == "Project_resources"){
            $module = "Project";
        }
        require_once('modules/ModuleBuilder/parsers/ParserFactory.php');
        $viewArray = ParserFactory::getParser('editview',$module);

        $editDetailViewFieldsData = getFields($viewArray, $module, $flag);

        if($view == 'EditView'){
            $fieldsHTML = "<option value=''>--None--</option>";
            foreach($editDetailViewFieldsData as $fieldKey => $fieldValues){
                $fieldsHTML .= "<optgroup label='".$fieldKey."'>";
                foreach($fieldValues as $fieldName => $fieldValue){
                    $fieldsHTML .= "<option value='".$fieldName."'>".$fieldValue."</option>";
                }
                $fieldsHTML .= "</optgroup>";
            }
            return $fieldsHTML;
        }else{
            return $editDetailViewFieldsData;
        }
    }
}//end of function

function getFields($viewArray, $module, $flag){
    $panelArray = $viewArray->_viewdefs['panels'];

    $bean = BeanFactory::newBean($module);//bean
    $field = $bean->getFieldDefinitions();//fields
    $field = addProductFields($module, $field);//Add Product Fields 

    $addressFields = $viewFieldArray = $dateTimeFields = $editDetailViewFields = array();
    foreach($field as $key => $value){
        if($value['type'] == 'varchar'){
            if(isset($value['group'])){
                $fieldName = $value['name'];
                $fieldLabel = translate($value['vname'],$module);
                if(strpos($fieldLabel, ':')){
                    $fieldLabel = substr_replace($fieldLabel, "", -1);
                }
                if($flag == 1 || $flag == 2){
                    $addressFields[$fieldName] = $fieldLabel;
                }else{
                    $addressFields['$'.$fieldName.'$'] = $fieldLabel;
                }   
            }
        }
        if($value['type'] == "file"){
            unset($field[$key]);
        }
        if($value['type'] == 'date' || $value['type'] == 'datetime' || $value['type'] == 'datetimecombo'){
            $fieldName = $value['name'];
            $fieldLabel = translate($value['vname'], $module);
            if(strpos($fieldLabel, ':')){
                $fieldLabel = substr_replace($fieldLabel, "", -1);
            }
            if($flag == 1 || $flag == 2){
                $dateTimeFields[$fieldName] = $fieldLabel;
            }else{
                $dateTimeFields['$'.$fieldName.'$'] = $fieldLabel;
            }   
        }
    }//end of for

    if($module == "Tasks"){
        if($flag == 1 || $flag == 2){
            unset($dateTimeFields['time_due']);
        }else{
            unset($dateTimeFields['$time_due$']);
        }
    }elseif($module == "Calls" || $module == "Meetings"){
        if($flag == 1 || $flag == 2){
            unset($dateTimeFields['repeat_until']);
        }else{
            unset($dateTimeFields['$repeat_until$']);
        }
    }

    foreach($panelArray as $key => $value) {
        foreach ($value as $keys => $values) {
            $viewFieldArray[] = $values;
        }
    }//end of foreach

    if($flag == 1){
        $productFieldData = getProductFields($module, $field);   
    }

    foreach($viewFieldArray as $key => $value) {
        foreach($value as $k => $v) {
            if(array_key_exists($v, $field)) {
                require_once('include/utils.php');
                if($v == 'flow_run_on'){
                    $fieldLabel = translate('LBL_FLOW_RUN_ON',$module);
                }else{
                    $fieldLabel = translate($field[$v]['vname'],$module);
                }

                $fieldName = $v;
                if(strpos($fieldLabel, ':')){
                    $fieldLabel = str_replace(":", "", $fieldLabel);
                }
                
                if($flag == 1 || $flag == 2){
                    $editDetailViewFields[$fieldName] = $fieldLabel;
                }else{
                    $editDetailViewFields['$'.$fieldName.'$'] = $fieldLabel;
                }   
            }    
        }
    }//end of foreach

    if($flag == 1 || $flag == 2){
        $unsetFieldNames = array('survey_questions_display','configurationGUI','line_items','insert_fields','email2','action_lines','condition_lines','reminders','product_image','pdffooter','pdfheader','duration','duration_hours');
    }else{
        $unsetFieldNames = array('$survey_questions_display$','$configurationGUI$','$line_items$','$insert_fields$','$email2$','$action_lines$','$condition_lines$','$reminders$','$product_image$','$pdffooter$','$pdfheader$','$duration','$duration_hours$');
    }

    foreach ($unsetFieldNames as $key => $value) {
        unset($editDetailViewFields[$value]);
    }

    if($flag == 1 || $flag == 2){
        unset($addressFields['email2']);
        if($module == 'jjwg_Maps' || $module == 'Meetings' || $module == 'Notes' || $module == 'Tasks'){
            unset($editDetailViewFields['parent_name']);
        }
        if($module == "AOS_PDF_Templates"){
            unset($editDetailViewFields['description']);
        }
    }else{
        unset($addressFields['$email2$']);
        if($module == 'jjwg_Maps' || $module == 'Meetings' || $module == 'Notes' || $module == 'Tasks'){
            unset($editDetailViewFields['$parent_name$']);
        }
        if($module == "AOS_PDF_Templates"){
            unset($editDetailViewFields['$description$']);
        }
    }

    $mergeEditDetailViewFields = array_merge($editDetailViewFields, $addressFields);
    if($flag != 2){
        $mergeEditDetailViewFields = array_merge($mergeEditDetailViewFields, $dateTimeFields);
    }
    $uniqueEditDetailViewFields = array_unique($editDetailViewFields, SORT_REGULAR);
    asort($uniqueEditDetailViewFields);
       
    if($flag == 1){
        if($module == "AOS_Invoices" || $module == "AOS_Quotes"){
            $editDetailViewFieldsData = array('Fields'=>$uniqueEditDetailViewFields,'Product Fields'=>$productFieldData);
        }else{
            $editDetailViewFieldsData = array('Fields'=>$uniqueEditDetailViewFields);
        }
        return $editDetailViewFieldsData;
    }else{
        return $uniqueEditDetailViewFields;
    }
}//end of function

//Add Product Fields on Condition Block
function addProductFields($source_module, $field){
    if($source_module == "AOS_Invoices" || $source_module == "AOS_Quotes"){
        $field['product_qty'] = array('name' =>'product_qty','vname'=>'Quantity','type'=>'number');
        $field['product'] = array('name' =>'product','vname'=>'Product','type'=>'link','module'=>'AOS_Products','bean_name'=>'AOS_Product','source'=>'non-db');
        $field['part_number']=array('name' =>'part_number','vname'=>'Part Number','type'=>'text');
        $field['product_list_price'] = array('name' =>'product_list_price','vname'=>'List Price','type'=>'currency','len' => '26,6');
        $field['product_discount'] = array('name' =>'product_discount','vname'=>'Product Discount','type'=>'currency','len' => '26,6');
        $field['discount'] = array('name' =>'discount','vname'=>'Discount','type'=>'enum','options' => array('Percentage'=>'Pct','Amount'=>'Amt'),'len' => '200');
        $field['product_unit_price'] = array('name' =>'product_unit_price','vname'=>'Sale Price','type'=>'currency','len' => '26,6');
        $field['vat_amt'] = array('name' =>'vat_amt','vname'=>'Tax Amount','type'=>'currency','len' => '26,6');
        $field['vat'] = array('name' =>'vat','vname'=>'Tax','type'=>'enum','options' => array('0.0'=>'0%','5.0'=>'5%','7.5'=>'7.5%','17.5'=>'17.5%','20.0'=>'20%'),'len' => '200');
    }
    return $field;
}//end of function

//Get Product Fields on Condition Block
function getProductFields($module, $field){
    if($module == "AOS_Invoices" || $module == "AOS_Quotes"){
        $productFields = array();
        array_push($productFields,array('0' => 'product','1'=>'(empty)'));
        array_push($productFields,array('0' => 'part_number','1'=>'(empty)'));
        array_push($productFields,array('0' => 'product_qty','1'=>'(empty)'));
        array_push($productFields,array('0' => 'product_list_price','1'=>'(empty)'));
        array_push($productFields,array('0' => 'product_discount','1'=>'(empty)'));
        array_push($productFields,array('0' => 'discount','1'=>'(empty)'));
        array_push($productFields,array('0' => 'product_unit_price','1'=>'(empty)'));
        array_push($productFields,array('0' => 'vat_amt','1'=>'(empty)'));
        array_push($productFields,array('0' => 'vat','1'=>'(empty)'));


        if(isset($productFields)){
            $productFieldData =array();
            foreach($productFields as $key => $value){
                foreach($value as $k => $v) {
                    if(array_key_exists($v, $field)) {
                        require_once('include/utils.php');
                        $fieldLabel = translate($field[$v]['vname'],$module);
                        $fieldName = $v;
                        if(strpos($fieldLabel, ':')){
                            $fieldLabel = str_replace(":","",$fieldLabel);
                        }
                        $productFieldData[$fieldName] = $fieldLabel;
                    }    
                }
            }
        }
        return $productFieldData;
    }
}//end of function

//Get Notification Besed on Configuration / Immediate Option

function getConfigDataforNotification($reminderNotificationData, $flag, $getReminderNotificationResult){
    //Select Data
    while($getReminderNotificationRows = $GLOBALS['db']->fetchByAssoc($getReminderNotificationResult)){
        $fieldNames = array('*');
        $whereData = array('reminder_notification_id'=>$getReminderNotificationRows['id'],'deleted'=>0);
        $getReminderNotificationCond = getReminderNotificationRecord('vi_reminders_notification_condition', $fieldNames, $innerJoin = array(), $onData = array(), $whereData, $orderBy = array(), $limit = array());
        $getReminderNotificationCondRes = $GLOBALS['db']->query($getReminderNotificationCond);

        $reminderNotificationCondData = array();
        while($getReminderNotificationCondRows = $GLOBALS['db']->fetchByAssoc($getReminderNotificationCondRes)){
            $reminderNotificationCondData[] = array(
                "conditionId" => $getReminderNotificationCondRows['id'],
                "modulePath" =>  $getReminderNotificationCondRows['module_path'],
                "field" =>  $getReminderNotificationCondRows['field'],
                "operator" =>  $getReminderNotificationCondRows['operator'],
                "valueType" =>  $getReminderNotificationCondRows['value_type'],
                "value" => $getReminderNotificationCondRows['value'],
                "conditionType" => $getReminderNotificationCondRows['condition_type']
            );
        }  
        $reminderNotificationData[$getReminderNotificationRows['module']][$getReminderNotificationRows['id']] = array(
            "recordId" => $getReminderNotificationRows['id'],
            "templateId" => $getReminderNotificationRows['template_id'],
            "subject" => $getReminderNotificationRows['subject'],
            "module" => $getReminderNotificationRows['module'],
            "notificationField" => $getReminderNotificationRows['notification_field'],
            "comparisonField" => $getReminderNotificationRows['comparison_field'],
            "conditions" => $reminderNotificationCondData,
            "triggerValue" => $getReminderNotificationRows['trigger_value'],
            "triggerPeriod" => $getReminderNotificationRows['trigger_period'],
            "triggerAction" => $getReminderNotificationRows['trigger_action'],
            "triggerMonthValue" => $getReminderNotificationRows['triggerMonthValue'],
            "triggerNotificationField" => $getReminderNotificationRows['trigger_notification_field'],
            "reminderMessage" => $getReminderNotificationRows['reminder_message'],
            "status" => $getReminderNotificationRows['status'],
            "conditionalOperator" => $getReminderNotificationRows['conditional_operator'],
            "enableUsers" => $getReminderNotificationRows['enable_users'],
            "allUsersId" => $getReminderNotificationRows['allUsersId'],
            "relatedModule" => $getReminderNotificationRows['related_module'],
            "relateFields" => $getReminderNotificationRows['relate_fields'],
            "enableNotification" => $getReminderNotificationRows['enable_notification'],
            "emailNotification" => $getReminderNotificationRows['email_notification'],
            "templates" => $getReminderNotificationRows['templates'],
            "templateMessage" => $getReminderNotificationRows['template_message'],
            "dateEntered" => $getReminderNotificationRows['date_entered']
        );
        if($flag == 0){
            $allRecordsIds[$getReminderNotificationRows['module']] = get_bean_select_array(false,get_singular_bean_name($getReminderNotificationRows['module']), "date_entered", "deleted=0");
        }   
    }//end of while

    if($flag == 0){
        $reminderNotificationData['allRecordsIds'] = $allRecordsIds;
        $reminderNotificationData['reminderNotificationData'] = $reminderNotificationData;
    }

    return $reminderNotificationData;
}//end of function

function matchCondition($moduleName, $allRecordsId, $reminderNotificationData){
    $matchConditionRecord = $matchData = array();

    foreach($allRecordsId  as $k => $v){
        $bean = BeanFactory::getBean($moduleName, $k); //bean
        $matchConditionRecord[$k] = getAllAnyConditions($k, $bean, $reminderNotificationData, $moduleName, $moduleData = array(), $flag = 0);
       
    }//end of foreach

    foreach($matchConditionRecord as $key => $value){
        foreach($value as $k => $v){
            $matchData[$k] = $v;
        }   
    }
    
    return $matchData;
}//end of function

function getAllAnyConditions($moduleRecordId, $bean, $reminderNotificationData, $moduleName, $moduleData, $flag){
    $matchAllCondition = $matchAnyCondition = $matchCondition = $matchConditionRecord = array();
    if(!empty($reminderNotificationData['conditions'])){
        foreach ($reminderNotificationData['conditions'] as $ckey => $cvalue){
            if($cvalue['conditionType'] == 'All'){
                $matchAllCondition[] = $cvalue;
            }else{
                $matchAnyCondition[] = $cvalue;
            }//end of else
        }
        if($flag == 1){
            $immediateNotification = "Immediate Notification";
        }else if($flag == 0){
            $immediateNotification = '';
        }
        if($flag == 1 || $flag == 0){
            $allCondition = getMatchConditionData($bean, "All", $matchAllCondition, $matchCondition, $moduleName, $moduleData, $immediateNotification); //All Condition
            $anyCondition = getMatchConditionData($bean, "Any", $matchAnyCondition, $matchCondition, $moduleName, $moduleData, $immediateNotification); //Any Condition
        }
    }else{
        $matchConditionRecord['conditions'] = '2';
    }
    
    if(isset($anyCondition) && !empty($anyCondition)){
        if($reminderNotificationData['conditionalOperator'] == "AND"){
            if(in_array('1', $allCondition) && in_array('1', $anyCondition)){
                $matchConditionRecord[$moduleRecordId] = '1'; 
            }else{
                $matchConditionRecord[$moduleRecordId] = '0';
            }//end of else
        }else if($reminderNotificationData['conditionalOperator'] == "OR"){
            if(in_array('1', $allCondition) && (in_array('0', $anyCondition) || in_array('1',$anyCondition))){
                $matchConditionRecord[$moduleRecordId] = '1'; 
            }else if(in_array('0', $allCondition) && (in_array('1', $anyCondition))){
                $matchConditionRecord[$moduleRecordId] = '1'; 
            }else{
                $matchConditionRecord[$moduleRecordId] = '0';
            }//end of else
        }//end of else if
    }else if(isset($allCondition) && in_array('1', $allCondition) && empty($anyCondition)){     
        $matchConditionRecord[$moduleRecordId] = '1'; 
    }//end of else if

   return $matchConditionRecord;
}

//get Matched All and Any Condition Data
function getMatchConditionData($bean, $conditionType, $matchConditionData, $matchCondition, $moduleName, $moduleData, $immediateNotification){
    $conditionData = array();
    foreach ($matchConditionData as $key => $value) {
        if($value['field'] != "product" && $value['field'] != "part_number" && $value['field'] != "product_qty" && $value['field'] != "product_list_price" && $value['field'] != "product_discount" && $value['field'] != "vat_amt" && $value['field'] != "discount" && $value['field'] != "vat" && $value['field'] != "product_unit_price" ){
            $conditionFieldName = $value['field'];
            $fieldDef = $bean->field_defs[$conditionFieldName];
            $fieldType = $fieldDef['type'];
            $fieldValue = $bean->$conditionFieldName;
            if(isset($fieldType) && ($fieldType == 'datetimecombo' || $fieldType == 'datetime')){
                $conditionValue = date('Y-m-d',strtotime($conditionValue));
                $fieldValue = date('Y-m-d',strtotime($fieldValue));
            }else if(isset($fieldType) && $fieldType == 'date'){
                $conditionValue = date('Y-m-d',strtotime($conditionValue));
                $fieldValue = date('Y-m-d',strtotime($fieldValue));
            }else if(isset($fieldType) && $fieldType == 'multienum'){
                $fieldValue = encodeMultienumValue($fieldValue);
                $conditionValue = $conditionValue;
            }else if(isset($fieldType) && $fieldType == 'enum'){
                if($value['valueType'] == 'Multi'){
                    $fieldValue = encodeMultienumValue($fieldValue);
                }//end of if
                 //$fieldValue = $bean->$conditionFieldName;
            }else if(isset($fieldType) && $fieldType == 'relate'){
                $relateFieldName = $fieldDef['id_name']; //id name
                $bean = BeanFactory::getBean($moduleName, $bean->id);
                $fieldValue = $bean->$relateFieldName;
            }else if(isset($fieldType) && $fieldType == 'id'){
                $idName = $fieldDef['name']; //id name
                $bean = BeanFactory::getBean($moduleName, $bean->id);
                $fieldValue = $bean->$idName;
            }else{
                $numericValue = str_replace( ',', '', $fieldValue);
                if( is_numeric( $numericValue ) ) {
                    $fieldValue = $numericValue;
                }//end of if
            }//end of else
            $conditionValue = $value['value'];
            $matchCondition = getMatchOperatorConditions($value['operator'], $fieldValue, $matchCondition, $conditionValue);
        }else{
            $conditionValue = $value['value'];
            if($immediateNotification == "Immediate Notification"){
                $conditionFieldName = $value['field'];
                if($conditionFieldName == "product"){
                    $conditionFieldName = 'product_product_id';
                }else{
                    $conditionFieldName = 'product_'.$conditionFieldName;
                }
                $fieldValueData = $moduleData[$conditionFieldName];
            }else if($immediateNotification == ""){
                $fieldNames = array('*');
                $whereData = array('parent_id'=>$bean->id,'deleted'=>0);
                $getProductData = getReminderNotificationRecord('aos_products_quotes', $fieldNames, $innerJoin = array(), $onData = array(), $whereData, $orderby = array(), $limit = array());
                $getProductDataResult = $GLOBALS['db']->query($getProductData);
                $fieldValueData = array();
                while($getProductDataRow = $GLOBALS['db']->fetchByAssoc($getProductDataResult)){
                    if($value['field'] == "product"){
                        $value['field'] = 'product_id';
                    }
                    $fieldValueData[] = $getProductDataRow[$value['field']];
                }
            } 
            if(!empty($fieldValueData)){
                $matchProductCondition = array();
                foreach($fieldValueData as $key => $fieldValue){
                    $matchProductCondition = getMatchOperatorConditions($value['operator'], $fieldValue, $matchProductCondition, $conditionValue);
                }//end of foreach
                    
                if(!empty($matchProductCondition)){
                    if(in_array('1',$matchProductCondition)){
                        $matchCondition[] = '1'; 
                    }else{
                        $matchCondition[] = '0';
                    }
                }
            }
        }
    } 

  
    if(!empty($matchCondition)){
        if($conditionType == "All"){
            if(in_array('0',$matchCondition)){
                $conditionData[$bean->id] = '0'; 
            }else{
                $conditionData[$bean->id] = '1';
            }//end of else
        }else{
            if(in_array('1',$matchCondition)){
                $conditionData[$bean->id] = '1'; 
            }else{
                $conditionData[$bean->id] = '0';
            }//end of else
        }//end of else
    }//end of if
  
    return $conditionData;
}//end of function

function getMatchOperatorConditions($operator, $fieldValue, $matchCondition, $conditionValue){
    switch ($operator) {
        case 'Equal_To':
            if($fieldValue == $conditionValue){
                $matchCondition[$fieldValue] = '1';
            }else{
                $matchCondition[$fieldValue] = '0';
            }//end of else
            break;
        case 'Not_Equal_To':
            if($fieldValue != $conditionValue){
                $matchCondition[$fieldValue] = '1';
            }else{
                $matchCondition[$fieldValue] = '0';
            }//end of else
            break;
        case 'Contains':
            if(strpos($fieldValue, $conditionValue) !== false){
                $matchCondition[$fieldValue] = '1';
            }else{
                $matchCondition[$fieldValue] = '0';
            }//end of else
            break;
        case 'Starts_With':
            if(startsWiths($fieldValue,$conditionValue)){
                $matchCondition[$fieldValue] = '1';
            }else{
                $matchCondition[$fieldValue] = '0';
            }//end of else
            break;
        case 'Ends_With':
            if(endsWiths($fieldValue,$conditionValue)){
                $matchCondition[$fieldValue] = '1';
            }else{
                $matchCondition[$fieldValue] = '0';
            }//end of else
            break;
        case 'Greater_Than':
            if($fieldValue > $conditionValue){
                $matchCondition[$fieldValue] = '1';
            }else{
                $matchCondition[$fieldValue] = '0';
            }//end of else
            break;
        case 'Less_Than':
            if($fieldValue < $conditionValue){
                $matchCondition[$fieldValue] = '1'; 
            }else{
                $matchCondition[$fieldValue] = '0';
            }//end of else
            break;
        case 'Greater_Than_or_Equal_To':
            if($fieldValue >= $conditionValue){
                $matchCondition[$fieldValue] = '1';
            }else{
                $matchCondition[$fieldValue] = '0';
            }//end of else
            break;
        case 'Less_Than_or_Equal_To':
            if($fieldValue <= $conditionValue){
                $matchCondition[$fieldValue] = '1';
            }else{
                $matchCondition[$fieldValue] = '0';
            }//end of else
            break;
        case 'is_null':
            if(empty($fieldValue)){
                $matchCondition[$fieldValue] = '1';    
            }else{
                $matchCondition[$fieldValue] = '0';
            }//end of else
            break;
        default:
            echo "";
            break;
    }//end of switch
    return $matchCondition;
}//end of function

function getCheckConditionData($matchRecordsIds, $recordData, $reminderNotificationData, $currentTime, $current_user, $flag = 0, $records, $timedate){
    //check conditions
    $checkConditionValue = $beanField = array();
    foreach($matchRecordsIds as $moduleName => $IdsData){
        foreach($IdsData as $configId => $moduleData){
            foreach($moduleData as $k => $recordId){
                $Days = $Week =  $Month = $birthDate = $birthMonth = "";

                $recordData = $reminderNotificationData[$moduleName][$configId];
                $recordBean = BeanFactory::getBean($recordData['module'], $recordId);//bean
            
                if($recordData['notificationField'] != ""){
                    if(isset($recordBean->fetched_row[$recordData['notificationField']])){
                        $beanField[$recordId] = $recordBean->fetched_row[$recordData['notificationField']];//record id
                    }else if(isset($recordBean->$recordData['notificationField'])){
                        $beanField[$recordId] = $recordBean->$recordData['notificationField'];//record id
                    }
                    $fieldDef = $recordBean->field_defs[$recordData['notificationField']];
                }else{
                    $beanField[$recordId] = '';
                }

                if($recordData['triggerAction'] == "Immediate Notification"){
                    if($recordData['triggerNotificationField'] == "" && $records == ""){
                        $fieldDef = $recordBean->field_defs[$recordData['notificationField']];
                        if($moduleName == 'AOS_Contracts'){
                            $moduleDir = $recordBean->module_dir;
                            if($moduleDir == "AOD_IndexEvent"){
                                $recordModule = $recordBean->record_module;
                                if($recordModule != $moduleName){
                                    $notificationFieldDate = '';
                                }else{
                                    $notificationFieldDate = $recordBean->$recordData['notificationField'];
                                }//end of else
                            }else{
                                if(isset($recordBean->fetched_row[$recordData['notificationField']])){
                                    $notificationFieldDate = $recordBean->fetched_row[$recordData['notificationField']];//record id
                                }else if(isset($recordBean->$recordData['notificationField'])){
                                    $notificationFieldDate = $recordBean->$recordData['notificationField'];//record id
                                }
                            } 
                        }else{
                            if(isset($recordBean->$recordData['notificationField'])){
                                $notificationFieldDate = $recordBean->$recordData['notificationField'];
                            }else if(isset($recordBean->fetched_row[$recordData['notificationField']])){
                                $notificationFieldDate = $recordBean->fetched_row[$recordData['notificationField']];
                            }
                        }
                        $notificationFieldDate = date('Y-m-d H:i', strtotime($timedate->to_display_date_time($notificationFieldDate, true, true, $current_user)));
                    }
                }else if($recordData['triggerAction'] == "Now"){
                    $notificationFieldDate = $beanField[$recordId];
                    if(isset($recordBean->fetched_row[$recordData['notificationField']])){
                        $beanField[$recordId] = $recordBean->fetched_row[$recordData['notificationField']];//record id
                    }else if(isset($recordBean->$recordData['notificationField'])){
                        $beanField[$recordId] = $recordBean->$recordData['notificationField'];//record id
                    }
                }
                
                switch ($recordData['triggerPeriod']){
                    case "Hours":
                        $Hours = getTriggerNotification($recordData['triggerValue'], $recordData['triggerAction'], $beanField, $fieldDef['type'], 'Hours');
                        break;
                    case "Days":
                        $Days = getTriggerNotification($recordData['triggerValue'], $recordData['triggerAction'], $beanField, $fieldDef['type'], 'Days');
                        break;
                    case "Week":  
                        $Week = getTriggerNotification($recordData['triggerValue'], $recordData['triggerAction'], $beanField, $fieldDef['type'], 'Week');
                        break;
                    case "Month": 
                        $Month = getTriggerNotification($recordData['triggerValue'], $recordData['triggerAction'], $beanField, $fieldDef['type'], 'Month');
                        break;
                    default:
                        echo "";
                }

                if(isset($Hours) && $Hours != ""){
                    if($recordData['comparisonField'] == "Compare Entire Date"){
                        $currentDate = date('Y-m-d', strtotime($currentTime));
                        $hourDate = date('Y-m-d', strtotime($Hours));
                      
                        if($currentDate == $hourDate && (strtotime($currentTime) >= strtotime($Hours))){
                            $checkConditionValue[$moduleName][$configId][$recordId][] = '1';
                        }else{
                            $checkConditionValue[$moduleName][$configId][$recordId][] = '0';
                        }
                    }
                }

                if(isset($Days) && $Days != ""){
                    $triggerDate = $Days;
                }

                if(isset($Month) && $Month != ""){
                    $triggerDate = $Month;
                }

                if(($recordData['triggerAction'] != ""  && $recordData['triggerAction'] == "Immediate Notification") && ($recordData['triggerNotificationField'] == "" && $records == "")){
                    if($fieldDef['type'] == "datetime" || $fieldDef['type'] == "datetimecombo"){
                        $triggerDate = date('Y-m-d H:i', strtotime($notificationFieldDate));
                    }else{
                        $triggerDate = date('Y-m-d', strtotime($notificationFieldDate));
                    }
                }

                if($recordData['triggerAction'] != "" && $recordData['triggerAction'] == "Now"){
                    if($fieldDef['type'] == "datetime" || $fieldDef['type'] == "datetimecombo"){
                        $triggerDate = date('Y-m-d H:i', strtotime($notificationFieldDate));
                    }else{
                        $triggerDate = date('Y-m-d', strtotime($notificationFieldDate));
                    }
                }
               
                if($recordData['triggerNotificationField'] == ""){
                    if($recordData['comparisonField'] == "Compare Entire Date"){
                        if($fieldDef['type'] == "datetime" || $fieldDef['type'] == "datetimecombo"){
                            $currentDate = $currentTime;
                            $date = date('Y-m-d', strtotime($triggerDate));
                            $curDate = date('Y-m-d', strtotime($currentTime));
                            if(isset($triggerDate) && ($curDate == $date && strtotime($currentDate) >= strtotime($triggerDate))){
                                $checkConditionValue[$moduleName][$configId][$recordId][] = '1';
                            }else{
                                $checkConditionValue[$moduleName][$configId][$recordId][] = '0';
                            }
                        }else{
                            $currentDate = date('Y-m-d', strtotime($currentTime));
                            if(isset($triggerDate) && $currentDate == $triggerDate){
                                $checkConditionValue[$moduleName][$configId][$recordId][] = '1';
                            }else{
                                $checkConditionValue[$moduleName][$configId][$recordId][] = '0';
                            }
                        }
                    }else if(isset($triggerDate) && $recordData['comparisonField'] == "Compare Month and Day"){
                        $currentDate = date('d', strtotime($currentTime));
                        $date = date('d', strtotime($triggerDate));
                        $currentMonth = date('m', strtotime($currentTime));
                        $month = date('m', strtotime($triggerDate));
                        if($currentDate == $date && $currentMonth == $month){
                            $checkConditionValue[$moduleName][$configId][$recordId][] = '1';
                        }else{
                            $checkConditionValue[$moduleName][$configId][$recordId][] = '0';
                        }
                    }else if(isset($triggerDate) && $recordData['comparisonField'] == "Compare Month and Year"){
                        $currentYear = date('Y', strtotime($currentTime));
                        $year = date('Y', strtotime($triggerDate));
                        $currentMonth = date('m', strtotime($currentTime));
                        $month = date('m', strtotime($triggerDate));
                        if($currentYear == $year && $currentMonth == $month){
                            $checkConditionValue[$moduleName][$configId][$recordId][] = '1';
                        }else{
                            $checkConditionValue[$moduleName][$configId][$recordId][] = '0';
                        }
                    }else if(isset($triggerDate) && $recordData['comparisonField'] == "Compare Day and Year"){
                        $currentDate = date('d', strtotime($currentTime));
                        $date = date('d', strtotime($triggerDate));
                        $currentYear = date('Y', strtotime($currentTime));
                        $year = date('Y', strtotime($triggerDate));
                        if($currentDate == $date && $currentYear == $year){
                            $checkConditionValue[$moduleName][$configId][$recordId][] = '1';
                        }else{
                            $checkConditionValue[$moduleName][$configId][$recordId][] = '0';
                        }
                    }else if(isset($triggerDate) && $recordData['comparisonField'] == "Compare Month"){
                        $currentMonth = date('m', strtotime($currentTime));
                        $month = date('m', strtotime($triggerDate));
                        if($currentMonth == $month){
                            $checkConditionValue[$moduleName][$configId][$recordId][] = '1';
                        }else{
                            $checkConditionValue[$moduleName][$configId][$recordId][] = '0';
                        }
                    }else if(isset($triggerDate) && $recordData['comparisonField'] == "Compare Day"){
                        $currentDay = date('d', strtotime($currentTime));
                        $day = date('d', strtotime($triggerDate));
                        if($currentDay == $day){
                            $checkConditionValue[$moduleName][$configId][$recordId][] = '1';
                        }else{
                            $checkConditionValue[$moduleName][$configId][$recordId][] = '0';
                        }
                    }else if(isset($triggerDate) && $recordData['comparisonField'] == "Compare Year"){
                        $currentYear = date('Y', strtotime($currentTime));
                        $year = date('Y', strtotime($triggerDate));
                        if($currentYear == $year){
                            $checkConditionValue[$moduleName][$configId][$recordId][] = '1';
                        }else{
                            $checkConditionValue[$moduleName][$configId][$recordId][] = '0';
                        }
                    }
                }else if($recordData['triggerNotificationField'] != ""){
                    $notificationFieldValue = $recordBean->$recordData['triggerNotificationField'];
                    if($notificationFieldValue != ""){
                        $checkConditionValue[$moduleName][$configId][$recordId][] = '1';
                    }else{
                        $checkConditionValue[$moduleName][$configId][$recordId][] = '0';
                    }
                }
            }
        }   
    }//end of foreach

    foreach($checkConditionValue as $moduleName => $moduleRecords){
        foreach($moduleRecords as $moduleRecordsKey => $moduleRecordsValue){
            foreach($moduleRecordsValue as $moduleRecordId => $moduleRecordStatus){
                foreach($moduleRecordStatus as $key => $value){
                    if($value == "1"){ 
                        foreach($beanField as $beanFieldId => $beanFieldValue){
                            if($moduleRecordId == $beanFieldId){
                                $recordData = $reminderNotificationData[$moduleName][$moduleRecordsKey];
                                $reminderMessage = reminderMessage($recordData['reminderMessage'], $moduleName, $moduleRecordId);
                                $templateMessage = templateMessage($recordData['templateMessage'], $moduleName, $moduleRecordId, $recordData['templates'], $recordData['templateId']);
                                addReminderAndAlertData($recordData, $current_user, $reminderMessage, $moduleRecordId, $templateMessage, $beanFieldValue, $currentTime);
                            }  
                        }
                    }
                }
            }
        }
    }//end of foreach
}//end of function

//Get Trigger Notification 
function getTriggerNotification($triggerValue, $triggerAction, $beanFieldValue, $fieldType, $triggerPeriod){
    foreach($beanFieldValue as $id => $date){
        if (strpos($date, '.') !== false) {
            $date = str_replace('.', ':', $date);   
        }
        if(strpos($date,'pm') !== false) {
            $date = str_replace('pm', ' ', $date);
        }
        if(strpos($date, 'am') !== false) {
            $date = str_replace('am', ' ', $date);
        }

        if($triggerPeriod == "Hours"){
            if($triggerAction == "Before"){
                $date = date('Y-m-d H:i', strtotime($date."-".$triggerValue.$triggerPeriod));
            }else if($triggerAction == "After"){
                $date = date("Y-m-d H:i", strtotime($date."+".$triggerValue.$triggerPeriod));
            }
        }else{
            if($triggerAction == "Before"){
                if($fieldType == "datetime" || $fieldType == "datetimecombo"){
                    $date = date("Y-m-d H:i", strtotime($date."-".$triggerValue.$triggerPeriod));
                }else{
                    $date = date("Y-m-d", strtotime($date."-".$triggerValue.$triggerPeriod));
                }
            }else{
                if($fieldType == "datetime" || $fieldType == "datetimecombo"){
                    $date = date("Y-m-d H:i", strtotime($date."+".$triggerValue.$triggerPeriod));
                }else{
                    $date = date("Y-m-d", strtotime($date."+".$triggerValue.$triggerPeriod));
                }
            }
        }
    }
    return $date;
}//end of function

//Save Reminder Alert Data 
function addReminderAndAlertData($recordData, $current_user, $reminderMessage, $recordId, $templateMessage, $notificationFieldValue, $currentTime){
    global $sugar_config;

    $currentDate = date("Y-m-d");
    $recordBean = BeanFactory::getBean($recordData['module'], $recordId);//bean
    $notificationField = $recordData['notificationField'];
    if($recordData['triggerAction'] == "Immediate Notification"){
        if($recordData['triggerNotificationField'] == ""){
            $notificationFieldValue = $recordBean->$recordData['notificationField'];
        }else{
            $fieldDef = $recordBean->field_defs[$recordData['triggerNotificationField']];
            if($fieldDef['type'] == "date"){
                $notificationFieldValue = date('Y-m-d', strtotime($recordBean->$recordData['triggerNotificationField']));
            }else if($fieldDef['type'] == "datetime" || $fieldDef['type'] == "datetimecombo"){
                $notificationFieldValue = date('Y-m-d H:i', strtotime($recordBean->$recordData['triggerNotificationField']));
            }else{
                $notificationFieldValue = $recordBean->$recordData['triggerNotificationField'];
            }
            $notificationField = $recordData['triggerNotificationField'];
        }
    }else if($recordData['triggerAction'] == "Now"){
        $fieldDef = $recordBean->field_defs[$recordData['notificationField']];
        if($fieldDef['type'] == "date"){
            $notificationFieldValue = date('Y-m-d', strtotime($notificationFieldValue));
        }else if($fieldDef['type'] == "datetime" || $fieldDef['type'] == "datetimecombo"){
            $notificationFieldValue = date('Y-m-d H:i', strtotime($notificationFieldValue));
        }
    }else{
        $fieldDef = $recordBean->field_defs[$recordData['notificationField']];
        if($recordData['triggerPeriod'] == "Hours"){
            $notificationFieldValue = date("Y-m-d H:i", strtotime($notificationFieldValue));
        }else{
            if($fieldDef['type'] == "date"){
                $notificationFieldValue = date('Y-m-d', strtotime($notificationFieldValue));
            }else if($fieldDef['type'] == "datetime" || $fieldDef['type'] == "datetimecombo"){
                $notificationFieldValue = date('Y-m-d H:i', strtotime($notificationFieldValue));
            }
        }
    }

    $beanEmail = '';
    if(isset($recordBean->email1)){
        $beanEmail = $recordBean->email1;
    }
    $subject = $recordData['subject'];
    $reminderMessage = trim($reminderMessage);
    $url = "index.php?module=".$recordData['module']."&action=ajaxui";

    $id = create_guid();
    $alertId = create_guid();

    $dateCreated = date("Y-m-d H:i:s");
    $dateModified = date("Y-m-d H:i:s");

    $moduleName = get_singular_bean_name(translate($recordData['module']));
    if(substr($moduleName, -1) == 's'){
        $moduleName = substr_replace($moduleName, "", -1);
    }

    $databaseType = $sugar_config['dbconfig']['db_type'];

    $fieldNames = array('*');
   
    $innerJoin = array('vi_reminder_alert');
    $onData = array('alerts.id'=>'vi_reminder_alert.alert_id');

    if($databaseType == 'mssql'){
        if($recordData['triggerPeriod'] == "Hours"){
            $whereData = array('target_module' => $moduleName, 'CONVERT(DATE,date_entered)' => $currentDate, 'vi_reminder_alert.module_record_id' => $recordId, 'vi_reminder_alert.notification_field' => $notificationField, 'vi_reminder_alert.notificationField_value' => $notificationFieldValue);
        }else if($recordData['triggerAction'] == "Immediate Notification"){
            if($recordData['triggerNotificationField'] == ""){
                $whereData = array('target_module' => $moduleName, 'CONVERT(DATE,date_entered)' => $currentDate, 'vi_reminder_alert.module_record_id' => $recordId, 'vi_reminder_alert.notification_field' => $notificationField, 'CONVERT(DATE,vi_reminder_alert.notificationField_value)' => $notificationFieldValue);
            }else{
                $whereData = array('target_module' => $moduleName, 'CONVERT(DATE,date_entered)' => $currentDate, 'vi_reminder_alert.module_record_id' => $recordId, 'vi_reminder_alert.notification_field' => $notificationField, 'vi_reminder_alert.notificationField_value' => $notificationFieldValue);
            }
        }else{
            $whereData = array('target_module' => $moduleName, 'CONVERT(DATE,date_entered)' => $currentDate, 'vi_reminder_alert.module_record_id' => $recordId, 'vi_reminder_alert.notification_field' => $notificationField, 'CONVERT(DATE,vi_reminder_alert.notificationField_value)' => $notificationFieldValue);
        }  
    }else{
        if($recordData['triggerPeriod'] == "Hours"){
            $whereData = array('target_module' => $moduleName, 'DATE(date_entered)' => $currentDate, 'vi_reminder_alert.module_record_id' => $recordId, 'vi_reminder_alert.notification_field' => $notificationField, 'vi_reminder_alert.notificationField_value' => $notificationFieldValue);
        }else if($recordData['triggerAction'] == "Immediate Notification"){
            if($recordData['triggerNotificationField'] == ""){
                $whereData = array('target_module' => $moduleName, 'DATE(date_entered)' => $currentDate, 'vi_reminder_alert.module_record_id' => $recordId, 'vi_reminder_alert.notification_field' => $notificationField, 'DATE(vi_reminder_alert.notificationField_value)' => $notificationFieldValue);
            }else{
                $whereData = array('target_module' => $moduleName, 'DATE(date_entered)' => $currentDate, 'vi_reminder_alert.module_record_id' => $recordId, 'vi_reminder_alert.notification_field' => $notificationField, 'vi_reminder_alert.notificationField_value' => $notificationFieldValue);
            }
        }else{
            $whereData = array('target_module' => $moduleName, 'DATE(date_entered)' => $currentDate, 'vi_reminder_alert.module_record_id' => $recordId, 'vi_reminder_alert.notification_field' => $notificationField, 'vi_reminder_alert.notificationField_value' => $notificationFieldValue);
        }       
    }

    $getAlertData = getReminderNotificationRecord('alerts', $fieldNames, $innerJoin, $onData, $whereData, $orderby = array(), $limit=array());
    $getAlertResultData = $GLOBALS['db']->fetchRow($GLOBALS['db']->query($getAlertData));

    if(empty($getAlertResultData)){
        //Add Record on Alert Table
        $type = "info";
        $alertTableFieldData = array('id'=>"'".$alertId."'", 'name'=>"'".$subject."'", 'date_entered'=>"'".$dateCreated."'", 'date_modified'=>"'".$dateModified."'", 'modified_user_id'=>"'".$current_user->id."'", 'created_by'=>'1', 'description'=>"'".$reminderMessage."'", 'assigned_user_id'=>"'".$current_user->id."'", 'is_read'=>'0', 'target_module'=>"'".$moduleName."'", 'type'=>"'".$type."'", 'url_redirect'=>"'".$url."'");  
        $insAlertResult = insertReminderNotificationRecord('alerts', $alertTableFieldData);
     
        //Add Record on Reminder Alert Table
        $reminderAlertTableFieldData = array('id'=>"'".$id."'", 'alert_id'=>"'".$alertId."'", 'module_record_id'=>"'".$recordId."'", 'notification_field'=>"'".$notificationField."'", 'notificationField_value'=>"'".$notificationFieldValue."'");
        $reminderAlertResult = insertReminderNotificationRecord('vi_reminder_alert', $reminderAlertTableFieldData);
        
        sendMail($recordData, $beanEmail , $templateMessage, $recordId);
    }
}//end of function

//Convert Template Email Message 
function templateMessage($templateMessage, $moduleName, $id, $templates, $templateId){
    global $sugar_config;

    $bean = BeanFactory::getBean($moduleName, $id); 
    $templateMessage = preg_replace('#<div class="btn_cntr_1"(.*?)</div>#',' ',html_entity_decode($templateMessage));

    $templateMessage = preg_replace('/<img([^>]*)src=["\']([^"\'\\/][^"\']*)["\']/', '<img\1src="'.$sugar_config['site_url'].'/'.'\2"', $templateMessage);

    $templateMessage = preg_replace_callback('/\{DATE\s+(.*?)\}/',function($matches){
        return date($matches[1]);
    }, $templateMessage);

    $reminderTemplateMessage = getPregMatchReminderNotificationData($templateMessage, $bean);
   
    return $reminderTemplateMessage;
}//end of function
    
//Convert Message  
function reminderMessage($reminderMessage, $moduleName, $id){
    $bean = BeanFactory::getBean($moduleName, $id);
    $reminderMessage = preg_replace_callback('/\{DATE\s+(.*?)\}/',function($matches){
                                return date($matches[1]);
                            }, $reminderMessage);
    $reminderNotificationMessage = getPregMatchReminderNotificationData($reminderMessage, $bean);
    
    return $reminderNotificationMessage;
}//end of function
     
//Send Email 
function sendMail($recordData, $beanEmail, $templateMessage, $recordId){
    $bean = BeanFactory::getBean($recordData['module'], $recordId);
    $field = $bean->getFieldDefinition($recordData['relatedModule']);
    if($field['module'] == ""){
        $relatedModule = $recordData['relatedModule'];
    }else{
        $relatedModule = $field['module'];
    }
    $relateId = $field['id_name'];

    $id = "";
    if(isset($bean->parent_id) && $bean->parent_id != ""){
        $id = $bean->parent_id;
    }else if(isset($bean->$relateId) && $bean->$relateId != ""){
        $id = $bean->$relateId;
    }
    
    $relateFieldUserMails = $toAddresses = $userMail = array();

    $relateFieldNames = explode(",", $recordData['relateFields']);
    $relateFieldsBean = BeanFactory::getBean($relatedModule, $id);
   
    foreach($relateFieldNames as $relateFieldKey => $relateFieldValue) {
        if(isset($relateFieldsBean->$relateFieldValue)){
            $relateFieldUserMails[] = $relateFieldsBean->$relateFieldValue;
        }
    }    
   
    if(!empty($beanEmail)){  
        $toAddresses[]=array(  
            'email'=>$beanEmail,  
        );  
    }

    $allUsersId = explode(",", $recordData['allUsersId']);
    foreach ($allUsersId as $allUserIdKey => $allUserIdValue) {
        $userBean = BeanFactory::getBean('Users', $allUserIdValue);
        if($userBean->email1  != ""){
            $userMail[] = $userBean->email1; 
        }
    }

    $specificEmail = $recordData['emailNotification'];
        
    require_once('modules/Emails/Email.php');
    require_once('include/SugarPHPMailer.php');
    require_once('modules/EmailTemplates/EmailTemplate.php');
    $emailObj = new Email();
    $defaults = $emailObj->getSystemDefaultEmail();
    $mail = new SugarPHPMailer();
    $mail->setMailerForSystem();
    $mail->From = $defaults['email'];
    $mail->FromName = $defaults['name'];
    $mail->Subject = $recordData['subject']; 
    $mail->Body = $templateMessage;
    $mail->IsHTML(true);
    $mail->AddAttachment("");  
    $mail->prepForOutbound();
        
    if(isset($toAddresses)  && !empty($toAddresses)){
        foreach($toAddresses as $key => $val){
            foreach($val as $k => $v){
                $mail->AddAddress($v);
            }
        }
        if($specificEmail != ''){
            $mail->AddCC($specificEmail);
        } 
        foreach($relateFieldUserMails as $key => $val){
            $mail->AddCC($val);
        }
        foreach($userMail as $key => $value) {
            $mail->AddCC($value);
        }
    }else if(isset($userMail) && !empty($userMail)){
        foreach($userMail as $key => $value) {
            $mail->AddAddress($value);
        }
        if($specificEmail != ''){
            $mail->AddCC($specificEmail);
        } 
        foreach($relateFieldUserMails as $key => $val){
            $mail->AddCC($val);
        }
    }else if(isset($relateFieldUserMails) && !empty($relateFieldUserMails)){
        foreach($relateFieldUserMails as $key => $email){
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $mail->AddAddress($email);
            }
        }
        if($specificEmail != ''){
            $mail->AddCC($specificEmail);
        } 
    }else if(isset($specificEmail) && $specificEmail != ""){
        $mail->AddAddress($specificEmail);
    }
    $mail->send();  
}//end of function

//Get Prag Match Reminder Data 
function getPregMatchReminderNotificationData($reminderMessage, $bean){
    preg_match_all('/(\$\w+\$)/', $reminderMessage, $matches);
    foreach($matches as $key => $matchData){  
        foreach($matchData as $matchKey => $matchValue){
            $trimValue = ltrim($matchValue, "$");
            $trimValue = rtrim($trimValue, "$");
            if($trimValue == "currency_id"){
                $trimValue = "currency_name";
            } 
            $field = $bean->getFieldDefinition($trimValue);
            if(!empty($bean)){
                if(isset($bean->$trimValue)){
                    if($trimValue == "duration"){
                        $hours = $bean->duration_hours;
                        $minutes = $bean->duration_minutes;
                        $fieldValue = $hours."h".' '.$minutes."m";
                    }else{
                        $fieldValue = $bean->$trimValue;
                    }
                    $field = $bean->getFieldDefinition($trimValue);
                    if($field['type'] == "enum"){
                        global $app_list_strings;
                        $options = $app_list_strings[$field['options']];
                        if(array_key_exists($fieldValue, $options)){
                            $fieldValue = $options[$fieldValue];
                        }
                    }
                }else{
                    $fieldValue = "";
                }
            }
            
            if($fieldValue != ""){
                $reminderMessage = str_replace($matchValue, $fieldValue, $reminderMessage);  
            }else{
                $reminderMessage = str_replace($matchValue, $matchValue, $reminderMessage);  
            }
        }//end of for loop
    }//end of for loop

    return $reminderMessage;
}//end of function

function startsWiths($str, $substr){
    $sl = strlen($str);
    $ssl = strlen($substr);
    if ($sl >= $ssl) {
        if(strpos($str,$substr,0) === 0){
            return true;
        }
    }
}//end of function

function endsWiths($str, $subStr){
    $length = strlen($subStr);
    if ($length == 0) {
        return true;
    }
    return (substr($str, -$length) === $subStr);
}//end of function

//Get Help Box 
function getReminderNotificationHelpBoxHtml($url){
    global $theme,$current_language;
        
    $helpBoxContent = '';
    $curl = curl_init();

    $postData = json_encode(array("themeName" => $theme, 'currentLanguage' => $current_language));
        
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
    $data = curl_exec($curl);
    $httpCode = curl_getinfo($curl,CURLINFO_HTTP_CODE);
    if($httpCode == 200){
        $helpBoxContent = $data;
    }//end of if
    curl_close($curl);

    return $helpBoxContent;
}//end of function  

//Post Execute Functions
function updateReminderNotificationConfigData(){
    $fieldNames = array('id','status','templates');
    $getReminderNotificationData = getReminderNotificationRecord('vi_reminders_notifications', $fieldNames, $innerJoin = array(), $onData = array(), $whereData = array(), $orderby = array(), $limit=array());
    $getReminderNotificationDataResult = $GLOBALS['db']->query($getReminderNotificationData);
    while($getReminderNotificationDataRows = $GLOBALS['db']->fetchByAssoc($getReminderNotificationDataResult)){
        if($getReminderNotificationDataRows['status'] == "Inactive"){
            $status = 0;
        }else if($getReminderNotificationDataRows['status'] == "Active"){
            $status = 1;
        }

        if($getReminderNotificationDataRows['templates'] == "Customize Defualt Template"){
            $templates = 0;
        }else if($getReminderNotificationDataRows['templates'] == "Create New Template"){
            $templates = 1;
        }

        $reminderNotificationId = $getReminderNotificationDataRows['id'];
        $updateData = array('status'=>$status, 'templates'=>"'".$templates."'");
        $whereCondition = array('id'=>$reminderNotificationId);
        $updateFieldsDataResult = updateReminderNotificationRecord('vi_reminders_notifications', $updateData, $whereCondition);
    }//end of while
}

function updateReminderNotificationConditionData(){
    $fieldNames = array('id','reminder_notification_id');
    $getReminderNotificationData = getReminderNotificationRecord('vi_reminders_notification_condition', $fieldNames, $innerJoin = array(), $onData = array(), $whereData = array(), $orderby = array(), $limit=array());
    $getReminderNotificationDataResult = $GLOBALS['db']->query($getReminderNotificationData);
    while($getReminderNotificationDataRows = $GLOBALS['db']->fetchByAssoc($getReminderNotificationDataResult)){
        $reminderNotificationId = $getReminderNotificationDataRows['reminder_notification_id'];
        $fieldNames = array('date_modified');
        $whereCondition = array('id'=>$reminderNotificationId);
        $getReminderNotificationQuery = getReminderNotificationRecord('vi_reminders_notifications', $fieldNames, $innerJoin = array(), $onData = array(), $whereCondition, $orderby = array(), $limit=array());
        $getReminderNotificationRow = $GLOBALS['db']->fetchOne($getReminderNotificationQuery);
        $dateModified = $getReminderNotificationRow['date_modified'];

        $conditionId = $getReminderNotificationDataRows['id'];
        $updateData = array('condition_type'=>"'All'", 'date_entered'=>"'".$dateModified."'");
        $whereCondition = array('id'=>$conditionId);
        $updateFieldsDataResult = updateReminderNotificationRecord('vi_reminders_notification_condition', $updateData, $whereCondition);
    }
}
?>
