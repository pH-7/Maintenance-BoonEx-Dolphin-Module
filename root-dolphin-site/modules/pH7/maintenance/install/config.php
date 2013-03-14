<?php
/**
 * @category         Maintenance module for BoonEx Dolphin.
 *
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2013, Pierre-Henry Soria. All Rights Reserved.
 * @link             http://github.com/pH-7
 * @license          GNU General Public License <http://www.gnu.org/licenses/gpl.html>
 */

$aConfig = array(
    /**
     * Main Section.
     */
    'title' => 'Maintenance',
    'version' => '1.0.0',
    'vendor' => 'pH7 (Pierre-Henry Soria)',
    'update_url' => 'https://github.com/pH-7/Maintenance-BoonEx-Dolphin-Module/blob/master/version.xml', // URL to get info about available module updates
    'compatible_with' => array(
        '7.x.x'
    ),

    /**
    * 'home_dir' and 'home_uri' - should be unique. Don't use spaces in 'home_uri' and the other special chars.
    */
    'home_dir' => 'pH7/maintenance/',
    'home_uri' => 'maintenance',

    'db_prefix' => 'ph_maintenance',
    'class_prefix' => 'PhMaintenance',

    /**
     * Installation/Uninstallation Section.
     */
    'install' => array(
        'show_introduction' => 1,
        'update_languages' => 1,
        'recompile_global_paramaters' => 1,
        'execute_sql' => 1,
        'recompile_permalinks' => 1,
        'clear_db_cache' => 1,
        'show_conclusion' => 1
    ),
    'uninstall' => array(
        'show_introduction' => 1,
        'update_languages' => 1,
        'recompile_global_paramaters' => 1,
        'execute_sql' => 1,
        'recompile_permalinks' => 1,
        'clear_db_cache' => 1,
        'show_conclusion' => 1
    ),

    /**
     * Category for language keys.
     */
    'language_category' => 'pH7 Maintenance',

    /**
     * Introduction and Conclusion Section.
     */
    'install_info' => array(
        'introduction' => 'inst_intro.html',
        'conclusion' => 'inst_concl.html'
    ),
    'uninstall_info' => array(
        'introduction' => 'uninst_intro.html',
        'conclusion' => 'uninst_concl.html'
    )
);
