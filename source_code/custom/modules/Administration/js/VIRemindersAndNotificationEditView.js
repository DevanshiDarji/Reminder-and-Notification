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
var wizardCurrentStep = $('.nav-steps.selected').attr('data-nav-step');
if(wizardCurrentStep == 1){
    $('#btnSave').hide();
    $('#backButton').hide();
}

//Click Event for Cancel Button
$('#btnCancel').on('click',function(){
    window.location.href = "index.php?module=Administration&action=vi_reminderandnotificationlistview";
});//end of function

function clearall(){
    var wizardCurrentStep = $('.nav-steps.selected').attr('data-nav-step');
    if(wizardCurrentStep == 1){
        $('#subject').val('');
        $('#module').val('');
        $('#fieldNotification').val('');
        $('#triggerValue').val('');
        $('#triggerPeriod').val('');
        $('#triggerAction').val('');
        $('#triggerMonthValue').val('');
        $('#triggerMonthValue').hide();
        $('#triggerNotificationRow').css('display','none');
    }else if(wizardCurrentStep == 2){
        $("#aowAllConditionLines tr").remove(); 
        $("#aowAnyConditionLines tr").remove(); 
    }else if(wizardCurrentStep == 3){
        $('#sendNotificationReceiver').removeAttr('checked');
        $('#emailNoteRow').hide();
        $('#emailNotification').val('');
        $('#emailNotificationRow').hide();
        $('#templateType').val('');
        $('#template').hide();
        $("#displayTinyMce").hide();
        $('#customTemplates').css('display','none');
        $('#allUsers').prop('checked',false);
        $('.userChk').prop('checked',false);
        $('#primaryModuleFields option').attr('selected',false);
        $('#primaryModuleFields option:first').attr('selected',true);
        $('#reminderMessage').val('');
        $('#relateFields').find('option').remove();
        $('#relatedModule option').attr('selected',false);
        $('#relatedModule option:first').attr('selected',true);
    }
}//end of function

var flag;

if(recordId != ""){
    if(reminderNotificationData.module != ""){
        getPrimaryModuleDateDateTimeFields(reminderNotificationData.module, reminderNotificationData.notification_field); //Get Primary Module Date/DateTime Fields
    }

    $('#fieldcomparison').find('option:selected').removeAttr('selected'); 
    $('#fieldcomparison').find("option[value='"+reminderNotificationData.comparison_field+"']").attr("selected",true);

    getTriggerActionDisplay(reminderNotificationData.trigger_action);

    if(reminderNotificationData.trigger_action == "Immediate Notification"){
        if(reminderNotificationData.trigger_notification_field != "" && reminderNotificationData.trigger_notification_field != undefined){
            $("#triggerRecordModified").prop("checked", true);
            $("#triggerRecordModified").val('1');
            $('#triggerNotificationFieldsRow').css('display','table-row');
            $('#fieldNotification').val('');
            $('#fieldNotification').find('option:selected').removeAttr('selected');
            $('#fieldNotification').find('option:first').attr('selected',true);
            $('#fieldNotificationRow').css('display','none');
            $('#fieldcomparisonRow').css('display','none');
            getPrimaryModuleFields(reminderNotificationData.module,  flag = 2, reminderNotificationData.trigger_notification_field);
        }else{
            $("#triggerRecordCreation").val('1');
            $("#triggerRecordCreation").prop("checked", true);
            $('#triggerNotificationFieldsRow').css('display','none');
        }
    }
    
    getMonthFirstLastDate();//Get Month First/Last Date

    var templateType = $("#templateType").val();
    if(templateType != ""){
        $('#template').show();
        if($(".templates").is(":checked")){
            if(templateType == 0 || templateType == 1){
                $("#displayTinyMce").show();
                $("#templateId").val(reminderNotificationData.template_id);
            }
        }
    }
}else{ 
    $('#emailNoteRow').hide();
    $('#emailNotificationRow').hide()
}

//Module on change event function
$('#module').on('change', function(){
    var moduleName = $(this).val();   
    if(moduleName != ""){
        getPrimaryModuleFields(moduleName, flag = '', '');//Get Primary Module Fields

        getPrimaryModuleDateDateTimeFields(moduleName, '');//Get Primary Module Date/DateTime Fields

        getRelatedModule(moduleName,  flag = 1, '');//Get Relate Module
    }else{
        $("#primaryModuleFields").empty();
        $('#primaryModuleFields').append("<option value='' selected>"+SUGAR.language.get('Administration','LBL_SELECT_AN_OPTION')+"</option>");
        $("#fieldNotification").empty();
        $('#fieldNotification').append("<option value='' selected>"+SUGAR.language.get('Administration','LBL_SELECT_AN_OPTION')+"</option>");
        $('#reminderMessage').val('');
        $('#triggerValue').val('');
        $('#triggerPeriod').val('');
        $('#triggerAction').val('');
        $('#triggerMonthValue').val(''); 
        $('#triggerMonthValue').hide();    
        $("#aowAllConditionLines tr").remove(); 
        $("#aowAnyConditionLines tr").remove(); 
    }
    $('#triggerValue').css('display', 'inline-block');
    $('#triggerPeriod').css('display', 'inline-block');
    $('#triggerAction').css('display', 'inline-block');
    $('#fieldNotificationRow').css('display', 'table-row');
    $('#triggerNotificationRow').css('display', 'none');
    $('#triggerNotificationFieldsRow').css('display', 'none');
    $('#reminderMessage').val('');
    $('#triggerValue').val('');
    $('#triggerPeriod').val('');
    $('#triggerAction').val('');
    $('#triggerMonthValue').val('');
    $('#triggerMonthValue').hide();
    $('#sendNotificationReceiver').removeAttr('checked');
    $('#emailNotification').val('');
    $('#emailNoteRow').hide();
    $('#emailNotificationRow').hide();
    $("#aowAllConditionLines tr").remove(); 
    $("#aowAnyConditionLines tr").remove(); 
});//end of module change function

$('#fieldcomparison').on('change', function(){
    if($(this).val() != "Compare Entire Date" && $('#triggerPeriod').val() == "Hours"){
        alert(SUGAR.language.get('Administration','LBL_ENTIRE_DATE_MSG1')+' '+'"'+$('#triggerPeriod').val()+'"'+' '+SUGAR.language.get('Administration','LBL_ENTIRE_DATE_MSG2'));
        $(this).find('option:selected').attr('selected',false);
        $(this).find('option:first').attr('selected',true);
    }
});

$('#triggerPeriod').on('change', function(){
    var triggerPeriod = $(this).val();
    var fieldcomparison = $('#fieldcomparison').val();
    if(fieldcomparison != "Compare Entire Date"){
        alert(SUGAR.language.get('Administration','LBL_HOURS_VALID_MSG1')+' '+'"'+fieldcomparison+'"'+' '+SUGAR.language.get('Administration','LBL_HOURS_VALID_MSG2'));
        $(this).find('option:selected').attr('selected',false);
        $(this).find('option:first').attr('selected',true);
    }
});

$('#triggerAction').on('change', function(){
    $("input[name='triggerNotification']").attr('checked',false);
    $('#triggerRecordCreation').val('0');
    $('#triggerRecordModified').val('0');
    var triggerAction = $(this).val();
    getTriggerActionDisplay(triggerAction);
});

function getTriggerActionDisplay(triggerAction){
    if(triggerAction == "Immediate Notification"){
        $('#triggerValue').val('');
        $('#triggerPeriod').val('');
        $('#triggerPeriod').find('option:selected').attr('selected',false);
        $('#triggerPeriod').find('option:first').attr('selected',true);
        $('#triggerValue').css('display','none');
        $('#triggerPeriod').css('display','none');
        $('#notificationRow').css('width','300px');
        $('#triggerNotificationRow').css('display','table-row');
    }else if(triggerAction == "Now"){
        $('#triggerValue').val('');
        $('#triggerPeriod').val('');
        $('#triggerPeriod').find('option:selected').attr('selected',false);
        $('#triggerPeriod').find('option:first').attr('selected',true);
        $('#triggerValue').css('display','none');
        $('#triggerPeriod').css('display','none');
        $('#triggerNotificationRow').css('display','none');
        $('#notificationRow').css('width','300px');
        $('#triggerNotificationFieldsRow').css('display','none');
        $('#fieldNotification').val('');
        $('#fieldNotification').find('option:selected').removeAttr('selected');
        $('#fieldNotification').find('option:first').attr('selected',true);
        $('#fieldNotificationRow').css('display','table-row');
        $('#fieldcomparisonRow').css('display','table-row');
    }else{
        $('#fieldNotification').find('option:selected').attr('selected',false);
        $('#fieldNotification').find('option:first').attr('selected',true);
        $('#notificationRow').removeAttr('style');
        $('#triggerValue').css('display','inline-block');
        $('#triggerPeriod').css('display','inline-block');
        $('#triggerNotificationRow').css('display','none');
        $('#triggerNotificationFieldsRow').css('display','none');
        $('#fieldNotificationRow').css('display','table-row');
        $('#fieldcomparisonRow').css('display','table-row');
    }
}

function getTrigger(obj){
    $('#triggerRecordCreation').val('0');
    $('triggerRecordModified').val('0');
    var moduleName = $('#module').val();
    if ($(obj).is(':checked')){
        if($(obj).attr('id') == 'triggerRecordModified') {
            $(obj).val('1');
            $('#triggerNotificationFieldsRow').css('display','table-row');
            $('#fieldNotification').val('');
            $('#fieldNotification').find('option:selected').removeAttr('selected');
            $('#fieldNotification').find('option:first').attr('selected',true);
            $('#fieldNotificationRow').css('display','none');
            $('#fieldcomparisonRow').css('display','none');

            getPrimaryModuleFields(moduleName,  flag = 2, '');
        }else if($(obj).attr('id') == 'triggerRecordCreation'){
            $(obj).val('1');
            $('#triggerNotificationModuleFields').find('option:selected').removeAttr('selected');
            $('#triggerNotificationModuleFields').find('option:first').attr('selected',true);
            $('#triggerNotificationFieldsRow').css('display','none');
            $('#fieldNotificationRow').css('display','table-row');
            $('#fieldcomparisonRow').css('display','table-row');
        }
    }
}//end of function 

$("#triggerAction, #triggerPeriod, #triggerValue").on("change", function(){
    getMonthFirstLastDate();//Get Month First/Last Date
});//end of function

//Get Primary Module Date/DateTime Fields
function getPrimaryModuleDateDateTimeFields(module, notificationField){
    $.ajax({
        url: "index.php?entryPoint=VIRemindersAndNoificationFetchPrimaryModuleDateDateTimeFields",
        type: "post",
        data: {module : module},
        success: function (response) {
            if(response != ''){
                $("#fieldNotification").empty();
                $('#fieldNotification').append("<option value='' selected>"+SUGAR.language.get('Administration','LBL_SELECT_AN_OPTION')+"</option>");
                $("#fieldNotification").append(response);
                if(notificationField != ''){
                    $('#fieldNotification').find("option[value='"+reminderNotificationData.notification_field+"']").attr("selected",true);
                    getFieldType(reminderNotificationData.module,reminderNotificationData.notification_field);
                }
            }
        }    
    });
}//end of function

function getFieldType(module, obj){
    var field = $(obj).val();
    var fieldLabel = $(obj).find('option[value="'+field+'"]').text();
    var triggerPeriod = $('#triggerPeriod').val();
    $.ajax({
        url: "index.php?entryPoint=VIRemindersAndNotificationGetFieldType",
        type: "post",
        data: {module : module,
            field : field},
        success: function (response) {
            if(response == 1 && triggerPeriod == "Hours"){
                alert(SUGAR.language.get('Administration','LBL_SELECT')+'"'+fieldLabel+'"'+SUGAR.language.get('Administration','LBL_FIELD_NOTIFICATION_MSG'));
                $('#fieldNotification').find('option:selected').attr('selected', false);
                $('#fieldNotification').find('option:first').attr('selected', true);
            }
        }    
    });
}//end of function

function getMonthFirstLastDate(){
    var triggerAction = $('#triggerAction').val();  
    var triggerValue = $('#triggerValue').val();
    var triggerPeriod = $('#triggerPeriod').val(); 
    $.ajax({
        url: "index.php?entryPoint=VIRemindersAndNoificationFetchMonthFirstandLastDate",
        type: "post",
        data: {triggerValue : triggerValue,
                triggerPeriod :triggerPeriod,
                triggerAction : triggerAction},
        success: function (response) {
            if(response != ""){
                if(triggerPeriod != "" && triggerAction != ""){
                    if(triggerPeriod == "Month"){
                        $("#triggerMonthValue").show();
                        $("#triggerMonthValue").val(response);
                    }else{
                        $("#triggerMonthValue").hide();
                    }
                }else{
                    $("#triggerMonthValue").hide();
                }
            }
        }
    });
}//end of function

//Click Event for Next Button
$('#btnNext').on('click', function(){
    var wizardCurrentStep = $('.nav-steps.selected').attr('data-nav-step');

    getwizardCurrentStep1(wizardCurrentStep);
    
    if(recordId != ""){
        if(reminderNotificationData.enable_notification == "1"){
            $('#sendNotificationReceiver').prop('checked',true);
            if ($('#sendNotificationReceiver').is(':checked')){
                $('#emailNotificationRow').show();
                if(reminderNotificationData.email_notification != ""){
                    $('#emailNotification').val(reminderNotificationData.email_notification);
                }
                emailTypeFields();
            }else{
                $('#emailNotificationRow').hide();
            }
        }
        if(reminderNotificationData.enable_users != ""){
            if(reminderNotificationData.enable_users == "1"){
                var status = true;
            }
        }else{
            var status = false;
        }

        $("#allUsers").val(reminderNotificationData.enable_users);
        $('#allUsers').prop('checked',status);
        var $el = $("dt").next();
        var $checks = $el.find(":checkbox");
        $checks.prop('checked',status);
        
        if(reminderNotificationData.reminder_message != ""){
            $('#reminderMessage').val(reminderNotificationData.reminder_message);
        }
    }else{
        $('#emailNoteRow').hide();
        $('#emailNotificationRow').hide();
    }
            
    if($('#sendNotificationReceiver').is(':checked')){
        $('#emailNotificationRow').show();
        emailTypeFields();
    }else{
        $('#emailNoteRow').hide();
        $('#emailNotificationRow').hide()
    }
    $('#sendNotificationReceiver').on('click',function(){
        if ($(this).is(':checked')){
            $('#emailNotificationRow').show();
            emailTypeFields();
            $(this).val(1);
            $('#emailNotification').val('');
        }else{
            $('#emailNoteRow').hide();
            $('#emailNotificationRow').hide();
            $(this).val(0);
        }
    });
            
    getWizardCurrentStep2(wizardCurrentStep);

    if(recordId != ""){
        if(wizardCurrentStep == 2){
            if($(".templates").is(":checked")){
                var templateType = $("#templateType").find("option[value='"+reminderNotificationData.templates+"']").prop("selected",true);
                var template = $('input[name="templates"][value="'+templateData.templateType+'"]').prop('checked', true);
                if(templateType.val() == 0 || templateType.val() == 1){
                    if(template.val() == "Birthday Templates" || template.val() == 'Marriage Anniversary Templates' || template.val() == "Work Anniversary Templates" ||  template.val() == "Other Templates"){
                        $('#birthdayTemplates').hide();
                        $("#workAniversryTemplates").hide(); 
                        $("#marriageAniversryTemplates").hide();
                        $("#customTemplates").css('display','none');
                        $("#displayTinyMce").show();
                        $("#templateId").val(reminderNotificationData.template_id);
                        setTimeout(function(){
                            tinymce.get('template_message').setContent(html_entity_decode(reminderNotificationData.template_message));
                        }, 1000);
                    }
                }
            }
            var moduleName = $('#module').val();
            if(reminderNotificationData.module != moduleName){
                $('#sendNotificationReceiver').removeAttr('checked');
                $('#emailNoteRow').hide();
                $('#emailNotificationRow').hide();
                $('#templateType').val('');
                $('#template').hide();
                $("#displayTinyMce").hide();
                $('#customTemplates').css('display','none');
            }
            getPrimaryModuleFields(moduleName, flag = '', '');

            getRelatedModule(reminderNotificationData.module,  flag = 1, reminderNotificationData.related_module); //Get Relate Module 

            if(reminderNotificationData.related_module != ""){
                var relatedModule = $('#relatedModule').find('option[value="'+reminderNotificationData.related_module+'"]').attr('related_module');
                getRelatedModuleFields(relatedModule,  flag = 0, reminderNotificationData.relate_fields);//Get Related Module Fields
            }
        }
    }//end of if  
});//end of function

//Click Event for Add Conditions
$('#navStep2').on('click', function(){
    var wizardCurrentStep = $('.nav-steps.selected').attr('data-nav-step');
    getwizardCurrentStep1(wizardCurrentStep);
    if(recordId != ""){
        if($('#sendNotificationReceiver').is(':checked')){
            $('#emailNotificationRow').show();
            emailTypeFields();
        }else{
            $('#emailNotificationRow').hide();
        }
    }else{
        $('#emailNotificationRow').hide();
    }
    $('#sendNotificationReceiver').on('click', function(){
        if ($(this).is(':checked')){
            $('#emailNotificationRow').show();
            emailTypeFields();
            $("#emailNotification").val('');
        }else{
            $('#emailNotificationRow').hide();
        }
    });
});//end of function

//Get Primary Module Fields
function getPrimaryModuleFields(primaryModule, flag, triggerNotificationField){
    $.ajax({
        url: "index.php?entryPoint=VIRemindersAndNotificationFetchPrimaryModuleFields",
        type: "post",
        data: {module : primaryModule,
                flag : flag},
        success: function (response) {
            if(flag == ''){
                $('#primaryModuleFields').empty();
                $('#primaryModuleFields').append("<option value='' selected>"+SUGAR.language.get('Administration','LBL_SELECT_AN_OPTION')+"</option>");
                $('#primaryModuleFields').append(response);

                $('#templateField').empty();
                $('#templateField').append("<option value='' selected>"+SUGAR.language.get('Administration','LBL_SELECT_AN_OPTION')+"</option>");
                $('#templateField').append(response); 
            }else if(flag == 2){
                $('#triggerNotificationModuleFields').empty();
                $('#triggerNotificationModuleFields').append("<option value='' selected>"+SUGAR.language.get('Administration','LBL_SELECT_AN_OPTION')+"</option>");
                $('#triggerNotificationModuleFields').append(response);  

                if(triggerNotificationField != ""){
                    $('#triggerNotificationModuleFields').find("option[value='"+triggerNotificationField+"']").attr("selected",true);
                }       
            }
        }    
    });
}//end of function

$('#backButton').on('click', function(){
    var wizardCurrentStep = $('.nav-steps.selected').attr('data-nav-step');
    if(wizardCurrentStep == 2){
        $('#btnSave').hide();
        $('#step1').css('display','block');
        $('#navStep1').addClass('selected');
        $('#btnNext').show();
        $('#backButton').hide();
        $('#step2').css('display','none');
        $('#navStep2').removeClass('selected');
        $('#step3').css('display','none');
        $('#navStep3').removeClass('selected');
        $('#cancelButtonDiv').css('margin-left','0px');
    }else if(wizardCurrentStep == 3){
        $('#btnSave').hide();
        $('#step1').css('display','none');
        $('#navStep1').removeClass('selected');
        $("#step2").css('display','block');
        $('#navStep2').addClass('selected');
        $('#btnNext').show();
        $('#step3').css('display','none');
        $('#navStep3').removeClass('selected');
    }
});//end of function

//Get All User Click Event
$('#allUserchk').on('click', function(){
    if($(this).is(':checked')){
        $('#Users option').attr('selected','selected');
    }else{
        $('#Users option').removeAttr('selected');
    }
});//end of function

$("dt > #allUsers").on('change', function(){
    if($(this).is(':checked')){
        $('.userChk').prop('checked',true);
        $("#allUsers").val("1");
    }else{
        $('.userChk').prop('checked',false);
        $("#allUsers").val("0");
    }
});
            
$('.userChk').on('click', function(){
    if($(".userChk").length == $(".userChk:checked").length) {
        $("#allUsers").prop("checked", true);
        $("#allUsers").val("1");   
    }else{
        $("#allUsers").prop("checked", false);
        $("#allUsers").val("0");
    }//end of else
});//end of Function

//Set Field Value in Textbox
$('#primaryModuleFields').on('change', function(){
    var field = $(this).val();
    if(field != ""){
        $('#reminderMessage').val($('#reminderMessage').val()+$(this).val());
    }
});//end of function

$('.tmpltCard').on('click', function(){
    var tempId = $(this).parent().attr('id');
    var templateType = $("#templateType").val();
    var templates = $("input[name='templates']:checked").val(); 
    if(templateType == 0 || templateType == 1){
        $("#displayTinyMce").show();
        $("#birthdayTemplates").hide();
        $("#workAniversryTemplates").hide();
        $("#marriageAniversryTemplates").hide();
        $("#customTemplates").css('display','none');
    }else{
        if(templates == "Birthday Templates"){
            $('#birthdayTemplates').show();
            $("#marriageAniversryTemplates").hide();
            $("#workAniversryTemplates").hide();
            $('#displayTinyMce').hide();
        }else if(templates == "Marriage Anniversary Templates"){
            $("#marriageAniversryTemplates").show();
            $('#birthdayTemplates').hide();
            $("#workAniversryTemplates").hide();
            $('#displayTinyMce').hide();
        }else if(templates == "Work Anniversary Templates"){
            $("#workAniversryTemplates").show();
            $("#marriageAniversryTemplates").hide();
            $('#birthdayTemplates').hide();
            $('#displayTinyMce').hide();
        }
    }
    $("#templateId").val(tempId);
    var htmldata = $('#'+tempId).html();
    var removeData = '<input type="button" class="button" name="clickHere" id="clickHere" value="Click Here">';
    var data = htmldata.replace(removeData, " ");
    tinymce.get('template_message').setContent(data);
});//end of function

$('.templates').on('click', function(){
    var templateType = $("#templateType").val();
    if ($(this).is(':checked')){
        var templates = $(this).val();
        if(templateType == 0){
            if(templates != ""){  
                $('#customTemplates').css('display','inline-block');
                if(templates == "Birthday Templates"){
                    $('#birthdayTemplates').show();
                    $("#marriageAniversryTemplates").hide();
                    $("#workAniversryTemplates").hide();
                    $('#displayTinyMce').hide();
                    $("#othersTemplates").hide();
                }else if(templates == "Marriage Anniversary Templates"){
                    $("#marriageAniversryTemplates").show();
                    $('#birthdayTemplates').hide();
                    $("#workAniversryTemplates").hide();
                    $('#displayTinyMce').hide();
                    $("#othersTemplates").hide();
                }else if(templates == "Work Anniversary Templates"){
                    $("#workAniversryTemplates").show();
                    $("#marriageAniversryTemplates").hide();
                    $('#birthdayTemplates').hide();
                    $('#displayTinyMce').hide();
                    $("#othersTemplates").hide();
                }else if(templates == "Other Templates"){
                    $("#othersTemplates").show();
                    $("#workAniversryTemplates").hide();
                    $("#marriageAniversryTemplates").hide();
                    $('#birthdayTemplates').hide();
                    $('#displayTinyMce').hide();
                }
            }else{
                $('#customTemplates').css('display','none');
            }
        }else{
            if(templates == "Birthday Templates"){              
                $('#displayTinyMce').show();
                tinymce.get('template_message').setContent('');
                $("#marriageAniversryTemplates").hide();
                $("#workAniversryTemplates").hide();
                $('#birthdayTemplates').hide();
                $("#othersTemplates").hide();
            }else if(templates == "Marriage Anniversary Templates"){
                $('#displayTinyMce').show();
                tinymce.get('template_message').setContent('');
                $("#marriageAniversryTemplates").hide();
                $("#workAniversryTemplates").hide();
                $('#birthdayTemplates').hide();
                $("#othersTemplates").hide();
            }else if(templates == "Work Anniversary Templates"){
                $('#displayTinyMce').show();
                tinymce.get('template_message').setContent('');
                $("#marriageAniversryTemplates").hide();
                $("#workAniversryTemplates").hide();
                $('#birthdayTemplates').hide();
                $("#othersTemplates").hide();
            }else if(templates == "Other Templates"){
                $("#othersTemplates").show();
                tinymce.get('template_message').setContent('');
                $("#workAniversryTemplates").hide();
                $("#marriageAniversryTemplates").hide();
                $('#birthdayTemplates').hide();
                $('#displayTinyMce').show();
            }
        }
    }
});//end of function

//get template type
$("#templateType").on("change",function(){
    var templateType = $(this).val();
    $('.templates').prop('checked', false);
    $('#displayTinyMce').hide();
    $('#customTemplates').css('display','none');
    if(templateType != ""){
        $('#template').show();
    }else{
        $('#template').hide();
    }
});//end of function

//Insert Template Field in Tinymce
function insertTemplateField() {
    var field = $('#templateField').val();
    var inst = tinyMCE.getInstanceById("template_message");
    insertFieldTemplateEditor(field,inst);
    $('#templateField option:first').removeAttr('selected',false);
    $('#templateField option:first').attr('selected',true); 
}//end of function

function insertFieldTemplateEditor(text,inst){
    if (text != ''){
        if (inst) inst.getWin().focus();
        inst.execCommand('mceInsertContent', false, text);
        inst.execCommand('mceToggleEditor');
        inst.execCommand('mceToggleEditor');
    }
}//end of function

//Back Button for Template Block
$("#templateBackBtn").on("click",function(){
    var templateType = $("#templateType").val();
    var templates = $("input[name='templates']:checked"). val(); 
    if(templateType != ""){
        if(templates == "Birthday Templates"){
            $('#birthdayTemplates').show();
            $("#marriageAniversryTemplates").hide();
            $("#workAniversryTemplates").hide();
            $('#displayTinyMce').hide();
        }else if(templates == "Marriage Anniversary Templates"){
            $("#marriageAniversryTemplates").show();
            $('#birthdayTemplates').hide();
            $("#workAniversryTemplates").hide();
            $('#displayTinyMce').hide();
        }else if(templates == "Work Anniversary Templates"){
            $("#workAniversryTemplates").show();
            $("#marriageAniversryTemplates").hide();
            $('#birthdayTemplates').hide();
            $('#displayTinyMce').hide();
        }else if(templates == "Other Templates"){
            $("#othersTemplates").show();
            $("#workAniversryTemplates").hide();
            $("#marriageAniversryTemplates").hide();
            $('#birthdayTemplates').hide();
            $('#displayTinyMce').hide();
        }
    }
    $('#templateType option:selected').removeAttr('selected');
    $('#template').hide();
    $('#customTemplates').css('display','none');
});//end of function

//Click Event of Notifications
$('#navStep3').on('click', function(){
    var wizardCurrentStep = $('.nav-steps.selected').attr('data-nav-step');
    getWizardCurrentStep2(wizardCurrentStep);
});//end of function

function getWizardCurrentStep2(wizardCurrentStep){
    if(wizardCurrentStep == 2){
        var checkAllConditionValue = checkAnyConditionValue = 0;
     
        checkAllConditionValue = checkConditionFieldValidation('aowAllConditionLines', 'aowAllProductLine', 'aowAllConditionsField', 'aowAllConditionsFieldInput', 'aowAllConditionsValue');
        checkAnyConditionValue = checkConditionFieldValidation('aowAnyConditionLines', 'aowAnyProductLine', 'aowAnyConditionsField', 'aowAnyConditionsFieldInput', 'aowAnyConditionsValue');
    
        if(checkAllConditionValue == 1 || checkAnyConditionValue == 1){
            alert(SUGAR.language.get('Administration','LBL_ENTER_VALUE'));
        }else{
            $('#step1').css("display","none");
            $('#step2').css("display","none");
            $('#step3').css("display","block");        
            $('#navStep1').removeClass('selected');
            $('#navStep2').removeClass('selected');
            $('#navStep3').addClass('selected');
            $('#backButton').show();
            $('#btnNext').hide();
            $('#btnSave').show();
            $('.notification').css("display", "block"); 
        }
    }
}//end of function

$('#relatedModule').on('change',function(){
    var relatedModule = $(this).find('option:selected').attr('related_module');
    if(relatedModule != ""){
        getRelatedModuleFields(relatedModule,  flag = 0, '');
    }else{
        $('#relateFields').find('option').remove();
    }
}); //end of function

//Check Valid Conditions Value
function checkConditionFieldValidation(tableName, lineId, fieldId, fieldInputId, fieldValue){
    var checkConditionValue = 0;
    var rowc = $("#"+tableName+" > tbody > tr").length; //count of condition lines
    var conditionValue = '';
    for(var i=0;i<rowc;i++){
        if($('#'+lineId+i).is(':visible')){
            var field = document.getElementById(fieldId+i).value; //field name
            if(field != ''){
                var myTDs = $('td #'+fieldInputId+i).closest('tr').find("td input.datetimecombo_date").length;
                if(field == 'currency_id'){
                    conditionValue = document.getElementById(fieldValue+'['+i+']_select').value;
                }else if(myTDs > 0){
                    conditionValue = $('td #'+fieldInputId+i).closest('tr').find("td input.datetimecombo_date").val();
                }else{
                    conditionValue = document.getElementById(fieldValue+'['+i+']').value;    
                }//end of else

                if(tableName == 'aowAllConditionLines' || tableName == 'aowAnyConditionLines'){
                    if(tableName == 'aowAllConditionLines'){
                        operator = document.getElementById('aowAllConditionsOperator['+i+']').value; //operator
                    }else{
                        operator = document.getElementById('aowAnyConditionsOperator['+i+']').value; //operator
                    }//end of else
                    
                    if(operator != 'is_null'){  
                        if(conditionValue == ''){
                            checkConditionValue = 1;
                        }//end of if
                    }//end of if
                }else{
                    if(conditionValue == ''){
                        checkConditionValue = 1;
                    }//end of if
                }//end of else
            }else{
                checkConditionValue = 1;
            }//end of else
        }//end of if        
    }//end of for
    return checkConditionValue;
}//end of function

function getwizardCurrentStep1(wizardCurrentStep){
    if(wizardCurrentStep == 1){
        var subject = $('#subject').val();
        var module = $('#module').val();
        var fieldNotification = $('#fieldNotification').val();
        var triggerValue = $('#triggerValue').val();
        var triggerPeriod = $('#triggerPeriod').val();
        var triggerAction = $('#triggerAction').val();
        var triggerRecordCreation = $('#triggerRecordCreation').val();
        var triggerRecordModified = $('#triggerRecordModified').val();
        var triggerNotificationModuleField = $('#triggerNotificationModuleFields').val();
       
        var reminderNotificationStatus = 0;
        if(subject != "" && module != ""){
            if(triggerAction != "" && triggerAction == "Immediate Notification"){
                if((triggerRecordCreation == "1" && triggerNotificationModuleField == "" && fieldNotification != "") || (triggerRecordModified == "1" && triggerNotificationModuleField != "")){
                    reminderNotificationStatus = 1;     
                }
            }else if(triggerAction != "" && triggerAction == "Now"){
                if(fieldNotification != ""){
                    reminderNotificationStatus = 1;     
                }
            }else if(triggerValue != "" && triggerPeriod != "" && triggerAction != "" && fieldNotification != ""){
                reminderNotificationStatus = 1;
            }
        }
        if(reminderNotificationStatus == 1){
            $('#step1').css("display","none");
            $('#step2').css("display","block");      
            $('#navStep1').removeClass('selected');
            $('#navStep2').addClass('selected');    
            $('#backButton').show();
            $('#cancelButtonDiv').css('margin-left','20px');
            $('.notification').css("display","none");  
        }else{
            alert(SUGAR.language.get('Administration','LBL_REQUIRE_FIELD'));
        } 
    }
}//end of function  

//Get Email Type Fields
function emailTypeFields(){
    var moduleName = $('#module').val();
    $.ajax({
        url: "index.php?entryPoint=VIRemindersAndNotificationcheckModuleFieldTypeEmail",
        type: "post",
        data: {module : moduleName},
        success: function (response) {
            if(response == 1){
                $('#emailNoteRow').hide();//Hide Note if not getting email field on editview
            }else{
                $('#emailNoteRow').show();//Show Note if not getting email field on editview
            }
        }
    });
}//end of function  

function getRelatedModule(module, flag, relateModule){
    $.ajax({
        url: "index.php?entryPoint=VIRemindersAndNoificationGetRelatedModule",
        type: "post",
        async: false,
        data: {module : module,
                flag : flag},
        success: function (response){
            var relatedModuleFields = JSON.parse(response);
            $("#relatedModule").empty();
            var relateFieldsHtml = "<option value=''>"+SUGAR.language.get('Administration','LBL_SELECT_AN_OPTION')+"</option>";
            $.each(relatedModuleFields,function(relatedModuleFieldsKey,relatedModuleFieldsValue){
                if(relatedModuleFieldsKey == "relateFields"){
                    relateFieldsHtml += "<optgroup label='"+SUGAR.language.get('Administration','LBL_RELATE_FIELDS')+"'>";
                        $.each(relatedModuleFieldsValue,function(relateFieldKey,relateFieldValue){
                            $.each(relateFieldValue,function(relatedModule,relateField){
                                $.each(relateField,function(fieldName,fieldValue){
                                    relateFieldsHtml += "<option value="+fieldName+" related_module="+relatedModule+">"+fieldValue+"</option>";
                                });
                            });
                        });
                    relateFieldsHtml += "</optgroup>";
                }
                if(relatedModuleFieldsKey == "parentRelateFieldModule"){
                    relateFieldsHtml += "<optgroup label='"+SUGAR.language.get('Administration','LBL_PARENT_RELATE_FIELDS')+"'>";
                    $.each(relatedModuleFieldsValue,function(fieldName,fieldValue){
                        relateFieldsHtml += "<option value="+fieldName+" related_module="+fieldName+">"+fieldValue+"</option>";
                    });
                    relateFieldsHtml += "</optgroup>";
                }
            });
            $("#relatedModule").append(relateFieldsHtml);
            if(relateModule != ''){
                $('#relatedModule').find("option[value='"+relateModule+"']").attr("selected",true);
            }
        }
    });
}//end of function 

function getRelatedModuleFields(relatedModule, flag, relateFields){
    $.ajax({
        url: "index.php?entryPoint=VIRemindersAndNoificationGetRelatedModule",
        type: "post",
        data: {module : relatedModule,
                flag : flag
            },
        success: function (response) {
            var relatedFields = JSON.parse(response);
            $('#relateFields').empty();
            $.each(relatedFields,function(fieldName,fieldValue){             
                $('#relateFields').append("<option value="+fieldName+">"+fieldValue+"</option>");
            });
            if(relateFields != ""){
                var relateFieldsData = relateFields.split(',');
                $.each(relateFieldsData,function(key,value){
                    $('#relateFields').find("option[value='"+value+"']").attr("selected",true);
                });
            }
        }
    });
}//end of function 

//Save Function
var count = 0;
$("#btnSave").on('click', function(){
    var reminderMessage = $('#reminderMessage').val();
    var templateId = $("#templateId").val();
    var templateMessage = tinymce.get('template_message').getContent();
    if(reminderMessage != ''){
        var formData = $('form');
        var disabled = formData.find(':disabled').removeAttr('disabled');
        formData = formData.serialize();
        if(count == 0){
            $.ajax({
                url: "index.php?entryPoint=VIRemindersAndNotificationSaveRecords",
                type: "post",
                data: {val : formData,
                    templateMessage : templateMessage,
                    id : recordId,
                    templateId : templateId,
                    theme : theme
                },
                success: function (response) {
                    window.location.href = "index.php?module=Administration&action=vi_reminderandnotificationlistview";
                }
            });
            count++;
        }
    }else{
        alert(SUGAR.language.get('Administration','LBL_REQUIRE_FIELD'));
    }
});//end of function
