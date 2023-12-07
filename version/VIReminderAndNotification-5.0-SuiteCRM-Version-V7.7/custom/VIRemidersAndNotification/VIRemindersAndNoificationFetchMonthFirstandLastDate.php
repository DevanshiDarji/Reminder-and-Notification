<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
 
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