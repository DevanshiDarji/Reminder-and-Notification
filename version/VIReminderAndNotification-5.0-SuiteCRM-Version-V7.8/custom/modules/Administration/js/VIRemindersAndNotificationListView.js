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
if(theme == "SuiteR"){
    $('.suite_cont').css('margin-top','0px');
    $('.bulkActionLabel').css('margin-top','4px');
}else if(theme == "Suite7"){
    $('.bulkActionLabel').css('margin-top','8px');
}
//select all checkbox
$('#selectAll').click(function(event) {   
    $('#actionMenu').css('display','none');
    if(this.checked) {
        $('.bulkAction').css('display','none');
        $('#actionLinkTop').css('display','block');
        // Iterate each checkbox
        $('.listviewCheckbox').each(function() {
            this.checked = true;                        
        });
    }else{
        $('.bulkAction').css('display','block');
        $('#actionLinkTop').css('display','none');
        $('.listviewCheckbox').each(function() {
            this.checked = false;                       
        });
    }
});//end of function

$('.listviewCheckbox').on('click', function(){
    var id = [];
    var recordsId = [];
    $(".listviewCheckbox:checked").each(function() {
        if(this.checked == true){
            id.push($(this).val());         
        }
    });
    $(".listviewCheckbox").each(function() {
        if(this.checked == true){
            recordsId.push($(this).val());         
        }
    });
    if(id.length == recordsId.length){
        $('#selectAll').attr('checked',false);  
    }

    $('#actionMenu').css('display','none');

    if(this.checked) {
        $('.bulkAction').css('display','none');
        $('#actionLinkTop').css('display','block');
    }else{
        var id = [];
        $(".listviewCheckbox:checked").each(function() {
            if(this.checked == true){
                id.push($(this).val());         
            }
        });
        if(id.length >= 1){
            $('.bulkAction').css('display','none');
            $('#actionLinkTop').css('display','block');
        }else{
            $('.bulkAction').css('display','block');
            $('#actionLinkTop').css('display','none');
        }
    }
});

$('.enableRemindersNotificationModule').on('change', function(){
    var title = $(this).closest('tr').find('td:nth-child(3)').text();
    var checkValue;
    if($(this).is(':checked')){
        $(this).val('1');
        checkValue = 1;
    }else{
        $(this).val('0');
        checkValue = 0;
    }
    var id = $(this).closest('tr').attr('data-id');
    $.ajax({
        url: "index.php?entryPoint=VIRemindersNotificationUpdateStatus",
        type: "post",
        data: {enableRemindersNotification : checkValue,
                id : id},
        success: function (response) {
            if(response == 1){
                if(checkValue == 1){
                    alert(trim(title)+' '+SUGAR.language.get('Administration','LBL_REMINDER_NOTIFICATION_STATUS_ACTIVATED'));
                }else if(checkValue == 0){
                    alert(trim(title)+' '+SUGAR.language.get('Administration','LBL_REMINDER_NOTIFICATION_STATUS_DEACTIVATED'));
                }
            }
        }
    });
});//end of function

$('.actionButton').on('click', function(){
    if($('#actionMenu').css('display') == "none"){
        $('#actionMenu').css('display','block');        
        $('#actionMenu').css('margin-top','11px');
    }else{
        $('#actionMenu').css('display','none');  
    }
});//end of function

function updateActionStatus(checkValue){
    var id = [];
    $(".listviewCheckbox:checked").each(function() {
        id.push($(this).val());
    });
   
    var selectedValues = id.join(",");
    $.ajax({
        url: "index.php?entryPoint=VIRemindersNotificationUpdateStatus",
        type: "post",
        data: {enableRemindersNotification : checkValue,
                recordId : selectedValues},
        success: function (response) {
            if(response == 1){
                window.location.reload();
            }
        }
    });
}//end of function 

//ListView Delete 
$('.btnDelete').on('click', function(e) {
    var id = [];
    $(".listviewCheckbox:checked").each(function() {
        id.push($(this).val());
    });
    var deleteMsg = SUGAR.language.get('Administration','LBL_DELETE_MSG')+' '+(id.length>1?SUGAR.language.get('Administration','LBL_THESE')+' '+id.length:SUGAR.language.get('Administration','LBL_THIS'))+" "+SUGAR.language.get('Administration','LBL_ROW');
    var checked = confirm(deleteMsg);
    if(checked == true){
        var selectedValues = id.join(",");
        $.ajax({
            type: "POST",
            url: "index.php?entryPoint=VIRemindersAndNotificationDeleteRecords",
            data: 'delId='+selectedValues,
            success: function(response) {
                if(response == 1){
                    window.location.reload();
                }
            }
        });
    }
});//end of function