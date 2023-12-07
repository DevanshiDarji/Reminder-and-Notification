<?php
 
require_once('modules/VIReminderAndNotificationLicenseAddon/license/VIReminderAndNotificationOutfittersLicense.php');
require_once('custom/VIRemidersAndNotification/VIRemindersAndNotificationFunction.php');
require_once('include/MVC/Controller/SugarController.php');

global $sugar_config, $mod_strings;

$siteURL = $sugar_config['site_url'];
$url = $siteURL."/index.php?module=VIReminderAndNotificationLicenseAddon&action=license";

$fieldNames = array('*');
$whereCondition = array('name'=>'lic_reminder-notification');
$licenseQuery = getReminderNotificationRecord('config', $fieldNames, $innerJoin = array(), $onData = array(), $whereCondition, $orderby = array(), $limit = array());
$licenseQueryResult = $GLOBALS['db']->query($licenseQuery);
$licenseQueryResultData = $GLOBALS['db']->fetchRow($GLOBALS['db']->query($licenseQuery));
if(!empty($licenseQueryResultData)){
	$validateLicense = VIReminderAndNotificationOutfittersLicense::isValid('VIReminderAndNotificationLicenseAddon');
    if($validateLicense !== true) {
        if(is_admin($current_user)) {
         SugarApplication::appendErrorMessage($mod_strings['LBL_LICENCE_ACTIVE_LABEL'].$validateLicense.$mod_strings['LBL_LICENCE_ISSUES']. '<a href='.$url.'>'.$mod_strings['LBL_CLICK_HERE'].'</a>');
        }
            echo '<h2><p class="error">'.$mod_strings['LBL_LICENCE_ACTIVE'].'</p></h2><p class="error">'.$mod_strings['LBL_RENEW_LICENCE'].'</p><a href='.$url.'>'.$mod_strings['LBL_CLICK_HERE'].'</a>';
     }else{
    	foreach ($admin_group_header as $key => $value) {
            $values[] = $value[0];
        }	
        if (in_array("Other", $values)){
                $array['ReminderandNotification'] = array(
                			'ReminderandNotification',
                			$mod_strings["LBL_REMINDER_NOTIFICATION"],
                			$mod_strings["LBL_REMINDER_NOTIFICATION_DESCRIPTION"],
                			'./index.php?module=Administration&action=vi_reminderandnotificationlistview',
                			'reminderandnotification'
                	);
                $admin_group_header['Other'][3]['Administration'] = array_merge($admin_group_header['Other'][3]['Administration'],$array);
        }else{
        	$admin_option_defs = array();
			$admin_option_defs['Administration']['ReminderandNotification'] = array(
				//Icon name. Available icons are located in ./themes/default/images
				'ReminderandNotification',

				//Link name label 
				$mod_strings["LBL_REMINDER_NOTIFICATION"],

				//Link description label
				$mod_strings["LBL_REMINDER_NOTIFICATION_DESCRIPTION"],

				//Link URL
				'./index.php?module=Administration&action=vi_reminderandnotificationlistview',

				'reminderandnotification'
			);
			$admin_group_header['Other'] = array(
				//Section header label
				'Other',

				//$other_text parameter for get_form_header()
				'',

				//$show_help parameter for get_form_header()
				false,

				//Section links
				$admin_option_defs,

				//Section description label
				''
			);
        }	
    }
}else{
	foreach ($admin_group_header as $key => $value) {
        $values[] = $value[0];
    }
    if (in_array("Other", $values))
    {
        $array['ReminderandNotification'] = array(
        				'ReminderandNotification',
        				
        				$mod_strings["LBL_REMINDER_NOTIFICATION"],
                		
                		$mod_strings["LBL_REMINDER_NOTIFICATION_DESCRIPTION"],
                		'./index.php?module=VIReminderAndNotificationLicenseAddon&action=license',
                		
                		'reminderandnotification'
                	);
        $admin_group_header['Other'][3]['Administration'] = array_merge($admin_group_header['Other'][3]['Administration'],$array);
    }else{
    	$admin_option_defs = array();
		$admin_option_defs['Administration']['ReminderandNotification'] = array(
			//Icon name. Available icons are located in ./themes/default/images
			'ReminderandNotification',

			//Link name label 
			$mod_strings["LBL_REMINDER_NOTIFICATION"],

			//Link description label
			$mod_strings["LBL_REMINDER_NOTIFICATION_DESCRIPTION"],

			//Link URL
			'./index.php?module=VIReminderAndNotificationLicenseAddon&action=license',

			'reminderandnotification'
		);
		$admin_group_header['Other'] = array(
			//Section header label
			'Other',

			//$other_text parameter for get_form_header()
			'',

			//$show_help parameter for get_form_header()
			false,

			//Section links
			$admin_option_defs,

			//Section description label
			''
		);
    }
}
?>