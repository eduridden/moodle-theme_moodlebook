<?php

/**
 * Settings for the Moodlebook theme
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    // Background colour setting
    $name = 'theme_moodlebook/backgroundcolor';
    $title = get_string('backgroundcolor','theme_moodlebook');
    $description = get_string('backgroundcolordesc', 'theme_moodlebook');
    $default = '#EEE';
    $previewconfig = array('selector'=>'html', 'style'=>'backgroundColor');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
    $settings->add($setting);

    // Foot note setting
    $name = 'theme_moodlebook/footnote';
    $title = get_string('footnote','theme_moodlebook');
    $description = get_string('footnotedesc', 'theme_moodlebook');
    $setting = new admin_setting_confightmleditor($name, $title, $description, '');
    $settings->add($setting);

    // Custom CSS file
    $name = 'theme_moodlebook/customcss';
    $title = get_string('customcss','theme_moodlebook');
    $description = get_string('customcssdesc', 'theme_moodlebook');
    $setting = new admin_setting_configtextarea($name, $title, $description, '');
    $settings->add($setting);

    // Hide Settings block
    $name = 'theme_moodlebook/hidesettingsblock';
    $title = get_string('hidesettingsblock','theme_moodlebook');
    $description = get_string('hidesettingsblockdesc', 'theme_moodlebook');
    $default = 1;
    $choices = array(1=>'Yes', 0=>'No');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // Hide Navigation block
    $name = 'theme_moodlebook/hidenavigationblock';
    $title = get_string('hidenavigationblock','theme_moodlebook');
    $description = get_string('hidenavigationblockdesc', 'theme_moodlebook');
    $default = 0;
    $choices = array(1=>'Yes', 0=>'No');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);
    
    // Show user profile picture
    $name = 'theme_moodlebook/showuserpicture';
    $title = get_string('showuserpicture','theme_moodlebook');
    $description = get_string('showuserpicturedesc', 'theme_moodlebook');
    $default = 0;
    $choices = array(1=>'Yes', 0=>'No');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // Add custom menu to Awesomebar
    $name = 'theme_moodlebook/custommenuinawesomebar';
    $title = get_string('custommenuinawesomebar','theme_moodlebook');
    $description = get_string('custommenuinawesomebardesc', 'theme_moodlebook');
    $default = 0;
    $choices = array(1=>'Yes', 0=>'No');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    // Place custom menu after Awesomebar
    $name = 'theme_moodlebook/custommenuafterawesomebar';
    $title = get_string('custommenuafterawesomebar','theme_moodlebook');
    $description = get_string('custommenuafterawesomebardesc', 'theme_moodlebook');
    $default = 0;
    $choices = array(0=>'No', 1=>'Yes');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);
   

}