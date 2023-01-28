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
		<link rel="stylesheet" type="text/css" href="custom/modules/Administration/css/VIRemindersAndNotificationTemplates.css">

		<link rel="stylesheet" type="text/css" href="custom/modules/Administration/css/VIRemindersAndNotificationEditView.css">
	</head>
	
	<body>
		<div class="moduleTitle">
			<h2>{$MOD.LBL_REMINDER_NOTIFICATION}</h2>
		</div>

		<div class="clear"></div>

		<form name="EditView" id="EditView">
			<div class="progression-container">
			    <ul class="progression">
				    <li id="navStep1" class="nav-steps selected" data-nav-step="1"><div>{$MOD.LBL_SELECT_MODULE}</div></li>
			        <li id="navStep2" class="nav-steps" data-nav-step="2"><div id="label">{$MOD.LBL_ADD_CONDITIONS}</div></li>
			        <li id="navStep3" class="nav-steps" data-nav-step="3"><div>{$MOD.LBL_NOTIFICATIONS}</div></li>
				</ul>
			</div>

			<p>
				<div id ='buttons'>
				    <table width="100%" border="0" cellspacing="0" cellpadding="0">
				        <tr> 
				            <td align="left" width='30%'>
				            	<table border="0" cellspacing="0" cellpadding="0" >
				                    <td>
				                    	<div>
				                    		<button id="backButton" type='button' title="{$MOD.LBL_BACK}" class="button" name="back">{$MOD.LBL_BACK}
				                    		</button>
				                    	</div>
				                    </td>
				                    <td>
				                    	<div id="cancelButtonDiv">
				                    		<button type="button" class="button" name= "btnCancel" id= "btnCancel" >{$MOD.LBL_CANCEL}</button>
				                    	</div>
				                    </td>
				                    <td>
				                    	<div>
				                    		<button type="button" class="button" name= "btnClear" id= "btnClear" onclick = "clearall();">{$MOD.LBL_CLEAR}</button>
				                    	</div>
				                    </td>
				                    <td>
				                    	<div>
				                    		<button type="button" class="button" name= "btnNext" id= "btnNext">{$MOD.LBL_NEXT}</button>
				                    	</div>
				                    </td>
				                    <td>
				                    	<div>
				                    		<button type="button" class="button" name= "btnSave" id= "btnSave">{$MOD.LBL_SAVE}</button>
				                    	</div>
				                    </td>
				                </table>
				            </td>
				        </tr>
				    </table>
				</div>
			</p>

			<table cellspacing="1" id="reminderNotification" width='100%'>
			    <tr>
			        <td class='edit view' rowspan='2' width='100%'>
			            <div id="wiz_message"></div>
			            <div id=wizard class="wizard-unique-elem">
			            	<div id="step1">
			                    <div class="template-panel">
			                        <div class="template-panel-container panel">
			                            <div class="template-container-full">
			                                <table width="100%" border="0" cellspacing="10" cellpadding="0">
			                                    <tbody>
			                                    	<tr>
			                                    		<th colspan="4"><h4 class="header-4">{$MOD.LBL_SELECT_MODULE}</h4></th>
			                                    	</tr>

			                                    	<tr rowspan = "4">
			                                    		<td><b>{$MOD.LBL_SUBJECT}<span class="required">*</span></b>
			                                    			<img id="info_img_subject" src="{$HELPLINEIMAGEPATH}" class="image" alt="{$MOD.LBL_INFO_INLINE}" height="15" width="15" title="" onclick="return SUGAR.util.showHelpTips(this,'{$MOD.LBL_SUBJECT_INFO}');" >
			                                    		</td>
			                                    		<td class="setvisibilityclass">
			                                    			<input type="text" name="subject" id="subject" value="{if isset($REMINDERNOTIFICATIONDATA.subject)}{$REMINDERNOTIFICATIONDATA.subject}{/if}">
			                                    		</td>
			                                    	</tr>

			                                    	<tr rowspan = "4">
			                                            <td><b>{$MOD.LBL_SELECT_MODULE}<span class="required">*</span></b>
			                                            	<img id="info_img_display_module" src="{$HELPLINEIMAGEPATH}"  class="image" alt="{$MOD.LBL_INFO_INLINE}" height="15" width="15" onclick="return SUGAR.util.showHelpTips(this,'{$MOD.LBL_SELECT_MODULE_INFO}');">
			                                            </td>
			                                            <td class="setvisibilityclass">
			                                            	<select name="module" id="module">
					                                            <option value="" selected="selected">{$MOD.LBL_SELECT_AN_OPTION}</option>
			                                            		{foreach from=$MODULELIST key=moduleValue item=moduleName}
			                                            			<option label="{$moduleName}" value="{$moduleValue}" {if $REMINDERNOTIFICATIONDATA.module eq $moduleValue} selected="selected" {/if}>{$moduleName}</option>
			                                            		{/foreach}
			                                            	</select>
			                                        	</td>
			                                        </tr>

			                                        <tr>
			                                            <td id="notificationRow">
			                                            	<b>{$MOD.LBL_TRIGGER_NOTIFICATION}<span class="required">*</span></b>
			                                            	<img id="info_img_status" src="{$HELPLINEIMAGEPATH}" class="image"  alt="{$MOD.LBL_INFO_INLINE}" height="15" width="15" onclick="return SUGAR.util.showHelpTips(this,'{$MOD.LBL_TRIGGER_NOTIFICATION_INFO}');"/>
			                                            </td>
			                                            <td class="setvisibilityclass CellWithComment">
			                                            	<input type="text" name="triggerValue" id="triggerValue" size="25"  value="{if isset($REMINDERNOTIFICATIONDATA.trigger_value)}{$REMINDERNOTIFICATIONDATA.trigger_value}{/if}">
			                                            
			                                            	<select name="triggerPeriod" id="triggerPeriod">
			                                            		<option value="">{$MOD.LBL_SELECT_AN_OPTION}</option>
			                                            		{foreach from=$TRIGGERPERIODFIELDS key=fieldLabel item=fieldName}
			                                            			<option label="{$fieldLabel}" value="{$fieldName}" {if $fieldLabel eq "Hours"} {/if} {if $REMINDERNOTIFICATIONDATA.trigger_period eq $fieldLabel} selected="selected" {/if}>{$fieldName}</option>
			                                            		{/foreach} 
				                                        	</select>

			                                            	<select name="triggerAction" id="triggerAction">
			                                            		<option value="">{$MOD.LBL_SELECT_AN_OPTION}</option>
			                                            		{foreach from=$TRIGGERACTIONFIELDS key=fieldLabel item=fieldName}
			                                            			<option label="{$fieldLabel}" value="{$fieldName}" {if $REMINDERNOTIFICATIONDATA.trigger_action eq $fieldLabel} selected="selected" {/if}>{$fieldName}</option>
			                                            		{/foreach} 
				                                        	</select>

				                                        	<input type="text" name="triggerMonthValue" id="triggerMonthValue" value="{if isset($REMINDERNOTIFICATIONDATA.triggerMonthValue)}{$REMINDERNOTIFICATIONDATA.triggerMonthValue}{/if}" style="margin-top: 10px;" readonly>
				                                    	</td>
			                                        </tr>

			                                        <tr id="triggerNotificationRow">
			                                        	<td></td>
			                                        	<td id="triggerNotificationCol">
			                                        		<input type="radio" name="triggerNotification" value="0" id="triggerRecordCreation" onclick = "getTrigger(this)"/>&nbsp;&nbsp;{$MOD.LBL_RECORD_CREATION}&nbsp;&nbsp;

			                                        		<input type="radio" name="triggerNotification" value="0" id="triggerRecordModified"  onclick = "getTrigger(this)"/>&nbsp;&nbsp;{$MOD.LBL_RECORD_UPDATED}
			                                        	</td>
			                                        </tr>

			                                        <tr id="triggerNotificationFieldsRow">
			                                        	<td id="triggerNotificationCol"><b>{$MOD.LBL_SELECT_FIELD_FOR_NOTIFICATION}<span class="required">*</span><b>
			                                        		<img id="info_img_terigger_notification" src="{$HELPLINEIMAGEPATH}" class="image"  alt="{$MOD.LBL_INFO_INLINE}" height="15" width="15" onclick="return SUGAR.util.showHelpTips(this,'{$MOD.LBL_TRIGGER_FIELD_INFO}');"/>
			                                        	</td>
			                                        	<td class="setvisibilityclass">
			                                        		<select name="triggerNotificationModuleFields" id="triggerNotificationModuleFields">	
			                                        			<option value="" selected="selected">{$MOD.LBL_SELECT_AN_OPTION}	
			                                        			</option>
			                                        		</select>
			                                        	</td>
			                                        </tr>

			                                        <tr rowspan = "4" id="fieldNotificationRow">
			                                            <td><b>{$MOD.LBL_SELECT_FIELD_FOR_NOTIFICATION}<span class="required">*</span></b>
			                                            	<img id="info_img_terigger_notification" src="{$HELPLINEIMAGEPATH}" class="image"  alt="{$MOD.LBL_INFO_INLINE}" height="15" width="15" onclick="return SUGAR.util.showHelpTips(this,'{$MOD.LBL_TRIGGER_FIELD_INFO}');"/>
			                                            </td>
			                                            <td class="setvisibilityclass">
			                                            	<select name="fieldNotification" id="fieldNotification" onchange="getFieldType(document.getElementById('module').value, this)">	
			                                            		<option value="" selected="selected">{$MOD.LBL_SELECT_AN_OPTION}</option>
															</select>
														</td>
			                                        </tr>

			                                        <tr rowspan = "4" id="fieldcomparisonRow">
			                                        	<td id="fieldcomparisonLabel"><b>{$MOD.LBL_SELECT_FIELD_FOR_COMPARISON}<span class="required">*</span></b>
			                                            	<img id="info_img_field_comparison" src="{$HELPLINEIMAGEPATH}" class="image"  alt="{$MOD.LBL_INFO_INLINE}" height="15" width="15" onclick="return SUGAR.util.showHelpTips(this,'{$MOD.LBL_FIELD_comparison_INFO}');"/>
			                                            </td>
			                                            <td class="setvisibilityclass">
			                                            	<select name="fieldcomparison" id="fieldcomparison">	
			                                            		{foreach from=$FIELDcomparison key=fieldLabel item=fieldName}
			                                            			<option label="{$fieldLabel}" value="{$fieldName}"  {if $fieldLabel eq 'Compare Entire Date'} selected="selected" {/if}>{$fieldName}</option>
			                                            		{/foreach}
															</select>
														</td>
			                                        </tr>

			                                        <tr rowspan = "4">
			                                            <td>
			                                            	<b>{$MOD.LBL_STATUS}
			                                            		<span class="required">*</span>
			                                            	</b>
			                                            	<img id="info_img_status" src="{$HELPLINEIMAGEPATH}" class="image"  alt="{$MOD.LBL_INFO_INLINE}" height="15" width="15" onclick="return SUGAR.util.showHelpTips(this,'{$MOD.LBL_INFO_STATUS}');"/>
			                                            </td>
			                                            <td class="setvisibilityclass">
			                                            	<select name="status" id="status">
																<option label="{$MOD.LBL_ACTIVE}" value="1" {if isset($REMINDERNOTIFICATIONDATA.status) && $REMINDERNOTIFICATIONDATA.status eq '1'} selected="selected" {/if}>{$MOD.LBL_ACTIVE}</option>
					                                            <option label="{$MOD.LBL_INACTIVE}" value="0" {if isset($REMINDERNOTIFICATIONDATA.status) && $REMINDERNOTIFICATIONDATA.status eq '0'} selected="selected" {/if}>{$MOD.LBL_INACTIVE}</option>
				                                        	</select>
				                                    	</td>
			                                        </tr>
			                                    </tbody>
			                                </table>
			                            </div>
			                        </div>
			                    </div>
			                </div>
			               
			                <div id="step2">
			                	<div class="template-panel">
			                        <div class="template-panel-container panel">
			                            <div class="template-container-full">
                                            <div id="conditionBorder">
                                                <table id="allCondition" width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tbody>
                                                        <tr><th colspan="4"><h4 class="header-4"><b>{$MOD.LBL_ALL_CONDITION}</b></h4></th></tr>
                                                    </tbody>
                                                </table>
                                                <span class="conditionMessage">{$MOD.LBL_ALL_CONDITION_NOTE} </span>
                                                <br/><br/>
                     
                                                {if $REMINDER_NOTIFICATION_ALL_CONDITION_DATA eq ''}
                                                    <script type="text/javascript" src="custom/modules/Administration/js/VIRemindersAndNotificationConditionLines.js?v={$RANDNUM}"></script>
                                                    
                                                    <table id="aowAllConditionLines" width="100%" cellspacing="4" border="0"></table>

                                                    <div class="conditionDiv"><input tabindex="116" class="button" value="Add Conditions" id="btnAllConditionLine" onclick="insertConditionLine('All')" type="button" ></div>
                                                {else} 
                                                    {$REMINDER_NOTIFICATION_ALL_CONDITION_DATA} 
                                                {/if}
                                            </div>

                                            <br>
                                            <label>{$MOD.LBL_CONDITIONAL_OPERATOR}</label>
                                            <select name="conditionalOperator" id="conditionalOperator">
                                               <option label="{$MOD.LBL_AND}" value="AND" selected="selected">{$MOD.LBL_AND}</option>
                                                <option label="{$MOD.LBL_OR}" value="OR" {if $REMINDERNOTIFICATIONDATA.conditional_operator eq 'OR'} selected = "selected"{/if}>{$MOD.LBL_OR}</option>
                                            </select>
                                            <br><br>

                                            <div id="conditionBorder">
                                                <table id="anyCondition" width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tbody>
                                                        <tr>
                                                            <th colspan="4"><h4 class="header-4"><b>{$MOD.LBL_ANY_CONDITION}</b></h4></th>
                                                        </tr> 
                                                    </tbody>
                                                </table>
                                                <span class="conditionMessage">{$MOD.LBL_ANY_CONDITION_NOTE}
                                                <br/><br/>
                                                {if $REMINDER_NOTIFICATION_ANY_CONDITION_DATA eq ''}
                                                    <script type="text/javascript" src="custom/modules/Administration/js/VIRemindersAndNotificationConditionLines.js?v={$RANDNUM}"></script>
                                                    
                                                    <table id="aowAnyConditionLines" width="100%" cellspacing="4" border="0"></table>
                                                    <div class="conditionDiv"><input tabindex="116" class="button" value="{$MOD.LBL_ADD_CONDITIONS}" id="btnAnyConditionLine" onclick="insertConditionLine('Any')" type="button" ></div>
                                                {else} 
                                                    {$REMINDER_NOTIFICATION_ANY_CONDITION_DATA} 
                                                {/if}
                                            </div>
                                        </div>
			                        </div>
			                    </div>
			                </div>

			                <div id="step3" class="notification">
			                    <div class="template-panel">
			                        <div class="template-panel-container panel">
			                            <div class="template-container-full">
			                                <table width="100%" border="0" cellspacing="0" cellpadding="0" id="notification">
			                                    <tbody>
			                                        <tr>
			                                        	<th colspan="4"><h4 class="header-4">{$MOD.LBL_SEND_NOTIFICATION}</h4></th>
			                                        </tr>
			                                        <tr rowspan = "4">
				                                        <td>{$MOD.LBL_SYSTEM_USERS}
				                                        	<img id="info_img_users" src="{$HELPLINEIMAGEPATH}" class="image"  alt="{$MOD.LBL_INFO_INLINE}" height="15" width="15" onclick="return SUGAR.util.showHelpTips(this,'{$MOD.LBL_ALL_USERS_INFO}');"/>
				                                        </td>
			                                            <td class="setvisibilityclass">
															<dl>
															    <dt><input type="checkbox" name="allUsers" id="allUsers" value=""><label for="{$MOD.ALL_USERS}">{$MOD.ALL_USERS}</label>
															    </dt>
															    <dd>
															        <ul>
															        	{foreach from=$ALLUSERS key=key item=value}
																        <li>
																            {if $RECORDID neq ''}
																		    	<input type = "checkbox" name="users[]" class="userChk" id='edit_user' value="{$key}" {if $ALLEDITUSERS.$key} checked {/if}>
																		    {else}
																		    	<input type="checkbox" class="userChk" id="users" name="users[]" value="{$key}">
																		    {/if}
																            <label for="{$key}">{$value}</label>
																        </li>  
																        {/foreach}
															        </ul>
															    </dd>
															</dl>
														</td>
			                                        </tr>

			                                        <tr>
			                                        	<td>{$MOD.LBL_SEND_NOTIFICATION_RELATE}
			                                        		<img id="info_img_users" src="{$HELPLINEIMAGEPATH}" class="image" alt="{$MOD.LBL_INFO_INLINE}" height="15" width="15" onclick="return SUGAR.util.showHelpTips(this,'{$MOD.LBL_SEND_NOTIFICATION_INFO}');">
			                                        	</td>
			                                        	<td class="setvisibilityclass">
			                                        		<dl>
															    <dt id="ass_Users">
																    <select name="relatedModule" id="relatedModule" >
																    	<option value="">{$MOD.LBL_SELECT_AN_OPTION}<option>
																    </select>
																</dt>
																<dd>
																	<select name="relateFields[]" id="relateFields" multiple="multiple" size="6">
																    </select>
																</dd>
															</dl>
			                                        	</td>
			                                        </tr>

													<tr rowspan = "4">
				                                        <td>{$MOD.LBL_SEND_NOTIFICATION_RECEIVER}</td>
				                                        <td><input type="checkbox" name="sendNotificationReceiver" id="sendNotificationReceiver" {if $REMINDERNOTIFICATIONDATA.enable_notification eq '1'}checked='checked'{/if} value="{$REMINDERNOTIFICATIONDATA.enable_notification}"></td>
			                                        </tr>

			                                        <tr rowspan = "4" id="emailNoteRow"> 
				                                        <td></td>
			                                            <td class="setvisibilityclass" class="note">
			                                            	<b>{$MOD.LBL_NOTE}</b>{$MOD.LBL_NOTE_MSG}
			                                        	</td>
			                                        </tr>

			                                        <tr rowspan = "4" id="emailNotificationRow"> 
			                                        	<td>{$MOD.LBL_SEND_EMAIL_NOTIFICATION}
			                                        	</td>
			                                            <td class="setvisibilityclass">
			                                            	<input type="text" size="30" tabindex="60" name="emailNotification" id="emailNotification" value="{if isset($REMINDERNOTIFICATIONDATA.email_notification)}{$REMINDERNOTIFICATIONDATA.email_notification}{/if}">
			                                        	</td>
													</tr>
			                            
			                                        <tr rowspan = "4" id="fieldsRow">
			                                            <td><b>{$MOD.LBL_FIELDS}</b>
			                                            	<img id="info_img_reminder_message" src="{$HELPLINEIMAGEPATH}" class="image" alt="{$MOD.LBL_INFO_INLINE}" height="15" width="15"  onclick="return SUGAR.util.showHelpTips(this,'{$MOD.LBL_MODULE_FIELD_INFO}');">
			                                            </td> 
			                                            <td class="setvisibilityclass">
			                                            	<select name="primaryModuleFields"  id="primaryModuleFields">
					                                            <option value="" selected="selected">{$MOD.LBL_SELECT_AN_OPTION}</option>
					                                        </select>
					                                    </td>				                
			                                        </tr>

			                                        <tr rowspan = "4">
			                                            <td><b>{$MOD.LBL_REMINDER_MESSAGE}<span class="required">*</span></b>
			                                            	<img id="info_img_reminder_message" src="{$HELPLINEIMAGEPATH}" class="image" alt="{$MOD.LBL_INFO_INLINE}" height="15" width="15"  onclick="return SUGAR.util.showHelpTips(this,'{$MOD.LBL_NOTIFICATION_INFO}');">
			                                            </td>   
				                                   		<td class="setvisibilityclass">
			                                            	<textarea name="reminderMessage" id="reminderMessage" rows="4" cols="50">{if isset($REMINDERNOTIFICATIONDATA.reminder_message)}{$REMINDERNOTIFICATIONDATA.reminder_message}{/if}</textarea>
			                                            </td>
			                                        </tr>
			                                    </tbody>
			                               	</table>
			                            </div>
			                    	</div> 
			                    	<div class="template-panel-container panel">
			                            <div class="template-container-full">
			                    			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			                                    <tbody>
			                                        <tr>
			                                        	<th colspan="4"><h4 class="header-4">{$MOD.LBL_NOTIFICATIONS_TEMPLATES}</h4></th>
			                                        </tr>
			                                        <tr rowspan = "4">
			                                            <td><b>{$MOD.LBL_SELECT_TEMPLATE}</b></td>
			                                            <td class="setvisibilityclass">
			                                            	<select name="templateType" id="templateType">	
			                                            		<option value="" selected="selected">{$MOD.LBL_SELECT_AN_OPTION}</option>
			                                            		<option  value="0" {if $REMINDERNOTIFICATIONDATA.templates eq '0'} selected='selected'{/if}>{$MOD.LBL_CUSTOMIZE_DEFUALT_TEMPLATE}</option>
			                                            		<option value="1"  {if $REMINDERNOTIFICATIONDATA.templates eq '1'} selected='selected'{/if}>{$MOD.LBL_CREATE_NEW_TEMPLATE}</option>
															</select>
														</td>
			                                        </tr>
			                                       
				                                    <tr rowspan = "4" id="template">
				                                     	<td>
				                                       		<input type="radio" name="templates" class="templates"  {if $TEMPLATEDATA.templateType eq 'Birthday Templates'}checked='checked'{/if} value="Birthday Templates">{$MOD.LBL_BIRTHDAY_TEMPLATES}
					                                    </td>
					                                    <td>
					                                      	<input type="radio" name="templates" class="templates" {if $TEMPLATEDATA.templateType eq 'Marriage Anniversary Templates'} checked='checked'{/if} value="Marriage Anniversary Templates">{$MOD.LBL_MARRIAGE_ANIVERSARY_TEMPLATES}
					                                    </td>
					                                    <td>
					                                        <input type="radio" name="templates" class="templates" {if $TEMPLATEDATA.templateType eq 'Work Anniversary Templates'} checked='checked'{/if} value="Work Anniversary Templates"> {$MOD.LBL_WORK_ANIVERSARY_TEMPLATES}
					                                    </td>
					                                    <td>
					                                        <input type="radio" name="templates" class="templates" {if $TEMPLATEDATA.templateType eq 'Other Templates'} checked='checked'{/if} value="Other Templates">{$MOD.LBL_OTHER_TEMPLATES}
					                                    </td>
				                                    </tr>
			                                    </tbody>
			                               	</table>
			                        	</div>
			                    	</div>
			                    	<div class = "template-panel-container panel" id="customTemplates">
			                    		<input type="hidden" name="hidden" id="templateId" value="{if isset($REMINDERNOTIFICATIONDATA.template_id)}{$REMINDERNOTIFICATIONDATA.template_id}{/if}"> 
			                    		<div class="template-container-full">
			                    			{if $BIRTHDAYTEMPLATEDATA|@count gt 0}
			                               	<div id="birthdayTemplates">
  												<div class="tmpltRow">
  													{foreach key=key item=value from=$BIRTHDAYTEMPLATEDATA}
  													<div class="tmpltColumn" id='{$key}'>
  														<div class="tmpltCard">
  															<p>{$value}</p>
  															<center>
  																<input type="button" class="button" name="clickHere" id="clickHere" value="Click Here">
  															</center>
  														</div>
  													</div>
	    											{/foreach}
			                               		</div>
			                               	</div>	
			                               	{/if}
			                               	{if $MARRIAGETEMPLATEDATA|@count gt 0}
			                               	<div id="marriageAniversryTemplates">
  												<div class="tmpltRow">
  													{foreach key=key item=value from=$MARRIAGETEMPLATEDATA}
  													<div class="tmpltColumn" id='{$key}'>
  														<div class="tmpltCard">
  															<p>{$value}</p>
  															<center>
  																<input type="button" class="button" name="clickHere" id="clickHere" value="Click Here">
  															</center>
  														</div>
  													</div>
	    											{/foreach}
			                               		</div>
			                               	</div>
			                               	{/if}
			                               	{if $WORKTEMPLATEDATA|@count gt 0} 
			                               	<div id="workAniversryTemplates">
  												<div class="tmpltRow">
  													{foreach key=key item=value from=$WORKTEMPLATEDATA}
  													<div class="tmpltColumn" id='{$key}'>
  														<div class="tmpltCard">
  															<p>{$value}</p>
  															<center>
  																<input type="button" class="button" name="clickHere" id="clickHere" value="Click Here">
  															</center>
  														</div>
  													</div>
	    											{/foreach}
			                               		</div>
			                               	</div>
			                               	{/if}
			                               	{if $OTHERTEMLATEDATA|@count gt 0} 
			                               	<div id="othersTemplates">
  												<div class="tmpltRow">
  													{foreach key=key item=value from=$OTHERTEMLATEDATA}
  													<div class="tmpltColumn" id='{$key}'>
  														<div class="tmpltCard">
  															<p>{$value}</p>
  															<center>
  																<input type="button" class="button" name="clickHere" id="clickHere" value="Click Here">
  															</center>
  														</div>
  													</div>
	    											{/foreach}
			                               		</div>
			                               	</div>
			                               	{/if}
			                    		</div>
			                    	</div>  
			                	</div>
			                	<div id="displayTinyMce">
			                    	<div class="template-panel-container panel">
			                    		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			                    			<tr rowspan="4">
			                    				<td></td>
			                    				<td class="setvisibilityclass">
			                    					<button id="templateBackBtn" type='button' title="{$MOD.LBL_BACK}" class="button" name="back">{$MOD.LBL_BACK}</button>
			                    				</td>
			                    			</tr>
			                    			
			                    			<tr rowspan = "4">
			                                    <td><b>{$MOD.LBL_TEMPLATE_FIELDS}</b></td> 
			                                    <td class="setvisibilityclass">
			                                      	<select name="templateField" id="templateField">
					                                    <option value="" selected="selected">{$MOD.LBL_SELECT_AN_OPTION}</option>
					                                </select>
					                                <input type="button" tabindex="70" onclick = "insertTemplateField();"  class="button" value="{$MOD.LBL_INSERT_FIELD}">
						                        </td>		                                  
			                                </tr>

			                                <tr rowspan = "4">
			                                    <td><b>{$MOD.LBL_TEMPLATE_MESSAGE}</b></td>   
				                                <td class="setvisibilityclass">
				                                	<textarea name="template_message" id="template_message" rows="4" cols="50">{if isset($REMINDERNOTIFICATIONDATA.template_message)}{$REMINDERNOTIFICATIONDATA.template_message}{/if}</textarea>
			                                    </td>
			                                </tr>
			                            </table>
			                    	</div>
			                    </div>
			            	</div>
			            </div>
			        </td>
			    </tr>
			</table>
		</form>
	</body>
</html>
{literal}
	<script src="include/javascript/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript">
    	var reminderNotificationData = {/literal}{$REMINDERNOTIFICATIONDATA|@json_encode}{literal};
		var recordId = "{/literal}{$RECORDID}{literal}";
    	var allUsers = {/literal}{$ALLUSERS|@json_encode}{literal};
        var allEditUsers = {/literal}{$ALLEDITUSERS|@json_encode}{literal}; 
        var templateData = {/literal}{$TEMPLATEDATA|@json_encode}{literal};
        var theme = "{/literal}{$THEME}{literal}";
        
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "custom/modules/Administration/js/VIRemindersAndNotificationEditView.js?v="+Math.random();
        document.body.appendChild(script);
    </script>
{/literal}