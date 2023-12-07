<?php
 
$manifest = array (
   0 => 
  array (
    'acceptable_sugar_versions' => 
    array (
      0 => '',
    ),
  ),
  1 => 
  array (
    'acceptable_sugar_flavors' => 
    array (
      0 => 'CE',
      1 => 'PRO',
      2 => 'ENT',
    ),
  ),
  'key' => '',
  'name' => 'Reminder And Notification',
  'description' => 'Reminder And Notification',
  'author' => 'Variance Infotech PVT LTD',
  'version' => 'v.5.0',
  'is_uninstallable' => true,
  'published_date' => '2020-11-24 14:00:12',
  'type' => 'module',
  'readme' => '',
  'icon' => '',
  'remove_tables' => 'prompt',
);

$installdefs = array (
  'id' => 'reminder notification',
  'beans' => 
    array (
      array (
        'module' => 'VIReminderAndNotificationLicenseAddon',
        'class' => 'VIReminderAndNotificationLicenseAddon',
        'path' => 'modules/VIReminderAndNotificationLicenseAddon/VIReminderAndNotificationLicenseAddon.php',
        'tab' => false,
      ),
    ),
    'post_execute' => array(  0 =>  '<basepath>/scripts/post_execute.php',),
    'post_install' => array(  0 =>  '<basepath>/scripts/post_install.php',),
    'post_uninstall' => array( 0 =>  '<basepath>/scripts/post_uninstall.php',),
    'pre_execute' => array(  0 =>  '<basepath>/scripts/pre_execute.php',),
    'copy' => array (
        0 => array (
            'from' => '<basepath>/custom/Extension/application/Ext/EntryPointRegistry/VIRemidersAndNotificationEntryPoint.php',
            'to' => 'custom/Extension/application/Ext/EntryPointRegistry/VIRemidersAndNotificationEntryPoint.php',
        ),
        1 => array (
            'from' => '<basepath>/custom/Extension/application/Ext/LogicHooks/VIReminderandNotificationLogicHook.php',
            'to' => 'custom/Extension/application/Ext/LogicHooks/VIReminderandNotificationLogicHook.php',
        ),
        2 => array (
            'from' => '<basepath>/custom/Extension/modules/Administration/Ext/ActionViewMap/VIReminderAndNotificationAction_View_Map.ext.php',
            'to' => 'custom/Extension/modules/Administration/Ext/ActionViewMap/VIReminderAndNotificationAction_View_Map.ext.php',
        ),
        3 => array (
            'from' => '<basepath>/custom/Extension/modules/Administration/Ext/Administration/VIReminderAndNotificationAdministration.ext.php',
            'to' => 'custom/Extension/modules/Administration/Ext/Administration/VIReminderAndNotificationAdministration.ext.php',
        ),
        4 => array (
            'from' => '<basepath>/custom/Extension/modules/Administration/Ext/Language/VIRemindersAndNotification.de_DE.lang.php',
            'to' => 'custom/Extension/modules/Administration/Ext/Language/VIRemindersAndNotification.de_DE.lang.php',
        ),
        5 => array (
          'from' => '<basepath>/custom/Extension/modules/Administration/Ext/Language/VIRemindersAndNotification.en_us.lang.php',
          'to' => 'custom/Extension/modules/Administration/Ext/Language/VIRemindersAndNotification.en_us.lang.php',
        ),
        6 => array (
            'from' => '<basepath>/custom/Extension/modules/Administration/Ext/Language/VIRemindersAndNotification.es_ES.lang.php',
            'to' => 'custom/Extension/modules/Administration/Ext/Language/VIRemindersAndNotification.es_ES.lang.php',
        ),
        7 => array (
            'from' => '<basepath>/custom/Extension/modules/Administration/Ext/Language/VIRemindersAndNotification.fr_FR.lang.php',
            'to' => 'custom/Extension/modules/Administration/Ext/Language/VIRemindersAndNotification.fr_FR.lang.php',
        ), 
        8 => array (
            'from' => '<basepath>/custom/Extension/modules/Administration/Ext/Language/VIRemindersAndNotification.hu_HU.lang.php',
            'to' => 'custom/Extension/modules/Administration/Ext/Language/VIRemindersAndNotification.hu_HU.lang.php',
        ),
        9 => array (
            'from' => '<basepath>/custom/Extension/modules/Administration/Ext/Language/VIRemindersAndNotification.it_IT.lang.php',
            'to' => 'custom/Extension/modules/Administration/Ext/Language/VIRemindersAndNotification.it_IT.lang.php',
        ),
        10 => array (
            'from' => '<basepath>/custom/Extension/modules/Administration/Ext/Language/VIRemindersAndNotification.nl_NL.lang.php',
            'to' => 'custom/Extension/modules/Administration/Ext/Language/VIRemindersAndNotification.nl_NL.lang.php',
        ),
        11 => array (
            'from' => '<basepath>/custom/Extension/modules/Administration/Ext/Language/VIRemindersAndNotification.pt_BR.lang.php',
            'to' => 'custom/Extension/modules/Administration/Ext/Language/VIRemindersAndNotification.pt_BR.lang.php',
        ),
        12 => array (
            'from' => '<basepath>/custom/Extension/modules/Administration/Ext/Language/VIRemindersAndNotification.ru_RU.lang.php',
            'to' => 'custom/Extension/modules/Administration/Ext/Language/VIRemindersAndNotification.ru_RU.lang.php',
        ),
        13 => array (
            'from' => '<basepath>/custom/Extension/modules/Administration/Ext/Language/VIRemindersAndNotification.ua_UA.lang.php',
            'to' => 'custom/Extension/modules/Administration/Ext/Language/VIRemindersAndNotification.ua_UA.lang.php',
        ),
        14 => array (
            'from' => '<basepath>/custom/Extension/modules/Schedulers/Ext/Language/VIReminderandNotificationen_us.lang.php',
            'to' => 'custom/Extension/modules/Schedulers/Ext/Language/VIReminderandNotificationen_us.lang.php',
        ),
        15 => array (
            'from' => '<basepath>/custom/Extension/modules/Schedulers/Ext/ScheduledTasks/VIReminderAndNotificationScheduler.php',
            'to' => 'custom/Extension/modules/Schedulers/Ext/ScheduledTasks/VIReminderAndNotificationScheduler.php',
        ),
        16 =>  array (
          'from' => '<basepath>/modules/VIReminderAndNotificationLicenseAddon/',
          'to' => 'modules/VIReminderAndNotificationLicenseAddon/',
        ),
        17 => array (
          'from' => '<basepath>/custom/Extension/modules/VIReminderAndNotificationLicenseAddon/',
          'to' => 'custom/Extension/modules/VIReminderAndNotificationLicenseAddon/',
        ),
        18 => array (
          'from' => '<basepath>/custom/modules/VIReminderAndNotificationLicenseAddon/',
          'to' => 'custom/modules/VIReminderAndNotificationLicenseAddon/',
        ),
        19 => array (
            'from' => '<basepath>/custom/include/VIReminderAndNotification/VIReminderandNotificationLogicHook.php',
            'to' => 'custom/include/VIReminderAndNotification/VIReminderandNotificationLogicHook.php',
        ),
        20 => array (
            'from' => '<basepath>/custom/include/VIReminderAndNotification/VIRemindersAndNotificationGetImmediateNotification.php',
            'to' => 'custom/include/VIReminderAndNotification/VIRemindersAndNotificationGetImmediateNotification.php',
        ),
        21 => array (
            'from' => '<basepath>/custom/include/VIReminderAndNotification/css/VIReminderandNotificationIcon.css',
            'to' => 'custom/include/VIReminderAndNotification/css/VIReminderandNotificationIcon.css',
        ),
        22 => array (
            'from' => '<basepath>/custom/modules/Administration/css/VIRemindersAndNotificationEditView.css',
            'to' => 'custom/modules/Administration/css/VIRemindersAndNotificationEditView.css',
        ),
        23 => array (
            'from' => '<basepath>/custom/modules/Administration/css/VIRemindersAndNotificationListView.css',
            'to' => 'custom/modules/Administration/css/VIRemindersAndNotificationListView.css',
        ),
        24 => array (
            'from' => '<basepath>/custom/modules/Administration/css/VIRemindersAndNotificationTemplates.css',
            'to' => 'custom/modules/Administration/css/VIRemindersAndNotificationTemplates.css',
        ),
        25 => array (
            'from' => '<basepath>/custom/modules/Administration/image/hbd_2.jpg',
            'to' => 'custom/modules/Administration/image/hbd_2.jpg',
        ),
        26 => array (
            'from' => '<basepath>/custom/modules/Administration/image/hbd_3.jpg',
            'to' => 'custom/modules/Administration/image/hbd_3.jpg',
        ),
        27 => array (
            'from' => '<basepath>/custom/modules/Administration/image/hbd_4.png',
            'to' => 'custom/modules/Administration/image/hbd_4.png',
        ),
        28 => array (
            'from' => '<basepath>/custom/modules/Administration/image/hbd_5.gif',
            'to' => 'custom/modules/Administration/image/hbd_5.gif',
        ),
        29 => array (
            'from' => '<basepath>/custom/modules/Administration/image/hbd_6.png',
            'to' => 'custom/modules/Administration/image/hbd_6.png',
        ),
        30 => array (
            'from' => '<basepath>/custom/modules/Administration/image/hbd_7.gif',
            'to' => 'custom/modules/Administration/image/hbd_7.gif',
        ),
        31 => array (
            'from' => '<basepath>/custom/modules/Administration/image/wed_ann_1.png',
            'to' => 'custom/modules/Administration/image/wed_ann_1.png',
        ),
        32 => array (
            'from' => '<basepath>/custom/modules/Administration/image/wed_ann_2.png',
            'to' => 'custom/modules/Administration/image/wed_ann_2.png',
        ),
        33 => array (
            'from' => '<basepath>/custom/modules/Administration/image/wed_ann_3.png',
            'to' => 'custom/modules/Administration/image/wed_ann_3.png',
        ),
        34 => array (
          'from' => '<basepath>/custom/modules/Administration/image/wed_ann_4.png',
            'to' => 'custom/modules/Administration/image/wed_ann_4.png',
        ),
        35 => array (
            'from' => '<basepath>/custom/modules/Administration/image/wed_ann_5.png',
            'to' => 'custom/modules/Administration/image/wed_ann_5.png',
        ),
        36 => array (
            'from' => '<basepath>/custom/modules/Administration/image/wed_ann_6.png',
            'to' => 'custom/modules/Administration/image/wed_ann_6.png',
        ),
        37 => array (
            'from' => '<basepath>/custom/modules/Administration/image/work_ann_1.png',
            'to' => 'custom/modules/Administration/image/work_ann_1.png',
        ),
        38 => array (
            'from' => '<basepath>/custom/modules/Administration/image/work_ann_2.png',
            'to' => 'custom/modules/Administration/image/work_ann_2.png',
        ),
        39 => array (
            'from' => '<basepath>/custom/modules/Administration/image/work_ann_3.png',
            'to' => 'custom/modules/Administration/image/work_ann_3.png',
        ),
        40 => array (
            'from' => '<basepath>/custom/modules/Administration/image/work_ann_4.png',
            'to' => 'custom/modules/Administration/image/work_ann_4.png',
        ),
        41 => array (
            'from' => '<basepath>/custom/modules/Administration/image/work_ann_5.png',
            'to' => 'custom/modules/Administration/image/work_ann_5.png',
        ),
        42 => array (
            'from' => '<basepath>/custom/modules/Administration/image/work_ann_6.png',
            'to' => 'custom/modules/Administration/image/work_ann_6.png',
        ),
        43 => array (
            'from' => '<basepath>/custom/modules/Administration/image/aCases.gif',
            'to' => 'custom/modules/Administration/image/aCases.gif',
        ),
        44 => array (
            'from' => '<basepath>/custom/modules/Administration/image/Accounts.gif',
            'to' => 'custom/modules/Administration/image/Accounts.gif',
        ),
        45 => array (
            'from' => '<basepath>/custom/modules/Administration/image/Call.gif',
            'to' => 'custom/modules/Administration/image/Call.gif',
        ),
        46 => array (
            'from' => '<basepath>/custom/modules/Administration/image/Contact.gif',
            'to' => 'custom/modules/Administration/image/Contact.gif',
        ),
        47 => array (
            'from' => '<basepath>/custom/modules/Administration/image/Contracts.gif',
            'to' => 'custom/modules/Administration/image/Contracts.gif',
        ),
        48 => array (
            'from' => '<basepath>/custom/modules/Administration/image/Document.gif',
            'to' => 'custom/modules/Administration/image/Document.gif',
        ),
        49 => array (
            'from' => '<basepath>/custom/modules/Administration/image/Emails.gif',
            'to' => 'custom/modules/Administration/image/Emails.gif',
        ),
        50 => array (
            'from' => '<basepath>/custom/modules/Administration/image/Events.gif',
            'to' => 'custom/modules/Administration/image/Events.gif',
        ),
        51 => array (
            'from' => '<basepath>/custom/modules/Administration/image/Invoices.gif',
            'to' => 'custom/modules/Administration/image/Invoices.gif',
        ),
        52 => array (
            'from' => '<basepath>/custom/modules/Administration/image/KB - Categories.gif',
            'to' => 'custom/modules/Administration/image/KB - Categories.gif',
        ),
        53 => array (
            'from' => '<basepath>/custom/modules/Administration/image/KnowledgeBase.gif',
            'to' => 'custom/modules/Administration/image/KnowledgeBase.gif',
        ),
        54 => array (
            'from' => '<basepath>/custom/modules/Administration/image/Leads.gif',
            'to' => 'custom/modules/Administration/image/Leads.gif',
        ),
        55 => array (
            'from' => '<basepath>/custom/modules/Administration/image/Maps.gif',
            'to' => 'custom/modules/Administration/image/Maps.gif',
        ),
        56 => array (
            'from' => '<basepath>/custom/modules/Administration/image/Note.gif',
            'to' => 'custom/modules/Administration/image/Note.gif',
        ),
        57 => array (
            'from' => '<basepath>/custom/modules/Administration/image/Opportunity.gif',
            'to' => 'custom/modules/Administration/image/Opportunity.gif',
        ),
        58 => array (
            'from' => '<basepath>/custom/modules/Administration/image/PDF - Templates.gif',
            'to' => 'custom/modules/Administration/image/PDF - Templates.gif',
        ),
        59 => array (
            'from' => '<basepath>/custom/modules/Administration/image/Products - Categories.gif',
            'to' => 'custom/modules/Administration/image/Products - Categories.gif',
        ),
        60 => array (
            'from' => '<basepath>/custom/modules/Administration/image/Products.gif',
            'to' => 'custom/modules/Administration/image/Products.gif',
        ),
        61 => array (
            'from' => '<basepath>/custom/modules/Administration/image/Projects - Templates.gif',
            'to' => 'custom/modules/Administration/image/Projects - Templates.gif',
        ),
        62 => array (
            'from' => '<basepath>/custom/modules/Administration/image/Projects - Templates.gif',
            'to' => 'custom/modules/Administration/image/Projects - Templates.gif',
        ),
        63 => array (
            'from' => '<basepath>/custom/modules/Administration/image/Projects.gif',
            'to' => 'custom/modules/Administration/image/Projects.gif',
        ),
        64 => array (
              'from' => '<basepath>/custom/modules/Administration/image/Quotes.gif',
            'to' => 'custom/modules/Administration/image/Quotes.gif',
        ),
        65 => array (
            'from' => '<basepath>/custom/modules/Administration/image/Reports.gif',
            'to' => 'custom/modules/Administration/image/Reports.gif',
        ),
        66 => array (
            'from' => '<basepath>/custom/modules/Administration/image/Surveys.gif',
            'to' => 'custom/modules/Administration/image/Surveys.gif',
        ),
        67 => array (
            'from' => '<basepath>/custom/modules/Administration/image/Targets - Lists.gif',
            'to' => 'custom/modules/Administration/image/Targets - Lists.gif',
        ),
        68 => array (
             'from' => '<basepath>/custom/modules/Administration/image/Targets.gif',
            'to' => 'custom/modules/Administration/image/Targets.gif',
        ),
        69 => array (
            'from' => '<basepath>/custom/modules/Administration/image/Task.gif',
            'to' => 'custom/modules/Administration/image/Task.gif',
        ),
        70 => array (
            'from' => '<basepath>/custom/modules/Administration/image/WorkFlow.gif',
            'to' => 'custom/modules/Administration/image/WorkFlow.gif',
        ),
        71 => array (
            'from' => '<basepath>/custom/modules/Administration/image/helpInline.gif',
            'to' => 'custom/modules/Administration/image/helpInline.gif',
        ),
        72 => array (
            'from' => '<basepath>/custom/modules/Administration/js/VIRemindersAndNotificationConditionLines.js',
            'to' => 'custom/modules/Administration/js/VIRemindersAndNotificationConditionLines.js',
        ),
        73 => array (
            'from' => '<basepath>/custom/modules/Administration/js/VIRemindersAndNotificationEditView.js',
            'to' => 'custom/modules/Administration/js/VIRemindersAndNotificationEditView.js',
        ),
        74 => array (
            'from' => '<basepath>/custom/modules/Administration/js/VIRemindersAndNotificationListView.js',
            'to' => 'custom/modules/Administration/js/VIRemindersAndNotificationListView.js',
        ),
        75 => array (
            'from' => '<basepath>/custom/modules/Administration/tpl/vi_reminderandnotificationeditview.tpl',
            'to' => 'custom/modules/Administration/tpl/vi_reminderandnotificationeditview.tpl',
        ),
        76 => array (
            'from' => '<basepath>/custom/modules/Administration/tpl/vi_reminderandnotificationlistview.tpl',
            'to' => 'custom/modules/Administration/tpl/vi_reminderandnotificationlistview.tpl',
        ),
        77 => array (
            'from' => '<basepath>/custom/modules/Administration/views/view.vi_reminderandnotificationeditview.php',
            'to' => 'custom/modules/Administration/views/view.vi_reminderandnotificationeditview.php',
        ),
        78 => array (
            'from' => '<basepath>/custom/modules/Administration/views/view.vi_reminderandnotificationlistview.php',
            'to' => 'custom/modules/Administration/views/view.vi_reminderandnotificationlistview.php',
        ),
        79 => array (
            'from' => '<basepath>/custom/VIRemidersAndNotification/VIRemindersAndNoificationFetchMonthFirstandLastDate.php',
            'to' => 'custom/VIRemidersAndNotification/VIRemindersAndNoificationFetchMonthFirstandLastDate.php',
        ),
        80 => array (
            'from' => '<basepath>/custom/VIRemidersAndNotification/VIRemindersAndNoificationFetchPrimaryModuleDateDateTimeFields.php',
            'to' => 'custom/VIRemidersAndNotification/VIRemindersAndNoificationFetchPrimaryModuleDateDateTimeFields.php',
        ),
        81 => array (
            'from' => '<basepath>/custom/VIRemidersAndNotification/VIRemindersAndNoificationGetRelatedModule.php',
            'to' => 'custom/VIRemidersAndNotification/VIRemindersAndNoificationGetRelatedModule.php',
        ),
        82 => array (
            'from' => '<basepath>/custom/VIRemidersAndNotification/VIRemindersAndNotificationcheckModuleFieldTypeEmail.php',
            'to' => 'custom/VIRemidersAndNotification/VIRemindersAndNotificationcheckModuleFieldTypeEmail.php',
        ),
        83 => array (
            'from' => '<basepath>/custom/VIRemidersAndNotification/VIRemindersAndNotificationDeleteRecords.php',
            'to' => 'custom/VIRemidersAndNotification/VIRemindersAndNotificationDeleteRecords.php',
        ),
        84 => array (
            'from' => '<basepath>/custom/VIRemidersAndNotification/VIRemindersAndNotificationFetchPrimaryModuleFields.php',
            'to' => 'custom/VIRemidersAndNotification/VIRemindersAndNotificationFetchPrimaryModuleFields.php',
        ),
        85 => array (
            'from' => '<basepath>/custom/VIRemidersAndNotification/VIRemindersAndNotificationFieldTypeOptions.php',
            'to' => 'custom/VIRemidersAndNotification/VIRemindersAndNotificationFieldTypeOptions.php',
        ),
        86 => array (
            'from' => '<basepath>/custom/VIRemidersAndNotification/VIRemindersAndNotificationFunction.php',
            'to' => 'custom/VIRemidersAndNotification/VIRemindersAndNotificationFunction.php',
        ),
        87 => array (
            'from' => '<basepath>/custom/VIRemidersAndNotification/VIRemindersAndNotificationGetFieldType.php',
            'to' => 'custom/VIRemidersAndNotification/VIRemindersAndNotificationGetFieldType.php',
        ),
        88 => array (
            'from' => '<basepath>/custom/VIRemidersAndNotification/VIRemindersAndNotificationModuleFieldType.php',
            'to' => 'custom/VIRemidersAndNotification/VIRemindersAndNotificationModuleFieldType.php',
        ),
        89 => array (
            'from' => '<basepath>/custom/VIRemidersAndNotification/VIRemindersAndNotificationModuleOperatorField.php',
            'to' => 'custom/VIRemidersAndNotification/VIRemindersAndNotificationModuleOperatorField.php',
        ),
        90 => array (
            'from' => '<basepath>/custom/VIRemidersAndNotification/VIRemindersAndNotificationModuleRelationships.php',
            'to' => 'custom/VIRemidersAndNotification/VIRemindersAndNotificationModuleRelationships.php',
        ),
        91 => array (
            'from' => '<basepath>/custom/VIRemidersAndNotification/VIRemindersAndNotificationSaveRecords.php',
            'to' => 'custom/VIRemidersAndNotification/VIRemindersAndNotificationSaveRecords.php',
        ),
        92 => array (
            'from' => '<basepath>/custom/VIRemidersAndNotification/VIRemindersNotificationUpdateStatus.php',
            'to' => 'custom/VIRemidersAndNotification/VIRemindersNotificationUpdateStatus.php',
        ),
        93 => array (
            'from' => '<basepath>/images/ReminderandNotification.png',
            'to' => 'themes/SuiteP/images/ReminderandNotification.png',
        ),
        94 => array (
            'from' => '<basepath>/images/ReminderandNotification.svg',
            'to' => 'themes/SuiteP/images/ReminderandNotification.svg',
        ),
    ),
);
?>













