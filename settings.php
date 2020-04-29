<?php
// This file is part of Ranking block for Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Theme settings file
 *
 * @package    theme_cocreatic
 * @copyright  2020 David Herney
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

$settings = null;

// This is used for performance, we don't need to know about these settings on every page in Moodle, only when
// we are looking at the admin settings pages.
if (is_siteadmin()) {

    global $PAGE;

    $orderoptions = array();
    for ($i = 0; $i <= 10; $i++) {
        $orderoptions[$i] = $i;
    }

    $ADMIN->add('themes', new admin_category('theme_cocreatic', 'CocreaTIC'));

    /*
    * ----------------------
    * General settings page
    * ----------------------
    */
    $page = new admin_settingpage('theme_cocreatic_general', get_string('generalsettings', 'theme_cocreatic'));

    // Favicon setting.
    $name = 'theme_cocreatic/favicon';
    $title = get_string('favicon', 'theme_cocreatic');
    $description = get_string('favicon_desc', 'theme_cocreatic');
    $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.ico'), 'maxfiles' => 1);
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'favicon', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Page background image.
    $name = 'theme_cocreatic/pagebgimg';
    $title = get_string('pagebgimg', 'theme_cocreatic');
    $description = get_string('pagebgimg_desc', 'theme_cocreatic');
    $opts = array('accepted_types' => array('.png', '.jpg', '.svg'));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'pagebgimg', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Second page background image.
    $name = 'theme_cocreatic/secondbgimg';
    $title = get_string('secondbgimg', 'theme_cocreatic');
    $description = get_string('secondbgimg_desc', 'theme_cocreatic');
    $opts = array('accepted_types' => array('.png', '.jpg', '.svg'));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'secondbgimg', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Variable $brand-color.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_cocreatic/brandcolor';
    $title = get_string('brandcolor', 'theme_cocreatic');
    $description = get_string('brandcolor_desc', 'theme_cocreatic');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Social networking setting.
    $name = 'theme_cocreatic/socialnet';
    $title = get_string('socialnet', 'theme_cocreatic');
    $description = get_string('socialnet_desc', 'theme_cocreatic');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Google font family.
    $name = 'theme_cocreatic/googlefont';
    $title = get_string('googlefont', 'theme_cocreatic');
    $description = get_string('googlefont_desc', 'theme_cocreatic');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Must add the page after definiting all the settings!
    $ADMIN->add('theme_cocreatic', $page);

    /*
    * ----------------------
    * Advanced settings page
    * ----------------------
    */
    $page = new admin_settingpage('theme_cocreatic_advanced', get_string('advancedsettings', 'theme_cocreatic'));

    // Raw SCSS to include before the content.
    $setting = new admin_setting_scsscode('theme_cocreatic/scsspre',
        get_string('rawscsspre', 'theme_cocreatic'), get_string('rawscsspre_desc', 'theme_cocreatic'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS to include after the content.
    $setting = new admin_setting_scsscode('theme_cocreatic/scss', get_string('rawscss', 'theme_cocreatic'),
        get_string('rawscss_desc', 'theme_cocreatic'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Google analytics block.
    $name = 'theme_cocreatic/googleanalytics';
    $title = get_string('googleanalytics', 'theme_cocreatic');
    $description = get_string('googleanalytics_desc', 'theme_cocreatic');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $ADMIN->add('theme_cocreatic', $page);

    /*
    * -----------------------
    * Slider settings page
    * -----------------------
    */
    $page = new admin_settingpage('theme_cocreatic_slider', get_string('slidersettings', 'theme_cocreatic'));

    for ($sliderindex = 1; $sliderindex <= 10; $sliderindex++) {
        $name = 'theme_cocreatic/sliderorder' . $sliderindex;
        $title = get_string('sliderorder', 'theme_cocreatic');
        $description = get_string('sliderorder_desc', 'theme_cocreatic');
        $default = 0;
        $setting = new admin_setting_configselect($name, $title, $description, $default, $orderoptions);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $fileid = 'sliderimage' . $sliderindex;
        $name = 'theme_cocreatic/sliderimage' . $sliderindex;
        $title = get_string('sliderimage', 'theme_cocreatic');
        $description = get_string('sliderimage_desc', 'theme_cocreatic');
        $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'), 'maxfiles' => 1);
        $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid, 0, $opts);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_cocreatic/slidertitle' . $sliderindex;
        $title = get_string('slidertitle', 'theme_cocreatic');
        $description = get_string('slidertitle_desc', 'theme_cocreatic');
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_TEXT);
        $page->add($setting);

        $name = 'theme_cocreatic/slidercap' . $sliderindex;
        $title = get_string('slidercaption', 'theme_cocreatic');
        $description = get_string('slidercaption_desc', 'theme_cocreatic');
        $default = '';
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $page->add($setting);
    }

    $ADMIN->add('theme_cocreatic', $page);

    /*
    * --------------------
    * News settings page
    * --------------------
    */
    $page = new admin_settingpage('theme_cocreatic_news', get_string('newssettings', 'theme_cocreatic'));

    for ($newsindex = 1; $newsindex <= 10; $newsindex++) {
        $name = 'theme_cocreatic/newsorder' . $newsindex;
        $title = get_string('newsorder', 'theme_cocreatic');
        $description = get_string('newsorder_desc', 'theme_cocreatic');
        $default = 0;
        $setting = new admin_setting_configselect($name, $title, $description, $default, $orderoptions);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $fileid = 'newsimage' . $newsindex;
        $name = 'theme_cocreatic/newsimage' . $newsindex;
        $title = get_string('newsimage', 'theme_cocreatic');
        $description = get_string('newsimage_desc', 'theme_cocreatic');
        $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'), 'maxfiles' => 1);
        $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid, 0, $opts);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_cocreatic/newslink' . $newsindex;
        $title = get_string('newslink', 'theme_cocreatic');
        $description = get_string('newslink_desc', 'theme_cocreatic');
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
        $page->add($setting);

        $name = 'theme_cocreatic/newscontent' . $newsindex;
        $title = get_string('newscontent', 'theme_cocreatic');
        $description = get_string('newscontent_desc', 'theme_cocreatic');
        $default = '';
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $page->add($setting);
    }

    $ADMIN->add('theme_cocreatic', $page);

    /*
    * --------------------
    * Footer settings page
    * --------------------
    */
    $page = new admin_settingpage('theme_cocreatic_footer', get_string('footersettings', 'theme_cocreatic'));

    // Footer content.
    $name = 'theme_cocreatic/footercontent';
    $title = get_string('footercontent', 'theme_cocreatic');
    $description = get_string('footercontent_desc', 'theme_cocreatic');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Footer info.
    $name = 'theme_cocreatic/footerinfo';
    $title = get_string('footerinfo', 'theme_cocreatic');
    $description = get_string('footerinfo_desc', 'theme_cocreatic');
    $default = 'Proyecto CocreaTIC';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $ADMIN->add('theme_cocreatic', $page);

    /*
    * --------------------
    * Logos settings page
    * --------------------
    */
    $page = new admin_settingpage('theme_cocreatic_logos', get_string('logossettings', 'theme_cocreatic'));

    for ($logosindex = 1; $logosindex <= 10; $logosindex++) {
        $name = 'theme_cocreatic/logosorder' . $logosindex;
        $title = get_string('logosorder', 'theme_cocreatic');
        $description = get_string('logosorder_desc', 'theme_cocreatic');
        $default = 0;
        $setting = new admin_setting_configselect($name, $title, $description, $default, $orderoptions);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $fileid = 'logosimage' . $logosindex;
        $name = 'theme_cocreatic/logosimage' . $logosindex;
        $title = get_string('logosimage', 'theme_cocreatic');
        $description = get_string('logosimage_desc', 'theme_cocreatic');
        $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'), 'maxfiles' => 1);
        $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid, 0, $opts);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_cocreatic/logoslink' . $logosindex;
        $title = get_string('logoslink', 'theme_cocreatic');
        $description = get_string('logoslink_desc', 'theme_cocreatic');
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
        $page->add($setting);

        $name = 'theme_cocreatic/logoscontent' . $logosindex;
        $title = get_string('logoscontent', 'theme_cocreatic');
        $description = get_string('logoscontent_desc', 'theme_cocreatic');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $page->add($setting);
    }

    $ADMIN->add('theme_cocreatic', $page);

    /*
    * --------------------
    * Stats settings page
    * --------------------
    */
    $page = new admin_settingpage('theme_cocreatic_stats', get_string('statssettings', 'theme_cocreatic'));

    for ($statsindex = 1; $statsindex <= 10; $statsindex++) {
        $name = 'theme_cocreatic/statsorder' . $statsindex;
        $title = get_string('statsorder', 'theme_cocreatic');
        $description = get_string('statsorder_desc', 'theme_cocreatic');
        $default = 0;
        $setting = new admin_setting_configselect($name, $title, $description, $default, $orderoptions);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $fileid = 'statsimage' . $statsindex;
        $name = 'theme_cocreatic/statsimage' . $statsindex;
        $title = get_string('statsimage', 'theme_cocreatic');
        $description = get_string('statsimage_desc', 'theme_cocreatic');
        $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'), 'maxfiles' => 1);
        $setting = new admin_setting_configstoredfile($name, $title, $description, $fileid, 0, $opts);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $page->add($setting);

        $name = 'theme_cocreatic/statslink' . $statsindex;
        $title = get_string('statslink', 'theme_cocreatic');
        $description = get_string('statslink_desc', 'theme_cocreatic');
        $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
        $page->add($setting);

        $name = 'theme_cocreatic/statscontent' . $statsindex;
        $title = get_string('statscontent', 'theme_cocreatic');
        $description = get_string('statscontent_desc', 'theme_cocreatic');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $page->add($setting);
    }

    $ADMIN->add('theme_cocreatic', $page);


}
