/*********************************************************************************
 * This file is part of package Custom Filter.
 * 
 * Author : Variance InfoTech PVT LTD (http://www.varianceinfotech.com)
 * All rights (c) 2020 by Variance InfoTech PVT LTD
 *
 * This Version of Custom Filter is licensed software and may only be used in 
 * alignment with the License Agreement received with this Software.
 * This Software is copyrighted and may not be further distributed without
 * written consent of Variance InfoTech PVT LTD
 * 
 * You can contact via email at info@varianceinfotech.com
 * 
 ********************************************************************************/
var allCondln = allCondlnCount = anyCondln = anyCondlnCount = fieldln = fieldCount = 0;
var flowFields =  new Array();
var flowModule = '';

var decodeUrl = decodeURIComponent(window.location.href);
function getParam( name ){
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    var regexS = "[\\?&]"+name+"=([^&#]*)";
    var regex = new RegExp( regexS );
    var results = regex.exec(decodeUrl);
    if( results == null )
    return "";
    else
    return results[1];
}//end of function
var recordId = getParam('records');

//module name
$('#module').on('change', function(){
    flowModule = $(this).val();
    showModuleFields();
});//end of function

//coniditions function 
function loadConditionLine(condition, conditionType){
    var ln = 0;
    ln = insertConditionLine(conditionType);
    
    if(conditionType == 'All'){
        conditionFieldId = 'aowAllConditionsField';
        conditionFieldLabel = 'aowAllConditionsFieldLabel';
        conditionModulePath = 'aowAllConditionsModulePath';
        conditionModulePathLabel = 'aowAllConditionsModulePathLabel';
    }else{
        conditionFieldId = 'aowAnyConditionsField';
        conditionFieldLabel = 'aowAnyConditionsFieldLabel';
        conditionModulePath = 'aowAnyConditionsModulePath';
        conditionModulePathLabel = 'aowAnyConditionsModulePathLabel';
    }
    var select_field = document.getElementById(conditionFieldId+ln);
    document.getElementById(conditionFieldLabel+ln).innerHTML = select_field.options[select_field.selectedIndex].text;

    document.getElementById(conditionModulePath+ln).disabled = true;
    var select_field2 = document.getElementById(conditionModulePath+ln);
    document.getElementById(conditionModulePathLabel+ln).innerHTML = select_field2.options[select_field2.selectedIndex].text;

    if (condition['value'] instanceof Array) {
        condition['value'] = JSON.stringify(conditionflowFields['value'])
    }//end of if

    document.getElementById(conditionFieldId+ln).value = condition['field'];
    showModuleField(conditionType, ln, condition['operator'], condition['value_type'], condition['value']);
}//end of function

function showModuleFields(){
    clearConditionLines();
    flowModule = $('#module').val();
    var flag = 1;
    if(flowModule != ''){
         var callback = {
            success: function(result) {
                flowRelModules = result.responseText;
            }
        }
        var callback2 = {
            success: function(result) {
                flowFields = result.responseText;
                document.getElementById('btnAllConditionLine').disabled = '';
                document.getElementById('btnAnyConditionLine').disabled = '';
            }//end of success
        }//end of function
        YAHOO.util.Connect.asyncRequest ("GET", "index.php?entryPoint=VIRemindersAndNotificationModuleRelationships&aow_module="+flowModule,callback);
        YAHOO.util.Connect.asyncRequest ("GET", "index.php?entryPoint=VIRemindersAndNotificationFetchPrimaryModuleFields&view=EditView&aow_module="+flowModule+"&flag="+flag,callback2);
    }//end of if
}//end of function

function showModuleField(conditionType, ln, operatorValue, typeValue, fieldValue){
    if (typeof operatorValue === 'undefined') { operatorValue = ''; }
    if (typeof typeValue === 'undefined') { typeValue = ''; }
    if (typeof fieldValue === 'undefined') { fieldValue = ''; }

    if(conditionType == 'All'){
        var conditionModulePathId = 'aowAllConditionsModulePath';
        var conditionFieldId = 'aowAllConditionsField';
        var conditionOperatorInputId = 'aowAllConditionsOperatorInput';
        var conditionFieldTypeId = 'aowAllConditionsFieldTypeInput';
        var conditionsFieldInputId = 'aowAllConditionsFieldInput';

        var aowOperatorName = "aowAllConditionsOperator["+ln+"]";
        var aowFieldTypeName = "aowAllConditionsValueType["+ln+"]";
        var aowFieldName = "aowAllConditionsValue["+ln+"]";
    }else if(conditionType == 'Any'){
        var conditionModulePathId = 'aowAnyConditionsModulePath';
        var conditionFieldId = 'aowAnyConditionsField';
        var conditionOperatorInputId = 'aowAnyConditionsOperatorInput';
        var conditionFieldTypeId = 'aowAnyConditionsFieldTypeInput';
        var conditionsFieldInputId = 'aowAnyConditionsFieldInput';

        var aowOperatorName = "aowAnyConditionsOperator["+ln+"]";
        var aowFieldTypeName = "aowAnyConditionsValueType["+ln+"]";
        var aowFieldName = "aowAnyConditionsValue["+ln+"]";
    }//end of else
    
    var relField = document.getElementById(conditionModulePathId+ln).value;
    var aowField = document.getElementById(conditionFieldId+ln).value;

    if(aowField != ''){
        var callback = {
            success: function(result) {
                document.getElementById(conditionOperatorInputId+ln).innerHTML = result.responseText;
                SUGAR.util.evalScript(result.responseText);
                document.getElementById(conditionOperatorInputId+ln).onchange = function(){changeOperator(conditionType, ln);};
            },//end of success
            failure: function(result) {
                document.getElementById(conditionOperatorInputId+ln).innerHTML = '';
            }//end of failure
        }//end of function

        var callback2 = {
            success: function(result) {
                document.getElementById(conditionFieldTypeId+ln).innerHTML = result.responseText;
                SUGAR.util.evalScript(result.responseText);
                document.getElementById(conditionFieldTypeId+ln).onchange = function(){showModuleFieldType(conditionType, ln);};
            },//end of success
            failure: function(result) {
                document.getElementById(conditionFieldTypeId+ln).innerHTML = '';
            }//end of failure
        }//end of function

        var callback3 = {
            success: function(result) {
                document.getElementById(conditionsFieldInputId+ln).innerHTML = result.responseText;
                SUGAR.util.evalScript(result.responseText);
                enableQS(true);
            },//end of success
            failure: function(result) {
                document.getElementById(conditionsFieldInputId+ln).innerHTML = '';
            }//end of failure
        }//end of function
        
        YAHOO.util.Connect.asyncRequest ("GET", "index.php?entryPoint=VIRemindersAndNotificationModuleOperatorField&view="+action_sugar_grp1+"&aow_module="+flowModule+"&aow_fieldname="+aowField+"&aow_newfieldname="+aowOperatorName+"&aow_value="+operatorValue+"&relField="+relField,callback);
        YAHOO.util.Connect.asyncRequest ("GET", "index.php?entryPoint=VIRemindersAndNotificationFieldTypeOptions&view="+action_sugar_grp1+"&aow_module="+flowModule+"&aow_fieldname="+aowField+"&aow_newfieldname="+aowFieldTypeName+"&aow_value="+typeValue+"&relField="+relField,callback2);    
        YAHOO.util.Connect.asyncRequest ("GET", "index.php?entryPoint=VIRemindersAndNotificationModuleFieldType&view="+action_sugar_grp1+"&aow_module="+flowModule+"&aow_fieldname="+aowField+"&aow_newfieldname="+aowFieldName+"&aow_value="+fieldValue+"&aow_type="+typeValue+"&relField="+relField+"&ln="+ln+"&recordId="+recordId,callback3);

    } else {
        document.getElementById(conditionOperatorInputId+ln).innerHTML = ''
        document.getElementById(conditionFieldTypeId+ln).innerHTML = '';
        document.getElementById(conditionsFieldInputId+ln).innerHTML = '';
    }//end of else

    if(operatorValue == 'is_null'){
        hideElem(conditionFieldTypeId + ln);
        hideElem(conditionsFieldInputId + ln);
    } else {
        showElem(conditionFieldTypeId + ln);
        showElem(conditionsFieldInputId + ln);
    }//end of else
}//end of function

function showModuleFieldType(conditionType, ln, value){
    if (typeof value === 'undefined') { value = ''; }
    if(conditionType == 'All'){
        conditionFieldInputId = 'aowAllConditionsFieldInput';
        conditionModulePathId = 'aowAllConditionsModulePath';
        conditionFieldId = 'aowAllConditionsField';
        conditionValueTypeId = 'aowAllConditionsValueType';
        var aowFieldName = "aowAllConditionsValue["+ln+"]";
    }else{
        conditionFieldInputId = 'aowAnyConditionsFieldInput';
        conditionModulePathId = 'aowAnyConditionsModulePath';
        conditionFieldId = 'aowAnyConditionsField';
        conditionValueTypeId = 'aowAnyConditionsValueType';
        var aowFieldName = "aowAnyConditionsValue["+ln+"]";
    }//end of else
    var callback = {
        success: function(result) {
            document.getElementById(conditionFieldInputId+ln).innerHTML = result.responseText;
            SUGAR.util.evalScript(result.responseText);
            enableQS(false);
        },//end of success
        failure: function(result) {
            document.getElementById(conditionFieldInputId+ln).innerHTML = '';
        }//end of failure
    }//end of function

    var relField = document.getElementById(conditionModulePathId+ln).value;
    var aowField = document.getElementById(conditionFieldId+ln).value;
    var typeValue = document.getElementById(conditionValueTypeId+"["+ln+"]").value;
    

    YAHOO.util.Connect.asyncRequest ("GET", "index.php?entryPoint=VIRemindersAndNotificationModuleFieldType&view="+action_sugar_grp1+"&aow_module="+flowModule+"&aow_fieldname="+aowField+"&aow_newfieldname="+aowFieldName+"&aow_value="+value+"&aow_type="+typeValue+"&relField="+relField+"&filename=2&ln="+ln+"&recordId="+recordId,callback);
}//end of function

function insertConditionHeader(conditionType){
    tablehead = document.createElement("thead");
    
    if(conditionType == 'All'){
        tableHeadId = "allConditionLinesHead";
        tableId = "aowAllConditionLines";
    }else{
        tableHeadId = "anyConditionLinesHead";
        tableId = "aowAnyConditionLines";
    }//end of else

    tablehead.id = tableHeadId;
    
    document.getElementById(tableId).appendChild(tablehead);

    var x=tablehead.insertRow(-1);
    x.id = tableHeadId ;

    var a=x.insertCell(0);
    
    var b=x.insertCell(1);
    b.style.color="rgb(0,0,0)";
    b.innerHTML= SUGAR.language.get('Administration', 'LBL_MODULE_PATH');

    var c=x.insertCell(2);
    c.style.color="rgb(0,0,0)";
    c.innerHTML= SUGAR.language.get('Administration', 'LBL_FIELD');

    var d=x.insertCell(3);
    d.style.color="rgb(0,0,0)";
    d.innerHTML= SUGAR.language.get('Administration', 'LBL_OPERATOR');

    var e=x.insertCell(4);
    e.style.color="rgb(0,0,0)";
    e.innerHTML= SUGAR.language.get('Administration', 'LBL_VALUE_TYPE');

    var f=x.insertCell(5);
    f.style.color="rgb(0,0,0)";
    f.innerHTML= SUGAR.language.get('Administration', 'LBL_VALUE');
}//end of function

function insertConditionLine(conditionType){
    if(conditionType == 'All'){
        var rowc  = $("#aowAllConditionLines > tbody > tr").length;
        var rowCnt = $("#aowAllConditionLines > tbody > tr:visible").length;
        allCondln = rowc;

        tableId = 'aowAllConditionLines';
        tableHeadId = 'allConditionLinesHead';
        tableBodyId = 'aowAllConditionsBody' + allCondln;
        productLineId = 'aowAllProductLine' + allCondln;
        deleteLineId = 'aowAllConditionsDeleteLine' + allCondln;
        deleteOnclickFunction = 'markConditionLineDeleted("All",'+allCondln+')';
        deleteConditionsDeletedName = 'aowAllConditionsDeleted[' + allCondln + ']';
        deleteConditionsDeletedId = 'aowAllConditionsDeleted'+ allCondln;
        conditionsName = 'aowAllConditionsId[' + allCondln + ']';
        conditionsId = 'aowAllConditionsId'+ allCondln;
        modulePathName = 'aowAllConditionsModulePath['+ allCondln +'][0]';
        modulePathId = 'aowAllConditionsModulePath'+ allCondln;
        modulePathLabel = 'aowAllConditionsModulePathLabel'+ allCondln;
        conditionsFieldName = 'aowAllConditionsField['+allCondln+']';
        conditionsFieldId = 'aowAllConditionsField'+allCondln;
        fieldOnchangeFunction = 'showModuleField("'+conditionType+'",'+allCondln+')';
        conditionsFieldLabel = 'aowAllConditionsFieldLabel'+allCondln;
        conditionsOperatorId = 'aowAllConditionsOperatorInput'+allCondln;
        conditionsFieldTypeId = 'aowAllConditionsFieldTypeInput'+allCondln;
        conditionsFieldInputId = 'aowAllConditionsFieldInput'+allCondln;

    }else{
        var rowc  = $("#aowAnyConditionLines > tbody > tr").length;
        var rowCnt = $("#aowAnyConditionLines > tbody > tr:visible").length;
        anyCondln = rowc;

        tableId = 'aowAnyConditionLines';
        tableHeadId = 'anyConditionLinesHead';
        tableBodyId = 'aowAnyConditionsBody' + anyCondln;
        productLineId = 'aowAnyProductLine' + anyCondln;
        deleteLineId = 'aowAnyConditionsDeleteLine' + anyCondln;
        deleteOnclickFunction = 'markConditionLineDeleted("Any",'+anyCondln+')';
        deleteConditionsDeletedName = 'aowAnyConditionsDeleted[' + anyCondln + ']';
        deleteConditionsDeletedId = 'aowAnyConditionsDeleted'+ anyCondln;
        conditionsName = 'aowAnyConditionsId[' + anyCondln + ']';
        conditionsId = 'aowAnyConditionsId'+ anyCondln;
        modulePathName = 'aowAnyConditionsModulePath['+ anyCondln +'][0]';
        modulePathId = 'aowAnyConditionsModulePath'+ anyCondln;
        modulePathLabel = 'aowAnyConditionsModulePathLabel'+ anyCondln;
        conditionsFieldName = 'aowAnyConditionsField['+anyCondln+']';
        conditionsFieldId = 'aowAnyConditionsField'+anyCondln;
        fieldOnchangeFunction = 'showModuleField("'+conditionType+'",'+anyCondln+')';
        conditionsFieldLabel = 'aowAnyConditionsFieldLabel'+anyCondln;
        conditionsOperatorId = 'aowAnyConditionsOperatorInput'+anyCondln;
        conditionsFieldTypeId = 'aowAnyConditionsFieldTypeInput'+anyCondln;
        conditionsFieldInputId = 'aowAnyConditionsFieldInput'+anyCondln;
    }//end of else

    if (document.getElementById(tableHeadId) == null) {
        insertConditionHeader(conditionType);
    } else {
        document.getElementById(tableHeadId).style.display = '';
    }//end of else

    tablebody = document.createElement("tbody");
    tablebody.id = tableBodyId;
    document.getElementById(tableId).appendChild(tablebody);


    var x = tablebody.insertRow(-1);
    x.id = productLineId;

    var a = x.insertCell(0);
    if(action_sugar_grp1 == 'vi_reminderandnotificationeditview'){
        a.innerHTML = "<button type='button' id='"+deleteLineId+"' class='button' value='' tabindex='116' onclick='"+deleteOnclickFunction+"'><span class='suitepicon suitepicon-action-minus'></span></button><br>";
        a.innerHTML += "<input type='hidden' name='"+deleteConditionsDeletedName+"' id='"+deleteConditionsDeletedId+"' value='0'><input type='hidden' name='"+conditionsName+"' id='"+conditionsId+"' value=''>";
    }//end of if 

    var b = x.insertCell(1);
    b.innerHTML = "<select name='"+modulePathName+"' id='"+modulePathId+"' value='' tabindex='116' disabled = 'disabled'>" + flowRelModules + "</select>";
    b.innerHTML += "<span id='"+modulePathLabel+"' style='display:none;'></span>";

    var c = x.insertCell(2);
    c.innerHTML = "<select name='"+conditionsFieldName+"' id='"+conditionsFieldId+"' value='' tabindex='116' onchange='"+fieldOnchangeFunction+"' class='"+conditionType+"FieldClass'>" + flowFields + "</select>";
    c.innerHTML += "<span id='"+conditionsFieldLabel+"' style='display:none;'></span>";


    var d = x.insertCell(3);
    d.id = conditionsOperatorId;

    var e = x.insertCell(4);
    e.id = conditionsFieldTypeId;

    var f = x.insertCell(5);
    f.id = conditionsFieldInputId;

    if(conditionType == 'All'){
        allCondln++;
        allCondlnCount = rowCnt
        allCondlnCount++;
    }else{
        anyCondln++;
        anyCondlnCount = rowCnt
        anyCondlnCount++;
    }//end of else

    $('.edit-view-field #'+tableId).find('tbody').last().find('select').change(function () {
        $(this).find('td').last().removeAttr("style");
        $(this).find('td').height($(this).find('td').last().height() + 8);
    });//end of function

    if(conditionType == 'All'){
        return allCondln -1;
    }else{
        return anyCondln -1;
    }//end of else
}//end of function

function changeOperator(conditionType, ln){
    if(conditionType == 'All'){
        var aowOperator = document.getElementById("aowAllConditionsOperator["+ln+"]").value;
    }else{
        var aowOperator = document.getElementById("aowAnyConditionsOperator["+ln+"]").value;
    }//end of else
    
    if(aowOperator == 'is_null'){
        showModuleField(conditionType, ln, aowOperator);
    } else {
        if(conditionType == 'All'){
            showElem('aowAllConditionsFieldTypeInput' + ln);
            showElem('aowAllConditionsFieldInput' + ln);
        }else{
            showElem('aowAnyConditionsFieldTypeInput' + ln);
            showElem('aowAnyConditionsFieldInput' + ln);
        }//end of else
    }//end of else
}//end of function

function markConditionLineDeleted(conditionType, ln) {
    // collapse line; update deleted value
    if(conditionType == 'All'){
        document.getElementById('aowAllConditionsBody' + ln).style.display = 'none';
        document.getElementById('aowAllConditionsDeleted' + ln).value = '1';
        document.getElementById('aowAllConditionsDeleteLine' + ln).onclick = '';

        allCondlnCount--;
        if(allCondlnCount == 0){
            document.getElementById('allConditionLinesHead').style.display = "none";
        }//end of if
    }else{
        document.getElementById('aowAnyConditionsBody' + ln).style.display = 'none';
        document.getElementById('aowAnyConditionsDeleted' + ln).value = '1';
        document.getElementById('aowAnyConditionsDeleteLine' + ln).onclick = '';

        anyCondlnCount--;
        if(anyCondlnCount == 0){
            document.getElementById('anyConditionLinesHead').style.display = "none";
        }//end of if 
    }//end of else
}//end of function

function clearConditionLines(){
    if(document.getElementById('aowAllConditionLines') != null){
        var condRows = document.getElementById('aowAllConditionLines').getElementsByTagName('tr');
        var condRowLength = condRows.length;
        var i;
        for (i=0; i < condRowLength; i++) {
            if(document.getElementById('aowAllConditionsDeleteLine'+i) != null){
                document.getElementById('aowAllConditionsDeleteLine'+i).click();
            }//end of if
        }//end of for
    }//end of if

    if(document.getElementById('aowAnyConditionLines') != null){
        var condRows = document.getElementById('aowAnyConditionLines').getElementsByTagName('tr');
        var condRowLength = condRows.length;
        var i;
        for (i=0; i < condRowLength; i++) {
            if(document.getElementById('aowAnyConditionsDeleteLine'+i) != null){
                document.getElementById('aowAnyConditionsDeleteLine'+i).click();
            }//end of if
        }//end of for
    }//end of if
}//end of function

function hideElem(id){
    if(document.getElementById(id)){
        document.getElementById(id).style.display = "none";
        document.getElementById(id).value = "";
    }//end of if
}//end of function

function showElem(id){
    if(document.getElementById(id)){
        document.getElementById(id).style.display = "";
    }//end of if
}//end of function

//end conditions functions

//Open Product Module Popup
var productInputId, conditionFieldInputId;
function openModulePopup(moduleName, productName, productId, conditionFieldId){
    productInputId = productId;
    conditionFieldInputId = conditionFieldId;
    var popupRequestData = {
        "call_back_function": "setProductReturn",
        "form_name": "EditView",
        "field_to_name_array": {
            "id" : ""+productId+"" ,
            "name" : ""+productName+"" ,
        }
    };//end
    open_popup(moduleName,600,400,'',true,false,popupRequestData); //open popup 
}//end of function

function setProductReturn(popupReplyData){
    set_return(popupReplyData);
    document.getElementById(conditionFieldInputId).value = $('#'+productInputId).val();
}//end of function

//Remove Product From Condition Line Value
function removeProductConditionField(obj){
    if($(obj).parent('span').prev('input').attr('type') == "hidden"){
        $(obj).parent('span').prev('input').val('');
    }
}//end of function

//Get Products Field Discount,Text
function getProductField(obj){
    if($(obj).next('input').attr('type') == "hidden"){
        $(obj).next('input').val($(obj).val());
    }
}//end of function