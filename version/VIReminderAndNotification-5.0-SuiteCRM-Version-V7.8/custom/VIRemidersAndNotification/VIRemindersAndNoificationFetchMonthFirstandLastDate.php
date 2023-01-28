<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
class VIRemindersAndNoificationFetchMonthFirstandLastDate{
	public function __construct(){
        $this->getMonthFirstandLastDate();
    }//end of function
    public function getMonthFirstandLastDate(){
        global $current_user, $timedate;
       
    	$dateTime = new datetime();
        $timeDate = new TimeDate();
        $formattedDate = $timeDate->asUser($dateTime, $current_user);
        $currentTime = date('Y-m-d H:i',strtotime($formattedDate));
       
        if($_REQUEST['triggerAction'] == "Before"){
        	$date = date("Y-m-d H:i", strtotime($currentTime."-".$_REQUEST['triggerValue']." ".$_REQUEST['triggerPeriod']));
        }else{
        	$date = date("Y-m-d H:i", strtotime($currentTime."+".$_REQUEST['triggerValue']." ".$_REQUEST['triggerPeriod']));
        }

        $firstDateofMonth = strtotime(date("Y-m-d", strtotime($date)) . ", first day of this month");
        $firstDate = date("Y-m-d",$firstDateofMonth);

        $lastDateofMonth = strtotime(date("Y-m-d", strtotime($date)) . ", last day of this month");
        $lastDate = date("Y-m-d",$lastDateofMonth);
        
        echo $firstDate." "."to"." ".$lastDate;
   	}//end of function
}//end of class
new VIRemindersAndNoificationFetchMonthFirstandLastDate();
?>