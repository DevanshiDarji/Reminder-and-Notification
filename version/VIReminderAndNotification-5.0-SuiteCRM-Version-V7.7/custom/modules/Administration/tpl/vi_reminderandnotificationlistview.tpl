{*
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
 *}
<html>
    <head>
        {if $THEME eq 'SuiteR' || $THEME eq 'Suite7'}
        <link rel="stylesheet" type="text/css" href="custom/modules/Administration/css/VIRemindersAndNotificationListViewSuiteR7.css">
        {else}
        <link rel="stylesheet" type="text/css" href="custom/modules/Administration/css/VIRemindersAndNotificationListView.css">
        {/if}
    </head>
    <body>
        <div class="moduleTitle">
            <h2 class="module-title-text">{$MOD.LBL_REMINDERS}</h2>
            <div id="updateLicense">
                <a href="index.php?module=VIReminderAndNotificationLicenseAddon&action=license"><button class="button">{$MOD.LBL_UPDATE_LICENSE}</button></a>
            </div>
            <div class="clear"></div>
        </div>

        {$HELPBOXCONTENT}

        {if !empty($REMINDERNOTIFICATIONDATA)}
        <div>
            <table id="reminderNotificationTable">
                <tr>
                    <td>
                        <input type="button" name="add_new" value="{$MOD.LBL_ADD_NEW}" class="button" onclick="location.href = '{$EDITVIEWURL}';">
                    </td>
                    <td class="bulkActionRow">
                        <div class="selectActionsDisabled bulkAction" id="select_actions_disabled_bottom">
                            <a href="javascript:void(0)" class="parent-dropdown-handler" onclick="">
                                <label class="selected-actions-label hidden-desktop"> {$MOD.LBL_BULK_ACTION}</label>
                            </a>
                            <span class="ab" onclick=""></span>
                        </div>

                        <ul id="actionLinkTop" class="clickMenu selectActions fancymenu SugarActionMenu" style="display:none;" name="selectActions">
                            <li class="sugar_action_button actionButton">
                                <a href="javascript:void(0)" class="parent-dropdown-handler" id="delete_listview_bottom" onclick="return false;"><label class="selected-actions-label hidden-desktop bulkActionLabel">{$MOD.LBL_BULK_ACTION}</label></a>
                                <ul class="subnav ddopen" id="actionMenu" style="display:none;">
                                    <li>
                                        <a class="actionStatus" onclick="updateActionStatus(1)">{$MOD.LBL_ACTIVE}</a>
                                    </li>
                                    <li>
                                        <a class="actionStatus" onclick="updateActionStatus(0)">{$MOD.LBL_INACTIVE}</a>
                                    </li>
                                    <li>
                                        <a class="btnDelete actionStatus">{$MOD.LBL_DELETE}</a>
                                    </li>
                                </ul>
                                <span class="actionIcon"></span> 
                            </li>
                        </ul> 
                    </td>
                </tr>
            </table>
        </div>

        <div class="list-view-rounded-corners">
            <table class="list view table-responsive">
                <thead>
                    <th class="td_alt"><input type="checkbox" id="selectAll"></th>
                    <th class="td_alt quick_view_links"></th>
                    <th scope="col">
                        <div>
                            <a class="listViewThLinkS1"  href="#">{$MOD.LBL_MODULE}</a>
                        </div>
                    </th>
                    <th scope="col">
                        <div>
                            <a class="listViewThLinkS1"  href="#">{$MOD.LBL_SELECT_FIELD_FOR_NOTIFICATION}</a>
                        </div>
                    </th>
                    <th scope="col">
                        <div>
                            <a class="listViewThLinkS1"  href="#">{$MOD.LBL_STATUS}</a>
                        </div>
                    </th>
                    <th scope="col">
                        <div>
                            <a class="listViewThLinkS1"  href="#">{$MOD.LBL_DATE_CREATE}</a>
                        </div>
                    </th>
                    <th scope="col">
                        <div>
                            <a class="listViewThLinkS1"  href="#">{$MOD.LBL_DATE_MODIFIED}</a>
                        </div>
                    </th>
                </thead>
                {foreach key=key item=value from=$REMINDERNOTIFICATIONDATA}
                    <tr class="oddListRowS1" height="20" data-id="{$value.id}" value="{$value.module}">
                        <td>
                            <input title="{$MOD.LBL_SELECT_THIS_ROW}" class="listviewCheckbox" name="mass[]" id="mass[]" value="{$value.id}" type="checkbox">
                        </td>
                        {if $THEME eq 'SuiteP'}
                            <td>
                                <a class="edit-link" title="Edit" id="{$value.id}" href="{
                                $EDITVIEWURL}&records={$value.id}">
                                    <img src="themes/{$THEME}/images/edit_inline.png"> 
                                </a>
                            </td>
                        {else}
                            <td>
                                <a class="edit-link" title="Edit" id="{$value.id}" href="{
                                $EDITVIEWURL}&records={$value.id}">
                                    <img src="themes/{$THEME}/images/edit.gif"> 
                                </a>
                            </td>
                        {/if}
                        <td scope="row" valign="top" align="left">
                            {$value.module}
                        </td>
                        <td scope="row" valign="top" align="left">
                            {$value.notificationField}
                        </td>
                        <td scope="row" valign="top" align="left">
                            <label class="switch">
                                <input type="checkbox" class="enableRemindersNotificationModule" name="enableRemindersNotificationModule" {if $value.status eq 1}checked="checked"{/if} value="0">
                                <span class="slider round" id='slider_round'></span>
                            </label>    
                        </td>
                        <td scope="row" valign="top" align="left">
                            {$value.dateEntered}
                        </td>
                        <td scope="row" valign="top" align="left">
                            {$value.dateModified}
                        </td>
                    </tr>
                {/foreach}
            </table>
        </div>
        {else}
        <br>
        <div class="list view listViewEmpty">
            <br>
            <p class="msg">
                {$MOD.LBL_CREATE_MESSAGE}
                <a href="{$EDITVIEWURL}">{$MOD.LBL_CREATE}</a>
                {$MOD.LBL_CREATE_MESSAGE_ONE}
            </p>
        </div>
        {/if}
    </body>
</html>

{literal}
    <script type="text/javascript">
        var theme = '{/literal}{$THEME}{literal}';
        var listViewUrl = '{/literal}{$LISTVIEWURL}{literal}';
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "custom/modules/Administration/js/VIRemindersAndNotificationListView.js?v="+Math.random();
        document.body.appendChild(script);
    </script>
{/literal}