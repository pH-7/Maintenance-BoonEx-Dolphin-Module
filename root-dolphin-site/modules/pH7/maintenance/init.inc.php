<?php
/**
 * @category         Maintenance module for BoonEx Dolphin.
 *
 * @author           Pierre-Henry Soria <ph7software@gmail.com>
 * @copyright        (c) 2013, Pierre-Henry Soria. All Rights Reserved.
 * @link             http://github.com/pH-7
 * @license          GNU General Public License <http://www.gnu.org/licenses/gpl.html>
 */

require_once BX_DIRECTORY_PATH_INC . 'admin.inc.php';
require_once BX_DIRECTORY_PATH_INC . 'db.inc.php';

if (false === strpos($_SERVER['REQUEST_URI'], 'maintenance') && false === strpos($_SERVER['REQUEST_URI'], 'administration') && !$GLOBALS['logged']['admin'] && getParam('ph_maintenance_enable') == 'on')
{
    bx_import('BxDolPermalinks');
    $oDolPermalinks = new BxDolPermalinks;
    header('Location: ' . BX_DOL_URL_ROOT . $oDolPermalinks->permalink('modules/?r=maintenance/'));
    exit;
}
